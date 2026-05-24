<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function verifyPayment(Booking $booking)
    {
        if ($booking->status === 'completed') {
            return back()->with('error', 'Booking ini sudah diverifikasi.');
        }

        // Cek konflik
        foreach ($booking->details as $detail) {
            $conflict = \App\Models\BookingDetail::where('court_id', $detail->court_id)
                ->where('id', '!=', $detail->id)
                ->whereHas('booking', function($q) use ($booking) {
                    $q->where('date', $booking->date)
                      ->whereIn('status', ['paid', 'completed']);
                })
                ->where(function($q) use ($detail) {
                    $q->whereBetween('start_time', [$detail->start_time, $detail->end_time])
                      ->orWhereBetween('end_time', [$detail->start_time, $detail->end_time]);
                })->exists();

            if ($conflict) {
                $booking->update(['status' => 'cancelled']);
                return back()->with('error', 'Gagal verifikasi: Slot lapangan sudah terisi oleh pelanggan lain yang sudah bayar.');
            }
        }

        $booking->status = 'completed';
        $booking->paid_at = now();
        $booking->save();

        // Tambahkan poin jika user yang booking (bukan guest)
        if ($booking->user_id) {
            $user = $booking->user;
            // +10 poin per jam durasi
            // Asumsi 1 detail booking = 1 jam (karena dibagi per jam di Controller)
            // Jadi hitung total details.
            $durationHours = $booking->details->count();
            $user->points_balance += ($durationHours * 10);
            $user->save();
        }

        return back()->with('success', 'Pembayaran booking ' . $booking->booking_code . ' berhasil diverifikasi.');
    }

    public function payCash(Booking $booking)
    {
        // Cek konflik
        foreach ($booking->details as $detail) {
            $conflict = \App\Models\BookingDetail::where('court_id', $detail->court_id)
                ->where('id', '!=', $detail->id)
                ->whereHas('booking', function($q) use ($booking) {
                    $q->where('date', $booking->date)
                      ->whereIn('status', ['paid', 'completed']);
                })
                ->where(function($q) use ($detail) {
                    $q->whereBetween('start_time', [$detail->start_time, $detail->end_time])
                      ->orWhereBetween('end_time', [$detail->start_time, $detail->end_time]);
                })->exists();

            if ($conflict) {
                $booking->update(['status' => 'cancelled']);
                return back()->with('error', 'Gagal bayar tunai: Slot lapangan sudah terisi oleh pelanggan lain yang sudah bayar.');
            }
        }

        $booking->status = 'completed';
        $booking->paid_at = now();
        $booking->save();

        \App\Models\Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'amount' => $booking->total_price,
                'payment_method' => 'Cash (Tunai)',
                'status' => 'verified'
            ]
        );

        return back()->with('success', 'Pembayaran tunai berhasil dicatat.');
    }

    public function destroyBooking(Booking $booking)
    {
        $booking->delete();
        return back()->with('success', 'Transaksi berhasil dihapus.');
    }

    public function storeMembership(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'discount_percent' => 'required|integer|min:0|max:100',
        ]);
        $data['priority_booking'] = $request->has('priority_booking');

        \App\Models\Membership::create($data);
        return back()->with('success', 'Paket Membership berhasil ditambahkan.');
    }

    public function destroyMembership(\App\Models\Membership $membership)
    {
        $membership->delete();
        return back()->with('success', 'Paket Membership berhasil dihapus.');
    }

    public function storeSchedule(Request $request, \App\Models\Membership $membership)
    {
        $data = $request->validate([
            'court_id' => 'required|exists:courts,id',
            'days' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        $data['membership_id'] = $membership->id;
        $data['is_available'] = true;

        // Cek konflik dengan sesi membership lain
        $existingSchedules = \App\Models\MemberSchedule::where('court_id', $data['court_id'])->get();
        $newStart = \Carbon\Carbon::createFromFormat('H:i', $data['start_time']);
        $newEnd = \Carbon\Carbon::createFromFormat('H:i', $data['end_time']);

        foreach ($existingSchedules as $sched) {
            // Jika harinya bentrok (contoh: "Senin" ada di "Senin & Kamis")
            if (stripos($sched->days, $data['days']) !== false || stripos($data['days'], $sched->days) !== false) {
                $existingStart = \Carbon\Carbon::createFromFormat('H:i:s', $sched->start_time);
                $existingEnd = \Carbon\Carbon::createFromFormat('H:i:s', $sched->end_time);
                
                if ($newStart < $existingEnd && $newEnd > $existingStart) {
                    return back()->with('error', 'Sesi gagal ditambahkan: Jadwal bentrok dengan Sesi Membership lain di lapangan dan hari tersebut.');
                }
            }
        }

        \App\Models\MemberSchedule::create($data);
        return back()->with('success', 'Sesi Lapangan berhasil ditambahkan ke Membership.');
    }

    public function destroySchedule(\App\Models\MemberSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Sesi Lapangan berhasil dihapus.');
    }

    public function memberships()
    {
        $memberships = \App\Models\Membership::with(['schedules.court', 'schedules.user'])->get();
        // Ambil user yang aktif beserta jadwalnya
        $activeMembers = \App\Models\User::whereNotNull('membership_id')->with(['membership', 'memberSchedules.court'])->get();
        return view('admin.memberships', compact('memberships', 'activeMembers'));
    }

    public function vouchers()
    {
        $promos = \App\Models\Promo::all();
        return view('admin.vouchers', compact('promos'));
    }

    public function storeVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:promos',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'min_transaction' => 'required|numeric|min:0',
            'points_required' => 'required|integer|min:0',
        ]);

        \App\Models\Promo::create($request->all());
        return back()->with('success', 'Voucher berhasil ditambahkan.');
    }

    public function destroyVoucher(\App\Models\Promo $promo)
    {
        $promo->delete();
        return back()->with('success', 'Voucher berhasil dihapus.');
    }

    public function courts()
    {
        $courts = \App\Models\Court::all();
        return view('admin.courts', compact('courts'));
    }

    public function storeCourt(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_hour' => 'required|numeric|min:0',
            'image' => 'nullable|url',
        ]);

        \App\Models\Court::create($request->all());
        return back()->with('success', 'Lapangan berhasil ditambahkan.');
    }

    public function updateCourt(Request $request, \App\Models\Court $court)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_hour' => 'required|numeric|min:0',
            'image' => 'nullable|url',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        
        $court->update($data);
        return back()->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function destroyCourt(\App\Models\Court $court)
    {
        $court->delete();
        return back()->with('success', 'Lapangan berhasil dihapus.');
    }
}
