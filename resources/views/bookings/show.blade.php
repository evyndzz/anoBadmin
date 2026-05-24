@php
$renderContent = function() use ($booking) {
@endphp
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-100 dark:bg-green-900/40 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-400 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-slate-100 dark:border-slate-700">
                <div class="p-6 text-gray-900 dark:text-white">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-bold mb-4 border-b border-gray-100 dark:border-slate-700 pb-2">Informasi Booking</h3>
                            <p class="mb-2"><span class="font-semibold w-32 inline-block text-slate-600 dark:text-slate-400">Tanggal</span>: {{ \Carbon\Carbon::parse($booking->date)->format('d F Y') }}</p>
                            <p class="mb-2"><span class="font-semibold w-32 inline-block text-slate-600 dark:text-slate-400">Lapangan</span>: 
                                @if($booking->details->first())
                                    {{ $booking->details->first()->court->name }}
                                @else
                                    -
                                @endif
                            </p>
                            <p class="mb-2"><span class="font-semibold w-32 inline-block text-slate-600 dark:text-slate-400">Waktu</span>: 
                                @if($booking->details->first())
                                    {{ \Carbon\Carbon::parse($booking->details->first()->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->details->first()->end_time)->format('H:i') }}
                                @else
                                    -
                                @endif
                            </p>
                            <p class="mb-2"><span class="font-semibold w-32 inline-block text-slate-600 dark:text-slate-400">Status</span>: 
                                @if($booking->status == 'pending')
                                    <span class="text-yellow-600 dark:text-yellow-400 font-bold uppercase">{{ $booking->status }}</span>
                                @elseif($booking->status == 'completed' || $booking->status == 'paid')
                                    <span class="text-green-600 dark:text-green-400 font-bold uppercase">{{ $booking->status }}</span>
                                @else
                                    <span class="text-gray-600 dark:text-gray-400 font-bold uppercase">{{ $booking->status }}</span>
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-bold mb-4 border-b border-gray-100 dark:border-slate-700 pb-2">Rincian Pembayaran</h3>
                            <p class="mb-2"><span class="font-semibold w-32 inline-block text-slate-600 dark:text-slate-400">Subtotal</span>: Rp {{ number_format($booking->total_price + $booking->discount_applied, 0, ',', '.') }}</p>
                            @if($booking->discount_applied > 0)
                            <p class="mb-2 text-green-600 dark:text-green-400"><span class="font-semibold w-32 inline-block">Diskon Member</span>: - Rp {{ number_format($booking->discount_applied, 0, ',', '.') }}</p>
                            @endif
                            <p class="mb-4 text-xl"><span class="font-bold w-32 inline-block">Total Bayar</span>: <span class="text-blue-600 dark:text-blue-400 font-black">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span></p>

                            @if($booking->status == 'pending')
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-6 rounded-2xl border border-blue-200 dark:border-blue-800/50 mt-4 shadow-sm text-center">
                                <h4 class="font-black text-blue-900 dark:text-blue-100 mb-2 text-xl">Bayar dengan QRIS</h4>
                                <p class="text-sm text-blue-800 dark:text-blue-200 mb-4">Scan QR code di bawah menggunakan M-Banking atau E-Wallet pilihan Anda.</p>
                                
                                <div class="bg-white p-4 rounded-xl shadow-md inline-block mb-4 border-2 border-blue-100 dark:border-blue-800">
                                    <!-- QRIS Dummy API -->
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&color=1e3a8a&data=QRIS-AnoBadmin-{{$booking->booking_code}}" alt="QRIS" class="w-48 h-48 mx-auto">
                                </div>
                                
                                <p class="text-xs text-blue-600 dark:text-blue-400 font-bold uppercase tracking-wider mb-1">Total Tagihan</p>
                                <div class="text-3xl font-black text-blue-700 dark:text-blue-300 mb-6">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>

                                <form action="{{ route('payments.store', $booking) }}" method="POST" class="text-left mt-6">
                                    @csrf
                                    
                                    <button type="submit" class="w-full bg-emerald-600 text-white font-black py-4 px-4 rounded-xl hover:bg-emerald-700 transition transform hover:-translate-y-0.5 shadow-lg shadow-emerald-500/30 flex items-center justify-center">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Simulasikan Pembayaran Selesai
                                    </button>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 text-center mt-3">Sistem otomatis mendeteksi pembayaran QRIS (Dummy)</p>
                                </form>
                            </div>
                            @elseif($booking->payment)
                            <div class="bg-green-50 dark:bg-green-900/30 p-4 rounded-lg border border-green-200 dark:border-green-800/50 mt-4">
                                <h4 class="font-bold text-green-900 dark:text-green-100 mb-2">Pembayaran Diterima</h4>
                                <p class="text-sm text-green-800 dark:text-green-200 mb-2">Status Pembayaran: <strong>{{ ucfirst($booking->payment->status) }}</strong></p>
                                @if($booking->payment->proof_image)
                                <a href="{{ asset('storage/' . $booking->payment->proof_image) }}" target="_blank" class="text-sm text-blue-600 dark:text-blue-400 underline">Lihat Bukti Upload</a>
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
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Detail Booking') }} {{ $booking->booking_code }}
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
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Booking Detail</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 dark:bg-slate-900">
        <div class="bg-white dark:bg-slate-800 border-b border-gray-100 dark:border-slate-700 py-4 px-6 mb-8 flex justify-between items-center shadow-sm">
            <a href="{{ route('home') }}" class="font-bold text-xl text-blue-600 dark:text-blue-400">anoBadmin</a>
            <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 dark:text-slate-400 hover:text-gray-800 dark:hover:text-white transition">Kembali ke Home</a>
        </div>
        
        {{ $renderContent() }}
        
    </body>
</html>
@endif
