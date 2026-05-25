<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class RevenueAnalyzerService
{
    /**
     * Analyze daily revenue, occupancy rate, growth and projections,
     * and generate recommendations using rule-based algorithms.
     *
     * @param Carbon $start
     * @param Carbon $end
     * @param int|null $monthlyTarget
     * @return array
     */
    public function analyze(Carbon $start, Carbon $end, ?int $monthlyTarget = null): array
    {
        $startDate = $start->copy()->startOfDay();
        $endDate = $end->copy()->endOfDay();
        $monthlyTarget = $monthlyTarget ?? (int) config('services.analytics.monthly_target', 50000000);

        $adminId = auth()->id() ?? 'guest';
        $periodHash = md5($startDate->toDateString() . '_' . $endDate->toDateString() . '_' . $monthlyTarget);
        $cacheKey = "revenue_analysis:{$adminId}:{$periodHash}";

        return Cache::remember($cacheKey, 600, function () use ($startDate, $endDate, $monthlyTarget) {
            $days = $startDate->diffInDays($endDate) + 1;

            // 1. Build chronological daily dataset
            $dataset = $this->buildRevenueDataset($startDate, $endDate);

            // Calculate total revenue
            $totalRevenue = array_sum(array_column($dataset, 'amount'));

            // Detect empty period based on total revenue being zero
            if ($totalRevenue === 0.0) {
                return [
                    'success' => true,
                    'is_empty' => true,
                    'data' => [
                        'period' => [
                            'start_date' => $startDate->toDateString(),
                            'end_date' => $endDate->toDateString(),
                            'total_days' => $days,
                        ],
                    ]
                ];
            }

            // 2. Compute statistics
            $stats = $this->calculateStatistics($dataset);

            // 3. Occupancy details (includes cancelled_ratio)
            $occupancy = $this->calculateOccupancy($startDate, $endDate);

            // 4. Growth & Trend
            $growth = $this->calculateGrowth($startDate, $endDate, $stats['total']);

            // 5. Scoring
            $scoring = $this->calculateScoring($stats['total'], $days, $monthlyTarget, $occupancy['occupancy_rate'], $stats['total_membership']);

            // 6. Monthly Projection (only if the period contains current month)
            $projection = null;
            $now = Carbon::now();
            $startOfMonth = $now->copy()->startOfMonth();
            $endOfMonth = $now->copy()->endOfMonth();
            $containsCurrentMonth = $startDate->lte($endOfMonth) && $endDate->gte($startOfMonth);

            if ($containsCurrentMonth) {
                $projection = $this->calculateMonthlyProjection($monthlyTarget);
            }

            // 7. Recommendations (verbatim conditional checks aligned with spec 3.5)
            $recommendations = $this->generateRecommendations($stats, $occupancy['occupancy_rate'], $scoring, $growth, $occupancy);

            return [
                'success' => true,
                'is_empty' => false,
                'data' => [
                    'period' => [
                        'start_date' => $startDate->toDateString(),
                        'end_date' => $endDate->toDateString(),
                        'total_days' => $days,
                    ],
                    'dataset' => $dataset,
                    'statistics' => $stats,
                    'occupancy' => $occupancy,
                    'growth' => $growth,
                    'scoring' => $scoring,
                    'projection' => $projection,
                    'recommendations' => $recommendations,
                ]
            ];
        });
    }

    /**
     * Build chronological daily revenue dataset
     */
    private function buildRevenueDataset(Carbon $startDate, Carbon $endDate): array
    {
        // Get all completed/paid bookings within range
        $bookings = Booking::selectRaw('DATE(paid_at) as date, SUM(total_price) as total')
            ->whereIn('status', ['paid', 'completed'])
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->groupByRaw('DATE(paid_at)')
            ->pluck('total', 'date')
            ->toArray();

        // Get success membership transactions within range
        $transactions = Transaction::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->where('status', 'success')
            ->where('type', 'membership')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupByRaw('DATE(created_at)')
            ->pluck('total', 'date')
            ->toArray();

        $dataset = [];
        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            $dateStr = $current->toDateString();
            $bookingRev = (float) ($bookings[$dateStr] ?? 0.0);
            $membershipRev = (float) ($transactions[$dateStr] ?? 0.0);
            $totalAmount = $bookingRev + $membershipRev;

            $dataset[] = [
                'date' => $dateStr,
                'booking_revenue' => $bookingRev,
                'membership_revenue' => $membershipRev,
                'amount' => $totalAmount,
            ];
            $current->addDay();
        }

        return $dataset;
    }

    /**
     * Calculate statistical indicators
     */
    private function calculateStatistics(array $dataset): array
    {
        $amounts = array_column($dataset, 'amount');
        $total = (float) array_sum($amounts);
        $totalBooking = (float) array_sum(array_column($dataset, 'booking_revenue'));
        $totalMembership = (float) array_sum(array_column($dataset, 'membership_revenue'));
        $count = count($amounts);

        if ($count === 0) {
            return [
                'total' => 0.0,
                'total_booking' => 0.0,
                'total_membership' => 0.0,
                'mean' => 0.0,
                'median' => 0.0,
                'std_dev' => 0.0,
                'min' => 0.0,
                'max' => 0.0,
                'coefficient_of_variation' => 0.0,
                'peak_day' => ['date' => null, 'amount' => 0.0],
                'low_day' => ['date' => null, 'amount' => 0.0],
            ];
        }

        $mean = $total / $count;

        // Median
        $sortedAmounts = $amounts;
        sort($sortedAmounts);
        $mid = intval($count / 2);
        if ($count % 2 === 0) {
            $median = ($sortedAmounts[$mid - 1] + $sortedAmounts[$mid]) / 2.0;
        } else {
            $median = (float) $sortedAmounts[$mid];
        }

        // Standard Deviation (Population)
        $varianceSum = 0.0;
        foreach ($amounts as $val) {
            $varianceSum += pow($val - $mean, 2);
        }
        $stdDev = sqrt($varianceSum / $count);

        // Coefficient of Variation
        $cv = $mean > 0 ? ($stdDev / $mean) : 0.0;

        $min = (float) min($amounts);
        $max = (float) max($amounts);

        // Filter days with revenue greater than zero for low_day
        $positiveDays = array_filter($dataset, function ($day) {
            return $day['amount'] > 0.0;
        });

        $lowDay = ['date' => null, 'amount' => PHP_FLOAT_MAX];
        $peakDay = ['date' => null, 'amount' => -1.0];

        foreach ($dataset as $day) {
            if ($day['amount'] > $peakDay['amount']) {
                $peakDay = ['date' => $day['date'], 'amount' => $day['amount']];
            }
        }

        if (count($positiveDays) > 0) {
            foreach ($positiveDays as $day) {
                if ($day['amount'] < $lowDay['amount']) {
                    $lowDay = ['date' => $day['date'], 'amount' => $day['amount']];
                }
            }
        } else {
            // Fallback when no day has positive revenue
            $lowDay = ['date' => $dataset[0]['date'] ?? null, 'amount' => 0.0];
        }

        if ($peakDay['date'] === null && $count > 0) {
            $peakDay = ['date' => $dataset[0]['date'], 'amount' => $dataset[0]['amount']];
        }

        return [
            'total' => $total,
            'total_booking' => $totalBooking,
            'total_membership' => $totalMembership,
            'mean' => (float) $mean,
            'median' => (float) $median,
            'std_dev' => (float) $stdDev,
            'min' => $min,
            'max' => $max,
            'coefficient_of_variation' => (float) $cv,
            'peak_day' => $peakDay,
            'low_day' => $lowDay,
        ];
    }

    /**
     * Calculate occupancy rate based on bookings
     */
    public function calculateOccupancy(Carbon $startDate, Carbon $endDate): array
    {
        $success = Booking::whereIn('status', ['paid', 'completed'])
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->count();

        $cancelled = Booking::where('status', 'cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $total = $success + $cancelled;
        $rate = $total > 0 ? ($success / $total) * 100.0 : 0.0;
        $cancelledRatio = $total > 0 ? ($cancelled / $total) * 100.0 : 0.0;

        return [
            'successful_bookings' => $success,
            'cancelled_bookings' => $cancelled,
            'occupancy_rate' => round($rate, 2),
            'cancelled_ratio' => round($cancelledRatio, 2),
        ];
    }

    /**
     * Calculate revenue growth and classify trends
     */
    private function calculateGrowth(Carbon $startDate, Carbon $endDate, float $currentTotal): array
    {
        $days = $startDate->diffInDays($endDate) + 1;
        $prevEndDate = $startDate->copy()->subDay()->endOfDay();
        $prevStartDate = $prevEndDate->copy()->subDays($days - 1)->startOfDay();

        // Calculate previous period's bookings
        $prevBookings = Booking::whereIn('status', ['paid', 'completed'])
            ->whereBetween('paid_at', [$prevStartDate, $prevEndDate])
            ->sum('total_price');

        // Calculate previous period's membership transactions
        $prevTransactions = Transaction::where('status', 'success')
            ->where('type', 'membership')
            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
            ->sum('amount');

        $prevTotal = (float) ($prevBookings + $prevTransactions);

        if ($prevTotal > 0.0) {
            $growthPct = (($currentTotal - $prevTotal) / $prevTotal) * 100.0;
        } else {
            $growthPct = $currentTotal > 0.0 ? 100.0 : 0.0;
        }

        // Trend Classification matching inclusive boundaries exactly
        if ($growthPct >= 20.0) {
            $trend = 'Naik Pesat';
        } elseif ($growthPct >= 5.0) {
            $trend = 'Naik';
        } elseif ($growthPct > -5.0) {
            $trend = 'Stabil';
        } elseif ($growthPct > -20.0) {
            $trend = 'Turun';
        } else {
            $trend = 'Turun Tajam';
        }

        return [
            'previous_total' => $prevTotal,
            'growth_pct' => round($growthPct, 2),
            'trend' => $trend,
            'previous_period' => [
                'start_date' => $prevStartDate->toDateString(),
                'end_date' => $prevEndDate->toDateString(),
            ]
        ];
    }

    /**
     * Calculate 3-criteria scoring
     */
    private function calculateScoring(float $total, int $days, int $monthlyTarget, float $occupancyRate, float $membershipRevenue): array
    {
        // 1. Target Score (40% weight): min(total / target, 1) * 100 (direct configured target, no day-prorating)
        $targetScore = $monthlyTarget > 0 ? min(1.0, $total / $monthlyTarget) * 100.0 : 100.0;

        // 2. Occupancy Score (30% weight): occupancyRate
        $occupancyScore = min(100.0, $occupancyRate);

        // 3. Membership Score (30% weight): min((membershipRevenue / total) / 0.5, 1) * 100
        $membershipPct = $total > 0 ? ($membershipRevenue / $total) : 0.0;
        $membershipScore = min(1.0, $membershipPct / 0.5) * 100.0;

        $finalScore = ($targetScore * 0.40) + ($occupancyScore * 0.30) + ($membershipScore * 0.30);
        $finalScore = round($finalScore, 2);

        // Restored grade bands: A >= 85, B 70-84, C 55-69, D < 55
        if ($finalScore >= 85.0) {
            $grade = 'A';
        } elseif ($finalScore >= 70.0) {
            $grade = 'B';
        } elseif ($finalScore >= 55.0) {
            $grade = 'C';
        } else {
            $grade = 'D';
        }

        return [
            'score' => $finalScore,
            'grade' => $grade,
            'criteria' => [
                'target' => [
                    'score' => round($targetScore, 2),
                    'weight' => 40,
                    'monthly_target' => $monthlyTarget,
                ],
                'occupancy' => [
                    'score' => round($occupancyScore, 2),
                    'weight' => 30,
                    'rate' => $occupancyRate,
                ],
                'membership' => [
                    'score' => round($membershipScore, 2),
                    'weight' => 30,
                    'contribution_pct' => round($membershipPct * 100.0, 2),
                ]
            ]
        ];
    }

    /**
     * Project end of month revenue using linear regression and moving average
     */
    private function calculateMonthlyProjection(int $monthlyTarget): array
    {
        $now = Carbon::now();
        $daysInMonth = $now->daysInMonth;
        $currentDay = $now->day;
        $remainingDays = $daysInMonth - $currentDay;

        // Get daily revenue of current month up to today
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfToday = $now->copy()->endOfDay();

        $dataset = $this->buildRevenueDataset($startOfMonth, $endOfToday);

        $dailyAmounts = array_column($dataset, 'amount');
        $revenueSoFar = (float) array_sum($dailyAmounts);

        // Standard 7-Day Moving Average
        $last7Days = array_slice($dailyAmounts, -7);
        $movingAverage7d = count($last7Days) > 0 ? array_sum($last7Days) / count($last7Days) : 0.0;

        // Simple Linear Regression
        $N = count($dailyAmounts);
        $slope = 0.0;
        $intercept = $N > 0 ? $revenueSoFar / $N : 0.0;

        if ($N > 1) {
            $sumX = 0.0;
            $sumY = 0.0;
            $sumXX = 0.0;
            $sumXY = 0.0;
            for ($i = 0; $i < $N; $i++) {
                $x = $i + 1; // Day of the month
                $y = $dailyAmounts[$i];
                $sumX += $x;
                $sumY += $y;
                $sumXX += $x * $x;
                $sumXY += $x * $y;
            }
            $denominator = ($N * $sumXX) - ($sumX * $sumX);
            if ($denominator != 0.0) {
                $slope = (($N * $sumXY) - ($sumX * $sumY)) / $denominator;
                $intercept = ($sumY - ($slope * $sumX)) / $N;
            }
        }

        // Project remaining days
        $lrProjectedRemaining = 0.0;
        for ($day = $currentDay + 1; $day <= $daysInMonth; $day++) {
            $lrProjectedRemaining += max(0.0, ($slope * $day) + $intercept);
        }

        // Raw projection values under spec contract (no margins applied)
        $projectionLow = $revenueSoFar + ($movingAverage7d * $remainingDays); // Raw MA Projection
        $projectionHigh = $revenueSoFar + $lrProjectedRemaining; // Raw LR Projection
        $projectionMid = ($projectionLow + $projectionHigh) / 2.0;

        // Round all numbers for a cleaner representation
        $projectionLow = round($projectionLow, 2);
        $projectionMid = round($projectionMid, 2);
        $projectionHigh = round($projectionHigh, 2);

        $targetPctLow = $monthlyTarget > 0 ? ($projectionLow / $monthlyTarget) * 100.0 : 0.0;
        $targetPctMid = $monthlyTarget > 0 ? ($projectionMid / $monthlyTarget) * 100.0 : 0.0;
        $targetPctHigh = $monthlyTarget > 0 ? ($projectionHigh / $monthlyTarget) * 100.0 : 0.0;

        return [
            'revenue_so_far' => $revenueSoFar,
            'remaining_days' => $remainingDays,
            'projection_low' => $projectionLow,
            'projection_mid' => $projectionMid,
            'projection_high' => $projectionHigh,
            'target_pct_low' => round($targetPctLow, 2),
            'target_pct_mid' => round($targetPctMid, 2),
            'target_pct_high' => round($targetPctHigh, 2),
            'monthly_target' => $monthlyTarget,
        ];
    }

    /**
     * Rule-based engine to generate business recommendations based verbatim on spec section 3.5
     */
    private function generateRecommendations(array $stats, float $occupancyRate, array $scoring, array $growth, array $occupancy): array
    {
        $recommendations = [];

        // 1. Negative growth plus high volatility
        if ($growth['growth_pct'] < 0.0 && $stats['coefficient_of_variation'] > 0.4) {
            $recommendations[] = [
                'type' => 'volatility_negative',
                'title' => 'Okupansi Tidak Stabil & Tren Negatif',
                'description' => 'Okupansi tidak stabil dengan tren negatif. Disarankan memberlakukan promo flash sale tengah pekan untuk merangsang volume booking.',
                'action_label' => 'Buat Promo Flash Sale',
            ];
        }

        // 2. Weekend peak with weekday low day
        if ($stats['peak_day']['date'] && $stats['low_day']['date']) {
            $peakWeekend = Carbon::parse($stats['peak_day']['date'])->isWeekend();
            $lowWeekday = Carbon::parse($stats['low_day']['date'])->isWeekday();
            if ($peakWeekend && $lowWeekday) {
                $recommendations[] = [
                    'type' => 'weekend_peak_weekday_low',
                    'title' => 'Pola Booking Akhir Pekan Dominan',
                    'description' => 'Pola booking dominan akhir pekan. Rekomendasi insentif weekday dengan poin loyalitas ganda.',
                    'action_label' => 'Atur Poin Loyalitas',
                ];
            }
        }

        // 3. Membership contribution below 20%
        $membershipPct = $stats['total'] > 0 ? ($stats['total_membership'] / $stats['total']) : 0.0;
        if ($stats['total'] > 0 && $membershipPct < 0.20) {
            $recommendations[] = [
                'type' => 'membership_critical',
                'title' => 'Kontribusi Membership Kritis',
                'description' => 'Kontribusi membership kritis (<20%). Jalankan kampanye bundling membership dengan sesi gratis court.',
                'action_label' => 'Buat Bundling Member',
            ];
        }

        // 4. Cancelled ratio above 15%
        if ($occupancyRate > 0 && isset($occupancy['cancelled_ratio']) && $occupancy['cancelled_ratio'] > 15.0) {
            $recommendations[] = [
                'type' => 'high_cancellations',
                'title' => 'Rasio Pembatalan Tinggi',
                'description' => 'Rasio pembatalan tinggi (>15%). Rekomendasikan pengetatan kebijakan refund/reschedule maksimal 24 jam sebelum slot.',
                'action_label' => 'Pengetatan Kebijakan',
            ];
        }

        // 5. Fallback recommendation (Always present to ensure at least one)
        if (count($recommendations) === 0) {
            if ($scoring['score'] >= 85.0) {
                $recommendations[] = [
                    'type' => 'success',
                    'title' => 'Performa Bisnis Luar Biasa',
                    'description' => 'Performa bisnis luar biasa! Pertahankan kualitas pelayanan lapangan dan terus bina hubungan baik dengan member setia AnoBadmin melalui loyalty points.',
                    'action_label' => 'Lihat Ulasan Pelanggan',
                ];
            } else {
                $recommendations[] = [
                    'type' => 'stable',
                    'title' => 'Stabilitas Operasional Terjaga',
                    'description' => 'Pertahankan stabilitas operasional. Pantau terus tingkat keterisian lapangan dan optimalkan strategi pemasaran digital secara konsisten.',
                    'action_label' => 'Analisis Pasar',
                ];
            }
        }

        return $recommendations;
    }
}
