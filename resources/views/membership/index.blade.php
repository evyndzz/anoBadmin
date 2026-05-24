<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gabung Membership AnoBadmin') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <div class="text-center mb-12">
                <h1 class="text-3xl font-black text-slate-800 mb-4">Pilih Paket Membership Anda</h1>
                <p class="text-slate-500 max-w-2xl mx-auto">Dapatkan kemudahan bermain rutin dengan jadwal tetap yang dikelola oleh admin, ditambah prioritas dan berbagai keuntungan menarik lainnya!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-center">
                <!-- Reguler -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 flex flex-col">
                    <h3 class="text-xl font-bold text-slate-800 mb-1">Reguler (Gratis)</h3>
                    <p class="text-sm text-slate-500 mb-6">Booking Harian Tanpa Komitmen</p>
                    <div class="text-4xl font-black text-slate-800 mb-6">Rp 0<span class="text-lg text-slate-500 font-normal">/bln</span></div>
                    
                    <ul class="space-y-4 flex-1 mb-8">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-3">✓</span> 
                            <span class="text-slate-600">Sistem Poin & Tukar Promo</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-3">✓</span> 
                            <span class="text-slate-600">Booking Manual via Website</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-slate-300 mr-3">✗</span> 
                            <span class="text-slate-400">Tidak ada jadwal rutin</span>
                        </li>
                    </ul>

                    @if(!auth()->user()->membership_id)
                        <button disabled class="w-full bg-slate-200 text-slate-500 font-bold py-3 rounded-xl cursor-not-allowed">
                            Saat ini Aktif
                        </button>
                    @else
                        <button disabled class="w-full bg-slate-100 text-slate-400 font-bold py-3 rounded-xl">
                            Bukan Pilihan Anda
                        </button>
                    @endif
                </div>

                @foreach($memberships as $membership)
                    <div class="bg-white rounded-3xl p-8 shadow-lg border-2 {{ $membership->name == 'Supah Ano' ? 'border-amber-400' : 'border-blue-500' }} flex flex-col relative transform hover:-translate-y-2 transition-transform duration-300">
                        @if($membership->name == 'Ano Member')
                            <div class="absolute top-0 right-0 bg-blue-500 text-white text-xs font-bold px-4 py-1 rounded-bl-xl rounded-tr-3xl">Paling Populer</div>
                        @elseif($membership->name == 'Supah Ano')
                            <div class="absolute top-0 right-0 bg-gradient-to-r from-amber-400 to-red-500 text-white text-xs font-bold px-4 py-1 rounded-bl-xl rounded-tr-3xl">Pilihan Sultan</div>
                        @endif
                        
                        <h3 class="text-xl font-bold {{ $membership->name == 'Supah Ano' ? 'bg-gradient-to-r from-amber-500 to-red-500 bg-clip-text text-transparent' : 'text-blue-600' }} mb-1">{{ $membership->name }}</h3>
                        <p class="text-sm text-slate-500 mb-6">Paket Main Rutin {{ $membership->duration_months }} Bulan</p>
                        <div class="text-4xl font-black text-slate-800 mb-6">Rp {{ number_format($membership->price, 0, ',', '.') }}<span class="text-lg text-slate-500 font-normal">/bln</span></div>
                        
                        <ul class="space-y-4 flex-1 mb-8 text-sm">
                            <li class="flex items-start">
                                <span class="text-green-500 mr-3">✓</span> 
                                <span class="text-slate-600 font-bold">8x Pertemuan Per Bulan</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-3">✓</span> 
                                <span class="text-slate-600 font-bold">Durasi {{ $membership->name == 'Supah Ano' ? '4 Jam' : '3 Jam' }}</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-3">✓</span> 
                                <span class="text-slate-600">Jadwal Tetap (Diatur Admin)</span>
                            </li>
                            
                            @if($membership->name == 'Supah Ano')
                            <li class="flex items-start">
                                <span class="text-amber-500 mr-3">⭐</span> 
                                <span class="text-slate-700 font-bold bg-amber-50 px-2 py-0.5 rounded">Gratis 2 Shuttlecock/Main</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-3">💧</span> 
                                <span class="text-slate-700 font-bold bg-blue-50 px-2 py-0.5 rounded">Gratis 2 Botol Air 600ml</span>
                            </li>
                            @endif
                        </ul>

                        @if(auth()->user()->membership_id == $membership->id)
                            <button disabled class="w-full bg-green-500 text-white font-bold py-3 rounded-xl shadow-lg cursor-not-allowed">
                                Membership Aktif
                            </button>
                        @elseif(auth()->user()->membership_id)
                            <button disabled class="w-full bg-slate-200 text-slate-500 font-bold py-3 rounded-xl cursor-not-allowed">
                                Anda Sudah Berlangganan
                            </button>
                        @elseif($membership->schedules->count() == 0)
                            <button disabled class="w-full bg-slate-300 text-slate-500 font-bold py-3 rounded-xl shadow cursor-not-allowed">
                                Kuota Penuh (Tidak Ada Jadwal)
                            </button>
                        @else
                            <a href="{{ route('membership.schedules', $membership) }}" class="w-full text-center block {{ $membership->name == 'Supah Ano' ? 'bg-gradient-to-r from-amber-500 to-red-500 hover:from-amber-600 hover:to-red-600 shadow-amber-500/30' : 'bg-blue-600 hover:bg-blue-700 shadow-blue-500/30' }} text-white font-bold py-3 rounded-xl shadow-lg transition-transform active:scale-95">
                                Lihat Jadwal Tersedia
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <!-- Panduan -->
            <div class="mt-16 bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
                <h3 class="text-xl font-bold mb-4">Bagaimana Cara Kerja Membership Rutin?</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-xl">1</div>
                        <h4 class="font-bold">Pilih Paket</h4>
                        <p class="text-sm text-slate-500">Pilih paket Ano Member atau Supah Ano dan klik berlangganan.</p>
                    </div>
                    <div>
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-xl">2</div>
                        <h4 class="font-bold">Admin Menghubungi</h4>
                        <p class="text-sm text-slate-500">Admin akan mengatur hari, jam, dan lapangan yang Anda inginkan (misal: tiap Rabu & Sabtu).</p>
                    </div>
                    <div>
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-xl">3</div>
                        <h4 class="font-bold">Jadwal Di-Lock</h4>
                        <p class="text-sm text-slate-500">Jadwal Anda otomatis terkunci di sistem. Pengguna reguler tidak bisa mem-booking di jam tersebut.</p>
                    </div>
                    <div>
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-xl">4</div>
                        <h4 class="font-bold">Main Sepuasnya</h4>
                        <p class="text-sm text-slate-500">Datang ke lapangan sesuai jadwal tanpa perlu repot booking manual setiap minggu!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
