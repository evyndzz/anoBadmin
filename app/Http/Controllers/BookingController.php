<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Court;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function getSlots(Request $request, Court $court)
    {
        $date = $request->date ?? Carbon::today()->format('Y-m-d');
        
        $bookedDetails = BookingDetail::where('court_id', $court->id)
            ->whereHas('booking', function($q) use ($date) {
                $q->where('date', $date)
                  ->whereIn('status', ['paid', 'completed']); // User instruction: "jangan dimerahkan jika baru dipesan (pending)"
            })->get();

        $dayNameIndo = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
        $dayNameId = $dayNameIndo[Carbon::parse($date)->format('l')];
        $memberSchedules = \App\Models\MemberSchedule::where('court_id', $court->id)->get();

        $slots = [];
        for ($i = 8; $i <= 23; $i++) {
            $time = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
            $isBooked = false;
            
            // Cek booking reguler (hanya paid/completed)
            foreach ($bookedDetails as $detail) {
                $startHour = (int) explode(':', $detail->start_time)[0];
                $endHour = (int) explode(':', $detail->end_time)[0];
                if ($i >= $startHour && $i < $endHour) {
                    $isBooked = true;
                    break;
                }
            }

            // Cek membership schedule
            if (!$isBooked) {
                foreach ($memberSchedules as $sched) {
                    if (stripos($sched->days, $dayNameId) !== false) {
                        $startHour = (int) explode(':', $sched->start_time)[0];
                        $endHour = (int) explode(':', $sched->end_time)[0];
                        if ($i >= $startHour && $i < $endHour) {
                            $isBooked = true;
                            break;
                        }
                    }
                }
            }
            
            $slots[] = [
                'time' => $time,
                'available' => !$isBooked
            ];
        }

        return response()->json($slots);
    }

    public function create()
    {
        $courts = \App\Models\Court::all();
        $promos = [];
        if(auth()->user()->role === 'user') {
            $promos = auth()->user()->promos()->wherePivot('is_used', false)->get();
        }
        return view('bookings.create', compact('courts', 'promos'));
    }

    public function index()
    {
        $bookings = auth()->user()->bookings()->with('details.court', 'payment')->orderBy('created_at', 'desc')->get();
        return view('bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== null) {
            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'Silakan login untuk melihat booking ini.');
            }
            if ($booking->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
                abort(403);
            }
        }
        $booking->load('details.court', 'payment');
        return view('bookings.show', compact('booking'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:1|max:5',
        ]);

        $court = Court::findOrFail($request->court_id);
        
        $startTime = Carbon::createFromFormat('H:i', $request->start_time);
        $endTime = (clone $startTime)->addHours((int) $request->duration);

        // Cek konflik dengan booking reguler
        $conflict = BookingDetail::where('court_id', $court->id)
            ->whereHas('booking', function($q) use ($request) {
                $q->where('date', $request->date)
                  ->whereIn('status', ['paid', 'completed']);
            })
            ->where(function($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime->format('H:i'), $endTime->format('H:i')])
                  ->orWhereBetween('end_time', [$startTime->format('H:i'), $endTime->format('H:i')]);
            })
            ->exists();

        // Cek konflik dengan member schedule
        if (!$conflict) {
            $dayNameIndo = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
            $dayNameId = $dayNameIndo[\Carbon\Carbon::parse($request->date)->format('l')];
            
            $memberSchedules = \App\Models\MemberSchedule::where('court_id', $court->id)->get();
            foreach ($memberSchedules as $sched) {
                if (stripos($sched->days, $dayNameId) !== false) {
                    $schedStart = \Carbon\Carbon::createFromFormat('H:i:s', $sched->start_time);
                    $schedEnd = \Carbon\Carbon::createFromFormat('H:i:s', $sched->end_time);
                    if ($startTime < $schedEnd && $endTime > $schedStart) {
                        $conflict = true;
                        break;
                    }
                }
            }
        }

        if ($conflict) {
            return back()->withErrors(['time' => 'Jadwal yang dipilih tidak tersedia (sudah dibooking atau jadwal khusus member).']);
        }

        $totalPrice = $court->price_per_hour * $request->duration;

        $discount = 0;
        
        // Cek Promo
        if ($request->has('promo_id') && $request->promo_id) {
            $promo = \App\Models\Promo::find($request->promo_id);
            if ($promo) {
                // Pastikan user memilikinya dan belum terpakai
                $hasPromo = auth()->user()->promos()->wherePivot('promo_id', $promo->id)->wherePivot('is_used', false)->first();
                if ($hasPromo) {
                    $discount = ($totalPrice * $promo->discount_percent) / 100;
                    
                    // Tandai terpakai
                    auth()->user()->promos()->updateExistingPivot($promo->id, ['is_used' => true]);
                }
            }
        }

        $bookingCode = 'BK' . date('YmdHis') . strtoupper(Str::random(4));

        $finalPrice = max(0, $totalPrice - $discount);
        $status = $finalPrice <= 0 ? 'completed' : 'pending';

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'user_id' => auth()->id(),
            'date' => $request->date,
            'total_price' => $finalPrice,
            'discount_applied' => $discount,
            'status' => $status
        ]);

        BookingDetail::create([
            'booking_id' => $booking->id,
            'court_id' => $court->id,
            'start_time' => $startTime->format('H:i'),
            'end_time' => $endTime->format('H:i'),
            'price' => $totalPrice
        ]);

        if ($status === 'completed') {
            // Auto tambahkan poin jika booking gratis
            auth()->user()->points_balance += ($request->duration * 10);
            auth()->user()->save();
            return redirect()->route('bookings.show', $booking)->with('success', 'Booking berhasil! Anda menggunakan voucher gratis 100%.');
        }

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function storeGuest(Request $request)
    {
        // Similar to store but for guest without auth
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'guest_name' => 'required|string|max:255',
            'guest_phone' => 'required|string|max:20',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:1|max:5',
        ]);

        $court = Court::findOrFail($request->court_id);
        
        $startTime = Carbon::createFromFormat('H:i', $request->start_time);
        $endTime = (clone $startTime)->addHours((int) $request->duration);

        // Cek konflik dengan booking reguler
        $conflict = BookingDetail::where('court_id', $court->id)
            ->whereHas('booking', function($q) use ($request) {
                $q->where('date', $request->date)
                  ->whereIn('status', ['paid', 'completed']);
            })
            ->where(function($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime->format('H:i'), $endTime->format('H:i')])
                  ->orWhereBetween('end_time', [$startTime->format('H:i'), $endTime->format('H:i')]);
            })
            ->exists();

        // Cek konflik dengan member schedule
        if (!$conflict) {
            $dayNameIndo = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
            $dayNameId = $dayNameIndo[\Carbon\Carbon::parse($request->date)->format('l')];
            
            $memberSchedules = \App\Models\MemberSchedule::where('court_id', $court->id)->get();
            foreach ($memberSchedules as $sched) {
                if (stripos($sched->days, $dayNameId) !== false) {
                    $schedStart = \Carbon\Carbon::createFromFormat('H:i:s', $sched->start_time);
                    $schedEnd = \Carbon\Carbon::createFromFormat('H:i:s', $sched->end_time);
                    if ($startTime < $schedEnd && $endTime > $schedStart) {
                        $conflict = true;
                        break;
                    }
                }
            }
        }

        if ($conflict) {
            return back()->withErrors(['time' => 'Jadwal yang dipilih tidak tersedia (sudah dibooking atau jadwal khusus member).']);
        }

        $totalPrice = $court->price_per_hour * $request->duration;

        $bookingCode = 'BK' . date('YmdHis') . strtoupper(Str::random(4));

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'guest_name' => $request->guest_name,
            'guest_phone' => $request->guest_phone,
            'date' => $request->date,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        BookingDetail::create([
            'booking_id' => $booking->id,
            'court_id' => $court->id,
            'start_time' => $startTime->format('H:i'),
            'end_time' => $endTime->format('H:i'),
            'price' => $totalPrice
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking guest berhasil. Silakan scan QR untuk membayar.');
    }

    public function pay(Request $request, Booking $booking)
    {
        // Cek apakah slot sudah diambil oleh orang lain yang sudah bayar lebih dulu
        foreach ($booking->details as $detail) {
            $conflict = BookingDetail::where('court_id', $detail->court_id)
                ->where('id', '!=', $detail->id)
                ->whereHas('booking', function($q) use ($booking) {
                    $q->where('date', $booking->date)
                      ->whereIn('status', ['paid', 'completed']);
                })
                ->where(function($q) use ($detail) {
                    $q->whereBetween('start_time', [$detail->start_time, $detail->end_time])
                      ->orWhereBetween('end_time', [$detail->start_time, $detail->end_time]);
                })
                ->exists();

            if ($conflict) {
                // Batalkan booking ini karena kalah cepat bayar
                $booking->update(['status' => 'cancelled']);
                return back()->with('error', 'Maaf, lapangan ini sudah dibayar oleh pelanggan lain terlebih dahulu. Booking Anda dibatalkan.');
            }
        }

        // Simulasikan pembayaran otomatis (Bypass Upload)
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_price,
            'payment_method' => 'QRIS (Automated)',
            'status' => 'verified', // Langsung verified
            'proof_image' => null
        ]);

        $booking->update(['status' => 'paid']);

        // Jika user login, tambahkan poin
        if ($booking->user_id) {
            $user = \App\Models\User::find($booking->user_id);
            if ($user) {
                // Hitung durasi
                $details = $booking->details;
                $duration = 0;
                foreach ($details as $detail) {
                    $start = \Carbon\Carbon::parse($detail->start_time);
                    $end = \Carbon\Carbon::parse($detail->end_time);
                    $duration += $end->diffInHours($start);
                }
                
                $user->points_balance += ($duration * 10);
                $user->save();
            }
        }

        return back()->with('success', 'Pembayaran berhasil disimulasikan! Status booking sekarang menjadi Lunas.');
    }
}
