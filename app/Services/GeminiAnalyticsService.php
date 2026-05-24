<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class GeminiAnalyticsService
{
    /**
     * Build the daily revenue dataset between two dates.
     *
     * @param Carbon $start
     * @param Carbon $end
     * @return array
     */
    public function buildRevenueDataset(Carbon $start, Carbon $end): array
    {
        $startDate = $start->copy()->startOfDay();
        $endDate = $end->copy()->endOfDay();

        // Aggregate daily revenue from Bookings (paid/completed)
        $bookings = Booking::selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->whereIn('status', ['paid', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupByRaw('DATE(created_at)')
            ->get();

        // Aggregate daily revenue from Transactions (membership, success)
        $transactions = Transaction::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->where('status', 'success')
            ->where('type', 'membership')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupByRaw('DATE(created_at)')
            ->get();

        // Combine daily data
        $data = [];
        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            $dateStr = $current->toDateString();
            $data[$dateStr] = [
                'date' => $dateStr,
                'booking_revenue' => 0.0,
                'membership_revenue' => 0.0,
                'total_revenue' => 0.0,
            ];
            $current->addDay();
        }

        foreach ($bookings as $booking) {
            $dateStr = Carbon::parse($booking->date)->toDateString();
            if (isset($data[$dateStr])) {
                $val = (float)$booking->total;
                $data[$dateStr]['booking_revenue'] = $val;
                $data[$dateStr]['total_revenue'] += $val;
            }
        }

        foreach ($transactions as $transaction) {
            $dateStr = Carbon::parse($transaction->date)->toDateString();
            if (isset($data[$dateStr])) {
                $val = (float)$transaction->total;
                $data[$dateStr]['membership_revenue'] = $val;
                $data[$dateStr]['total_revenue'] += $val;
            }
        }

        return array_values($data);
    }

    /**
     * Analyze revenue using Gemini AI.
     *
     * @param Carbon $start
     * @param Carbon $end
     * @return array
     */
    public function analyzeRevenue(Carbon $start, Carbon $end): array
    {
        $startDate = $start->copy()->startOfDay();
        $endDate = $end->copy()->endOfDay();

        // Cache parameters
        $adminUserId = auth()->id() ?? 'guest';
        $model = config('services.gemini.model', 'gemini-2.5-flash');
        $periodHash = md5($startDate->toDateString() . '_' . $endDate->toDateString() . '_' . $model);
        $cacheKey = "gemini:revenue:{$adminUserId}:{$periodHash}";

        // Return from cache if exists
        $cached = Cache::get($cacheKey);
        if ($cached) {
            return $cached;
        }

        $dataset = $this->buildRevenueDataset($startDate, $endDate);

        $totalBooking = 0.0;
        $totalMembership = 0.0;
        foreach ($dataset as $day) {
            $totalBooking += $day['booking_revenue'];
            $totalMembership += $day['membership_revenue'];
        }

        // Call Gemini API - aligned with config services.gemini.key
        $apiKey = config('services.gemini.key');

        if (empty($apiKey)) {
            Log::warning('Gemini API Key is not configured.');
            return [
                'success' => false,
                'message' => 'API Key Gemini belum dikonfigurasi di server. Harap hubungi administrator.',
            ];
        }

        $prompt = "Anda adalah AI Revenue Analyst profesional untuk sistem manajemen lapangan badminton 'anoBadmin'.
Tugas Anda adalah menganalisis data pendapatan harian dari booking reguler lapangan dan transaksi membership untuk periode {$startDate->toDateString()} hingga {$endDate->toDateString()}.

Berikut adalah data pendapatan harian (dalam Rupiah) yang berhasil dikumpulkan:
" . json_encode($dataset, JSON_PRETTY_PRINT) . "

Total Pendapatan Booking Reguler: Rp " . number_format($totalBooking, 0, ',', '.') . "
Total Pendapatan Membership: Rp " . number_format($totalMembership, 0, ',', '.') . "
Total Pendapatan Keseluruhan: Rp " . number_format($totalBooking + $totalMembership, 0, ',', '.') . "

Instruksi Analisis:
1. Berikan analisis profesional, informatif, dan mendalam dalam Bahasa Indonesia.
2. Format output harus menggunakan Markdown yang rapi dengan heading dan elemen-elemen modern yang sesuai.
3. Anda WAJIB membagi analisis Anda ke dalam 4 bagian utama berikut dengan judul yang persis sama:
   - ## Ringkasan Tren
     (Gambarkan bagaimana tren pendapatan keseluruhan selama periode ini, apakah cenderung naik, turun, atau fluktuatif, serta apa kontributor terbesarnya.)
   - ## Hari Puncak & Sepi
     (Identifikasi hari-hari tertentu dengan pendapatan tertinggi/puncak dan terendah/sepi. Berikan insight/analisis mengapa hari-hari tersebut memiliki performa seperti itu, misalnya hari libur, akhir pekan, atau pola pemesanan.)
   - ## Proyeksi Bulan Berjalan
     (Berikan proyeksi atau estimasi performa pendapatan untuk sisa bulan ini atau bulan depan berdasarkan tren saat ini, beserta target realistis yang dapat dicapai.)
   - ## Catatan
     (Berikan rekomendasi taktis atau saran operasional yang konkret berdasarkan temuan Anda untuk meningkatkan pendapatan, seperti promo khusus hari sepi, penawaran membership, atau optimasi jadwal lapangan.)

4. Jangan menyertakan salam pembuka atau penutup. Langsung mulai dengan analisis Ringkasan Tren.";

        try {
            $response = Http::timeout(20)->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->failed()) {
                Log::warning("Gemini API HTTP Error: " . $response->status() . " - " . $response->body());
                return [
                    'success' => false,
                    'message' => 'Gagal terhubung dengan layanan Gemini AI (HTTP Error). Silakan coba beberapa saat lagi.'
                ];
            }

            $responseData = $response->json();
            $markdown = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (empty($markdown)) {
                Log::warning("Gemini API returned an empty or invalid response: " . json_encode($responseData));
                return [
                    'success' => false,
                    'message' => 'Layanan Gemini AI mengembalikan respon kosong atau tidak valid.'
                ];
            }

            $result = [
                'success' => true,
                'markdown' => $markdown,
                'period' => [
                    'start_date' => $startDate->toDateString(),
                    'end_date' => $endDate->toDateString(),
                    'total_days' => (int) ($startDate->diffInDays($endDate) + 1),
                ],
                'summary_stats' => [
                    'total_booking_revenue' => (float) $totalBooking,
                    'total_membership_revenue' => (float) $totalMembership,
                    'total_revenue' => (float) ($totalBooking + $totalMembership),
                ],
                'generated_at' => now()->toIso8601String()
            ];

            // Cache for 30 minutes
            Cache::put($cacheKey, $result, now()->addMinutes(30));

            return $result;

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::warning("Gemini API Connection Timeout: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Koneksi ke Gemini AI mengalami timeout (melebihi batas 20 detik).'
            ];
        } catch (\Exception $e) {
            Log::warning("Gemini API general exception: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan internal saat menghubungi Gemini AI.'
            ];
        }
    }

    /**
     * Get revenue analysis based on period string.
     * Backwards-compatible wrapper that delegates to analyzeRevenue.
     *
     * @param string $period
     * @param string|null $startInput
     * @param string|null $endInput
     * @return array
     */
    public function getRevenueAnalysis(string $period, ?string $startInput = null, ?string $endInput = null): array
    {
        $now = Carbon::now();

        if ($period === 'custom') {
            $startDate = Carbon::parse($startInput)->startOfDay();
            $endDate = Carbon::parse($endInput)->endOfDay();
            $periodLabel = "Periode Kustom (" . Carbon::parse($startInput)->format('d M Y') . " - " . Carbon::parse($endInput)->format('d M Y') . ")";
        } else {
            $days = intval($period);
            $startDate = $now->copy()->subDays($days - 1)->startOfDay();
            $endDate = $now->copy()->endOfDay();
            $periodLabel = "{$days} Hari Terakhir";
        }

        $result = $this->analyzeRevenue($startDate, $endDate);

        if ($result['success']) {
            $result['period_label'] = $periodLabel;
            if (!isset($result['generated_at'])) {
                $result['generated_at'] = now()->toIso8601String();
            }
        }

        return $result;
    }
}
