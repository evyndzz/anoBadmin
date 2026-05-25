<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courts/{court}', [HomeController::class, 'showCourt'])->name('courts.show');
Route::get('/api/courts/{court}/slots', [BookingController::class, 'getSlots'])->name('api.courts.slots');
Route::post('/book-guest', [BookingController::class, 'storeGuest'])->name('book.guest');

// Dynamic dashboard redirect based on role
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Memberships
    Route::get('/membership', [\App\Http\Controllers\MembershipController::class, 'index'])->name('membership.index');
    Route::get('/membership/payment', [\App\Http\Controllers\MembershipController::class, 'payment'])->name('membership.payment');
    Route::post('/membership/pay', [\App\Http\Controllers\MembershipController::class, 'pay'])->name('membership.pay');
    Route::get('/membership/{membership}/schedules', [\App\Http\Controllers\MembershipController::class, 'schedules'])->name('membership.schedules');
    Route::post('/membership/{membership}', [\App\Http\Controllers\MembershipController::class, 'join'])->name('membership.join');

    // User Booking
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/book', [BookingController::class, 'store'])->name('book.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

    // Vouchers / Promos
    Route::get('/vouchers', [\App\Http\Controllers\VoucherController::class, 'index'])->name('vouchers.index');
    Route::post('/vouchers/{promo}/redeem', [\App\Http\Controllers\VoucherController::class, 'redeem'])->name('vouchers.redeem');

    // Dashboard routes based on roles
    Route::prefix('admin')->middleware('role:admin')->name('admin.')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::post('/analytics/revenue', [DashboardController::class, 'analyzeRevenue'])->name('analytics.revenue');
        
        Route::get('/memberships', [\App\Http\Controllers\AdminController::class, 'memberships'])->name('memberships.index');
        Route::get('/vouchers', [\App\Http\Controllers\AdminController::class, 'vouchers'])->name('vouchers.index');
        Route::post('/vouchers', [\App\Http\Controllers\AdminController::class, 'storeVoucher'])->name('vouchers.store');
        Route::delete('/vouchers/{promo}', [\App\Http\Controllers\AdminController::class, 'destroyVoucher'])->name('vouchers.destroy');

        Route::get('/courts', [\App\Http\Controllers\AdminController::class, 'courts'])->name('courts.index');
        Route::post('/courts', [\App\Http\Controllers\AdminController::class, 'storeCourt'])->name('courts.store');
        Route::put('/courts/{court}', [\App\Http\Controllers\AdminController::class, 'updateCourt'])->name('courts.update');
        Route::delete('/courts/{court}', [\App\Http\Controllers\AdminController::class, 'destroyCourt'])->name('courts.destroy');

        Route::post('/bookings/{booking}/verify', [\App\Http\Controllers\AdminController::class, 'verifyPayment'])->name('bookings.verify');
        Route::post('/bookings/{booking}/cash', [\App\Http\Controllers\AdminController::class, 'payCash'])->name('bookings.cash');
        Route::delete('/bookings/{booking}', [\App\Http\Controllers\AdminController::class, 'destroyBooking'])->name('bookings.destroy');

        Route::post('/memberships', [\App\Http\Controllers\AdminController::class, 'storeMembership'])->name('memberships.store');
        Route::delete('/memberships/{membership}', [\App\Http\Controllers\AdminController::class, 'destroyMembership'])->name('memberships.destroy');
        Route::post('/memberships/{membership}/schedules', [\App\Http\Controllers\AdminController::class, 'storeSchedule'])->name('schedules.store');
        Route::delete('/schedules/{schedule}', [\App\Http\Controllers\AdminController::class, 'destroySchedule'])->name('schedules.destroy');
    });

    Route::prefix('user')->middleware('role:user')->name('user.')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'user'])->name('dashboard');
    });
});

Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
Route::post('/payments/{booking}', [BookingController::class, 'pay'])->name('payments.store');

require __DIR__.'/auth.php';
