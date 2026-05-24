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
</x-app-layout>
