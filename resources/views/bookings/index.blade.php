<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold">Semua Riwayat Booking</h3>
                        <a href="{{ route('bookings.create') }}" class="text-sm bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 shadow-md shadow-blue-500/30 transition transform hover:-translate-y-0.5">Booking Baru</a>
                    </div>
                    
                    @if(count($bookings) > 0)
                        <div class="space-y-4">
                            @foreach($bookings as $booking)
                            <div class="border border-slate-100 rounded-xl p-5 flex flex-col sm:flex-row justify-between sm:items-center hover:bg-slate-50 transition shadow-sm">
                                <div>
                                    <div class="flex items-center space-x-3 mb-2">
                                        <div class="font-bold text-lg text-slate-800">
                                            {{ \Carbon\Carbon::parse($booking->date)->format('d F Y') }}
                                        </div>
                                        <span class="text-xs bg-slate-200 text-slate-700 px-2 py-1 rounded-md font-mono">{{ $booking->booking_code }}</span>
                                    </div>
                                    <div class="text-sm text-slate-600">
                                        @if($booking->details->first())
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                <span>{{ $booking->details->first()->court->name }}</span>
                                            </div>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span>{{ \Carbon\Carbon::parse($booking->details->first()->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->details->first()->end_time)->format('H:i') }} WIB</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-4 sm:mt-0 text-left sm:text-right flex flex-col justify-between h-full">
                                    <div class="font-black text-xl text-blue-600 mb-2">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                    <div>
                                        @if($booking->status == 'pending')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800">Menunggu Pembayaran</span>
                                            <a href="{{ route('bookings.show', $booking) }}" class="ml-2 text-xs font-bold text-blue-600 hover:underline">Bayar Sekarang &rarr;</a>
                                        @elseif($booking->status == 'paid')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-800">Lunas / Terjadwal</span>
                                            <a href="{{ route('bookings.show', $booking) }}" class="ml-2 text-xs font-bold text-blue-600 hover:underline">Lihat Tiket &rarr;</a>
                                        @elseif($booking->status == 'completed')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">Selesai dimainkan</span>
                                            <a href="{{ route('bookings.show', $booking) }}" class="ml-2 text-xs font-bold text-slate-500 hover:underline">Detail</a>
                                        @elseif($booking->status == 'cancelled')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800">Dibatalkan</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-slate-50 rounded-xl border border-slate-100">
                            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <h3 class="text-lg font-bold text-slate-700">Belum Ada Transaksi</h3>
                            <p class="text-slate-500 mb-4">Anda belum memiliki riwayat pemesanan lapangan.</p>
                            <a href="{{ route('bookings.create') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-blue-700 transition inline-block shadow-md">Booking Sekarang</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
