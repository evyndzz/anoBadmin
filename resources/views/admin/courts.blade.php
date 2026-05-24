<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
                {{ __('Kelola Lapangan') }}
            </h2>
            <button onclick="document.getElementById('addCourtModal').classList.remove('hidden')" class="btn-primary text-sm font-semibold shadow-soft py-2 px-5 flex items-center gap-1.5 active:scale-95 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Lapangan
            </button>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-950 transition-colors duration-300 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- List of Courts -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($courts as $court)
                    <div class="card bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 shadow-soft hover:shadow-soft-lg rounded-4xl overflow-hidden flex flex-col group hover:-translate-y-1.5 transition-all duration-300 p-0">
                        <div class="h-48 bg-slate-200 dark:bg-slate-850 relative overflow-hidden flex-shrink-0">
                            @if($court->image)
                                <img src="{{ $court->image }}" alt="{{ $court->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <img src="https://storage.googleapis.com/data.ayo.co.id/photos/77445/SEO%20HDI%202/16.%20Kelebihan%20dan%20Kekurangan%20Lapangan%20Badminton%20Sintetis%20yang%20Perlu%20Diketahui.jpg" alt="{{ $court->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @endif
                            <div class="absolute top-3 right-3">
                                @if($court->is_active)
                                    <span class="badge badge-success shadow-soft text-xs px-3 py-1">Aktif</span>
                                @else
                                    <span class="badge badge-danger shadow-soft text-xs px-3 py-1">Nonaktif</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="text-lg font-extrabold text-slate-850 dark:text-white mb-1 tracking-tight">{{ $court->name }}</h3>
                            <div class="text-brand-650 dark:text-brand-400 font-extrabold mb-3 text-base">Rp {{ number_format($court->price_per_hour, 0, ',', '.') }} <span class="text-xs text-slate-500 dark:text-slate-400 font-normal">/jam</span></div>
                            <p class="text-sm text-slate-550 dark:text-slate-400 flex-1 leading-relaxed">{{ \Illuminate\Support\Str::limit($court->description, 100) }}</p>
                            
                            <div class="mt-5 pt-4 border-t border-slate-100 dark:border-slate-850/80 flex justify-end space-x-2.5">
                                <button onclick="openEditModal({{ $court->toJson() }})" class="text-brand-600 dark:text-brand-400 hover:text-brand-700 dark:hover:text-brand-300 bg-brand-50 dark:bg-brand-950/40 hover:bg-brand-100/80 dark:hover:bg-brand-900/60 border border-brand-100/50 dark:border-brand-900/30 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all">
                                    Edit
                                </button>
                                <form action="{{ route('admin.courts.destroy', $court) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus lapangan ini secara permanen?')" class="text-rose-600 dark:text-rose-400 hover:text-rose-700 dark:hover:text-rose-350 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100/80 dark:hover:bg-rose-900/60 border border-rose-100/50 dark:border-rose-900/30 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($courts->count() === 0)
                <div class="text-center py-16 bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-300 dark:border-slate-850/80 max-w-2xl mx-auto shadow-sm">
                    <svg class="w-12 h-12 text-slate-350 dark:text-slate-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <p class="text-slate-500 dark:text-slate-450 font-bold">Belum ada lapangan yang ditambahkan.</p>
                </div>
            @endif

        </div>
    </div>

    <!-- Modal Add Court -->
    <div id="addCourtModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 dark:bg-slate-950/60 backdrop-blur-sm transition-all duration-300 hidden">
        <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-soft-lg w-full max-w-lg mx-4 rounded-4xl overflow-hidden p-0 relative transform scale-100 transition-all">
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-950/40">
                <h3 class="text-lg font-extrabold text-slate-850 dark:text-white tracking-tight">Tambah Lapangan Baru</h3>
                <button onclick="document.getElementById('addCourtModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('admin.courts.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">Nama Lapangan</label>
                        <input type="text" name="name" class="input w-full" required placeholder="Contoh: Lapangan 1 (Karpet)">
                    </div>
                    <div>
                        <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">Harga Per Jam (Rp)</label>
                        <input type="number" name="price_per_hour" class="input w-full" required placeholder="Contoh: 50000">
                    </div>
                    <div>
                        <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">URL Gambar (Opsional)</label>
                        <input type="url" name="image" class="input w-full" placeholder="https://contoh.com/gambar.jpg">
                        <p class="text-[10px] text-slate-500 dark:text-slate-450 mt-1 font-semibold">Masukkan URL gambar untuk ditampilkan.</p>
                    </div>
                    <div>
                        <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">Deskripsi (Opsional)</label>
                        <textarea name="description" rows="3" class="input w-full" placeholder="Fasilitas lapangan..."></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3 pt-3 border-t border-slate-100 dark:border-slate-850/80">
                    <button type="button" onclick="document.getElementById('addCourtModal').classList.add('hidden')" class="btn-secondary py-2 px-5 text-sm">Batal</button>
                    <button type="submit" class="btn-primary py-2 px-5 text-sm">Simpan Lapangan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Court -->
    <div id="editCourtModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 dark:bg-slate-950/60 backdrop-blur-sm transition-all duration-300 hidden">
        <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-soft-lg w-full max-w-lg mx-4 rounded-4xl overflow-hidden p-0 relative transform scale-100 transition-all">
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-950/40">
                <h3 class="text-lg font-extrabold text-slate-850 dark:text-white tracking-tight">Edit Lapangan</h3>
                <button onclick="document.getElementById('editCourtModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form id="editCourtForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">Nama Lapangan</label>
                        <input type="text" name="name" id="edit_name" class="input w-full" required>
                    </div>
                    <div>
                        <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">Harga Per Jam (Rp)</label>
                        <input type="number" name="price_per_hour" id="edit_price" class="input w-full" required>
                    </div>
                    <div>
                        <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">URL Gambar (Opsional)</label>
                        <input type="url" name="image" id="edit_image" class="input w-full">
                    </div>
                    <div>
                        <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">Deskripsi (Opsional)</label>
                        <textarea name="description" id="edit_desc" rows="3" class="input w-full"></textarea>
                    </div>
                    <div class="flex items-center pt-2">
                        <input type="checkbox" name="is_active" id="edit_active" value="1" class="rounded border-slate-300 dark:border-slate-800 text-brand-500 shadow-soft focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50 dark:bg-slate-900">
                        <label for="edit_active" class="ml-2.5 block text-sm text-slate-700 dark:text-slate-300 font-semibold cursor-pointer">
                            Lapangan Aktif (Bisa disewa)
                        </label>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3 pt-3 border-t border-slate-100 dark:border-slate-850/80">
                    <button type="button" onclick="document.getElementById('editCourtModal').classList.add('hidden')" class="btn-secondary py-2 px-5 text-sm">Batal</button>
                    <button type="submit" class="btn-primary py-2 px-5 text-sm">Perbarui Lapangan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(court) {
            document.getElementById('edit_name').value = court.name;
            document.getElementById('edit_price').value = court.price_per_hour;
            document.getElementById('edit_image').value = court.image || '';
            document.getElementById('edit_desc').value = court.description || '';
            document.getElementById('edit_active').checked = court.is_active;
            
            // Set form action action url
            document.getElementById('editCourtForm').action = `/admin/courts/${court.id}`;
            
            document.getElementById('editCourtModal').classList.remove('hidden');
        }
    </script>
</x-app-layout>
