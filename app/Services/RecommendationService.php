<?php

namespace App\Services;

use App\Models\User;
use App\Models\Membership;
use App\Models\Promo;
use Illuminate\Support\Carbon;

class RecommendationService
{
    /**
     * Get membership recommendation based on user activity.
     */
    public function getMembershipRecommendation(User $user)
    {
        $currentMonthBookings = $user->bookings()
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $totalSpent = $user->bookings()->where('status', 'completed')->sum('total_price');

        // Simple Rule-Based / Fuzzy Logic
        if ($currentMonthBookings > 10 && $totalSpent > 1000000) {
            return Membership::where('name', 'Supah Ano')->first();
        }

        if ($currentMonthBookings > 5 && $totalSpent > 300000) {
            return Membership::where('name', 'Ano Member')->first();
        }

        return null; // No specific recommendation
    }

    /**
     * Get promo recommendations based on user's points and activity
     */
    public function getPromoRecommendations(User $user)
    {
        $promos = Promo::where('is_active', true)->get();
        $recommended = [];

        foreach ($promos as $promo) {
            // Rule: If user has enough points and total spent > min_transaction
            if ($user->points_balance >= $promo->points_required && $user->total_spent >= $promo->min_transaction) {
                $recommended[] = $promo;
            }
        }

        return $recommended;
    }
}
