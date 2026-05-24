<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->timestamp('paid_at')->nullable()->after('status');
        });

        // Backfill existing paid/completed bookings with their created_at timestamp
        \DB::table('bookings')
            ->whereIn('status', ['paid', 'completed'])
            ->update(['paid_at' => \DB::raw('created_at')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('paid_at');
        });
    }
};
