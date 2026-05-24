<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
            {{ __('Kelola Voucher & Promo') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-950 transition-colors duration-300 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Add Promo Form -->
            <div class="card bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 shadow-soft rounded-4xl p-6 sm:p-8 transition-all duration-300">
                <h3 class="text-lg font-extrabold mb-4 flex items-center text-slate-850 dark:text-white tracking-tight border-b border-slate-100 dark:border-slate-800 pb-3">
                    <svg class="w-5 h-5 mr-2 text-brand-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Buat Voucher Baru
                </h3>
                <form action="{{ route('admin.vouchers.store') }}" method="POST" class="bg-slate-50/50 dark:bg-slate-950/40 p-5 rounded-3xl border border-slate-200 dark:border-slate-850 shadow-inner">
                    @csrf
                     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                        <div>
                            <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">Kode Promo</label>
                            <input type="text" name="code" class="input text-sm" required placeholder="Contoh: MERDEKA50">
                        </div>
                        <div>
                            <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">Potongan Rupiah (Rp)</label>
                            <input type="number" name="discount_amount" class="input text-sm" placeholder="Contoh: 50000">
                        </div>
                        <div>
                            <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">Atau Potongan Persen (%)</label>
                            <input type="number" name="discount_percent" class="input text-sm" placeholder="Maks 100">
                        </div>
                        <div>
                            <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">Min. Transaksi</label>
                            <input type="number" name="min_transaction" class="input text-sm" value="0" required>
                        </div>
                        <div>
                            <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">Harga Tukar Poin (Pts)</label>
                            <input type="number" name="points_required" class="input text-sm" value="0" required>
                        </div>
                    </div>
                    <div class="mt-5 flex justify-end">
                        <button type="submit" class="btn-primary py-2.5 px-6 flex items-center gap-1.5 shadow-soft">
                            Simpan Voucher
                        </button>
                    </div>
                </form>
            </div>

            <!-- List of Promos -->
            <div class="card bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 shadow-soft rounded-4xl p-6 sm:p-8 transition-all duration-300">
                <h3 class="text-lg font-extrabold mb-5 flex items-center text-slate-850 dark:text-white tracking-tight border-b border-slate-100 dark:border-slate-800 pb-3">
                    <svg class="w-5 h-5 mr-2 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    Daftar Voucher & Kupon Aktif
                </h3>
                
                @if($promos->count() > 0)
                    <div class="overflow-x-auto rounded-2xl border border-slate-100 dark:border-slate-800 shadow-inner">
                        <table class="table-soft">
                            <thead>
                                <tr>
                                    <th>Kode Voucher</th>
                                    <th>Nilai Potongan</th>
                                    <th>Syarat Transaksi</th>
                                    <th>Harga Tukar Poin</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promos as $promo)
                                <tr>
                                    <td>
                                        <div class="font-black text-slate-800 dark:text-white text-base uppercase font-mono tracking-wider">{{ $promo->code }}</div>
                                    </td>
                                    <td>
                                        @if($promo->discount_amount)
                                            <span class="badge badge-success text-xs px-2.5 py-1 shadow-sm">Rp {{ number_format($promo->discount_amount, 0, ',', '.') }}</span>
                                        @elseif($promo->discount_percent)
                                            <span class="badge badge-success text-xs px-2.5 py-1 shadow-sm">Diskon {{ $promo->discount_percent }}%</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-xs text-slate-550 dark:text-slate-400 font-bold">Min: Rp {{ number_format($promo->min_transaction, 0, ',', '.') }}</div>
                                    </td>
                                    <td>
                                        <span class="font-extrabold text-brand-600 dark:text-brand-400 flex items-center gap-1.5 text-sm">
                                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $promo->points_required }} Pts
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <form action="{{ route('admin.vouchers.destroy', $promo) }}" method="POST" class="inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus voucher {{ $promo->code }}?')" class="text-rose-600 dark:text-rose-400 hover:text-rose-700 dark:hover:text-rose-300 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100/80 dark:hover:bg-rose-900/60 border border-rose-100/50 dark:border-rose-900/30 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12 text-slate-500 dark:text-slate-450 bg-slate-50/50 dark:bg-slate-900/20 rounded-3xl border border-dashed border-slate-200 dark:border-slate-850">
                        <svg class="w-12 h-12 text-slate-300 dark:text-slate-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        <p class="text-sm font-semibold">Belum ada voucher yang dibuat.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
