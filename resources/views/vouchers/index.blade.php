<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Voucher & Promo Anda') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <!-- Points Banner -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 shadow-lg text-white flex flex-col sm:flex-row items-center justify-between">
                <div class="flex items-center mb-4 sm:mb-0">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mr-6 backdrop-blur">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-blue-200 text-sm font-medium uppercase tracking-wider mb-1">Total Poin Reward Anda</div>
                        <div class="text-4xl font-black">{{ number_format(auth()->user()->points_balance, 0, ',', '.') }} <span class="text-xl font-normal text-blue-200">Pts</span></div>
                    </div>
                </div>
                <div class="text-sm text-blue-100 bg-white/10 px-4 py-3 rounded-xl max-w-xs text-center sm:text-right border border-white/20">
                    Kumpulkan poin dengan mem-booking lapangan (+10 Pts/Jam) atau berlangganan membership!
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Owned Vouchers -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Voucher Dimiliki (Aktif)</h3>
                    </div>
                    
                    @if(count($ownedVouchers) > 0)
                        <div class="space-y-4">
                            @foreach($ownedVouchers as $voucher)
                            <div class="border-2 border-emerald-500 bg-emerald-50 rounded-2xl p-5 flex justify-between items-center relative overflow-hidden group">
                                <div class="absolute -right-4 -top-4 w-16 h-16 bg-emerald-500 rounded-full opacity-10 group-hover:scale-150 transition duration-500"></div>
                                <div>
                                    <div class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-1">Voucher Diskon</div>
                                    <div class="text-2xl font-black text-slate-800 font-mono">{{ $voucher->code }}</div>
                                    <div class="text-sm text-slate-600 mt-2">Potongan: <span class="font-bold">{{ $voucher->discount_percent }}%</span> (Min. Transaksi Rp {{ number_format($voucher->min_transaction, 0, ',', '.') }})</div>
                                </div>
                                <div class="text-center bg-white p-3 rounded-xl shadow-sm border border-emerald-100">
                                    <span class="block text-xs text-slate-400 mb-1">Status</span>
                                    <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full">Siap Pakai</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 px-4 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50 text-slate-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            Anda belum memiliki voucher aktif.<br>Tukarkan poin Anda di sebelahnya!
                        </div>
                    @endif
                </div>

                <!-- Available Vouchers -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Tukar Poin dengan Promo</h3>
                    </div>

                    @if(count($availablePromos) > 0)
                        <div class="space-y-4">
                            @foreach($availablePromos as $promo)
                            <div class="border border-slate-200 hover:border-amber-400 bg-white rounded-2xl p-5 flex justify-between items-center transition shadow-sm hover:shadow-md">
                                <div>
                                    <div class="font-mono font-bold text-amber-600 text-lg mb-1">{{ $promo->code }}</div>
                                    <div class="text-sm text-slate-600">Diskon {{ $promo->discount_percent }}% (Min. Belanja: Rp {{ number_format($promo->min_transaction, 0, ',', '.') }})</div>
                                    <div class="mt-2 inline-flex items-center text-xs font-bold bg-amber-50 text-amber-700 px-2 py-1 rounded">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Butuh {{ $promo->points_required }} Poin
                                    </div>
                                </div>
                                <form action="{{ route('vouchers.redeem', $promo) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Tukar {{ $promo->points_required }} poin untuk voucher {{ $promo->code }}?')" class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-2 px-4 rounded-xl text-sm transition transform hover:-translate-y-0.5">
                                        Tukar
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 px-4 border border-slate-200 rounded-2xl bg-slate-50 text-slate-500">
                            Saat ini belum ada promo yang tersedia untuk Anda tukarkan. Terus tingkatkan transaksi Anda!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
