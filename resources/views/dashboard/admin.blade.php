<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-850 dark:text-white leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Stat: Pending -->
                <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-850 rounded-3xl p-5 hover:shadow-soft-lg transition duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 bg-brand-50 dark:bg-brand-950/40 text-brand-600 dark:text-brand-400 rounded-2xl border border-brand-100/40 dark:border-brand-900/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19L20 5M20 5v10M20 5H10"></path></svg>
                    </div>
                    <div class="font-bold text-slate-700 dark:text-slate-400 text-base mb-0.5">Booking Pending</div>
                    <div class="text-xs text-slate-400 dark:text-slate-500 mb-3">Transaksi belum dibayar</div>
                    <div class="text-2xl font-black text-slate-850 dark:text-white">{{ $pendingBookings }}</div>
                </div>

                <!-- Stat: Court -->
                <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-850 rounded-3xl p-5 hover:shadow-soft-lg transition duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 bg-brand-50 dark:bg-brand-950/40 text-brand-600 dark:text-brand-400 rounded-2xl border border-brand-100/40 dark:border-brand-900/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19L20 5M20 5v10M20 5H10"></path></svg>
                    </div>
                    <div class="font-bold text-slate-700 dark:text-slate-400 text-base mb-0.5">Lapangan Aktif</div>
                    <div class="text-xs text-slate-400 dark:text-slate-500 mb-3">Total lapangan tersedia</div>
                    <div class="text-2xl font-black text-slate-850 dark:text-white">{{ $totalCourts }}</div>
                </div>

                <!-- Stat: All time bookings -->
                <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-850 rounded-3xl p-5 hover:shadow-soft-lg transition duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 bg-brand-50 dark:bg-brand-950/40 text-brand-600 dark:text-brand-400 rounded-2xl border border-brand-100/40 dark:border-brand-900/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19L20 5M20 5v10M20 5H10"></path></svg>
                    </div>
                    <div class="font-bold text-slate-700 dark:text-slate-400 text-base mb-0.5">Total Booking</div>
                    <div class="text-xs text-slate-400 dark:text-slate-500 mb-3">Seluruh transaksi (All Time)</div>
                    <div class="text-2xl font-black text-slate-850 dark:text-white">{{ \App\Models\Booking::count() }}</div>
                </div>

                <!-- Stat: Members -->
                <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-850 rounded-3xl p-5 hover:shadow-soft-lg transition duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 bg-brand-50 dark:bg-brand-950/40 text-brand-600 dark:text-brand-400 rounded-2xl border border-brand-100/40 dark:border-brand-900/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19L20 5M20 5v10M20 5H10"></path></svg>
                    </div>
                    <div class="font-bold text-slate-700 dark:text-slate-400 text-base mb-0.5">Member Aktif</div>
                    <div class="text-xs text-slate-400 dark:text-slate-500 mb-3">Langganan aktif</div>
                    <div class="flex items-baseline space-x-2">
                        <div class="text-2xl font-black text-slate-850 dark:text-white">{{ $totalMembers }}</div>
                        <div class="text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/30 px-2 py-0.5 rounded-lg border border-emerald-100 dark:border-emerald-900/20">+{{ $memberIncreaseThisMonth }} bulan ini</div>
                    </div>
                </div>
            </div>

            <!-- Revenue Chart Section -->
            <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-850 shadow-soft rounded-4xl p-6 transition-all duration-300">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-slate-850 dark:text-white tracking-tight">Performance Overview</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Grafik analisis pendapatan bulanan</p>
                    </div>
                    <div class="flex space-x-2">
                        <button class="btn-secondary py-2 px-4 rounded-xl text-xs font-bold">Export</button>
                        <button class="btn-primary py-2 px-4 rounded-xl text-xs font-bold shadow-soft flex items-center gap-1">
                            Last 30 days <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                    </div>
                </div>
                
                <div class="mb-8">
                    <h4 class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Revenue - {{ $currentMonthName ?? '' }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                        <div class="bg-slate-50 dark:bg-slate-950 p-4 rounded-2xl border border-slate-100 dark:border-slate-850/60 shadow-inner flex flex-col justify-center">
                            <div class="text-xs text-slate-500 dark:text-slate-400 font-semibold mb-1">Total Pendapatan</div>
                            <div class="text-2xl font-black text-slate-850 dark:text-white">Rp {{ number_format($totalRevenueBooking + $totalRevenueMembership, 0, ',', '.') }}</div>
                        </div>
                        <div class="bg-brand-50/50 dark:bg-brand-950/20 p-4 rounded-2xl border border-brand-100/40 dark:border-brand-900/25 shadow-inner flex flex-col justify-center">
                            <div class="text-xs text-brand-650 dark:text-brand-450 font-semibold mb-1">Dari Booking Reguler</div>
                            <div class="text-2xl font-black text-brand-600 dark:text-brand-400">Rp {{ number_format($totalRevenueBooking, 0, ',', '.') }}</div>
                        </div>
                        <div class="bg-emerald-50/50 dark:bg-emerald-950/20 p-4 rounded-2xl border border-emerald-100/40 dark:border-emerald-900/25 shadow-inner flex flex-col justify-center">
                            <div class="text-xs text-brand-650 dark:text-emerald-400 font-semibold mb-1">Dari Membership</div>
                            <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400">Rp {{ number_format($totalRevenueMembership, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <div class="relative h-80 w-full mb-8">
                    <canvas id="revenueChart"></canvas>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 pt-6 border-t border-slate-100 dark:border-slate-850/60">
                    <div>
                        <div class="font-bold text-slate-800 dark:text-white mb-0.5">New bookings</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 font-semibold">Today</div>
                    </div>
                    <div>
                        <div class="font-bold text-slate-800 dark:text-white mb-0.5">Total revenue</div>
                        <div class="text-sm text-slate-500 dark:text-slate-400 font-semibold">This month</div>
                    </div>
                    <div>
                        <div class="font-bold text-slate-800 dark:text-white mb-0.5">Active</div>
                        <div class="text-sm text-slate-500 dark:text-slate-400 font-semibold">Memberships</div>
                    </div>
                    <div>
                        <div class="font-bold text-slate-800 dark:text-white mb-0.5">Cancellations</div>
                        <div class="text-sm text-slate-500 dark:text-slate-400 font-semibold">Last 30 days</div>
                    </div>
                </div>
            </div>

            <!-- Smart Revenue Analyzer Card -->
            <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-850 shadow-soft rounded-4xl p-6 transition-all duration-300">
                <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-4 mb-6">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="p-1.5 bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 rounded-xl border border-emerald-100/40 dark:border-emerald-900/30">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2"></path></svg>
                            </span>
                            <h3 class="text-xl font-bold text-slate-850 dark:text-white tracking-tight">Smart Revenue Analyzer</h3>
                            <span class="text-[10px] font-black tracking-wider uppercase bg-emerald-100 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-400 px-2.5 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-900/40 animate-pulse">Rule-Based Engine</span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">Analisis pendapatan mendalam harian, okupansi, skor bisnis, proyeksi target bulanan, dan rekomendasi aksi strategis.</p>
                    </div>
                    
                    <!-- Controls -->
                    <form id="revenue-analyzer-form" class="flex flex-wrap items-center gap-3">
                        @csrf
                        <div>
                            <select id="analyzer-period-select" name="period" class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl py-2 px-3 text-xs font-bold text-slate-700 dark:text-slate-350 focus:outline-none focus:ring-2 focus:ring-brand-500">
                                <option value="7" selected>7 Hari Terakhir</option>
                                <option value="30">30 Hari Terakhir</option>
                                <option value="90">90 Hari Terakhir</option>
                                <option value="custom">Periode Kustom</option>
                            </select>
                        </div>
                        
                        <!-- Conditional Custom Dates -->
                        <div id="analyzer-custom-dates" class="hidden flex items-center gap-2">
                            <input type="date" id="analyzer-start-date" name="start_date" class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl py-2 px-2 text-xs font-semibold text-slate-700 dark:text-slate-350 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <span class="text-xs text-slate-400">s/d</span>
                            <input type="date" id="analyzer-end-date" name="end_date" class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl py-2 px-2 text-xs font-semibold text-slate-700 dark:text-slate-350 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>
                        
                        <button type="submit" id="analyzer-btn" class="btn-primary py-2 px-4 rounded-xl text-xs font-bold shadow-soft flex items-center gap-2 transition duration-250 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <span>Analisis Pendapatan</span>
                        </button>
                    </form>
                </div>
                
                <!-- Output Container -->
                <div id="analyzer-output-container" class="bg-slate-50/50 dark:bg-slate-950/40 rounded-3xl border border-slate-100 dark:border-slate-850 p-6 min-h-[220px] flex flex-col justify-center transition-all duration-300">
                    <!-- Empty State -->
                    <div id="analyzer-state-empty" class="text-center py-8">
                        <div class="inline-flex p-4 bg-slate-100 dark:bg-slate-900 text-slate-400 dark:text-slate-500 rounded-full mb-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2"></path></svg>
                        </div>
                        <h4 id="analyzer-empty-title" class="text-sm font-bold text-slate-700 dark:text-slate-350">Siap Menganalisis Pendapatan</h4>
                        <p id="analyzer-empty-desc" class="text-xs text-slate-450 dark:text-slate-500 max-w-md mx-auto mt-1">Pilih periode di atas lalu klik tombol "Analisis Pendapatan" untuk memproses intelijen finansial real-time.</p>
                    </div>

                    <!-- Loading Skeleton -->
                    <div id="analyzer-state-loading" class="hidden space-y-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="h-20 bg-slate-200 dark:bg-slate-800 rounded-2xl animate-pulse"></div>
                            <div class="h-20 bg-slate-200 dark:bg-slate-800 rounded-2xl animate-pulse"></div>
                            <div class="h-20 bg-slate-200 dark:bg-slate-800 rounded-2xl animate-pulse"></div>
                            <div class="h-20 bg-slate-200 dark:bg-slate-800 rounded-2xl animate-pulse"></div>
                        </div>
                        <div class="space-y-2">
                            <div class="h-4 w-full bg-slate-200 dark:bg-slate-800 rounded animate-pulse"></div>
                            <div class="h-4 w-5/6 bg-slate-200 dark:bg-slate-800 rounded animate-pulse"></div>
                        </div>
                    </div>

                    <!-- Error Banner -->
                    <div id="analyzer-state-error" class="hidden flex items-start gap-3 p-4 bg-rose-50 dark:bg-rose-950/20 border border-rose-100 dark:border-rose-900/35 rounded-2xl animate-fade-in">
                        <div class="text-rose-550 dark:text-rose-450 flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-rose-800 dark:text-rose-400">Gagal Melakukan Analisis</h4>
                            <p id="analyzer-error-message" class="text-xs text-rose-700 dark:text-rose-450 mt-0.5">Terjadi kesalahan pada server saat memproses data. Silakan coba beberapa saat lagi.</p>
                        </div>
                    </div>

                    <!-- Content State -->
                    <div id="analyzer-state-content" class="hidden space-y-6">
                        
                        <!-- Top Summary Widgets (Score & Trend & Growth) -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Widget: Score -->
                            <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-100 dark:border-slate-805 shadow-soft-sm flex items-center justify-between">
                                <div class="space-y-1">
                                    <div class="text-xs text-slate-405 dark:text-slate-500 font-bold uppercase tracking-wider">Skor Kinerja</div>
                                    <div class="flex items-baseline gap-1.5">
                                        <span id="analyzer-score-val" class="text-3xl font-black text-slate-800 dark:text-white">-</span>
                                        <span class="text-xs text-slate-400">/100</span>
                                    </div>
                                </div>
                                <div id="analyzer-grade-badge" class="h-12 w-12 rounded-2xl flex items-center justify-center font-black text-xl shadow-soft">
                                    -
                                </div>
                            </div>
                            
                            <!-- Widget: Trend -->
                            <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-100 dark:border-slate-805 shadow-soft-sm flex flex-col justify-between">
                                <div class="text-xs text-slate-450 dark:text-slate-500 font-bold uppercase tracking-wider">Tren Pendapatan</div>
                                <div class="mt-2.5">
                                    <span id="analyzer-trend-badge" class="px-3.5 py-1.5 rounded-full text-xs font-black tracking-wide border inline-block shadow-sm">
                                        -
                                    </span>
                                </div>
                            </div>

                            <!-- Widget: Growth -->
                            <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-100 dark:border-slate-805 shadow-soft-sm flex flex-col justify-between">
                                <div class="text-xs text-slate-450 dark:text-slate-500 font-bold uppercase tracking-wider">Pertumbuhan (Growth)</div>
                                <div class="mt-1">
                                    <div id="analyzer-growth-val" class="text-xl font-extrabold text-slate-850 dark:text-white">-</div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-550 mt-0.5">vs periode setara sebelumnya</div>
                                </div>
                            </div>

                            <!-- Widget: Occupancy -->
                            <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-100 dark:border-slate-805 shadow-soft-sm flex flex-col justify-between">
                                <div class="text-xs text-slate-450 dark:text-slate-500 font-bold uppercase tracking-wider">Okupansi Pemesanan</div>
                                <div class="mt-1">
                                    <div id="analyzer-occupancy-val" class="text-xl font-extrabold text-slate-850 dark:text-white">-</div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-550 mt-0.5" id="analyzer-bookings-count-label">0 sukses / 0 batal</div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics Details Grid -->
                        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-5 shadow-soft-sm">
                            <h4 class="text-sm font-bold text-slate-850 dark:text-white mb-4 border-b border-slate-100 dark:border-slate-800/60 pb-2">Rincian Statistik Keuangan</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider font-bold">Total Omzet</div>
                                    <div class="text-base font-extrabold text-slate-850 dark:text-white mt-0.5" id="analyzer-stat-total">-</div>
                                </div>
                                <div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider font-bold">Rata-rata Harian (Mean)</div>
                                    <div class="text-base font-extrabold text-slate-850 dark:text-white mt-0.5" id="analyzer-stat-mean">-</div>
                                </div>
                                <div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider font-bold">Nilai Tengah (Median)</div>
                                    <div class="text-base font-extrabold text-slate-850 dark:text-white mt-0.5" id="analyzer-stat-median">-</div>
                                </div>
                                <div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider font-bold">Deviasi Standar (Std Dev)</div>
                                    <div class="text-base font-extrabold text-slate-850 dark:text-white mt-0.5" id="analyzer-stat-stddev">-</div>
                                </div>
                                <div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider font-bold">Koefisien Variasi</div>
                                    <div class="text-base font-extrabold text-slate-850 dark:text-white mt-0.5" id="analyzer-stat-cv">-</div>
                                </div>
                                <div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider font-bold">Pendapatan Terendah</div>
                                    <div class="text-base font-extrabold text-slate-850 dark:text-white mt-0.5" id="analyzer-stat-min">-</div>
                                </div>
                                <div class="col-span-1">
                                    <div class="text-[10px] text-rose-500 dark:text-rose-450 uppercase tracking-wider font-black flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Hari Tersepi
                                    </div>
                                    <div class="text-xs font-extrabold text-slate-800 dark:text-slate-200 mt-1" id="analyzer-stat-lowday">-</div>
                                </div>
                                <div class="col-span-1">
                                    <div class="text-[10px] text-emerald-500 dark:text-emerald-450 uppercase tracking-wider font-black flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Hari Puncak (Peak)
                                    </div>
                                    <div class="text-xs font-extrabold text-slate-800 dark:text-slate-200 mt-1" id="analyzer-stat-peakday">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Month Projection Section (Dynamic) -->
                        <div id="analyzer-projection-card" class="bg-gradient-to-br from-brand-50 to-indigo-50/50 dark:from-brand-950/20 dark:to-indigo-950/10 rounded-3xl border border-brand-100/50 dark:border-indigo-900/35 p-5 shadow-soft-sm">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="p-1 bg-brand-100 dark:bg-brand-900/60 text-brand-600 dark:text-brand-400 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                </span>
                                <h4 class="text-sm font-black text-brand-900 dark:text-brand-300">Proyeksi Pendapatan Akhir Bulan</h4>
                            </div>
                            <p class="text-xs text-slate-600 dark:text-slate-450 leading-relaxed mb-4">Estimasi total pendapatan di sisa hari bulan berjalan dihitung menggunakan interpolasi <strong>Linear Regression</strong> (tren harian) dan <strong>Moving Average 7-hari</strong>.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="bg-white/80 dark:bg-slate-900/80 p-4 rounded-2xl border border-brand-100/30 dark:border-brand-900/20 shadow-sm">
                                    <div class="text-[10px] text-slate-450 dark:text-slate-500 font-bold uppercase tracking-wider">Proyeksi Pesimis (Low)</div>
                                    <div class="text-base font-black text-slate-800 dark:text-slate-100 mt-0.5" id="analyzer-proj-low">-</div>
                                    <div class="text-[10px] text-rose-600 dark:text-rose-450 font-bold mt-1" id="analyzer-proj-low-pct">-</div>
                                </div>
                                <div class="bg-white/80 dark:bg-slate-900/80 p-4 rounded-2xl border border-brand-100/40 dark:border-brand-900/30 shadow-sm relative overflow-hidden">
                                    <div class="absolute top-0 right-0 bg-brand-500 text-white text-[8px] font-black px-2 py-0.5 rounded-bl-lg uppercase tracking-wider">Median</div>
                                    <div class="text-[10px] text-slate-450 dark:text-slate-500 font-bold uppercase tracking-wider">Proyeksi Tengah (Mid)</div>
                                    <div class="text-lg font-black text-brand-600 dark:text-brand-400 mt-0.5" id="analyzer-proj-mid">-</div>
                                    <div class="text-[10px] text-slate-500 dark:text-slate-400 font-semibold mt-1">Estimasi pencapaian target bulanan</div>
                                </div>
                                <div class="bg-white/80 dark:bg-slate-900/80 p-4 rounded-2xl border border-brand-100/30 dark:border-brand-900/20 shadow-sm">
                                    <div class="text-[10px] text-slate-450 dark:text-slate-500 font-bold uppercase tracking-wider">Proyeksi Optimis (High)</div>
                                    <div class="text-base font-black text-slate-800 dark:text-slate-100 mt-0.5" id="analyzer-proj-high">-</div>
                                    <div class="text-[10px] text-emerald-600 dark:text-emerald-400 font-bold mt-1" id="analyzer-proj-high-pct">-</div>
                                </div>
                            </div>

                            <!-- Target Progress Bar -->
                            <div class="mt-4 space-y-1.5 bg-white/40 dark:bg-slate-900/40 p-3 rounded-2xl border border-brand-100/20 dark:border-brand-900/10">
                                <div class="flex justify-between text-xs font-bold text-slate-700 dark:text-slate-350">
                                    <span>Kemajuan Target Bulanan (Prorated)</span>
                                    <span id="analyzer-proj-progress-pct" class="text-brand-600 dark:text-brand-400 font-extrabold">-</span>
                                </div>
                                <div class="w-full bg-slate-200 dark:bg-slate-800 rounded-full h-3 overflow-hidden shadow-inner border border-slate-100 dark:border-slate-850/60">
                                    <div id="analyzer-proj-progress-bar" class="bg-gradient-to-r from-emerald-500 to-brand-500 h-full rounded-full transition-all duration-500" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Recommendations Section -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-850 dark:text-white mb-3 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 .364l-.707 .707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 113.536 0z"></path></svg>
                                Rekomendasi Bisnis Cerdas
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="analyzer-recommendations-container">
                                <!-- Recommendation cards will be dynamically injected here -->
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-850/60 flex flex-wrap justify-between items-center text-xs text-slate-400 dark:text-slate-500">
                            <div>
                                Dihasilkan oleh Mesin Analitik Cerdas (Rule-Based Engine) &middot; <span id="analyzer-generated-timestamp">-</span>
                            </div>
                            <div class="font-bold text-brand-600 dark:text-brand-455 bg-brand-50/50 dark:bg-brand-950/30 px-3 py-1 rounded-xl border border-brand-100/40 dark:border-brand-900/15" id="analyzer-period-badge">
                                -
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Recent Bookings Table -->
            <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-850 shadow-soft rounded-4xl p-6 transition-all duration-300">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-slate-850 dark:text-white tracking-tight">Manajemen Transaksi & Booking</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kelola seluruh riwayat pemesanan lapangan pelanggan</p>
                    </div>
                    <!-- Link to homepage for manual booking -->
                    <a href="{{ route('bookings.create') }}" class="btn-primary text-xs font-bold py-2.5 px-4 rounded-2xl flex items-center gap-1 shadow-soft transition-transform active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Transaksi
                    </a>
                </div>
                <div class="overflow-x-auto -mx-6">
                    <div class="inline-block min-w-full align-middle px-6">
                        <table class="table-soft w-full">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td class="font-extrabold text-slate-850 dark:text-white">{{ $booking->booking_code }}</td>
                                     <td>
                                        <div class="font-bold text-slate-850 dark:text-slate-200">{{ $booking->user ? $booking->user->name : $booking->guest_name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $booking->user ? $booking->user->phone : $booking->guest_phone }}</div>
                                    </td>
                                    <td class="font-semibold text-slate-600 dark:text-slate-400">
                                        {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                                        <div class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                                            @if($booking->details->first())
                                                {{ \Carbon\Carbon::parse($booking->details->first()->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->details->first()->end_time)->format('H:i') }} WIB
                                            @endif
                                        </div>
                                    </td>
                                    <td class="font-extrabold text-slate-850 dark:text-white">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        @if($booking->status == 'pending')
                                            <span class="badge-warning px-2.5 py-0.5 rounded-full text-xs font-bold">Pending</span>
                                        @elseif($booking->status == 'paid')
                                            <span class="badge-success px-2.5 py-0.5 rounded-full text-xs font-bold">Lunas</span>
                                        @elseif($booking->status == 'completed')
                                            <span class="badge-success px-2.5 py-0.5 rounded-full text-xs font-bold">Selesai</span>
                                        @elseif($booking->status == 'cancelled' || $booking->status == 'canceled')
                                            <span class="badge-danger px-2.5 py-0.5 rounded-full text-xs font-bold">Dibatalkan</span>
                                        @else
                                            <span class="badge-info px-2.5 py-0.5 rounded-full text-xs font-bold">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-right whitespace-nowrap space-x-1">
                                        @if($booking->status == 'pending')
                                            <form action="{{ route('admin.bookings.verify', $booking) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Verifikasi pembayaran Transfer untuk booking {{ $booking->booking_code }}?')" class="inline-flex items-center justify-center px-3 py-1 rounded-xl text-xs font-bold text-brand-650 dark:text-brand-400 bg-brand-50 dark:bg-brand-950/40 border border-brand-100/50 hover:bg-brand-100 hover:text-brand-700 transition">Verif Transfer</button>
                                            </form>
                                            <form action="{{ route('admin.bookings.cash', $booking) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Tandai booking {{ $booking->booking_code }} telah dibayar Tunai/Cash?')" class="inline-flex items-center justify-center px-3 py-1 rounded-xl text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-100/50 hover:bg-emerald-100 hover:text-emerald-700 transition">Bayar Tunai</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin ingin menghapus transaksi {{ $booking->booking_code }}?')" class="inline-flex items-center justify-center px-3 py-1 rounded-xl text-xs font-bold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 border border-rose-100/50 hover:bg-rose-100 hover:text-rose-700 transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart');
            if (ctx) {
                const rawDataBooking = @json($dailyRevenueBooking ?? []);
                const rawDataMembership = @json($dailyRevenueMembership ?? []);
                const daysInMonth = {{ $daysInMonth ?? 30 }};
                
                const labels = [];
                const dataPointsBooking = new Array(daysInMonth).fill(0);
                const dataPointsMembership = new Array(daysInMonth).fill(0);
                
                for (let i = 1; i <= daysInMonth; i++) {
                    labels.push(i);
                }
                
                Object.keys(rawDataBooking).forEach(dayNum => {
                    const idx = parseInt(dayNum) - 1;
                    dataPointsBooking[idx] = parseFloat(rawDataBooking[dayNum]);
                });
                Object.keys(rawDataMembership).forEach(dayNum => {
                    const idx = parseInt(dayNum) - 1;
                    dataPointsMembership[idx] = parseFloat(rawDataMembership[dayNum]);
                });

                // Create gradient for booking (emerald)
                let gradientBooking = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
                gradientBooking.addColorStop(0, 'rgba(16, 185, 129, 0.25)'); // brand-500
                gradientBooking.addColorStop(1, 'rgba(16, 185, 129, 0)');

                // Create gradient for membership (slate/teal)
                let gradientMembership = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
                gradientMembership.addColorStop(0, 'rgba(20, 184, 166, 0.25)'); // teal-500
                gradientMembership.addColorStop(1, 'rgba(20, 184, 166, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Booking Reguler (Rp)',
                                data: dataPointsBooking,
                                borderColor: '#10b981', // brand-500
                                backgroundColor: gradientBooking,
                                borderWidth: 3,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#10b981',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                fill: true,
                                tension: 0.4
                            },
                            {
                                label: 'Membership (Rp)',
                                data: dataPointsMembership,
                                borderColor: '#14b8a6', // teal-500
                                backgroundColor: gradientMembership,
                                borderWidth: 3,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#14b8a6',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                fill: true,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { 
                                display: true, 
                                position: 'top',
                                labels: {
                                    font: { size: 12, weight: 'bold', family: 'Figtree' },
                                    color: document.documentElement.classList.contains('dark') ? '#cbd5e1' : '#475569'
                                }
                            },
                            tooltip: {
                                backgroundColor: '#0f172a', // slate-900
                                padding: 12,
                                titleFont: { size: 12, weight: 'bold', family: 'Figtree' },
                                bodyFont: { size: 14, weight: 'extrabold', family: 'Figtree' },
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        let value = context.raw || 0;
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false, drawBorder: false },
                                ticks: { color: '#94a3b8', font: { size: 11, family: 'Figtree' } }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.08)',
                                    drawBorder: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: { size: 11, family: 'Figtree' },
                                    callback: function(value) {
                                        if (value >= 1000000) return (value/1000000) + 'm';
                                        if (value >= 1000) return (value/1000) + 'k';
                                        return value;
                                    }
                                }
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                    }
                });
            }
        });
    </script>

    <!-- Smart Revenue Analyzer Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const periodSelect = document.getElementById('analyzer-period-select');
            const customDatesDiv = document.getElementById('analyzer-custom-dates');
            const startDateInput = document.getElementById('analyzer-start-date');
            const endDateInput = document.getElementById('analyzer-end-date');
            const form = document.getElementById('revenue-analyzer-form');
            const btn = document.getElementById('analyzer-btn');
            const btnText = btn ? btn.querySelector('span') : null;

            const stateEmpty = document.getElementById('analyzer-state-empty');
            const emptyTitle = document.getElementById('analyzer-empty-title');
            const emptyDesc = document.getElementById('analyzer-empty-desc');
            const stateLoading = document.getElementById('analyzer-state-loading');
            const stateError = document.getElementById('analyzer-state-error');
            const stateContent = document.getElementById('analyzer-state-content');
            const errorMessage = document.getElementById('analyzer-error-message');

            const scoreVal = document.getElementById('analyzer-score-val');
            const gradeBadge = document.getElementById('analyzer-grade-badge');
            const trendBadge = document.getElementById('analyzer-trend-badge');
            const growthVal = document.getElementById('analyzer-growth-val');
            const occupancyVal = document.getElementById('analyzer-occupancy-val');
            const bookingsCountLabel = document.getElementById('analyzer-bookings-count-label');

            const statTotal = document.getElementById('analyzer-stat-total');
            const statMean = document.getElementById('analyzer-stat-mean');
            const statMedian = document.getElementById('analyzer-stat-median');
            const statStdDev = document.getElementById('analyzer-stat-stddev');
            const statCv = document.getElementById('analyzer-stat-cv');
            const statMin = document.getElementById('analyzer-stat-min');
            const statLowDay = document.getElementById('analyzer-stat-lowday');
            const statPeakDay = document.getElementById('analyzer-stat-peakday');

            const projectionCard = document.getElementById('analyzer-projection-card');
            const projLow = document.getElementById('analyzer-proj-low');
            const projLowPct = document.getElementById('analyzer-proj-low-pct');
            const projMid = document.getElementById('analyzer-proj-mid');
            const projHigh = document.getElementById('analyzer-proj-high');
            const projHighPct = document.getElementById('analyzer-proj-high-pct');
            const projProgressBar = document.getElementById('analyzer-proj-progress-bar');
            const projProgressPct = document.getElementById('analyzer-proj-progress-pct');

            const recommendationsContainer = document.getElementById('analyzer-recommendations-container');
            const generatedTimestamp = document.getElementById('analyzer-generated-timestamp');
            const periodBadge = document.getElementById('analyzer-period-badge');

            if (!form) return;

            // Currency formatting helper
            const formatIDR = (num) => {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0
                }).format(num);
            };

            // Format simple date helper
            const formatDate = (dateStr) => {
                if (!dateStr) return '-';
                const dateObj = new Date(dateStr);
                return dateObj.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            };

            // Toggle custom dates view
            periodSelect.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customDatesDiv.classList.remove('hidden');
                    startDateInput.required = true;
                    endDateInput.required = true;
                    const today = new Date().toISOString().split('T')[0];
                    const sevenDaysAgo = new Date(Date.now() - 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
                    if (!startDateInput.value) startDateInput.value = sevenDaysAgo;
                    if (!endDateInput.value) endDateInput.value = today;
                } else {
                    customDatesDiv.classList.add('hidden');
                    startDateInput.required = false;
                    endDateInput.required = false;
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (periodSelect.value === 'custom') {
                    const start = new Date(startDateInput.value);
                    const end = new Date(endDateInput.value);
                    if (start > end) {
                        showError('Tanggal mulai tidak boleh melebihi tanggal selesai.');
                        return;
                    }
                    const diffTime = Math.abs(end - start);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                    if (diffDays > 365) {
                        showError('Rentang tanggal custom maksimal adalah 365 hari.');
                        return;
                    }
                }

                setLoadingState(true);

                const formData = new FormData(form);
                const payload = {
                    period: formData.get('period'),
                    start_date: formData.get('start_date'),
                    end_date: formData.get('end_date')
                };

                fetch('{{ route("admin.analytics.revenue") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                })
                .then(response => {
                    const contentType = response.headers.get('content-type');
                    if (response.status === 400 || response.status === 422) {
                        return response.json().then(err => { throw err; });
                    }
                    if (!response.ok) {
                        throw { message: 'Terjadi kesalahan koneksi server (Error ' + response.status + ')' };
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.is_empty) {
                        periodBadge.textContent = data.period_label;
                        const now = new Date();
                        const timeStr = now.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        }) + ' ' + now.toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit'
                        }) + ' WIB';
                        document.getElementById('analyzer-generated-timestamp').textContent = timeStr;
                        if (emptyTitle) emptyTitle.textContent = 'Tidak ada data pada periode ini';
                        if (emptyDesc) emptyDesc.textContent = 'Silakan pilih rentang waktu atau filter lain karena tidak ada transaksi yang terdaftar pada periode terpilih.';
                        showState('empty');
                        return;
                    }

                    if (data.success && data.data) {
                        const report = data.data;

                        // 1. Scoring & Grade
                        scoreVal.textContent = report.scoring.score;
                        gradeBadge.textContent = report.scoring.grade;
                        
                        // Dynamic grade styling classes
                        gradeBadge.className = 'h-12 w-12 rounded-2xl flex items-center justify-center font-black text-xl shadow-soft';
                        if (report.scoring.grade === 'A') {
                            gradeBadge.classList.add('bg-emerald-500', 'text-white');
                        } else if (report.scoring.grade === 'B') {
                            gradeBadge.classList.add('bg-indigo-500', 'text-white');
                        } else if (report.scoring.grade === 'C') {
                            gradeBadge.classList.add('bg-amber-500', 'text-white');
                        } else {
                            gradeBadge.classList.add('bg-rose-500', 'text-white');
                        }

                        // 2. Trend Badge
                        trendBadge.textContent = report.growth.trend;
                        trendBadge.className = 'px-3.5 py-1.5 rounded-full text-xs font-black tracking-wide border inline-block shadow-sm';
                        
                        if (report.growth.trend === 'Naik Pesat' || report.growth.trend === 'Naik') {
                            trendBadge.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-200', 'dark:bg-emerald-950/50', 'dark:text-emerald-400', 'dark:border-emerald-900/30');
                        } else if (report.growth.trend === 'Stabil') {
                            trendBadge.classList.add('bg-amber-50', 'text-amber-700', 'border-amber-200', 'dark:bg-amber-950/50', 'dark:text-amber-400', 'dark:border-amber-900/30');
                        } else {
                            trendBadge.classList.add('bg-rose-50', 'text-rose-700', 'border-rose-200', 'dark:bg-rose-950/50', 'dark:text-rose-400', 'dark:border-rose-900/30');
                        }

                        // 3. Growth Value
                        const growthSign = report.growth.growth_pct >= 0 ? '+' : '';
                        growthVal.textContent = `${growthSign}${report.growth.growth_pct}%`;
                        if (report.growth.growth_pct >= 0) {
                            growthVal.className = 'text-xl font-extrabold text-emerald-600 dark:text-emerald-400';
                        } else {
                            growthVal.className = 'text-xl font-extrabold text-rose-600 dark:text-rose-400';
                        }

                        // 4. Occupancy Value
                        occupancyVal.textContent = `${report.occupancy.occupancy_rate}%`;
                        bookingsCountLabel.textContent = `${report.occupancy.successful_bookings} sukses / ${report.occupancy.cancelled_bookings} batal`;

                        // 5. Financial Statistics Details
                        statTotal.textContent = formatIDR(report.statistics.total);
                        statMean.textContent = formatIDR(report.statistics.mean);
                        statMedian.textContent = formatIDR(report.statistics.median);
                        statStdDev.textContent = formatIDR(report.statistics.std_dev);
                        statCv.textContent = report.statistics.coefficient_of_variation.toFixed(2);
                        statMin.textContent = formatIDR(report.statistics.min);
                        
                        statLowDay.innerHTML = report.statistics.low_day.date 
                            ? `<span class="block">${formatDate(report.statistics.low_day.date)}</span><span class="text-[10px] text-slate-500 font-semibold">${formatIDR(report.statistics.low_day.amount)}</span>`
                            : '-';
                        statPeakDay.innerHTML = report.statistics.peak_day.date
                            ? `<span class="block text-emerald-600 dark:text-emerald-400 font-bold">${formatDate(report.statistics.peak_day.date)}</span><span class="text-[10px] text-slate-500 font-semibold">${formatIDR(report.statistics.peak_day.amount)}</span>`
                            : '-';

                        // 6. Projections (Hide if not available)
                        if (report.projection) {
                            projectionCard.classList.remove('hidden');
                            projLow.textContent = formatIDR(report.projection.projection_low);
                            projLowPct.textContent = `${report.projection.target_pct_low}% dari target`;
                            projMid.textContent = formatIDR(report.projection.projection_mid);
                            projHigh.textContent = formatIDR(report.projection.projection_high);
                            projHighPct.textContent = `${report.projection.target_pct_high}% dari target`;

                            // Target Progress Bar
                            const midPct = report.projection.target_pct_mid;
                            projProgressPct.textContent = `${midPct}%`;
                            projProgressBar.style.width = `${Math.min(100, midPct)}%`;
                        } else {
                            projectionCard.classList.add('hidden');
                        }

                        // 7. Recommendations
                        recommendationsContainer.innerHTML = '';
                        if (report.recommendations && report.recommendations.length > 0) {
                            report.recommendations.forEach(rec => {
                                const card = document.createElement('div');
                                card.className = 'bg-slate-50 dark:bg-slate-950 p-4 rounded-2xl border border-slate-100 dark:border-slate-850 shadow-soft-sm flex flex-col justify-between gap-3 hover:border-brand-200 dark:hover:border-brand-900/40 transition-colors duration-250';
                                
                                // Color accent based on recommendation type
                                let accentClass = 'bg-brand-50 text-brand-600 dark:bg-brand-950/40 dark:text-brand-450';
                                if (rec.type === 'occupancy') accentClass = 'bg-amber-50 text-amber-600 dark:bg-amber-950/40 dark:text-amber-450';
                                if (rec.type === 'membership' || rec.type === 'upsell') accentClass = 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-450';
                                if (rec.type === 'target') accentClass = 'bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-450';

                                card.innerHTML = `
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full ${rec.type === 'target' ? 'bg-rose-500' : (rec.type === 'occupancy' ? 'bg-amber-500' : 'bg-emerald-500')}"></span>
                                            <h5 class="text-xs font-black text-slate-850 dark:text-slate-200">${rec.title}</h5>
                                        </div>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed pl-4">${rec.description}</p>
                                    </div>
                                    <div class="pl-4">
                                        <span class="inline-flex items-center text-[10px] font-black text-brand-650 dark:text-brand-400 hover:text-brand-700 transition cursor-pointer gap-0.5">
                                            ${rec.action_label} &rarr;
                                        </span>
                                    </div>
                                `;
                                recommendationsContainer.appendChild(card);
                            });
                        } else {
                            recommendationsContainer.innerHTML = `<div class="col-span-2 text-center text-xs text-slate-450 dark:text-slate-550 py-4">Tidak ada rekomendasi spesifik saat ini. Kinerja stabil.</div>`;
                        }

                        // Set Generated Timestamp
                        const now = new Date();
                        const timeStr = now.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        }) + ' ' + now.toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit'
                        }) + ' WIB';
                        
                        generatedTimestamp.textContent = timeStr;
                        periodBadge.textContent = data.period_label;

                        // Show report state
                        showState('content');
                    } else {
                        showError(data.message || 'Gagal mengambil data pendapatan.');
                    }
                })
                .catch(error => {
                    console.error('Analyzer error:', error);
                    showError(error.message || 'Gagal terhubung dengan server. Harap periksa koneksi Anda.');
                })
                .finally(() => {
                    setLoadingState(false);
                });
            });

            function showState(state) {
                stateEmpty.classList.add('hidden');
                stateLoading.classList.add('hidden');
                stateError.classList.add('hidden');
                stateContent.classList.add('hidden');

                if (state === 'empty') stateEmpty.classList.remove('hidden');
                else if (state === 'loading') stateLoading.classList.remove('hidden');
                else if (state === 'error') stateError.classList.remove('hidden');
                else if (state === 'content') stateContent.classList.remove('hidden');
            }

            function showError(msg) {
                errorMessage.textContent = msg;
                showState('error');
            }

            function setLoadingState(isLoading) {
                if (isLoading) {
                    if (btn) {
                        btn.disabled = true;
                        btn.classList.add('opacity-75', 'cursor-not-allowed');
                    }
                    if (btnText) btnText.textContent = 'Menganalisis...';
                    if (emptyTitle) emptyTitle.textContent = 'Siap Menganalisis Pendapatan';
                    if (emptyDesc) emptyDesc.textContent = 'Pilih periode di atas lalu klik tombol "Analisis Pendapatan" untuk memproses intelijen finansial real-time.';
                    showState('loading');
                } else {
                    if (btn) {
                        btn.disabled = false;
                        btn.classList.remove('opacity-75', 'cursor-not-allowed');
                    }
                    if (btnText) btnText.textContent = 'Analisis Pendapatan';
                }
            }
        });
    </script>
</x-app-layout>
