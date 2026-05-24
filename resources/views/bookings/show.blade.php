@php
$renderContent = function() use ($booking) {
@endphp
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-100 dark:border-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-3 rounded-2xl relative mb-6 shadow-sm" role="alert">
                <span class="block sm:inline font-semibold">{{ session('success') }}</span>
            </div>
            @endif

            <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-soft rounded-4xl p-6 sm:p-8 transition-all duration-300">
                <div class="text-slate-800 dark:text-slate-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-extrabold mb-4 border-b border-slate-100 dark:border-slate-800 pb-2 tracking-tight">Informasi Booking</h3>
                            
                            <div class="space-y-3.5 text-sm">
                                <div class="flex items-center">
                                    <span class="font-semibold w-32 inline-block text-slate-500 dark:text-slate-400">Tanggal</span>
                                    <span class="text-slate-800 dark:text-slate-200 font-bold">: {{ \Carbon\Carbon::parse($booking->date)->format('d F Y') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="font-semibold w-32 inline-block text-slate-500 dark:text-slate-400">Lapangan</span>
                                    <span class="text-slate-800 dark:text-slate-200 font-bold">: 
                                        @if($booking->details->first())
                                            {{ $booking->details->first()->court->name }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <span class="font-semibold w-32 inline-block text-slate-500 dark:text-slate-400">Waktu</span>
                                    <span class="text-slate-800 dark:text-slate-200 font-mono font-bold">: 
                                        @if($booking->details->first())
                                            {{ \Carbon\Carbon::parse($booking->details->first()->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->details->first()->end_time)->format('H:i') }} WIB
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <span class="font-semibold w-32 inline-block text-slate-500 dark:text-slate-400">Status</span>
                                    <span class="font-bold">: 
                                        @if($booking->status == 'pending')
                                            <span class="badge badge-warning px-3 py-1 text-xs">Menunggu Pembayaran</span>
                                        @elseif($booking->status == 'paid')
                                            <span class="badge badge-success px-3 py-1 text-xs">Lunas</span>
                                        @elseif($booking->status == 'completed')
                                            <span class="badge badge-success px-3 py-1 text-xs">Selesai</span>
                                        @elseif($booking->status == 'cancelled' || $booking->status == 'canceled')
                                            <span class="badge badge-danger px-3 py-1 text-xs">Dibatalkan</span>
                                        @else
                                            <span class="badge badge-info px-3 py-1 text-xs uppercase">{{ $booking->status }}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-extrabold mb-4 border-b border-slate-100 dark:border-slate-800 pb-2 tracking-tight">Rincian Pembayaran</h3>
                            
                            <div class="space-y-3.5 text-sm mb-4">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-slate-500 dark:text-slate-400">Subtotal</span>
                                    <span class="font-bold text-slate-800 dark:text-slate-200">Rp {{ number_format($booking->total_price + $booking->discount_applied, 0, ',', '.') }}</span>
                                </div>
                                @if($booking->discount_applied > 0)
                                <div class="flex justify-between items-center text-emerald-600 dark:text-emerald-400">
                                    <span class="font-semibold">Diskon Member</span>
                                    <span class="font-bold">- Rp {{ number_format($booking->discount_applied, 0, ',', '.') }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between items-center border-t border-slate-100 dark:border-slate-800 pt-3">
                                    <span class="font-extrabold text-slate-850 dark:text-slate-200 text-base">Total Bayar</span>
                                    <span class="text-brand-600 dark:text-brand-400 font-black text-2xl">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            @if($booking->status == 'pending')
                            <div class="bg-brand-50/20 dark:bg-brand-950/10 p-6 rounded-3xl border border-brand-100/40 dark:border-brand-900/20 mt-6 shadow-inner text-center">
                                <h4 class="font-black text-brand-900 dark:text-brand-200 mb-2 text-xl tracking-tight">Bayar dengan QRIS</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">Scan QR code di bawah menggunakan M-Banking atau E-Wallet pilihan Anda.</p>
                                
                                <div class="bg-white p-4 rounded-3xl shadow-soft inline-block mb-4 border-2 border-brand-100 dark:border-brand-900/30">
                                    <!-- QRIS Dummy API using brand-600 Color -->
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&color=059669&data=QRIS-AnoBadmin-{{$booking->booking_code}}" alt="QRIS" class="w-44 h-44 mx-auto">
                                </div>
                                
                                <p class="text-xs text-brand-600 dark:text-brand-400 font-bold uppercase tracking-wider mb-1">Total Tagihan</p>
                                <div class="text-3xl font-black text-brand-700 dark:text-brand-400 mb-6">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>

                                <form action="{{ route('payments.store', $booking) }}" method="POST" class="text-left">
                                    @csrf
                                    <button type="submit" class="btn-primary w-full py-3.5 rounded-2xl flex items-center justify-center gap-2 font-bold text-sm shadow-soft hover:shadow-soft-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Simulasikan Pembayaran Selesai
                                    </button>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 text-center mt-3 font-semibold">SISTEM DUMMY OTOMATIS MENDETEKSI PEMBAYARAN</p>
                                </form>
                            </div>
                            @elseif($booking->payment)
                            <div class="bg-emerald-50 dark:bg-emerald-950/20 p-5 rounded-3xl border border-emerald-100 dark:border-emerald-900/30 mt-6 shadow-sm">
                                <h4 class="font-bold text-emerald-900 dark:text-emerald-200 mb-2 flex items-center gap-1.5 text-sm">
                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    Pembayaran Diterima
                                </h4>
                                <p class="text-sm text-emerald-800 dark:text-emerald-300">Status Pembayaran: <strong class="uppercase">{{ $booking->payment->status }}</strong></p>
                                @if($booking->payment->proof_image)
                                <a href="{{ asset('storage/' . $booking->payment->proof_image) }}" target="_blank" class="text-xs text-brand-600 dark:text-brand-400 font-bold hover:underline mt-2 inline-block">Lihat Bukti Upload &rarr;</a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
@php
};
@endphp

@if(auth()->check())
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
            {{ __('Detail Booking') }} <span class="font-mono text-brand-500 font-black">{{ $booking->booking_code }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        {{ $renderContent() }}
    </div>
</x-app-layout>
@else
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" 
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" 
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Booking Detail</title>

        <!-- Anti-FOUC Script -->
        <script>
            if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 dark:text-slate-100 bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
        <!-- Centered Header -->
        <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 py-4 px-6 mb-8 flex justify-between items-center shadow-soft">
            <a href="{{ route('home') }}" class="font-extrabold text-xl text-brand-500 hover:text-brand-600 transition flex items-center gap-2">
                <x-application-logo class="w-6 h-6 fill-current text-brand-500" />
                <span>anoBadmin</span>
            </a>
            
            <div class="flex items-center space-x-3">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" aria-label="Toggle Dark Mode" class="p-2 text-slate-500 dark:text-slate-400 hover:text-brand-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition focus:outline-none">
                    <svg x-show="darkMode" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>
                <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-brand-500 dark:hover:text-brand-400 transition bg-slate-100/80 dark:bg-slate-850 px-4 py-2 rounded-xl">Kembali ke Home</a>
            </div>
        </div>
        
        <div class="py-6 px-4">
            {{ $renderContent() }}
        </div>
    </body>
</html>
@endif
