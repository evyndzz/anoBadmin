<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Lapangan') }}
            </h2>
            <button onclick="document.getElementById('addCourtModal').classList.remove('hidden')" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-indigo-700 transition shadow-sm text-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Lapangan
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- List of Courts -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($courts as $court)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden flex flex-col group hover:shadow-md transition">
                        <div class="h-48 bg-slate-200 relative overflow-hidden">
                            @if($court->image)
                                <img src="{{ $court->image }}" alt="{{ $court->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <img src="https://storage.googleapis.com/data.ayo.co.id/photos/77445/SEO%20HDI%202/16.%20Kelebihan%20dan%20Kekurangan%20Lapangan%20Badminton%20Sintetis%20yang%20Perlu%20Diketahui.jpg" alt="{{ $court->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @endif
                            <div class="absolute top-3 right-3">
                                @if($court->is_active)
                                    <span class="bg-green-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">Aktif</span>
                                @else
                                    <span class="bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">Nonaktif</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $court->name }}</h3>
                            <div class="text-indigo-600 font-bold mb-3">Rp {{ number_format($court->price_per_hour, 0, ',', '.') }} <span class="text-xs text-gray-500 font-normal">/jam</span></div>
                            <p class="text-sm text-gray-500 flex-1">{{ \Illuminate\Support\Str::limit($court->description, 100) }}</p>
                            
                            <div class="mt-4 pt-4 border-t border-slate-100 flex justify-end space-x-2">
                                <button onclick="openEditModal({{ $court->toJson() }})" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg text-sm font-semibold transition">
                                    Edit
                                </button>
                                <form action="{{ route('admin.courts.destroy', $court) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus lapangan ini secara permanen?')" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-sm font-semibold transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($courts->count() === 0)
                <div class="text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <p class="text-gray-500 font-medium">Belum ada lapangan yang ditambahkan.</p>
                </div>
            @endif

        </div>
    </div>

    <!-- Modal Add Court -->
    <div id="addCourtModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 hidden">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="text-lg font-bold text-gray-900">Tambah Lapangan Baru</h3>
                <button onclick="document.getElementById('addCourtModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('admin.courts.store') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lapangan</label>
                        <input type="text" name="name" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required placeholder="Contoh: Lapangan 1 (Karpet)">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Harga Per Jam (Rp)</label>
                        <input type="number" name="price_per_hour" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required placeholder="Contoh: 50000">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">URL Gambar (Opsional)</label>
                        <input type="url" name="image" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="https://contoh.com/gambar.jpg">
                        <p class="text-xs text-gray-500 mt-1">Masukkan URL gambar untuk ditampilkan.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi (Opsional)</label>
                        <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Fasilitas lapangan..."></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('addCourtModal').classList.add('hidden')" class="px-4 py-2 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition">Simpan Lapangan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Court -->
    <div id="editCourtModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 hidden">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="text-lg font-bold text-gray-900">Edit Lapangan</h3>
                <button onclick="document.getElementById('editCourtModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form id="editCourtForm" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lapangan</label>
                        <input type="text" name="name" id="edit_name" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Harga Per Jam (Rp)</label>
                        <input type="number" name="price_per_hour" id="edit_price" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">URL Gambar (Opsional)</label>
                        <input type="url" name="image" id="edit_image" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi (Opsional)</label>
                        <textarea name="description" id="edit_desc" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="edit_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <label for="edit_active" class="ml-2 block text-sm text-gray-900 font-medium">
                            Lapangan Aktif (Bisa disewa)
                        </label>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('editCourtModal').classList.add('hidden')" class="px-4 py-2 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition">Perbarui Lapangan</button>
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
