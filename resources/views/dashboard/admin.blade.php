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

            <!-- AI Revenue Analyst Card -->
            <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-850 shadow-soft rounded-4xl p-6 transition-all duration-300">
                <style>
                    #ai-rendered-content h2 {
                        font-size: 1.25rem;
                        font-weight: 800;
                        margin-top: 1.5rem;
                        margin-bottom: 0.75rem;
                        color: #1e293b; /* slate-800 */
                        border-bottom: 2px solid #f1f5f9; /* slate-100 */
                        padding-bottom: 0.25rem;
                    }
                    .dark #ai-rendered-content h2 {
                        color: #f8fafc; /* slate-50 */
                        border-bottom-color: #334155; /* slate-700 */
                    }
                    #ai-rendered-content h2:first-of-type {
                        margin-top: 0;
                    }
                    #ai-rendered-content p {
                        margin-bottom: 1rem;
                        line-height: 1.625;
                    }
                    #ai-rendered-content ul {
                        list-style-type: disc;
                        padding-left: 1.5rem;
                        margin-bottom: 1rem;
                    }
                    #ai-rendered-content li {
                        margin-bottom: 0.5rem;
                    }
                    #ai-rendered-content strong {
                        font-weight: 700;
                        color: #0f172a; /* slate-900 */
                    }
                    .dark #ai-rendered-content strong {
                        color: #ffffff;
                    }
                    #ai-rendered-content blockquote {
                        border-left: 4px solid #6366f1; /* indigo-500 */
                        padding-left: 1rem;
                        font-style: italic;
                        color: #475569; /* slate-600 */
                        margin: 1rem 0;
                    }
                    .dark #ai-rendered-content blockquote {
                        color: #cbd5e1; /* slate-300 */
                    }
                </style>
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="p-1.5 bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 rounded-xl border border-indigo-100/40 dark:border-indigo-900/30">
                                <svg class="w-5 h-5 animate-pulse text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </span>
                            <h3 class="text-xl font-bold text-slate-850 dark:text-white tracking-tight">AI Revenue Analyst</h3>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Gunakan analisis cerdas Gemini AI untuk meninjau tren, hari puncak, dan proyeksi pendapatan.</p>
                    </div>
                    
                    <!-- Controls -->
                    <form id="ai-analysis-form" class="flex flex-wrap items-center gap-3">
                        @csrf
                        <div>
                            <select id="ai-period-select" name="period" class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl py-2 px-3 text-xs font-bold text-slate-700 dark:text-slate-350 focus:outline-none focus:ring-2 focus:ring-brand-500">
                                <option value="7" selected>7 Hari Terakhir</option>
                                <option value="30">30 Hari Terakhir</option>
                                <option value="90">90 Hari Terakhir</option>
                                <option value="custom">Periode Kustom</option>
                            </select>
                        </div>
                        
                        <!-- Conditional Custom Dates -->
                        <div id="ai-custom-dates" class="hidden flex items-center gap-2">
                            <input type="date" id="ai-start-date" name="start_date" class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl py-2 px-2 text-xs font-semibold text-slate-700 dark:text-slate-350 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <span class="text-xs text-slate-400">s/d</span>
                            <input type="date" id="ai-end-date" name="end_date" class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl py-2 px-2 text-xs font-semibold text-slate-700 dark:text-slate-350 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>
                        
                        <button type="submit" id="ai-analyze-btn" class="btn-primary py-2 px-4 rounded-xl text-xs font-bold shadow-soft flex items-center gap-2 transition duration-250 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 .364l-.707 .707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 113.536 0z"></path></svg>
                            <span>Analisis dengan AI</span>
                        </button>
                    </form>
                </div>
                
                <!-- Output Container -->
                <div id="ai-output-container" class="bg-slate-50/50 dark:bg-slate-950/40 rounded-3xl border border-slate-100 dark:border-slate-850 p-6 min-h-[220px] flex flex-col justify-center transition-all duration-300">
                    <!-- Empty State -->
                    <div id="ai-state-empty" class="text-center py-8">
                        <div class="inline-flex p-4 bg-slate-100 dark:bg-slate-900 text-slate-400 dark:text-slate-500 rounded-full mb-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 .364l-.707 .707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 113.536 0z"></path></svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-350">Siap Menganalisis</h4>
                        <p class="text-xs text-slate-450 dark:text-slate-500 max-w-md mx-auto mt-1">Pilih periode di atas lalu klik tombol "Analisis dengan AI" untuk mulai memproses data pendapatan menggunakan kecerdasan buatan.</p>
                    </div>

                    <!-- Loading Skeleton -->
                    <div id="ai-state-loading" class="hidden space-y-4 py-4">
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="h-5 w-32 bg-slate-200 dark:bg-slate-800 rounded animate-pulse"></div>
                            <div class="h-3 w-16 bg-slate-150 dark:bg-slate-850 rounded animate-pulse"></div>
                        </div>
                        <div class="space-y-2">
                            <div class="h-4 w-full bg-slate-200 dark:bg-slate-800 rounded animate-pulse"></div>
                            <div class="h-4 w-5/6 bg-slate-200 dark:bg-slate-800 rounded animate-pulse"></div>
                            <div class="h-4 w-4/5 bg-slate-200 dark:bg-slate-800 rounded animate-pulse"></div>
                        </div>
                        <div class="pt-4 space-y-2">
                            <div class="h-5 w-40 bg-slate-200 dark:bg-slate-800 rounded animate-pulse"></div>
                            <div class="h-4 w-full bg-slate-200 dark:bg-slate-800 rounded animate-pulse"></div>
                            <div class="h-4 w-11/12 bg-slate-200 dark:bg-slate-800 rounded animate-pulse"></div>
                        </div>
                    </div>

                    <!-- Error Banner -->
                    <div id="ai-state-error" class="hidden flex items-start gap-3 p-4 bg-rose-50 dark:bg-rose-950/20 border border-rose-100 dark:border-rose-900/35 rounded-2xl animate-fade-in">
                        <div class="text-rose-550 dark:text-rose-450 flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-rose-800 dark:text-rose-400">Gagal Melakukan Analisis</h4>
                            <p id="ai-error-message" class="text-xs text-rose-700 dark:text-rose-450 mt-0.5">Terjadi kesalahan pada server saat memproses data. Silakan coba beberapa saat lagi.</p>
                        </div>
                    </div>

                    <!-- Content State -->
                    <div id="ai-state-content" class="hidden">
                        <div class="prose prose-slate dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 text-sm leading-relaxed" id="ai-rendered-content">
                            <!-- Gemini Markdown output will be rendered here -->
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-850/60 flex flex-wrap justify-between items-center text-xs text-slate-400 dark:text-slate-500">
                            <div>
                                Dihasilkan oleh Gemini &middot; <span id="ai-generated-timestamp">-</span>
                            </div>
                            <div class="font-semibold text-brand-600 dark:text-brand-450 bg-brand-50/50 dark:bg-brand-950/30 px-2 py-0.5 rounded-lg border border-brand-100/40 dark:border-brand-900/15" id="ai-period-badge">
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
    <!-- Marked and DOMPurify for AI Revenue Analyst -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dompurify/dist/purify.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const periodSelect = document.getElementById('ai-period-select');
            const customDatesDiv = document.getElementById('ai-custom-dates');
            const startDateInput = document.getElementById('ai-start-date');
            const endDateInput = document.getElementById('ai-end-date');
            const form = document.getElementById('ai-analysis-form');
            const btn = document.getElementById('ai-analyze-btn');
            const btnText = btn ? btn.querySelector('span') : null;

            const stateEmpty = document.getElementById('ai-state-empty');
            const stateLoading = document.getElementById('ai-state-loading');
            const stateError = document.getElementById('ai-state-error');
            const stateContent = document.getElementById('ai-state-content');
            const errorMessage = document.getElementById('ai-error-message');
            const renderedContent = document.getElementById('ai-rendered-content');
            const generatedTimestamp = document.getElementById('ai-generated-timestamp');
            const periodBadge = document.getElementById('ai-period-badge');

            if (!form) return;

            // Initialize custom dates visibility
            if (periodSelect.value === 'custom') {
                customDatesDiv.classList.remove('hidden');
                startDateInput.required = true;
                endDateInput.required = true;
            }

            periodSelect.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customDatesDiv.classList.remove('hidden');
                    startDateInput.required = true;
                    endDateInput.required = true;
                    // Default to today and 7 days ago if empty
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

                // Validation for custom date difference
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

                // Show loading state
                setLoadingState(true);

                const formData = new FormData(form);
                const payload = {
                    period: formData.get('period'),
                    start_date: formData.get('start_date'),
                    end_date: formData.get('end_date')
                };

                fetch('{{ route("admin.ai.analyze-revenue") }}', {
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
                    const isJson = contentType && contentType.includes('application/json');

                    if (!response.ok) {
                        if (isJson) {
                            return response.json().then(err => { throw err; });
                        } else {
                            return response.text().then(text => {
                                let friendlyMessage = 'Terjadi kesalahan sistem pada server.';
                                if (response.status === 403) {
                                    friendlyMessage = 'Akses ditolak: Anda tidak memiliki izin untuk melakukan analisis ini.';
                                } else if (response.status === 419) {
                                    friendlyMessage = 'Sesi Anda telah berakhir. Harap muat ulang halaman dan coba lagi.';
                                } else if (response.status === 500) {
                                    friendlyMessage = 'Terjadi kesalahan internal pada server (Error 500).';
                                } else if (response.status === 404) {
                                    friendlyMessage = 'Layanan analisis tidak ditemukan.';
                                }
                                throw { message: friendlyMessage };
                            });
                        }
                    }

                    if (isJson) {
                        return response.json();
                    } else {
                        throw { message: 'Format respons dari server tidak valid (bukan JSON).' };
                    }
                })
                .then(data => {
                    if (data.success) {
                        // Render Markdown securely
                        const rawHtml = marked.parse(data.markdown);
                        const cleanHtml = DOMPurify.sanitize(rawHtml);
                        renderedContent.innerHTML = cleanHtml;

                        // Set metadata
                        const dateObj = new Date(data.generated_at);
                        const formattedTime = dateObj.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        }) + ' ' + dateObj.toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit'
                        }) + ' WIB';

                        generatedTimestamp.textContent = formattedTime;
                        periodBadge.textContent = data.period_label;

                        // Show content
                        showState('content');
                    } else {
                        showError(data.message || 'Terjadi kesalahan tidak dikenal.');
                    }
                })
                .catch(error => {
                    console.error('AI Revenue Analyst error:', error);
                    let msg = 'Gagal terhubung dengan server. Harap periksa koneksi Anda.';
                    if (error.message) {
                        msg = error.message;
                    } else if (error.errors) {
                        // Laravel validation errors
                        const firstKey = Object.keys(error.errors)[0];
                        msg = error.errors[firstKey][0];
                    }
                    showError(msg);
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
                    showState('loading');
                } else {
                    if (btn) {
                        btn.disabled = false;
                        btn.classList.remove('opacity-75', 'cursor-not-allowed');
                    }
                    if (btnText) btnText.textContent = 'Analisis dengan AI';
                }
            }
        });
    </script>
</x-app-layout>
