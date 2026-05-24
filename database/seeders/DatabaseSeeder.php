<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Court;
use App\Models\Membership;
use App\Models\Promo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        User::firstOrCreate(
            ['email' => 'admin@anobadmin.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]
        );


        $user = User::firstOrCreate(
            ['email' => 'user@anobadmin.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'points_balance' => 5000,
                'booking_count' => 10,
                'total_spent' => 600000,
            ]
        ); // Fuzzy logic will recommend Gold membership

        // Memberships
        // Memberships
        $anoMember = Membership::updateOrCreate(['name' => 'Ano Member'], ['price' => 300000, 'duration_months' => 1, 'discount_percent' => 0, 'priority_booking' => true]); // 8x meeting (3 hours)
        $supahAno = Membership::updateOrCreate(['name' => 'Supah Ano'], ['price' => 400000, 'duration_months' => 1, 'discount_percent' => 0, 'priority_booking' => true]); // 8x meeting (4 hours) + freebies

        // Courts
        $court1 = Court::updateOrCreate(['name' => 'Lapangan 1 (Karpet)'], ['description' => 'Lapangan karpet standar internasional.', 'price_per_hour' => 50000]);
        $court2 = Court::updateOrCreate(['name' => 'Lapangan 2 (Karpet)'], ['description' => 'Lapangan karpet standar internasional.', 'price_per_hour' => 50000]);
        $court3 = Court::updateOrCreate(['name' => 'Lapangan 3 (Vinyl)'], ['description' => 'Lapangan vinyl premium.', 'price_per_hour' => 60000]);
        $court4 = Court::updateOrCreate(['name' => 'Lapangan 4 (Vinyl)'], ['description' => 'Lapangan vinyl premium.', 'price_per_hour' => 60000]);

        // Create Available Schedules for Memberships
        \App\Models\MemberSchedule::firstOrCreate(['membership_id' => $anoMember->id, 'court_id' => $court1->id, 'days' => 'Senin & Kamis', 'start_time' => '19:00:00'], ['end_time' => '22:00:00', 'is_available' => true]);
        \App\Models\MemberSchedule::firstOrCreate(['membership_id' => $anoMember->id, 'court_id' => $court2->id, 'days' => 'Selasa & Jumat', 'start_time' => '20:00:00'], ['end_time' => '23:00:00', 'is_available' => true]);
        
        \App\Models\MemberSchedule::firstOrCreate(['membership_id' => $supahAno->id, 'court_id' => $court3->id, 'days' => 'Rabu & Sabtu', 'start_time' => '18:00:00'], ['end_time' => '22:00:00', 'is_available' => true]);
        \App\Models\MemberSchedule::firstOrCreate(['membership_id' => $supahAno->id, 'court_id' => $court3->id, 'days' => 'Senin & Jumat', 'start_time' => '19:00:00'], ['end_time' => '23:00:00', 'is_available' => false]); // Taken

        // Promos
        Promo::updateOrCreate(['code' => 'WELCOME10'], ['discount_percent' => 10, 'min_transaction' => 50000, 'points_required' => 0]);
        Promo::updateOrCreate(['code' => 'LOYALTY20'], ['discount_percent' => 20, 'min_transaction' => 150000, 'points_required' => 2000]);
    }
}
