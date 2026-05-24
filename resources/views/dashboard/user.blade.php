<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-850 dark:text-white leading-tight">
            {{ __('Dashboard Member') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Recommendations Alert (Fuzzy Logic Output) -->
            @if($membershipRec)
            <div class="bg-gradient-to-r from-amber-50 to-yellow-100/70 dark:from-amber-950/20 dark:to-yellow-950/30 rounded-3xl p-6 shadow-soft border border-amber-200/50 dark:border-yellow-900/30 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-yellow-900 dark:text-amber-400 mb-1 flex items-center">
                        <span class="mr-2">🌟</span> Rekomendasi Khusus Untuk Anda!
                    </h3>
                    <p class="text-amber-800 dark:text-slate-400 text-sm">Berdasarkan aktivitas Anda, kami merekomendasikan upgrade ke <strong>Membership {{ $membershipRec->name }}</strong> untuk jadwal rutin otomatis & bebas repot!</p>
                </div>
                <a href="{{ route('membership.index') }}" class="btn-primary bg-amber-600 hover:bg-amber-700 active:bg-amber-800 text-white font-bold text-sm shadow-soft rounded-2xl py-2.5 px-5 flex-shrink-0 transition-transform active:scale-95">Upgrade Sekarang</a>
            </div>
            @endif

            <!-- Points & Membership Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Points Reward -->
                <div class="card bg-white dark:bg-slate-900 shadow-soft rounded-4xl border border-slate-100 dark:border-slate-850 p-6 transition-all duration-300 hover:shadow-soft-lg">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-brand-50 dark:bg-brand-950/40 text-brand-600 dark:text-brand-400 rounded-2xl flex items-center justify-center border border-brand-100/40 dark:border-brand-900/20 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-slate-500 dark:text-slate-400 text-sm font-semibold">Poin Reward Anda</div>
                            <div class="text-2xl font-black text-slate-850 dark:text-white mt-0.5">{{ number_format($points, 0, ',', '.') }} <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pts</span></div>
                        </div>
                        <a href="{{ route('vouchers.index') }}" class="btn-primary text-sm font-semibold shadow-soft py-2.5 px-4 rounded-2xl flex items-center gap-1.5 transition-transform active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            Tukar Voucher
                        </a>
                    </div>
                </div>

                <!-- Membership Status -->
                <div class="card bg-white dark:bg-slate-900 shadow-soft rounded-4xl border border-slate-100 dark:border-slate-850 p-6 transition-all duration-300 hover:shadow-soft-lg">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center border border-emerald-100/40 dark:border-emerald-900/20 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-slate-500 dark:text-slate-400 text-sm font-semibold">Status Membership</div>
                            <div class="text-2xl font-black text-slate-850 dark:text-white mt-0.5">{{ auth()->user()->membership ? auth()->user()->membership->name : 'Reguler (Harian)' }}</div>
                            @if(auth()->user()->membership && isset($schedule))
                                @php 
                                    $endDate = \Carbon\Carbon::parse($schedule->updated_at)->addMonths(auth()->user()->membership->duration_months);
                                    $sisaHari = now()->diffInDays($endDate, false);
                                @endphp
                                <div class="text-xs {{ $sisaHari <= 7 ? 'text-rose-500 font-bold' : 'text-slate-500 dark:text-slate-400' }} mt-1 font-semibold">
                                    Sisa Durasi: {{ max(0, ceil($sisaHari)) }} Hari (Hingga {{ $endDate->format('d M Y') }})
                                </div>
                            @endif
                        </div>
                        @if(auth()->user()->membership_id)
                            <a href="{{ route('membership.index') }}" class="btn-secondary text-sm font-semibold py-2.5 px-4 rounded-2xl flex items-center gap-1.5 transition-transform active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Detail
                            </a>
                        @else
                            <a href="{{ route('membership.index') }}" class="btn-primary text-sm font-semibold shadow-soft py-2.5 px-4 rounded-2xl flex items-center gap-1.5 transition-transform active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Upgrade
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Membership Schedule Detail (If Active) -->
            @if(auth()->user()->membership && isset($schedule))
            <div class="bg-gradient-to-tr from-brand-600 via-emerald-500 to-teal-400 dark:from-brand-900 dark:via-emerald-950 dark:to-teal-950 rounded-4xl p-6 shadow-soft-lg text-white border border-brand-500/10 transition-all duration-300">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Jadwal Rutin Keanggotaan
                    </h3>
                    <span class="bg-white/20 border border-white/10 px-3 py-1 rounded-2xl text-xs font-bold uppercase tracking-wider">{{ auth()->user()->membership->name }}</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-white/10 dark:bg-slate-900/30 backdrop-blur-md rounded-3xl p-5 border border-white/15 dark:border-slate-800/40">
                    <div>
                        <div class="text-brand-100 text-xs uppercase font-extrabold mb-1.5 tracking-wider">Hari & Jam Bermain</div>
                        <div class="font-black text-xl tracking-tight">{{ $schedule->days }}</div>
                        <div class="text-sm font-semibold text-brand-50 mt-0.5">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB</div>
                    </div>
                    <div>
                        <div class="text-brand-100 text-xs uppercase font-extrabold mb-1.5 tracking-wider">Lokasi Lapangan</div>
                        <div class="font-black text-xl tracking-tight">{{ $schedule->court->name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-brand-100 text-xs uppercase font-extrabold mb-1.5 tracking-wider">Benefit Aktif</div>
                        <ul class="text-sm font-semibold space-y-1 mt-1">
                            <li class="flex items-center"><span class="text-emerald-400 mr-2">✓</span> Prioritas Booking Otomatis</li>
                            @if(auth()->user()->membership->name == 'Supah Ano')
                                <li class="flex items-center"><span class="text-amber-300 mr-2">⭐</span> 2 Shuttlecock / Sesi</li>
                                <li class="flex items-center"><span class="text-cyan-300 mr-2">💧</span> 2 Air Mineral / Sesi</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Bookings -->
            <div class="card bg-white dark:bg-slate-900 shadow-soft rounded-4xl border border-slate-100 dark:border-slate-850 p-6 transition-all duration-300">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-slate-850 dark:text-white tracking-tight">Riwayat Booking Anda</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Daftar pemesanan lapangan terbaru Anda</p>
                    </div>
                    <a href="{{ route('bookings.create') }}" class="btn-primary text-xs font-bold py-2.5 px-4 rounded-2xl flex items-center gap-1 shadow-sm transition-transform active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Booking Baru
                    </a>
                </div>
                
                @if(count($bookings) > 0)
                    <div class="space-y-4">
                        @foreach($bookings as $booking)
                        <div class="border border-slate-100 dark:border-slate-850/60 rounded-3xl p-5 bg-slate-50/30 dark:bg-slate-900/30 flex flex-col sm:flex-row justify-between sm:items-center hover:bg-slate-50 dark:hover:bg-slate-850/30 transition-all duration-300 shadow-inner">
                            <div class="space-y-2">
                                <div class="font-extrabold text-base text-slate-800 dark:text-white flex items-center gap-2">
                                    {{ \Carbon\Carbon::parse($booking->date)->format('d F Y') }} 
                                    <span class="text-xs font-bold tracking-wider bg-slate-200/60 dark:bg-slate-800 text-slate-650 dark:text-slate-400 px-2.5 py-1 rounded-xl border border-slate-200/20 dark:border-slate-700/50">{{ $booking->booking_code }}</span>
                                </div>
                                <div class="text-sm text-slate-500 dark:text-slate-400 font-semibold">
                                    @if($booking->details->first())
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                            <span>{{ $booking->details->first()->court->name }}</span>
                                            <span class="text-slate-300 dark:text-slate-700">•</span>
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span>{{ \Carbon\Carbon::parse($booking->details->first()->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->details->first()->end_time)->format('H:i') }} WIB</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 sm:mt-0 text-left sm:text-right flex flex-col sm:items-end gap-1.5">
                                <div class="font-extrabold text-xl text-brand-600 dark:text-brand-400">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                <div>
                                    @if($booking->status == 'pending')
                                        <span class="badge-warning px-3 py-1 rounded-full text-xs font-extrabold tracking-wide">Menunggu Pembayaran</span>
                                    @elseif($booking->status == 'paid')
                                        <span class="badge-success px-3 py-1 rounded-full text-xs font-extrabold tracking-wide">Lunas</span>
                                    @elseif($booking->status == 'completed')
                                        <span class="badge-success px-3 py-1 rounded-full text-xs font-extrabold tracking-wide">Selesai</span>
                                    @elseif($booking->status == 'cancelled' || $booking->status == 'canceled')
                                        <span class="badge-danger px-3 py-1 rounded-full text-xs font-extrabold tracking-wide">Dibatalkan</span>
                                    @else
                                        <span class="badge-info px-3 py-1 rounded-full text-xs font-extrabold tracking-wide">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 border-2 border-dashed border-slate-100 dark:border-slate-800 rounded-3xl">
                        <svg class="w-10 h-10 mx-auto text-slate-300 dark:text-slate-700 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-slate-500 dark:text-slate-400 font-semibold">Belum ada riwayat booking.</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Ayo pesan lapangan premium Anda sekarang!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
