<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class GeminiAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_ai_analysis(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this
            ->actingAs($user)
            ->postJson(route('admin.ai.analyze-revenue'), [
                'period' => '7'
            ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_access_ai_analysis_with_successful_mocked_gemini_api(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Mock config services using the spec-aligned key
        config(['services.gemini.key' => 'mock-api-key']);
        config(['services.gemini.model' => 'gemini-2.5-flash']);

        // Mock Http Client for Gemini REST API
        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => "## Ringkasan Tren\nPendapatan stabil.\n\n## Hari Puncak & Sepi\nSabtu ramai.\n\n## Proyeksi Bulan Berjalan\nCenderung naik.\n\n## Catatan\nBagus."]
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $response = $this
            ->actingAs($admin)
            ->postJson(route('admin.ai.analyze-revenue'), [
                'period' => '7'
            ]);

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'markdown',
                'period_label',
                'generated_at',
                'period' => [
                    'start_date',
                    'end_date',
                    'total_days',
                ],
                'summary_stats' => [
                    'total_booking_revenue',
                    'total_membership_revenue',
                    'total_revenue',
                ]
            ])
            ->assertJson([
                'success' => true,
                'period_label' => '7 Hari Terakhir'
            ]);

        $this->assertStringContainsString('Ringkasan Tren', $response->json('markdown'));
    }

    public function test_validation_fails_for_invalid_period(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this
            ->actingAs($admin)
            ->postJson(route('admin.ai.analyze-revenue'), [
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
            ->postJson(route('admin.ai.analyze-revenue'), [
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
            ->postJson(route('admin.ai.analyze-revenue'), [
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
        // Set standard config
        config(['services.gemini.key' => 'mock-api-key']);
        config(['services.gemini.model' => 'gemini-2.5-flash']);

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

        $service = new \App\Services\GeminiAnalyticsService();
        $dataset = $service->buildRevenueDataset($startDate, $endDate);

        // Dataset should span 3 days: 2026-05-20, 2026-05-21, 2026-05-22
        $this->assertCount(3, $dataset);

        // Find the record for 2026-05-21
        $targetDay = collect($dataset)->firstWhere('date', '2026-05-21');
        $this->assertNotNull($targetDay);
        // It should include the 150,000 completed booking but exclude the pending 200,000 and the 250,000 created on 25th
        $this->assertEquals(150000, $targetDay['booking_revenue']);
        $this->assertEquals(150000, $targetDay['total_revenue']);
    }

    public function test_cache_hits_preserve_original_generated_at_timestamp(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        config(['services.gemini.key' => 'mock-api-key']);
        config(['services.gemini.model' => 'gemini-2.5-flash']);

        // Mock Http Client for Gemini REST API
        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => "## Ringkasan Tren\nPendapatan stabil."]
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        // First call
        $response1 = $this
            ->actingAs($admin)
            ->postJson(route('admin.ai.analyze-revenue'), [
                'period' => '7'
            ]);

        $response1->assertOk();
        $timestamp1 = $response1->json('generated_at');
        $this->assertNotNull($timestamp1);

        // Modify the fake response to verify Http is NOT called a second time (cache hit)
        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => "## Ringkasan Tren\nDifferent response from API."]
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        // Second call (should be a cache hit)
        $response2 = $this
            ->actingAs($admin)
            ->postJson(route('admin.ai.analyze-revenue'), [
                'period' => '7'
            ]);

        $response2->assertOk();
        $timestamp2 = $response2->json('generated_at');
        
        // Assert they are identical
        $this->assertEquals($timestamp1, $timestamp2);
        // Assert markdown is still the cached one, not the new fake response
        $this->assertStringContainsString('Pendapatan stabil.', $response2->json('markdown'));
    }
}
