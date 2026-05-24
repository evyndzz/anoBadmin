<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
            {{ __('Dashboard Owner') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-950 transition-colors duration-300 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 shadow-soft hover:shadow-soft-lg rounded-3xl p-5 sm:p-6 transition-all duration-300 hover:-translate-y-0.5">
                    <div class="font-extrabold text-slate-800 dark:text-slate-300 text-base mb-0.5">Total Pendapatan</div>
                    <div class="text-xs text-slate-400 dark:text-slate-500 mb-3.5">Seluruh transaksi selesai</div>
                    <div class="text-3xl font-black text-slate-800 dark:text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                </div>

                <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 shadow-soft hover:shadow-soft-lg rounded-3xl p-5 sm:p-6 transition-all duration-300 hover:-translate-y-0.5">
                    <div class="font-extrabold text-slate-800 dark:text-slate-300 text-base mb-0.5">Total Booking</div>
                    <div class="text-xs text-slate-400 dark:text-slate-500 mb-3.5">Seluruh transaksi (All Time)</div>
                    <div class="text-3xl font-black text-slate-800 dark:text-white">{{ $totalBookings }}</div>
                </div>

                <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 shadow-soft hover:shadow-soft-lg rounded-3xl p-5 sm:p-6 transition-all duration-300 hover:-translate-y-0.5">
                    <div class="font-extrabold text-slate-800 dark:text-slate-300 text-base mb-0.5">Total Pelanggan</div>
                    <div class="text-xs text-slate-400 dark:text-slate-500 mb-3.5">User terdaftar</div>
                    <div class="text-3xl font-black text-slate-800 dark:text-white">{{ $totalUsers }}</div>
                </div>
            </div>

            <!-- Revenue Chart Section -->
            <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/85 p-6 sm:p-8 rounded-4xl shadow-soft">
                <div class="mb-8">
                    <h4 class="text-xl font-extrabold text-slate-800 dark:text-white tracking-tight">Laporan Pendapatan (Rp) - {{ $currentMonthName ?? '' }}</h4>
                    <div class="text-slate-500 dark:text-slate-400 text-sm mt-1">Total pendapatan bulan ini <span class="font-extrabold text-brand-600 dark:text-brand-400 ml-1">Rp {{ number_format(array_sum($dailyRevenue ?? []), 0, ',', '.') }}</span></div>
                </div>

                <div class="relative h-80 w-full mb-4">
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

                // Detect dark mode status for chart color customization
                const isDark = document.documentElement.classList.contains('dark');
                const gridColor = isDark ? 'rgba(226, 232, 240, 0.06)' : '#f1f5f9';
                const textColor = isDark ? '#9ca3af' : '#64748b';
                const brandColor = '#10b981'; // Emerald brand-500
                const hoverBrandColor = '#34d399'; // Emerald brand-400
                
                let gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 320);
                gradient.addColorStop(0, isDark ? 'rgba(16, 185, 129, 0.25)' : 'rgba(16, 185, 129, 0.2)');
                gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Pendapatan (Rp)',
                            data: dataPoints,
                            borderColor: brandColor,
                            backgroundColor: gradient,
                            borderWidth: 2.5,
                            pointBackgroundColor: isDark ? '#0f172a' : '#fff',
                            pointBorderColor: brandColor,
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: hoverBrandColor,
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 2,
                            fill: true,
                            tension: 0.35
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: isDark ? '#151e2e' : '#1e293b',
                                titleColor: '#fff',
                                bodyColor: hoverBrandColor,
                                padding: 12,
                                cornerRadius: 12,
                                borderWidth: 1,
                                borderColor: isDark ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.05)',
                                titleFont: { size: 12, weight: '600' },
                                bodyFont: { size: 14, weight: '800' },
                                displayColors: false,
                                callbacks: {
                                    title: function(context) {
                                        return 'Tanggal ' + context[0].label;
                                    },
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
                                ticks: { color: textColor, font: { size: 11, weight: '500' } }
                            },
                            y: {
                                grid: {
                                    color: gridColor,
                                    drawBorder: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    color: textColor,
                                    font: { size: 11, weight: '500' },
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
