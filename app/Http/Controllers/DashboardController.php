<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Court;
use App\Models\User;
use App\Services\RecommendationService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        $bookings = Booking::with('user', 'details.court')->latest()->take(10)->get();
        $totalCourts = Court::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        
        $totalMembers = User::whereNotNull('membership_id')->count();
        $memberIncreaseThisMonth = User::whereNotNull('membership_id')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();
            
        $memberships = \App\Models\Membership::with('schedules.court')->get();
        $courts = Court::where('is_active', true)->get();

        // Stats for chart
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $daysInMonth = now()->daysInMonth;
        $currentMonthName = now()->translatedFormat('F Y');

        // Booking Revenue (Daily)
        $dailyRevenueBooking = Booking::selectRaw('SUM(total_price) as sum, DAY(created_at) as day')
            ->whereIn('status', ['paid', 'completed'])
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('day')
            ->pluck('sum', 'day')->toArray();
            
        // Membership Revenue (Daily)
        $dailyRevenueMembership = \App\Models\Transaction::selectRaw('SUM(amount) as sum, DAY(created_at) as day')
            ->where('status', 'success')
            ->where('type', 'membership')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('day')
            ->pluck('sum', 'day')->toArray();

        // Total Revenue for current month
        $totalRevenueBooking = Booking::whereIn('status', ['paid', 'completed'])
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_price');
            
        $totalRevenueMembership = \App\Models\Transaction::where('status', 'success')
            ->where('type', 'membership')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('amount');
            
        // Combine for total daily chart
        $dailyRevenue = [];
        for($i=1; $i<=$daysInMonth; $i++) {
            $dailyRevenue[$i] = ($dailyRevenueBooking[$i] ?? 0) + ($dailyRevenueMembership[$i] ?? 0);
        }
        
        return view('dashboard.admin', compact('bookings', 'totalCourts', 'pendingBookings', 'totalMembers', 'memberIncreaseThisMonth', 'memberships', 'courts', 'dailyRevenue', 'dailyRevenueBooking', 'dailyRevenueMembership', 'totalRevenueBooking', 'totalRevenueMembership', 'daysInMonth', 'currentMonthName'));
    }

    public function user(RecommendationService $recommendationService)
    {
        $user = auth()->user();
        $bookings = $user->bookings()->latest()->take(5)->get();
        $points = $user->points_balance;
        
        $membershipRec = $user->membership_id ? null : $recommendationService->getMembershipRecommendation($user);
        $promoRec = $recommendationService->getPromoRecommendations($user);
        
        $schedule = $user->memberSchedules()->with('court')->first();

        return view('dashboard.user', compact('bookings', 'points', 'membershipRec', 'promoRec', 'schedule'));
    }
}
