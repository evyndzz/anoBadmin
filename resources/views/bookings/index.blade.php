<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-850 dark:text-white leading-tight">
            {{ __('Riwayat Booking') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-850 shadow-soft rounded-4xl p-6 transition-all duration-300">
                <div class="p-2">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-slate-850 dark:text-white tracking-tight">Semua Riwayat Booking</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Daftar lengkap pemesanan lapangan Anda</p>
                        </div>
                        <a href="{{ route('bookings.create') }}" class="btn-primary py-2.5 px-5 text-sm font-semibold rounded-2xl shadow-soft transition-transform active:scale-95 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Booking Baru
                        </a>
                    </div>
                    
                    @if(count($bookings) > 0)
                        <div class="space-y-4">
                            @foreach($bookings as $booking)
                            <div class="border border-slate-100 dark:border-slate-850/60 rounded-3xl p-5 bg-slate-50/30 dark:bg-slate-900/30 flex flex-col sm:flex-row justify-between sm:items-center hover:bg-slate-50 dark:hover:bg-slate-850/30 transition-all duration-300 shadow-inner">
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2">
                                        <div class="font-extrabold text-base text-slate-800 dark:text-white">
                                            {{ \Carbon\Carbon::parse($booking->date)->format('d F Y') }}
                                        </div>
                                        <span class="text-xs font-bold tracking-wider bg-slate-200/60 dark:bg-slate-800 text-slate-650 dark:text-slate-400 px-2.5 py-1 rounded-xl border border-slate-200/20 dark:border-slate-700/50">{{ $booking->booking_code }}</span>
                                    </div>
                                    <div class="text-sm font-semibold text-slate-500 dark:text-slate-400 space-y-1">
                                        @if($booking->details->first())
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                                <span>{{ $booking->details->first()->court->name }}</span>
                                            </div>
                                            <div class="flex items-center gap-1.5 mt-1.5">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span>{{ \Carbon\Carbon::parse($booking->details->first()->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->details->first()->end_time)->format('H:i') }} WIB</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-4 sm:mt-0 text-left sm:text-right flex flex-col sm:items-end gap-2 justify-between">
                                    <div class="font-extrabold text-xl text-brand-600 dark:text-brand-400">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                    <div class="flex items-center gap-2">
                                        @if($booking->status == 'pending')
                                            <span class="badge-warning px-3 py-1 rounded-full text-xs font-extrabold tracking-wide">Menunggu Pembayaran</span>
                                            <a href="{{ route('bookings.show', $booking) }}" class="text-xs font-bold text-brand-500 hover:text-brand-600 dark:text-brand-400 dark:hover:text-brand-400 hover:underline">Bayar &rarr;</a>
                                        @elseif($booking->status == 'paid')
                                            <span class="badge-success px-3 py-1 rounded-full text-xs font-extrabold tracking-wide">Lunas</span>
                                            <a href="{{ route('bookings.show', $booking) }}" class="text-xs font-bold text-brand-500 hover:text-brand-600 dark:text-brand-400 dark:hover:text-brand-400 hover:underline">Tiket &rarr;</a>
                                        @elseif($booking->status == 'completed')
                                            <span class="badge-success px-3 py-1 rounded-full text-xs font-extrabold tracking-wide">Selesai</span>
                                            <a href="{{ route('bookings.show', $booking) }}" class="text-xs font-bold text-slate-500 hover:text-slate-650 hover:underline">Detail</a>
                                        @elseif($booking->status == 'cancelled' || $booking->status == 'canceled')
                                            <span class="badge-danger px-3 py-1 rounded-full text-xs font-extrabold tracking-wide">Dibatalkan</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 border-2 border-dashed border-slate-100 dark:border-slate-800 rounded-3xl">
                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <h3 class="text-lg font-bold text-slate-700 dark:text-slate-300">Belum Ada Transaksi</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Anda belum memiliki riwayat pemesanan lapangan.</p>
                            <a href="{{ route('bookings.create') }}" class="btn-primary text-sm font-semibold rounded-2xl py-2.5 px-6 shadow-soft transition-all duration-200">Booking Sekarang</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
