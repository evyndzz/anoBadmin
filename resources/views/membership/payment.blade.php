<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
            {{ __('Pembayaran Membership') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-950 transition-colors duration-300 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Order Summary -->
            <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-soft rounded-4xl p-6 sm:p-8 transition-all duration-300">
                <div class="text-slate-800 dark:text-slate-100">
                    <h3 class="text-lg font-extrabold mb-4 border-b border-slate-100 dark:border-slate-800 pb-2 tracking-tight">Detail Transaksi Membership</h3>
                    
                    <div class="space-y-4 text-sm">
                        <div class="flex flex-col sm:flex-row justify-between border-b border-dashed border-slate-200 dark:border-slate-800 pb-3">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Paket Membership</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200 text-lg">{{ $membership->name }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between border-b border-dashed border-slate-200 dark:border-slate-800 pb-3">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Jadwal Main</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200 font-mono text-xs sm:text-sm bg-slate-50 dark:bg-slate-850 px-2.5 py-1 rounded-xl border border-slate-100 dark:border-slate-800">{{ $schedule->days }} ({{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB)</span>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between border-b border-dashed border-slate-200 dark:border-slate-800 pb-3">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Lapangan</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200">{{ $schedule->court->name ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between border-b border-dashed border-slate-200 dark:border-slate-800 pb-3">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Durasi Aktif</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200">{{ $membership->duration_months }} Bulan</span>
                        </div>

                        <!-- Total -->
                        <div class="flex justify-between pt-4 pb-2 items-center border-t border-slate-100 dark:border-slate-800">
                            <span class="text-slate-700 dark:text-slate-300 font-extrabold text-base sm:text-lg">Total Pembayaran</span>
                            <span class="font-black text-3xl text-brand-600 dark:text-brand-400">Rp {{ number_format($price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Simulation -->
            <div class="card bg-white dark:bg-slate-900 border-2 border-brand-100 dark:border-brand-900/40 shadow-soft rounded-4xl p-6 sm:p-8 transition-all duration-300">
                <div class="text-slate-800 dark:text-slate-100">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-brand-100 dark:bg-brand-900/40 border border-brand-200/20 dark:border-brand-800/30 rounded-2xl flex items-center justify-center mr-3 text-brand-650 dark:text-brand-400 shadow-sm flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        </div>
                        <h3 class="text-lg font-extrabold tracking-tight">Pembayaran QRIS (Simulasi)</h3>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6 items-center bg-slate-50/50 dark:bg-slate-900/40 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-inner">
                        <!-- Dummy QR Code in Brand Emerald Color -->
                        <div class="bg-white p-4 rounded-3xl shadow-soft border border-brand-100 dark:border-brand-900/30 shrink-0">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&color=059669&data=QRIS-AnoBadmin-Membership-{{ $membership->id }}" alt="QRIS" class="w-40 h-40 mx-auto">
                        </div>

                        <div class="flex-1 space-y-4 w-full">
                            <div class="bg-brand-50/20 dark:bg-brand-950/15 border border-brand-100/30 dark:border-brand-900/20 text-brand-800 dark:text-brand-300 p-4 rounded-2xl text-xs font-semibold leading-relaxed">
                                <strong>Info:</strong> Fitur ini adalah simulasi. Klik tombol di bawah ini untuk mensimulasikan keberhasilan pembayaran membership Anda.
                            </div>

                            <form action="{{ route('membership.pay') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-primary w-full py-3.5 rounded-2xl flex items-center justify-center gap-2 font-bold text-sm shadow-soft hover:shadow-soft-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Simulasikan Bayar Rp {{ number_format($price, 0, ',', '.') }}
                                </button>
                            </form>
                            
                            <div class="text-center pt-1">
                                <a href="{{ route('membership.index') }}" class="text-xs font-bold text-slate-400 hover:text-rose-500 transition hover:underline">Batalkan & Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
