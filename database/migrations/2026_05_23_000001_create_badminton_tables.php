<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Silver, Gold, VIP
            $table->decimal('price', 15, 2);
            $table->integer('duration_months');
            $table->integer('discount_percent')->default(0);
            $table->boolean('priority_booking')->default(false);
            $table->timestamps();
        });

        Schema::create('courts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price_per_hour', 15, 2);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('discount_amount', 15, 2)->nullable();
            $table->integer('discount_percent')->nullable();
            $table->decimal('min_transaction', 15, 2)->default(0);
            $table->integer('points_required')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // nullable for guest
            $table->string('guest_name')->nullable();
            $table->string('guest_phone')->nullable();
            $table->date('date');
            $table->decimal('total_price', 15, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled', 'completed'])->default('pending');
            $table->foreignId('promo_id')->nullable()->constrained('promos')->nullOnDelete();
            $table->decimal('discount_applied', 15, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('court_id')->constrained('courts')->cascadeOnDelete();
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('price', 15, 2);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->string('payment_method');
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->string('proof_image')->nullable();
            $table->timestamps();
        });

        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('amount');
            $table->enum('type', ['earn', 'spend']);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['booking', 'membership']);
            $table->unsignedBigInteger('reference_id'); // booking_id or membership_id
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['success', 'failed', 'pending'])->default('success');
            $table->timestamps();
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_id')->constrained('courts')->cascadeOnDelete();
            $table->string('day_of_week'); // e.g. Monday
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('points');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('booking_details');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('promos');
        Schema::dropIfExists('courts');
        Schema::dropIfExists('memberships');
    }
};
