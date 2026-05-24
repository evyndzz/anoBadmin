<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
            {{ __('Gabung Membership AnoBadmin') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-950 transition-colors duration-300 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
            <div class="bg-rose-50 dark:bg-rose-950/40 border border-rose-100 dark:border-rose-900/30 text-rose-700 dark:text-rose-400 px-4 py-3 rounded-2xl relative mb-6 shadow-sm" role="alert">
                <span class="block sm:inline font-semibold">{{ session('error') }}</span>
            </div>
            @endif

            <div class="text-center mb-12">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-800 dark:text-white mb-4 tracking-tight">Pilih Paket Membership Anda</h1>
                <p class="text-slate-500 dark:text-slate-400 max-w-2xl mx-auto text-sm sm:text-base">Dapatkan kemudahan bermain rutin dengan jadwal tetap yang dikelola oleh admin, ditambah prioritas dan berbagai keuntungan menarik lainnya!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-center">
                <!-- Reguler -->
                <div class="card bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 shadow-soft hover:shadow-soft-lg rounded-4xl p-8 flex flex-col hover:-translate-y-2 transition-all duration-300">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-1">Reguler (Gratis)</h3>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mb-6">Booking Harian Tanpa Komitmen</p>
                    <div class="text-4xl font-black text-slate-850 dark:text-white mb-6">Rp 0<span class="text-lg text-slate-500 dark:text-slate-400 font-normal">/bln</span></div>
                    
                    <ul class="space-y-4 flex-1 mb-8 text-sm">
                        <li class="flex items-start">
                            <span class="text-emerald-500 dark:text-emerald-400 mr-3 font-bold">✓</span> 
                            <span class="text-slate-600 dark:text-slate-300">Sistem Poin & Tukar Promo</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-emerald-500 dark:text-emerald-400 mr-3 font-bold">✓</span> 
                            <span class="text-slate-600 dark:text-slate-300">Booking Manual via Website</span>
                        </li>
                        <li class="flex items-start opacity-50">
                            <span class="text-slate-300 dark:text-slate-600 mr-3">✗</span> 
                            <span class="text-slate-400 dark:text-slate-500">Tidak ada jadwal rutin</span>
                        </li>
                    </ul>

                    @if(!auth()->user()->membership_id)
                        <button disabled class="w-full bg-slate-100 dark:bg-slate-850 text-slate-400 dark:text-slate-600 font-extrabold py-3.5 rounded-2xl cursor-not-allowed text-sm">
                            Saat ini Aktif
                        </button>
                    @else
                        <button disabled class="w-full bg-slate-50 dark:bg-slate-850/50 text-slate-400 dark:text-slate-600 font-extrabold py-3.5 rounded-2xl text-sm">
                            Bukan Pilihan Anda
                        </button>
                    @endif
                </div>

                @foreach($memberships as $membership)
                    @php
                        $isSultan = ($membership->name == 'Supah Ano');
                        $isPopular = ($membership->name == 'Ano Member');
                    @endphp
                    <div class="card bg-white dark:bg-slate-900 border-2 {{ $isSultan ? 'border-amber-400 dark:border-amber-500 bg-gradient-to-b from-white to-amber-50/10 dark:from-slate-900 dark:to-amber-950/5' : ($isPopular ? 'border-brand-500' : 'border-slate-200/60 dark:border-slate-800') }} rounded-4xl p-8 shadow-soft hover:shadow-soft-lg flex flex-col relative transform hover:-translate-y-2 transition-all duration-300">
                        @if($isPopular)
                            <div class="absolute top-0 right-0 bg-brand-500 text-white text-[10px] uppercase font-black tracking-wider px-4 py-1.5 rounded-bl-2xl rounded-tr-[1.8rem]">Paling Populer</div>
                        @elseif($isSultan)
                            <div class="absolute top-0 right-0 bg-gradient-to-r from-amber-400 via-rose-400 to-brand-500 text-white text-[10px] uppercase font-black tracking-wider px-4 py-1.5 rounded-bl-2xl rounded-tr-[1.8rem]">Pilihan Sultan</div>
                        @endif
                        
                        <h3 class="text-xl font-extrabold {{ $isSultan ? 'bg-gradient-to-r from-amber-500 to-brand-500 bg-clip-text text-transparent' : 'text-brand-600 dark:text-brand-400' }} mb-1">{{ $membership->name }}</h3>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mb-6">Paket Main Rutin {{ $membership->duration_months }} Bulan</p>
                        <div class="text-4xl font-black text-slate-850 dark:text-white mb-6">Rp {{ number_format($membership->price, 0, ',', '.') }}<span class="text-lg text-slate-500 dark:text-slate-400 font-normal">/bln</span></div>
                        
                        <ul class="space-y-4 flex-1 mb-8 text-sm">
                            <li class="flex items-start">
                                <span class="text-emerald-500 dark:text-emerald-400 mr-3 font-bold">✓</span> 
                                <span class="text-slate-700 dark:text-slate-200 font-bold">8x Pertemuan Per Bulan</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-emerald-500 dark:text-emerald-400 mr-3 font-bold">✓</span> 
                                <span class="text-slate-700 dark:text-slate-200 font-bold">Durasi {{ $isSultan ? '4 Jam' : '3 Jam' }}</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-emerald-500 dark:text-emerald-400 mr-3 font-bold">✓</span> 
                                <span class="text-slate-600 dark:text-slate-300">Jadwal Tetap (Diatur Admin)</span>
                            </li>
                            
                            @if($isSultan)
                            <li class="flex items-start">
                                <span class="text-amber-500 mr-3">★</span> 
                                <span class="text-slate-700 dark:text-slate-200 font-bold bg-amber-50 dark:bg-amber-950/40 border border-amber-100 dark:border-amber-900/30 px-2.5 py-1 rounded-xl text-xs">Gratis 2 Shuttlecock/Main</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-brand-500 mr-3">💧</span> 
                                <span class="text-slate-700 dark:text-slate-200 font-bold bg-brand-50 dark:bg-brand-950/40 border border-brand-100 dark:border-brand-900/30 px-2.5 py-1 rounded-xl text-xs">Gratis 2 Botol Air 600ml</span>
                            </li>
                            @endif
                        </ul>

                        @if(auth()->user()->membership_id == $membership->id)
                            <button disabled class="w-full bg-brand-500 text-white font-extrabold py-3.5 rounded-2xl shadow-soft cursor-not-allowed text-sm">
                                Membership Aktif
                            </button>
                        @elseif(auth()->user()->membership_id)
                            <button disabled class="w-full bg-slate-100 dark:bg-slate-850 text-slate-400 dark:text-slate-600 font-extrabold py-3.5 rounded-2xl cursor-not-allowed text-sm">
                                Anda Sudah Berlangganan
                            </button>
                        @elseif($membership->schedules->count() == 0)
                            <button disabled class="w-full bg-slate-200 dark:bg-slate-800 text-slate-400 dark:text-slate-500 font-extrabold py-3.5 rounded-2xl cursor-not-allowed text-sm">
                                Kuota Penuh (Tidak Ada Jadwal)
                            </button>
                        @else
                            <a href="{{ route('membership.schedules', $membership) }}" class="w-full text-center block {{ $isSultan ? 'bg-gradient-to-r from-amber-500 to-brand-600 hover:from-amber-600 hover:to-brand-700 shadow-soft shadow-amber-500/20' : 'btn-primary' }} py-3.5 rounded-2xl text-sm font-bold transition-all active:scale-98">
                                Lihat Jadwal Tersedia
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <!-- Panduan -->
            <div class="mt-16 card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-soft rounded-4xl p-8">
                <h3 class="text-xl font-extrabold text-slate-800 dark:text-white mb-6 text-center sm:text-left tracking-tight">Bagaimana Cara Kerja Membership Rutin?</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div class="space-y-2.5">
                        <div class="w-12 h-12 bg-brand-100 dark:bg-brand-900/40 text-brand-700 dark:text-brand-400 rounded-2xl flex items-center justify-center mx-auto font-extrabold text-lg shadow-sm border border-brand-200/30 dark:border-brand-800/40">1</div>
                        <h4 class="font-extrabold text-slate-850 dark:text-slate-100 text-base">Pilih Paket</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Pilih paket Ano Member atau Supah Ano dan klik berlangganan.</p>
                    </div>
                    <div class="space-y-2.5">
                        <div class="w-12 h-12 bg-brand-100 dark:bg-brand-900/40 text-brand-700 dark:text-brand-400 rounded-2xl flex items-center justify-center mx-auto font-extrabold text-lg shadow-sm border border-brand-200/30 dark:border-brand-800/40">2</div>
                        <h4 class="font-extrabold text-slate-850 dark:text-slate-100 text-base">Admin Menghubungi</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Admin akan mengatur hari, jam, dan lapangan yang Anda inginkan (misal: tiap Rabu & Sabtu).</p>
                    </div>
                    <div class="space-y-2.5">
                        <div class="w-12 h-12 bg-brand-100 dark:bg-brand-900/40 text-brand-700 dark:text-brand-400 rounded-2xl flex items-center justify-center mx-auto font-extrabold text-lg shadow-sm border border-brand-200/30 dark:border-brand-800/40">3</div>
                        <h4 class="font-extrabold text-slate-850 dark:text-slate-100 text-base">Jadwal Di-Lock</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Jadwal Anda otomatis terkunci di sistem. Pengguna reguler tidak bisa mem-booking di jam tersebut.</p>
                    </div>
                    <div class="space-y-2.5">
                        <div class="w-12 h-12 bg-brand-100 dark:bg-brand-900/40 text-brand-700 dark:text-brand-400 rounded-2xl flex items-center justify-center mx-auto font-extrabold text-lg shadow-sm border border-brand-200/30 dark:border-brand-800/40">4</div>
                        <h4 class="font-extrabold text-slate-850 dark:text-slate-100 text-base">Main Sepuasnya</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Datang ke lapangan sesuai jadwal tanpa perlu repot booking manual setiap minggu!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
