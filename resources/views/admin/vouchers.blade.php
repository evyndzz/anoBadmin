<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Voucher & Promo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Add Promo Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-slate-100">
                <h3 class="text-lg font-bold mb-4 flex items-center text-indigo-900">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Buat Voucher Baru
                </h3>
                <form action="{{ route('admin.vouchers.store') }}" method="POST" class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kode Promo</label>
                            <input type="text" name="code" class="w-full text-sm rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" required placeholder="Contoh: MERDEKA50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Potongan Rupiah (Rp)</label>
                            <input type="number" name="discount_amount" class="w-full text-sm rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" placeholder="Contoh: 50000">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Atau Potongan Persen (%)</label>
                            <input type="number" name="discount_percent" class="w-full text-sm rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" placeholder="Maks 100">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Min. Transaksi</label>
                            <input type="number" name="min_transaction" class="w-full text-sm rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" value="0" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Harga Tukar Poin (Pts)</label>
                            <input type="number" name="points_required" class="w-full text-sm rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" value="0" required>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition shadow-sm flex items-center">
                            Simpan Voucher
                        </button>
                    </div>
                </form>
            </div>

            <!-- List of Promos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-slate-100">
                <h3 class="text-lg font-bold mb-4 flex items-center text-slate-800">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    Daftar Voucher & Kupon Aktif
                </h3>
                
                @if($promos->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border rounded-xl overflow-hidden">
                            <thead class="bg-indigo-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Kode Voucher</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Nilai Potongan</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Syarat Transaksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Harga Tukar Poin</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-indigo-900 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($promos as $promo)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-black text-slate-900 text-lg uppercase">{{ $promo->code }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($promo->discount_amount)
                                            <span class="px-3 py-1 rounded-md bg-green-100 text-green-800 font-bold">Rp {{ number_format($promo->discount_amount, 0, ',', '.') }}</span>
                                        @elseif($promo->discount_percent)
                                            <span class="px-3 py-1 rounded-md bg-green-100 text-green-800 font-bold">Diskon {{ $promo->discount_percent }}%</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        Min: Rp {{ number_format($promo->min_transaction, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-bold text-blue-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $promo->points_required }} Pts
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('admin.vouchers.destroy', $promo) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus voucher {{ $promo->code }}?')" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition font-semibold">
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
                    <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        Belum ada voucher yang dibuat.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
