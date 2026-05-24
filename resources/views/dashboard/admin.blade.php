<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl p-5 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-gray-50 dark:bg-slate-700 rounded-lg">
                            <svg class="w-5 h-5 text-gray-700 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19L20 5M20 5v10M20 5H10"></path></svg>
                    </div>
                    <div class="font-bold text-gray-900 dark:text-white text-lg mb-1">Booking Pending</div>
                    <div class="text-xs text-gray-500 dark:text-slate-400 mb-3">Transaksi belum dibayar</div>
                    <div class="text-2xl font-black text-gray-900 dark:text-white">{{ $pendingBookings }}</div>
                </div>

                <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl p-5 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-gray-50 dark:bg-slate-700 rounded-lg">
                            <svg class="w-5 h-5 text-gray-700 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19L20 5M20 5v10M20 5H10"></path></svg>
                    </div>
                    <div class="font-bold text-gray-900 dark:text-white text-lg mb-1">Lapangan Aktif</div>
                    <div class="text-xs text-gray-500 dark:text-slate-400 mb-3">Total lapangan tersedia</div>
                    <div class="text-2xl font-black text-gray-900 dark:text-white">{{ $totalCourts }}</div>
                </div>

                <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl p-5 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-gray-50 dark:bg-slate-700 rounded-lg">
                            <svg class="w-5 h-5 text-gray-700 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19L20 5M20 5v10M20 5H10"></path></svg>
                    </div>
                    <div class="font-bold text-gray-900 dark:text-white text-lg mb-1">Total Booking</div>
                    <div class="text-xs text-gray-500 dark:text-slate-400 mb-3">Seluruh transaksi (All Time)</div>
                    <div class="text-2xl font-black text-gray-900 dark:text-white">{{ \App\Models\Booking::count() }}</div>
                </div>

                <div class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl p-5 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-gray-50 dark:bg-slate-700 rounded-lg">
                            <svg class="w-5 h-5 text-gray-700 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19L20 5M20 5v10M20 5H10"></path></svg>
                    </div>
                    <div class="font-bold text-gray-900 dark:text-white text-lg mb-1">Member Aktif</div>
                    <div class="text-xs text-gray-500 dark:text-slate-400 mb-3">Langganan aktif</div>
                    <div class="flex items-baseline space-x-2">
                        <div class="text-2xl font-black text-gray-900 dark:text-white">{{ $totalMembers }}</div>
                        <div class="text-xs font-bold text-green-500 dark:text-green-400 bg-green-50 dark:bg-green-500/10 px-2 py-0.5 rounded-full">+{{ $memberIncreaseThisMonth }} bulan ini</div>
                    </div>
                </div>
            </div>

            <!-- Revenue Chart Section -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden sm:rounded-xl border border-gray-100 dark:border-slate-700 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Performance overview</h3>
                    <div class="flex space-x-2">
                        <button class="px-4 py-2 border border-gray-200 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition">Export</button>
                        <button class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition flex items-center">
                            Last 30 day <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                    </div>
                </div>
                
                <div class="mb-8">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">Total Revenue - {{ $currentMonthName ?? '' }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-gray-50 dark:bg-slate-700/50 p-4 rounded-xl border border-gray-100 dark:border-slate-600">
                            <div class="text-sm text-gray-500 dark:text-slate-400 mb-1">Total Keseluruhan</div>
                            <div class="text-2xl font-black text-gray-900 dark:text-white">Rp {{ number_format($totalRevenueBooking + $totalRevenueMembership, 0, ',', '.') }}</div>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800/50">
                            <div class="text-sm text-blue-600 dark:text-blue-400 mb-1">Dari Booking Reguler</div>
                            <div class="text-2xl font-black text-blue-900 dark:text-blue-100">Rp {{ number_format($totalRevenueBooking, 0, ',', '.') }}</div>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-xl border border-purple-100 dark:border-purple-800/50">
                            <div class="text-sm text-purple-600 dark:text-purple-400 mb-1">Dari Membership</div>
                            <div class="text-2xl font-black text-purple-900 dark:text-purple-100">Rp {{ number_format($totalRevenueMembership, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <div class="relative h-80 w-full mb-8">
                    <canvas id="revenueChart"></canvas>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 pt-6 border-t border-gray-100 dark:border-slate-700">
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white mb-1">New bookings</div>
                        <div class="text-sm text-gray-500 dark:text-slate-400">Today</div>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white mb-1">Total revenue</div>
                        <div class="text-sm text-gray-500 dark:text-slate-400">This month</div>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white mb-1">Active</div>
                        <div class="text-sm text-gray-500 dark:text-slate-400">Memberships</div>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white mb-1">Cancellations</div>
                        <div class="text-sm text-gray-500 dark:text-slate-400">Last 30 day</div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings Table -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-slate-100 dark:border-slate-700">
                <div class="p-6 text-gray-900 dark:text-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Manajemen Transaksi & Booking</h3>
                        <!-- Link to homepage for manual booking -->
                        <a href="{{ route('bookings.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-blue-700 transition">
                            + Tambah Transaksi
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                            <thead class="bg-gray-50 dark:bg-slate-700/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Tanggal & Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                                @foreach($bookings as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">{{ $booking->booking_code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->user ? $booking->user->name : $booking->guest_name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-slate-400">{{ $booking->user ? $booking->user->phone : $booking->guest_phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                        {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                                        <br>
                                        @if($booking->details->first())
                                            {{ \Carbon\Carbon::parse($booking->details->first()->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->details->first()->end_time)->format('H:i') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($booking->status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-400">Pending</span>
                                        @elseif($booking->status == 'completed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400">Selesai</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-slate-300">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        @if($booking->status == 'pending')
                                            <form action="{{ route('admin.bookings.verify', $booking) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Verifikasi pembayaran Transfer untuk booking {{ $booking->booking_code }}?')" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1 rounded-full text-xs font-semibold transition">Verif Transfer</button>
                                            </form>
                                            <form action="{{ route('admin.bookings.cash', $booking) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Tandai booking {{ $booking->booking_code }} telah dibayar Tunai/Cash?')" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-900 dark:hover:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/30 px-3 py-1 rounded-full text-xs font-semibold transition">Bayar Tunai</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin ingin menghapus transaksi {{ $booking->booking_code }}?')" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/30 px-3 py-1 rounded-full text-xs font-semibold transition">Hapus</button>
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

                // Create gradient for booking
                let gradientBooking = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
                gradientBooking.addColorStop(0, 'rgba(59, 130, 246, 0.2)'); // blue-500
                gradientBooking.addColorStop(1, 'rgba(59, 130, 246, 0)');

                // Create gradient for membership
                let gradientMembership = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
                gradientMembership.addColorStop(0, 'rgba(168, 85, 247, 0.2)'); // purple-500
                gradientMembership.addColorStop(1, 'rgba(168, 85, 247, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Booking Reguler (Rp)',
                                data: dataPointsBooking,
                                borderColor: '#3b82f6', // blue-500
                                backgroundColor: gradientBooking,
                                borderWidth: 2,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#3b82f6',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                fill: true,
                                tension: 0.4
                            },
                            {
                                label: 'Membership (Rp)',
                                data: dataPointsMembership,
                                borderColor: '#a855f7', // purple-500
                                backgroundColor: gradientMembership,
                                borderWidth: 2,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#a855f7',
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
                            legend: { display: true, position: 'top' },
                            tooltip: {
                                backgroundColor: '#1f2937', // gray-800
                                padding: 12,
                                titleFont: { size: 13, weight: 'normal' },
                                bodyFont: { size: 14, weight: 'bold' },
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
                                ticks: { color: '#9ca3af', font: { size: 12 } } // gray-400
                            },
                            y: {
                                grid: {
                                    color: 'rgba(156, 163, 175, 0.1)', // Subtle gray
                                    drawBorder: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    color: '#9ca3af',
                                    font: { size: 12 },
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
