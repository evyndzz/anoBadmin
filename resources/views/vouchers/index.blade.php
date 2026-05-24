<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
            {{ __('Voucher & Promo Anda') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-950 transition-colors duration-300 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-100 dark:border-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-3 rounded-2xl relative mb-4 shadow-sm" role="alert">
                <span class="block sm:inline font-semibold">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-rose-50 dark:bg-rose-950/40 border border-rose-100 dark:border-rose-900/30 text-rose-700 dark:text-rose-400 px-4 py-3 rounded-2xl relative mb-4 shadow-sm" role="alert">
                <span class="block sm:inline font-semibold">{{ session('error') }}</span>
            </div>
            @endif

            <!-- Points Banner in Brand Emerald-Teal Gradient -->
            <div class="bg-gradient-to-r from-brand-500 via-emerald-600 to-teal-700 rounded-4xl p-6 sm:p-8 shadow-soft text-white flex flex-col sm:flex-row items-center justify-between border border-emerald-400/20">
                <div class="flex items-center mb-4 sm:mb-0">
                    <div class="w-16 h-16 bg-white/20 dark:bg-white/10 rounded-2xl flex items-center justify-center mr-5 backdrop-blur shadow-inner">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-brand-100/90 dark:text-brand-200/80 text-xs sm:text-sm font-semibold uppercase tracking-wider mb-0.5">Total Poin Reward Anda</div>
                        <div class="text-3xl sm:text-4xl font-black tracking-tight">{{ number_format(auth()->user()->points_balance, 0, ',', '.') }} <span class="text-lg font-normal text-brand-100/90 dark:text-brand-200/80">Pts</span></div>
                    </div>
                </div>
                <div class="text-xs sm:text-sm text-emerald-50 dark:text-slate-100 bg-white/10 dark:bg-black/10 px-4 py-3 rounded-2xl max-w-xs text-center sm:text-right border border-white/20 dark:border-white/10 shadow-sm leading-relaxed">
                    Kumpulkan poin dengan mem-booking lapangan (+10 Pts/Jam) atau berlangganan membership!
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Owned Vouchers -->
                <div class="card bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 shadow-soft p-6 sm:p-8 rounded-4xl">
                    <div class="flex items-center mb-6 border-b border-slate-100 dark:border-slate-800/80 pb-4">
                        <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30 rounded-2xl flex items-center justify-center mr-4 shadow-inner">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-800 dark:text-white tracking-tight">Voucher Dimiliki (Aktif)</h3>
                    </div>
                    
                    @if(count($ownedVouchers) > 0)
                        <div class="space-y-4">
                            @foreach($ownedVouchers as $voucher)
                            <!-- Ticket-Stub Voucher Card (Wireframe 4.4) -->
                            <div class="relative bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl overflow-hidden flex shadow-soft hover:shadow-soft-lg transition-all duration-300">
                                <!-- Left Stub: Details -->
                                <div class="flex-1 p-5 pr-2">
                                    <div class="text-[10px] font-black text-brand-600 dark:text-brand-400 uppercase tracking-widest mb-1.5">Voucher Diskon</div>
                                    <div class="text-2xl font-black text-slate-800 dark:text-white font-mono tracking-wider uppercase">{{ $voucher->code }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 mt-2 font-semibold">Potongan <span class="font-extrabold text-brand-600 dark:text-brand-400 text-sm bg-brand-50 dark:bg-brand-950/40 px-2 py-0.5 rounded-xl border border-brand-100 dark:border-brand-900/20 ml-1">{{ $voucher->discount_percent }}%</span></div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 mt-3 font-semibold">Min. Transaksi Rp {{ number_format($voucher->min_transaction, 0, ',', '.') }}</div>
                                </div>
                                
                                <!-- Dashed Ticket Divider with Circular Notches -->
                                <div class="w-px border-l-2 border-dashed border-slate-200 dark:border-slate-800 relative flex items-center justify-center shrink-0">
                                    <!-- Top Cutout Notch -->
                                    <div class="absolute -top-3 -left-3.5 w-7 h-7 rounded-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 z-10 shadow-inner"></div>
                                    <!-- Bottom Cutout Notch -->
                                    <div class="absolute -bottom-3 -left-3.5 w-7 h-7 rounded-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 z-10 shadow-inner"></div>
                                </div>
                                
                                <!-- Right Stub: Status -->
                                <div class="w-28 p-5 flex flex-col items-center justify-center bg-slate-50/50 dark:bg-slate-950/20 shrink-0">
                                    <span class="text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 mb-1.5">Status</span>
                                    <span class="badge badge-success text-[10px] px-2.5 py-1 shadow-sm">Siap Pakai</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 px-6 border-2 border-dashed border-slate-100 dark:border-slate-800 rounded-3xl bg-slate-50/50 dark:bg-slate-900/20 text-slate-500 dark:text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            <p class="text-sm font-semibold">Anda belum memiliki voucher aktif.</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Tukarkan poin Anda di kolom sebelah kanan!</p>
                        </div>
                    @endif
                </div>

                <!-- Available Vouchers to Redeem -->
                <div class="card bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 shadow-soft p-6 sm:p-8 rounded-4xl">
                    <div class="flex items-center mb-6 border-b border-slate-100 dark:border-slate-800/80 pb-4">
                        <div class="w-10 h-10 bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-900/30 rounded-2xl flex items-center justify-center mr-4 shadow-inner">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-800 dark:text-white tracking-tight">Tukar Poin dengan Promo</h3>
                    </div>

                    @if(count($availablePromos) > 0)
                        <div class="space-y-4">
                            @foreach($availablePromos as $promo)
                            <div class="border border-slate-200 dark:border-slate-800 hover:border-brand-300 dark:hover:border-brand-700 bg-white dark:bg-slate-900/40 rounded-3xl p-5 flex justify-between items-center transition shadow-soft hover:shadow-soft-lg duration-300">
                                <div>
                                    <div class="font-mono font-black text-brand-600 dark:text-brand-400 text-lg uppercase tracking-wider mb-1">{{ $promo->code }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">Diskon {{ $promo->discount_percent }}% (Min. Belanja: Rp {{ number_format($promo->min_transaction, 0, ',', '.') }})</div>
                                    <div class="mt-2.5 inline-flex items-center text-[10px] font-bold bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 px-2.5 py-1 rounded-xl border border-amber-100/50 dark:border-amber-900/20 shadow-sm">
                                        <svg class="w-3.5 h-3.5 mr-1 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Butuh {{ $promo->points_required }} Poin
                                    </div>
                                </div>
                                <form action="{{ route('vouchers.redeem', $promo) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Tukar {{ $promo->points_required }} poin untuk voucher {{ $promo->code }}?')" class="btn-primary text-xs py-2 px-4 shadow-soft">
                                        Tukar
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 px-6 border-2 border-dashed border-slate-100 dark:border-slate-800 rounded-3xl bg-slate-50/50 dark:bg-slate-900/20 text-slate-500 dark:text-slate-400">
                            Saat ini belum ada promo yang tersedia untuk Anda tukarkan. Terus tingkatkan transaksi Anda!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
