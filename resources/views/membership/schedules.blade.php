<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
            <a href="{{ route('membership.index') }}" class="text-brand-500 hover:text-brand-600 transition hover:underline">Membership</a> 
            <span class="text-slate-400 dark:text-slate-600 mx-2">&raquo;</span> Pilih Jadwal ({{ $membership->name }})
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-950 transition-colors duration-300 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl font-extrabold text-slate-800 dark:text-white mb-4 tracking-tight">Pilih Sesi Pertemuan Tersedia</h1>
                <p class="text-slate-500 dark:text-slate-400 max-w-2xl mx-auto text-sm sm:text-base">Untuk paket <strong>{{ $membership->name }}</strong>, silakan pilih salah satu jadwal rutin di bawah ini. Sesi ini akan terkunci untuk Anda.</p>
            </div>

            @if($membership->schedules->count() == 0)
                <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 p-12 text-center rounded-4xl max-w-2xl mx-auto">
                    <svg class="w-16 h-16 text-slate-300 dark:text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-xl font-bold text-slate-700 dark:text-slate-300 mb-2">Semua Sesi Telah Penuh</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mb-6">Mohon maaf, saat ini tidak ada sesi pertemuan yang tersedia untuk paket ini. Silakan hubungi admin atau pilih paket lain.</p>
                    <a href="{{ route('membership.index') }}" class="btn-secondary px-6 py-2.5">Kembali</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($membership->schedules as $schedule)
                        <div class="card bg-white dark:bg-slate-900 border border-slate-150 dark:border-slate-850 shadow-soft hover:shadow-soft-lg rounded-4xl overflow-hidden flex flex-col group p-0 hover:-translate-y-1.5 transition-all duration-300">
                            <!-- Image Header -->
                            <div class="h-48 bg-slate-200 dark:bg-slate-800 overflow-hidden relative">
                                <img src="{{ $schedule->court->image ?? 'https://images.unsplash.com/photo-1613918431703-931d1265880b?q=80&w=2070&auto=format&fit=crop' }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                     alt="{{ $schedule->court->name }}">
                                <div class="absolute top-4 left-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur px-3 py-1.5 rounded-full text-xs font-bold text-slate-800 dark:text-slate-200 border border-slate-100/50 dark:border-slate-800/50 shadow-soft flex items-center">
                                    <svg class="w-4 h-4 text-brand-500 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $schedule->court->name }}
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex items-center mb-3.5 text-brand-600 dark:text-brand-400 font-extrabold text-base">
                                    <svg class="w-5 h-5 mr-2 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>{{ $schedule->days }}</span>
                                </div>
                                <div class="flex items-center mb-6 text-slate-600 dark:text-slate-400 text-sm font-semibold">
                                    <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB</span>
                                </div>
                                
                                <div class="mt-auto">
                                    <form action="{{ route('membership.join', $membership) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                        <button type="submit" 
                                                onclick="return confirm('Anda yakin ingin mengunci jadwal ini?')" 
                                                class="btn-primary w-full py-3 rounded-2xl text-sm flex justify-center items-center">
                                            <span>Pilih Sesi Ini</span>
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
