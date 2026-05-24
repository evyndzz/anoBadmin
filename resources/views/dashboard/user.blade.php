<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Dashboard Member') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Recommendations Alert (Fuzzy Logic Output) -->
            @if($membershipRec)
            <div class="bg-gradient-to-r from-amber-200 to-yellow-400 rounded-xl p-6 shadow-sm border border-yellow-300 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-yellow-900 mb-1">🌟 Rekomendasi Khusus Untuk Anda!</h3>
                    <p class="text-yellow-800 text-sm">Berdasarkan aktivitas Anda, kami merekomendasikan upgrade ke <strong>Membership {{ $membershipRec->name }}</strong> untuk jadwal rutin & bebas repot!</p>
                </div>
                <a href="{{ route('membership.index') }}" class="bg-yellow-900 text-white px-4 py-2 rounded-lg font-bold hover:bg-yellow-800 transition">Upgrade Sekarang</a>
            </div>
            @endif

            <!-- Points & Membership Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-slate-100 dark:border-slate-700">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-slate-500 dark:text-slate-400 text-sm font-medium">Poin Reward Anda</div>
                            <div class="text-2xl font-bold text-slate-800 dark:text-white">{{ number_format($points, 0, ',', '.') }} <span class="text-sm font-normal text-slate-500 dark:text-slate-400">Pts</span></div>
                        </div>
                        <a href="{{ route('vouchers.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            Voucher
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-slate-100 dark:border-slate-700">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-slate-500 dark:text-slate-400 text-sm font-medium">Status Membership</div>
                            <div class="text-2xl font-bold text-slate-800 dark:text-white">{{ auth()->user()->membership ? auth()->user()->membership->name : 'Reguler (Harian)' }}</div>
                            @if(auth()->user()->membership && isset($schedule))
                                @php 
                                    $endDate = \Carbon\Carbon::parse($schedule->updated_at)->addMonths(auth()->user()->membership->duration_months);
                                    $sisaHari = now()->diffInDays($endDate, false);
                                @endphp
                                <div class="text-xs {{ $sisaHari <= 7 ? 'text-red-500 font-bold' : 'text-slate-500 dark:text-slate-400' }} mt-1">
                                    Sisa Durasi: {{ max(0, ceil($sisaHari)) }} Hari (Batas: {{ $endDate->format('d M Y') }})
                                </div>
                            @endif
                        </div>
                        @if(auth()->user()->membership_id)
                            <a href="{{ route('membership.index') }}" class="bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-800/50 text-indigo-700 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-700/50 px-4 py-2 rounded-lg text-sm font-bold transition flex items-center shadow-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Lihat
                            </a>
                        @else
                            <a href="{{ route('membership.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Langganan
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Membership Schedule Detail (If Active) -->
            @if(auth()->user()->membership && isset($schedule))
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-800 dark:to-indigo-900 rounded-xl p-6 shadow-lg text-white">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Jadwal Rutin Membership
                    </h3>
                    <span class="bg-white/20 px-3 py-1 rounded-full text-xs font-bold">{{ auth()->user()->membership->name }}</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-white/10 rounded-lg p-4 border border-white/20">
                    <div>
                        <div class="text-blue-200 text-xs uppercase font-bold mb-1">Hari & Jam Main</div>
                        <div class="font-black text-lg">{{ $schedule->days }}</div>
                        <div class="text-sm">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB</div>
                    </div>
                    <div>
                        <div class="text-blue-200 text-xs uppercase font-bold mb-1">Lokasi Lapangan</div>
                        <div class="font-bold text-lg">{{ $schedule->court->name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-blue-200 text-xs uppercase font-bold mb-1">Benefit Tambahan</div>
                        <ul class="text-sm space-y-1">
                            <li class="flex items-center"><span class="text-green-300 mr-2">✓</span> Prioritas Lapangan</li>
                            @if(auth()->user()->membership->name == 'Supah Ano')
                                <li class="flex items-center"><span class="text-amber-300 mr-2">⭐</span> 2 Shuttlecock / Sesi</li>
                                <li class="flex items-center"><span class="text-blue-300 mr-2">💧</span> 2 Air Mineral / Sesi</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Bookings -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-slate-100 dark:border-slate-700">
                <div class="p-6 text-gray-900 dark:text-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Riwayat Booking Anda</h3>
                        <a href="{{ route('bookings.create') }}" class="text-sm bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 px-3 py-1.5 rounded-lg font-bold hover:bg-blue-100 dark:hover:bg-blue-800/50 transition">Booking Baru</a>
                    </div>
                    
                    @if(count($bookings) > 0)
                        <div class="space-y-4">
                            @foreach($bookings as $booking)
                            <div class="border border-slate-100 dark:border-slate-700 rounded-xl p-4 flex flex-col sm:flex-row justify-between sm:items-center hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                                <div>
                                    <div class="font-bold text-slate-800 dark:text-white">
                                        {{ \Carbon\Carbon::parse($booking->date)->format('d F Y') }} <span class="text-xs ml-2 bg-slate-200 dark:bg-slate-600 text-slate-600 dark:text-slate-300 px-2 py-1 rounded">{{ $booking->booking_code }}</span>
                                    </div>
                                    <div class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                        @if($booking->details->first())
                                            <div class="flex items-center space-x-2">
                                                <span>{{ $booking->details->first()->court->name }} • {{ \Carbon\Carbon::parse($booking->details->first()->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->details->first()->end_time)->format('H:i') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-4 sm:mt-0 text-left sm:text-right">
                                    <div class="font-bold text-blue-600 dark:text-blue-400 mb-1">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                    @if($booking->status == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-500/20 text-yellow-800 dark:text-yellow-400">Menunggu Pembayaran</span>
                                    @elseif($booking->status == 'completed')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-500/20 text-green-800 dark:text-green-400">Selesai</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-slate-500 dark:text-slate-400">
                            Belum ada riwayat booking. Yuk main badminton!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
