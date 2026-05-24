<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::with(['schedules' => function($q) {
            $q->where('is_available', true);
        }])->get();
        return view('membership.index', compact('memberships'));
    }

    public function schedules(Membership $membership)
    {
        $membership->load(['schedules' => function($q) {
            $q->where('is_available', true)->with('court');
        }]);
        
        return view('membership.schedules', compact('membership'));
    }

    public function join(Request $request, Membership $membership)
    {
        $user = auth()->user();
        if ($user->membership_id) {
            return redirect()->route('user.dashboard')->with('error', 'Anda sudah memiliki membership aktif. Tunggu hingga masa berlakunya habis.');
        }

        $request->validate([
            'schedule_id' => 'required|exists:member_schedules,id'
        ]);

        $schedule = \App\Models\MemberSchedule::findOrFail($request->schedule_id);

        if (!$schedule->is_available || $schedule->membership_id !== $membership->id) {
            return back()->with('error', 'Jadwal pertemuan tidak tersedia atau tidak sesuai dengan paket membership.');
        }

        // Simpan ke session untuk dilanjutkan ke pembayaran
        session([
            'pending_membership' => [
                'membership_id' => $membership->id,
                'schedule_id' => $schedule->id,
                'price' => $membership->price
            ]
        ]);

        return redirect()->route('membership.payment');
    }

    public function payment()
    {
        $pending = session('pending_membership');
        if (!$pending) {
            return redirect()->route('membership.index')->with('error', 'Tidak ada transaksi membership yang sedang berjalan.');
        }

        $membership = Membership::findOrFail($pending['membership_id']);
        $schedule = \App\Models\MemberSchedule::findOrFail($pending['schedule_id']);
        $price = $pending['price'];

        return view('membership.payment', compact('membership', 'schedule', 'price'));
    }

    public function pay(Request $request)
    {
        $pending = session('pending_membership');
        if (!$pending) {
            return redirect()->route('membership.index')->with('error', 'Transaksi sudah kadaluarsa.');
        }

        $user = auth()->user();
        if ($user->membership_id) {
            session()->forget('pending_membership');
            return redirect()->route('user.dashboard')->with('error', 'Anda sudah memiliki membership aktif.');
        }

        $membership = Membership::findOrFail($pending['membership_id']);
        $schedule = \App\Models\MemberSchedule::findOrFail($pending['schedule_id']);

        if (!$schedule->is_available) {
            session()->forget('pending_membership');
            return redirect()->route('membership.index')->with('error', 'Maaf, jadwal ini sudah diambil orang lain. Silakan pilih jadwal lain.');
        }

        // Proses aktivasi
        $user->membership_id = $membership->id;
        
        // Reward Points
        $bonusPoints = (stripos($membership->name, 'Supah') !== false) ? 350 : 150;
        $user->points_balance += $bonusPoints;
        
        $user->save();

        $schedule->is_available = false;
        $schedule->user_id = $user->id;
        $schedule->save();

        // Rekam transaksi
        \App\Models\Transaction::create([
            'user_id' => $user->id,
            'type' => 'membership',
            'reference_id' => $membership->id,
            'amount' => $pending['price'],
            'status' => 'success'
        ]);

        session()->forget('pending_membership');

        return redirect()->route('user.dashboard')->with('success', 'Pembayaran berhasil disimulasikan! Anda kini berlangganan ' . $membership->name . '.');
    }
}
