<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Owner') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
                    <div class="font-bold text-gray-900 text-lg mb-1">Total Pendapatan</div>
                    <div class="text-xs text-gray-500 mb-3">Seluruh transaksi selesai</div>
                    <div class="text-2xl font-black text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                </div>

                <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
                    <div class="font-bold text-gray-900 text-lg mb-1">Total Booking</div>
                    <div class="text-xs text-gray-500 mb-3">Seluruh transaksi (All Time)</div>
                    <div class="text-2xl font-black text-gray-900">{{ $totalBookings }}</div>
                </div>

                <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
                    <div class="font-bold text-gray-900 text-lg mb-1">Total Pelanggan</div>
                    <div class="text-xs text-gray-500 mb-3">User terdaftar</div>
                    <div class="text-2xl font-black text-gray-900">{{ $totalUsers }}</div>
                </div>
            </div>

            <!-- Revenue Chart Section -->
            <div class="bg-white overflow-hidden sm:rounded-xl border border-gray-100 p-6 shadow-sm">
                <div class="mb-8">
                    <h4 class="text-lg font-bold text-gray-900">Laporan Pendapatan (Rp) - {{ $currentMonthName ?? '' }}</h4>
                    <div class="text-gray-500 text-sm">Total pendapatan bulan ini <span class="font-bold text-gray-900 ml-1">Rp {{ number_format(array_sum($dailyRevenue ?? []), 0, ',', '.') }}</span></div>
                </div>

                <div class="relative h-80 w-full mb-8">
                    <canvas id="revenueChart"></canvas>
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
                const rawData = @json($dailyRevenue ?? []);
                const daysInMonth = {{ $daysInMonth ?? 30 }};
                
                const labels = [];
                const dataPoints = new Array(daysInMonth).fill(0);
                
                for (let i = 1; i <= daysInMonth; i++) {
                    labels.push(i);
                }
                
                Object.keys(rawData).forEach(dayNum => {
                    const idx = parseInt(dayNum) - 1;
                    dataPoints[idx] = parseFloat(rawData[dayNum]);
                });

                let gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(168, 85, 247, 0.2)');
                gradient.addColorStop(1, 'rgba(168, 85, 247, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Pendapatan (Rp)',
                            data: dataPoints,
                            borderColor: '#a855f7',
                            backgroundColor: gradient,
                            borderWidth: 2,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#a855f7',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1f2937',
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
                                ticks: { color: '#9ca3af', font: { size: 12 } }
                            },
                            y: {
                                grid: {
                                    color: '#f3f4f6',
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
