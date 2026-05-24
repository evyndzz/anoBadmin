<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran Membership') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Order Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Detail Transaksi Membership</h3>
                    
                    <div class="space-y-4 text-sm">
                        <div class="flex flex-col sm:flex-row justify-between border-b border-dashed border-gray-200 pb-3">
                            <span class="text-gray-500 font-medium">Paket Membership</span>
                            <span class="font-bold text-gray-800 text-lg">{{ $membership->name }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between border-b border-dashed border-gray-200 pb-3">
                            <span class="text-gray-500 font-medium">Jadwal Main</span>
                            <span class="font-bold text-gray-800">{{ $schedule->days }} ({{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB)</span>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between border-b border-dashed border-gray-200 pb-3">
                            <span class="text-gray-500 font-medium">Lapangan</span>
                            <span class="font-bold text-gray-800">{{ $schedule->court->name ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between border-b border-dashed border-gray-200 pb-3">
                            <span class="text-gray-500 font-medium">Durasi Aktif</span>
                            <span class="font-bold text-gray-800">{{ $membership->duration_months }} Bulan</span>
                        </div>

                        <!-- Total -->
                        <div class="flex flex-col sm:flex-row justify-between pt-4 pb-2 items-center">
                            <span class="text-gray-700 font-bold text-lg">Total Pembayaran</span>
                            <span class="font-black text-3xl text-blue-600">Rp {{ number_format($price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Simulation -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-blue-100">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Pembayaran QRIS (Simulasi)</h3>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6 items-center bg-gray-50 p-6 rounded-xl border border-gray-100">
                        <!-- Dummy QR Code -->
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 shrink-0">
                            <div class="w-48 h-48 bg-gray-900 flex items-center justify-center text-white text-center p-4">
                                <div>
                                    <svg class="w-16 h-16 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                    <span class="text-xs">SCAN QRIS UNTUK BAYAR</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 space-y-4">
                            <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg text-sm">
                                <strong>Info:</strong> Fitur ini adalah simulasi. Klik tombol di bawah ini untuk mensimulasikan keberhasilan pembayaran membership Anda.
                            </div>

                            <form action="{{ route('membership.pay') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 flex justify-center items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Simulasikan Bayar Rp {{ number_format($price, 0, ',', '.') }}
                                </button>
                            </form>
                            
                            <div class="text-center">
                                <a href="{{ route('membership.index') }}" class="text-sm text-gray-500 hover:text-gray-700 hover:underline">Batalkan & Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
