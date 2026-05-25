<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class RevenueAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_revenue_analysis(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this
            ->actingAs($user)
            ->postJson(route('admin.analytics.revenue'), [
                'period' => '7'
            ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_access_revenue_analysis(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this
            ->actingAs($admin)
            ->postJson(route('admin.analytics.revenue'), [
                'period' => '7'
            ]);

        // When database has no bookings/transactions, it returns is_empty => true
        $response->assertOk()
            ->assertJson([
                'success' => true,
                'is_empty' => true,
                'period_label' => '7 Hari Terakhir'
            ]);
    }

    public function test_validation_fails_for_invalid_period(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this
            ->actingAs($admin)
            ->postJson(route('admin.analytics.revenue'), [
                'period' => 'invalid-period'
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false
            ])
            ->assertJsonStructure(['message']);
    }

    public function test_validation_fails_for_custom_period_with_missing_dates(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this
            ->actingAs($admin)
            ->postJson(route('admin.analytics.revenue'), [
                'period' => 'custom'
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false
            ])
            ->assertJsonStructure(['message']);
    }

    public function test_validation_fails_for_custom_period_exceeding_365_days(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // 2025-01-01 to 2026-01-01 is 366 inclusive days, which exceeds the 365-day cap.
        $response = $this
            ->actingAs($admin)
            ->postJson(route('admin.analytics.revenue'), [
                'period' => 'custom',
                'start_date' => '2025-01-01',
                'end_date' => '2026-01-01'
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Rentang tanggal custom maksimal adalah 365 hari.'
            ]);
    }

    public function test_service_aggregates_booking_revenue_by_creation_timestamp(): void
    {
        $startDate = \Illuminate\Support\Carbon::parse('2026-05-20');
        $endDate = \Illuminate\Support\Carbon::parse('2026-05-22');

        // Create booking created inside the range and completed
        \Illuminate\Support\Carbon::setTestNow('2026-05-21 10:00:00');
        \App\Models\Booking::create([
            'booking_code' => 'BK_INSIDE',
            'date' => '2026-05-21',
            'total_price' => 150000,
            'discount_applied' => 0,
            'status' => 'completed',
            'paid_at' => '2026-05-21 15:30:00',
        ]);

        // Create booking created inside the range but NOT paid/completed (pending)
        \App\Models\Booking::create([
            'booking_code' => 'BK_OUTSIDE',
            'date' => '2026-05-21',
            'total_price' => 200000,
            'discount_applied' => 0,
            'status' => 'pending', // unpaid
            'paid_at' => null,
        ]);

        // Create booking completed but created outside the range (May 25)
        \Illuminate\Support\Carbon::setTestNow('2026-05-25 10:00:00');
        \App\Models\Booking::create([
            'booking_code' => 'BK_OUTSIDE_PAID',
            'date' => '2026-05-25',
            'total_price' => 250000,
            'discount_applied' => 0,
            'status' => 'paid',
            'paid_at' => '2026-05-25 12:00:00',
        ]);

        // Reset test time
        \Illuminate\Support\Carbon::setTestNow();

        $service = new \App\Services\RevenueAnalyzerService();
        $result = $service->analyze($startDate, $endDate);

        $this->assertTrue($result['success']);
        $this->assertFalse($result['is_empty']);
        $dataset = $result['data']['dataset'];

        // Dataset should span 3 days: 2026-05-20, 2026-05-21, 2026-05-22
        $this->assertCount(3, $dataset);

        // Find the record for 2026-05-21
        $targetDay = collect($dataset)->firstWhere('date', '2026-05-21');
        $this->assertNotNull($targetDay);
        // It should include the 150,000 completed booking but exclude the pending 200,000 and the 250,000 created on 25th
        $this->assertEquals(150000, $targetDay['booking_revenue']);
        $this->assertEquals(150000, $targetDay['amount']);
    }

    public function test_cache_hits_preserve_original_response(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Put a custom value in Cache to verify it is retrieved on the second call (cache hit)
        $startDate = \Illuminate\Support\Carbon::now()->subDays(6)->startOfDay();
        $endDate = \Illuminate\Support\Carbon::now()->endOfDay();
        $monthlyTarget = (int) config('services.analytics.monthly_target', 50000000);
        $periodHash = md5($startDate->toDateString() . '_' . $endDate->toDateString() . '_' . $monthlyTarget);
        $cacheKey = "revenue_analysis:{$admin->id}:{$periodHash}";

        $customCachedData = [
            'success' => true,
            'is_empty' => false,
            'data' => [
                'period' => [
                    'start_date' => $startDate->toDateString(),
                    'end_date' => $endDate->toDateString(),
                    'total_days' => 7,
                ],
                'dataset' => [],
                'statistics' => [
                    'total' => 999999.0, // custom value
                ],
                'occupancy' => [],
                'growth' => [],
                'scoring' => [],
                'projection' => null,
                'recommendations' => [],
            ]
        ];
        Cache::put($cacheKey, $customCachedData, 600);

        // Call (should be a cache hit and return our custom cached data)
        $response2 = $this
            ->actingAs($admin)
            ->postJson(route('admin.analytics.revenue'), [
                'period' => '7'
            ]);

        $response2->assertOk();
        $this->assertEquals(999999.0, $response2->json('data.statistics.total'));
    }

    public function test_scoring_rules_and_grade_bands(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Setting a mock monthly target of 1,000,000 for simplified test assertions
        config(['services.analytics.monthly_target' => 1000000]);

        $startDate = \Illuminate\Support\Carbon::parse('2026-05-01');
        $endDate = \Illuminate\Support\Carbon::parse('2026-05-07');

        // Let's create:
        // total price from booking = 250,000 (completes success bookings)
        // total price from transactions = 250,000 (total = 500,000)
        // So target achievement ratio = 500,000 / 1,000,000 = 50% => targetScore = 50.0
        // membership contribution = 250,000 / 500,000 = 50% => normalized to 100% against 50% threshold => membershipScore = 100.0
        // occupancy = 2 success, 2 cancelled => rate = 50.0% => occupancyScore = 50.0
        // Combined score = 50.0 * 0.40 + 50.0 * 0.30 + 100.0 * 0.30 = 20.0 + 15.0 + 30.0 = 65.0
        // 65.0 score maps to Grade C (C is between 55 and 69)

        \Illuminate\Support\Carbon::setTestNow('2026-05-02 10:00:00');
        \App\Models\Booking::create([
            'booking_code' => 'BK_S1',
            'date' => '2026-05-02',
            'total_price' => 125000,
            'discount_applied' => 0,
            'status' => 'completed',
            'paid_at' => '2026-05-02 10:00:00',
        ]);
        \App\Models\Booking::create([
            'booking_code' => 'BK_C1',
            'date' => '2026-05-02',
            'total_price' => 100000,
            'discount_applied' => 0,
            'status' => 'cancelled',
        ]);

        \Illuminate\Support\Carbon::setTestNow('2026-05-04 10:00:00');
        \App\Models\Booking::create([
            'booking_code' => 'BK_S2',
            'date' => '2026-05-04',
            'total_price' => 125000,
            'discount_applied' => 0,
            'status' => 'paid',
            'paid_at' => '2026-05-04 10:00:00',
        ]);
        \App\Models\Booking::create([
            'booking_code' => 'BK_C2',
            'date' => '2026-05-04',
            'total_price' => 100000,
            'discount_applied' => 0,
            'status' => 'cancelled',
        ]);

        \App\Models\Transaction::create([
            'user_id' => $admin->id,
            'type' => 'membership',
            'amount' => 250000,
            'status' => 'success',
            'reference_id' => 99,
        ]);

        \Illuminate\Support\Carbon::setTestNow();

        $service = new \App\Services\RevenueAnalyzerService();
        $result = $service->analyze($startDate, $endDate);

        $this->assertTrue($result['success']);
        $scoring = $result['data']['scoring'];

        $this->assertEquals(65.0, $scoring['score']);
        $this->assertEquals('C', $scoring['grade']);
        $this->assertEquals(50.0, $scoring['criteria']['target']['score']);
        $this->assertEquals(50.0, $scoring['criteria']['occupancy']['score']);
        $this->assertEquals(100.0, $scoring['criteria']['membership']['score']);
    }

    public function test_booking_revenue_by_payment_timestamp_boundary(): void
    {
        $startDate = \Illuminate\Support\Carbon::parse('2026-05-20');
        $endDate = \Illuminate\Support\Carbon::parse('2026-05-22');

        // Case A: Created OUTSIDE the range (May 10), but paid INSIDE the range (May 21).
        // Since it is paid inside the range, it SHOULD be counted.
        \Illuminate\Support\Carbon::setTestNow('2026-05-10 10:00:00');
        \App\Models\Booking::create([
            'booking_code' => 'BK_OUTSIDE_CREATED_INSIDE_PAID',
            'date' => '2026-05-10',
            'total_price' => 120000,
            'discount_applied' => 0,
            'status' => 'completed',
            'paid_at' => '2026-05-21 11:00:00',
        ]);

        // Case B: Created INSIDE the range (May 21), but paid OUTSIDE the range (May 25).
        // Since it is paid outside the range, it SHOULD NOT be counted in the analyzed range.
        \Illuminate\Support\Carbon::setTestNow('2026-05-21 10:00:00');
        \App\Models\Booking::create([
            'booking_code' => 'BK_INSIDE_CREATED_OUTSIDE_PAID',
            'date' => '2026-05-21',
            'total_price' => 180000,
            'discount_applied' => 0,
            'status' => 'completed',
            'paid_at' => '2026-05-25 15:00:00',
        ]);

        // Reset test time
        \Illuminate\Support\Carbon::setTestNow();

        $service = new \App\Services\RevenueAnalyzerService();
        $result = $service->analyze($startDate, $endDate);

        $this->assertTrue($result['success']);
        $this->assertFalse($result['is_empty']);
        $dataset = $result['data']['dataset'];

        // Find the record for 2026-05-21
        $targetDay = collect($dataset)->firstWhere('date', '2026-05-21');
        $this->assertNotNull($targetDay);
        // It should include the 120,000 (paid on May 21) but exclude the 180,000 (paid on May 25)
        $this->assertEquals(120000, $targetDay['booking_revenue']);
        $this->assertEquals(120000, $targetDay['amount']);
    }

    public function test_multi_month_projection_overlap(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Let's set the test now to a fixed date in the middle of a month
        \Illuminate\Support\Carbon::setTestNow('2026-05-15 12:00:00');
        
        $startDate = \Illuminate\Support\Carbon::parse('2026-04-15');
        $endDate = \Illuminate\Support\Carbon::parse('2026-06-15');

        // Create at least one paid booking inside the current month (May 10) so the dataset has revenue
        \App\Models\Booking::create([
            'booking_code' => 'BK_CURRENT_MONTH',
            'date' => '2026-05-10',
            'total_price' => 100000,
            'discount_applied' => 0,
            'status' => 'completed',
            'paid_at' => '2026-05-10 10:00:00',
        ]);

        $service = new \App\Services\RevenueAnalyzerService();
        $result = $service->analyze($startDate, $endDate);

        $this->assertTrue($result['success']);
        $this->assertFalse($result['is_empty']);
        
        // Assert that projection is present (not null) because the period overlaps with the current month (May 2026)
        $this->assertNotNull($result['data']['projection']);
        $this->assertEquals(100000, $result['data']['projection']['revenue_so_far']);

        \Illuminate\Support\Carbon::setTestNow();
    }
}
