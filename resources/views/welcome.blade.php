<!DOCTYPE html>
<html lang="id"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" 
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" 
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Lapangan Badminton - Premium</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800,900&display=swap" rel="stylesheet" />

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
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 font-sans antialiased selection:bg-brand-500 selection:text-white transition-colors duration-300">
    <!-- Navbar -->
    <nav class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100 dark:border-slate-800/80 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-2.5">
                        <x-application-logo class="h-8 w-auto fill-current text-brand-500" />
                        <span class="text-2xl font-black bg-gradient-to-r from-brand-500 to-emerald-600 dark:from-brand-400 dark:to-emerald-500 bg-clip-text text-transparent tracking-tight">anoBadmin</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" aria-label="Toggle Dark Mode" class="p-2.5 text-slate-500 dark:text-slate-400 hover:text-brand-500 dark:hover:text-brand-450 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors focus:outline-none">
                        <svg x-show="darkMode" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    </button>

                    @auth
                        <a href="{{ route('user.dashboard') }}" class="btn-secondary py-2 px-4 text-sm font-semibold rounded-xl">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 dark:text-slate-400 hover:text-brand-500 dark:hover:text-brand-400 font-semibold transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary py-2 px-4 text-sm font-semibold rounded-xl">Daftar Member</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-slate-900 text-white py-28 sm:py-36">
        <div class="absolute inset-0 z-0 opacity-30">
            <img src="https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover filter contrast-125 brightness-75" alt="Badminton">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/70 to-brand-950/20 z-10"></div>
        
        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-brand-500/10 text-brand-400 border border-brand-500/20 mb-6 tracking-wide uppercase">⚡ Premium Court Booking</span>
            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight mb-6">Main Badminton, <span class="text-brand-400 bg-gradient-to-r from-brand-400 to-emerald-300 bg-clip-text text-transparent">Lebih Mudah!</span></h1>
            <p class="text-lg sm:text-xl text-slate-300 max-w-2xl mx-auto mb-10 leading-relaxed">Booking lapangan favorit Anda dalam hitungan detik. Dapatkan poin dari setiap transaksi, dan nikmati keuntungan eksklusif serta diskon melimpah bagi pemegang membership.</p>
            <a href="#courts" class="btn-primary py-4 px-8 rounded-full text-base font-bold transition-all shadow-soft-lg shadow-brand-500/20">Lihat Lapangan</a>
        </div>
    </div>

    <!-- Courts Section -->
    <div id="courts" class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-4">Pilihan Lapangan Premium</h2>
            <p class="text-slate-500 dark:text-slate-400 max-w-lg mx-auto">Pilih lapangan badminton favorit Anda yang dilapisi karpet vinyl standar internasional dan nikmati pengalaman bermain premium.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($courts as $court)
            <div class="card p-0 overflow-hidden group">
                <div class="h-56 bg-slate-200 dark:bg-slate-800 overflow-hidden relative">
                    <img src="{{ $court->image ?? 'https://storage.googleapis.com/data.ayo.co.id/photos/77445/SEO%20HDI%202/16.%20Kelebihan%20dan%20Kekurangan%20Lapangan%20Badminton%20Sintetis%20yang%20Perlu%20Diketahui.jpg' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $court->name }}">
                    <div class="absolute top-4 right-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md px-3.5 py-1.5 rounded-2xl text-sm font-bold text-slate-800 dark:text-slate-100 border border-slate-100/10 shadow-soft">
                        Rp {{ number_format($court->price_per_hour, 0, ',', '.') }} <span class="text-xs text-slate-500 dark:text-slate-400 font-normal">/ jam</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ $court->name }}</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 line-clamp-2">{{ $court->description }}</p>
                    
                    <button onclick="openBookingModal({{ $court->id }}, '{{ $court->name }}', {{ $court->price_per_hour }})" class="w-full btn-primary py-3 rounded-2xl text-sm font-semibold shadow-soft">
                        Cek Jadwal & Booking
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Membership Info Section -->
    <div class="bg-slate-100 dark:bg-slate-900/40 border-y border-slate-200/45 dark:border-slate-800/60 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-4">Sistem Membership Keanggotaan</h2>
            <p class="text-slate-500 dark:text-slate-400 max-w-2xl mx-auto mb-16">Kami menyediakan beberapa tipe keanggotaan untuk memberikan fleksibilitas dan keuntungan maksimal bagi Anda yang rutin bermain badminton (8x per bulan).</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                <!-- Reguler -->
                <div class="card border border-slate-200/60 dark:border-slate-800/80 bg-white dark:bg-slate-900 flex flex-col justify-between">
                    <div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 mb-4">Reguler</span>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-1">Pemain Harian</h3>
                        <p class="text-sm text-slate-400 dark:text-slate-500 mb-6">Booking fleksibel harian</p>
                        <ul class="space-y-4 mb-8 text-slate-600 dark:text-slate-400 text-sm">
                            <li class="flex items-start"><span class="text-brand-500 font-bold mr-2.5 text-base">✓</span> Kumpulkan poin dan tukarkan voucher gratis.</li>
                            <li class="flex items-start"><span class="text-brand-500 font-bold mr-2.5 text-base">✓</span> Booking manual instan via website.</li>
                            <li class="flex items-start"><span class="text-brand-500 font-bold mr-2.5 text-base">✓</span> Akses booking ke semua jenis lapangan.</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Ano Member -->
                <div class="card border-2 border-brand-500 bg-brand-500 text-white flex flex-col justify-between relative transform md:-translate-y-4 shadow-soft-lg hover:shadow-soft-lg">
                    <div class="absolute -top-3.5 left-1/2 transform -translate-x-1/2 bg-amber-400 text-amber-950 text-xs font-extrabold px-4 py-1 rounded-full uppercase tracking-wider shadow-sm">Paling Populer</div>
                    <div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-white/20 text-white mb-4">Ano Member</span>
                        <h3 class="text-2xl font-bold mb-1 text-white">Ano Member</h3>
                        <p class="text-sm text-brand-100 mb-6">Booking Rutin Bulanan</p>
                        <ul class="space-y-4 mb-8 text-sm text-brand-50">
                            <li class="flex items-start"><span class="text-white font-bold mr-2.5 text-base">✓</span> <strong>8x Pertemuan per bulan.</strong></li>
                            <li class="flex items-start"><span class="text-white font-bold mr-2.5 text-base">✓</span> <strong>Durasi 3 Jam per pertemuan.</strong></li>
                            <li class="flex items-start"><span class="text-white font-bold mr-2.5 text-base">✓</span> Jadwal tetap yang dibooking otomatis oleh sistem.</li>
                            <li class="flex items-start"><span class="text-white font-bold mr-2.5 text-base">✓</span> Dapatkan poin melimpah untuk diskon tambahan.</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Supah Ano -->
                <div class="card border border-slate-200/60 dark:border-slate-800/80 bg-white dark:bg-slate-900 flex flex-col justify-between">
                    <div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-500 mb-4">Exclusive</span>
                        <h3 class="text-2xl font-bold mb-1 bg-gradient-to-r from-amber-500 to-rose-500 bg-clip-text text-transparent">Supah Ano</h3>
                        <p class="text-sm text-slate-400 dark:text-slate-500 mb-6">Pemain Klub & Pro</p>
                        <ul class="space-y-4 mb-8 text-sm text-slate-600 dark:text-slate-400">
                            <li class="flex items-start"><span class="text-amber-500 font-bold mr-2.5 text-base">✓</span> <strong>8x Pertemuan per bulan.</strong></li>
                            <li class="flex items-start"><span class="text-amber-500 font-bold mr-2.5 text-base">✓</span> <strong>Durasi Maksimal 4 Jam per pertemuan.</strong></li>
                            <li class="flex items-start"><span class="text-amber-500 font-bold mr-2.5 text-base">✓</span> Jadwal tetap prioritas utama auto-booking.</li>
                            <li class="flex items-start"><span class="text-amber-500 font-bold mr-2.5 text-base">✓</span> <strong class="text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 px-2 py-0.5 rounded-lg border border-emerald-100 dark:border-emerald-900/20">Gratis 2 Shuttlecock / Sesi</strong></li>
                            <li class="flex items-start"><span class="text-amber-500 font-bold mr-2.5 text-base">✓</span> <strong class="text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-950/40 px-2 py-0.5 rounded-lg border border-brand-100 dark:border-brand-900/20">Gratis 2 Air Mineral 600ml</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div id="bookingModal" class="fixed inset-0 bg-slate-950/45 backdrop-blur-sm z-50 hidden flex items-center justify-center opacity-0 transition-opacity duration-300 overflow-y-auto">
        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 rounded-4xl shadow-soft-lg w-full max-w-2xl my-8 overflow-hidden transform scale-95 transition-transform duration-300" id="modalContent">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50 dark:bg-slate-900/50 sticky top-0 z-10">
                <h3 class="text-xl font-extrabold text-slate-800 dark:text-white" id="modalCourtName">Booking Lapangan</h3>
                <button onclick="closeBookingModal()" class="text-slate-400 hover:text-rose-500 p-1 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('book.guest') }}" method="POST" class="p-6 space-y-6" id="bookingForm" onsubmit="return validateForm()">
                @csrf
                <input type="hidden" name="court_id" id="modalCourtId">
                <input type="hidden" name="start_time" id="inputStartTime">
                <input type="hidden" name="duration" id="inputDuration">
                
                @guest
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="label">Nama Lengkap</label>
                        <input type="text" name="guest_name" required class="input">
                    </div>
                    <div>
                        <label class="label">No. WhatsApp</label>
                        <input type="text" name="guest_phone" required class="input">
                    </div>
                </div>
                <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/20 text-amber-700 dark:text-amber-400 text-sm border border-amber-100 dark:border-amber-900/20 flex items-center shadow-inner">
                    <svg class="w-5 h-5 mr-2 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>💡 Tip: <a href="{{ route('login') }}" class="font-bold text-brand-650 dark:text-brand-400 hover:underline">Login</a> terlebih dahulu untuk kumpulkan poin & klaim promo voucher!</span>
                </div>
                @endguest

                <div>
                    <label class="label">Pilih Tanggal Booking</label>
                    <input type="date" name="date" id="modalDate" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" onchange="fetchSlots()" class="input">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-3">
                        <label class="label mb-0">Pilih Jam (Klik berurutan untuk kelipatan durasi)</label>
                        <div class="flex items-center gap-3 text-xs font-semibold text-slate-500 dark:text-slate-400">
                            <span class="flex items-center"><span class="w-3 h-3 bg-rose-50 dark:bg-rose-950/40 border border-rose-100 dark:border-rose-900/30 rounded-lg mr-1.5"></span> Terisi</span>
                            <span class="flex items-center"><span class="w-3 h-3 bg-brand-500 rounded-lg mr-1.5"></span> Dipilih</span>
                        </div>
                    </div>
                    
                    <!-- Loading state -->
                    <div id="slotsLoading" class="text-center py-6 text-brand-500 hidden">
                        <svg class="animate-spin h-7 w-7 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>

                    <!-- Error state -->
                    <div id="slotsError" class="text-center py-6 text-rose-500 font-semibold hidden">
                        Gagal memuat jadwal. Silakan coba beberapa saat lagi.
                    </div>

                    <!-- Slots Grid -->
                    <div id="slotsGrid" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2.5">
                        <!-- Filled by JS -->
                    </div>
                    <p id="slotsValidationMsg" class="text-rose-500 text-sm font-semibold mt-2.5 hidden"></p>
                </div>

                <div class="bg-slate-50 dark:bg-slate-950 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 flex justify-between items-center shadow-inner">
                    <span class="text-slate-600 dark:text-slate-400 font-semibold">Total Harga (<span id="displayDuration" class="text-brand-500">0</span> Jam)</span>
                    <span class="text-2xl font-black text-brand-500" id="modalTotalPrice">Rp 0</span>
                </div>

                @auth
                    <div class="mt-4 border border-brand-100 dark:border-brand-900/30 bg-brand-50/40 dark:bg-brand-950/20 p-4 rounded-2xl">
                        <label class="label text-brand-800 dark:text-brand-400 mb-2.5 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            Gunakan Voucher Anda
                        </label>
                        @if(isset($ownedVouchers) && count($ownedVouchers) > 0)
                            <select name="promo_id" id="promoSelect" onchange="updatePriceDisplay()" class="w-full rounded-2xl border-brand-200 focus:border-brand-500 focus:ring-brand-500/20 text-sm bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300">
                                <option value="">-- Tidak Pakai Voucher --</option>
                                @foreach($ownedVouchers as $voucher)
                                    <option value="{{ $voucher->id }}" data-discount="{{ $voucher->discount_percent }}">{{ $voucher->code }} (Diskon {{ $voucher->discount_percent }}%)</option>
                                @endforeach
                            </select>
                        @else
                            <div class="text-sm text-brand-700 dark:text-brand-400 bg-white/60 dark:bg-slate-900/60 p-3.5 rounded-xl border border-brand-100/40 dark:border-brand-900/30 flex items-center justify-between">
                                <span>Anda belum memiliki voucher aktif.</span>
                                <a href="{{ route('vouchers.index') }}" class="btn-primary py-1 px-3 text-xs font-bold shadow-sm">Tukar Poin</a>
                            </div>
                        @endif
                    </div>
                @endauth

                <button type="submit" id="btnSubmit" disabled class="w-full btn-primary py-3.5 rounded-2xl font-bold shadow-soft">
                    @auth Konfirmasi Booking @else Lanjut Booking (Guest) @endauth
                </button>
            </form>
        </div>
    </div>

    <script>
        let currentCourtId = 0;
        let currentPrice = 0;
        let selectedSlots = [];
        let slotsData = [];

        function openBookingModal(courtId, courtName, price) {
            currentCourtId = courtId;
            currentPrice = price;
            
            document.getElementById('modalCourtId').value = courtId;
            document.getElementById('modalCourtName').textContent = 'Booking ' + courtName;
            
            @auth
            document.getElementById('bookingForm').action = "{{ route('book.store') }}";
            @endauth
            
            // Reset selection
            selectedSlots = [];
            updatePriceDisplay();
            
            // Fetch Slots
            fetchSlots();

            const modal = document.getElementById('bookingModal');
            const content = document.getElementById('modalContent');
            modal.classList.remove('hidden');
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            }, 10);
        }

        function closeBookingModal() {
            const modal = document.getElementById('bookingModal');
            const content = document.getElementById('modalContent');
            
            modal.classList.add('opacity-0');
            content.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        async function fetchSlots() {
            const date = document.getElementById('modalDate').value;
            if (!date) return;
            
            selectedSlots = [];
            updatePriceDisplay();

            document.getElementById('slotsGrid').classList.add('hidden');
            document.getElementById('slotsLoading').classList.remove('hidden');
            document.getElementById('slotsError').classList.add('hidden');
            
            try {
                const response = await fetch(`{{ url('/api/courts') }}/${currentCourtId}/slots?date=${date}`);
                slotsData = await response.json();
                
                const grid = document.getElementById('slotsGrid');
                grid.innerHTML = '';
                
                slotsData.forEach((slot, index) => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.textContent = slot.time;
                    btn.dataset.index = index;
                    
                    if (slot.available) {
                        btn.className = 'py-2.5 px-2 rounded-2xl border text-sm font-semibold transition-all duration-200 hover:bg-brand-50 hover:border-brand-300 dark:hover:bg-slate-800 border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 text-slate-700 dark:text-slate-300';
                        btn.onclick = () => toggleSlot(index);
                    } else {
                        btn.className = 'py-2.5 px-2 rounded-2xl border border-rose-200/50 dark:border-rose-950/20 bg-rose-50/40 dark:bg-rose-950/20 text-rose-500 dark:text-rose-400 text-sm font-semibold cursor-not-allowed';
                        btn.disabled = true;
                    }
                    
                    grid.appendChild(btn);
                });
                
                document.getElementById('slotsGrid').classList.remove('hidden');
            } catch (e) {
                console.error(e);
                const grid = document.getElementById('slotsGrid');
                grid.innerHTML = '';
                grid.classList.remove('hidden');
                document.getElementById('slotsError').classList.remove('hidden');
            } finally {
                document.getElementById('slotsLoading').classList.add('hidden');
            }
        }

        function toggleSlot(index) {
            const slotIndex = selectedSlots.indexOf(index);
            
            if (slotIndex > -1) {
                // If unselecting, ensure we unselect the latest clicked to maintain consecutive hours
                selectedSlots = selectedSlots.filter(i => i < index);
            } else {
                // Ensure selection is consecutive
                if (selectedSlots.length > 0) {
                    const maxSelected = Math.max(...selectedSlots);
                    if (index !== maxSelected + 1) {
                        // Reset if non-consecutive
                        selectedSlots = [index];
                    } else {
                        selectedSlots.push(index);
                    }
                } else {
                    selectedSlots.push(index);
                }
            }
            
            // Limit to 5 hours (as per form rules min 1 max 5)
            if (selectedSlots.length > 5) {
                selectedSlots.shift();
            }

            renderSlots();
            updatePriceDisplay();
        }

        function renderSlots() {
            const buttons = document.getElementById('slotsGrid').querySelectorAll('button');
            buttons.forEach(btn => {
                if (btn.disabled) return;
                
                const idx = parseInt(btn.dataset.index);
                if (selectedSlots.includes(idx)) {
                    btn.className = 'py-2.5 px-2 rounded-2xl border border-brand-500 bg-brand-500 text-white text-sm font-bold shadow-soft transform scale-105 transition-all';
                } else {
                    btn.className = 'py-2.5 px-2 rounded-2xl border text-sm font-semibold transition-all duration-200 hover:bg-brand-50 hover:border-brand-300 dark:hover:bg-slate-800 border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 text-slate-700 dark:text-slate-300';
                }
            });
        }

        function updatePriceDisplay() {
            const duration = selectedSlots.length;
            let total = currentPrice * duration;
            
            // Check promo logic in frontend
            const promoSelect = document.getElementById('promoSelect');
            if (promoSelect && promoSelect.value && duration > 0) {
                const discountOption = promoSelect.options[promoSelect.selectedIndex];
                const discountPercent = parseFloat(discountOption.getAttribute('data-discount'));
                if (!isNaN(discountPercent)) {
                    total = total - (total * (discountPercent / 100));
                }
            }

            document.getElementById('displayDuration').textContent = duration;
            document.getElementById('modalTotalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
            
            const btnSubmit = document.getElementById('btnSubmit');
            
            if (duration > 0) {
                btnSubmit.disabled = false;
                
                // Set hidden inputs
                const minIndex = Math.min(...selectedSlots);
                document.getElementById('inputStartTime').value = slotsData[minIndex].time;
                document.getElementById('inputDuration').value = duration;
            } else {
                btnSubmit.disabled = true;
                document.getElementById('inputStartTime').value = '';
                document.getElementById('inputDuration').value = '';
            }
        }

        function validateForm() {
            if (selectedSlots.length === 0) {
                alert('Silakan pilih minimal 1 jam.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
