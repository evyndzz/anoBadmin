<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Lapangan Badminton - Premium</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased selection:bg-blue-500 selection:text-white">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">AnoBadmin</span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('user.dashboard') }}" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full font-medium transition-transform transform hover:scale-105 active:scale-95 shadow-lg shadow-blue-500/30">Daftar Member</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-slate-900 text-white py-24 sm:py-32">
        <div class="absolute inset-0 z-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover" alt="Badminton">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent z-10"></div>
        
        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-6xl font-black tracking-tight mb-6">Main Badminton, <span class="text-blue-400">Lebih Mudah!</span></h1>
            <p class="text-lg sm:text-xl text-slate-300 max-w-2xl mx-auto mb-10">Booking lapangan dalam hitungan detik. Dapatkan poin dari setiap transaksi, dan nikmati diskon eksklusif bagi pemegang membership Ano Member & Supah Ano.</p>
            <a href="#courts" class="inline-block bg-blue-600 hover:bg-blue-500 text-white px-8 py-4 rounded-full text-lg font-bold transition-all transform hover:-translate-y-1 shadow-xl shadow-blue-600/40">Lihat Lapangan</a>
        </div>
    </div>

    <!-- Courts Section -->
    <div id="courts" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-slate-900 mb-4">Pilihan Lapangan Premium</h2>
            <p class="text-slate-500">Pilih lapangan favorit Anda dan lihat jadwal yang tersedia.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($courts as $court)
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-slate-100 hover:shadow-2xl transition-all duration-300 group">
                <div class="h-48 bg-slate-200 overflow-hidden relative">
                    <img src="{{ $court->image ?? 'https://storage.googleapis.com/data.ayo.co.id/photos/77445/SEO%20HDI%202/16.%20Kelebihan%20dan%20Kekurangan%20Lapangan%20Badminton%20Sintetis%20yang%20Perlu%20Diketahui.jpg' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $court->name }}">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-sm font-bold text-slate-800 shadow-sm">
                        Rp {{ number_format($court->price_per_hour, 0, ',', '.') }} <span class="text-xs text-slate-500 font-normal">/ jam</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">{{ $court->name }}</h3>
                    <p class="text-slate-600 text-sm mb-6 line-clamp-2">{{ $court->description }}</p>
                    
                    <button onclick="openBookingModal({{ $court->id }}, '{{ $court->name }}', {{ $court->price_per_hour }})" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-medium py-3 rounded-xl transition-colors">
                        Cek Jadwal & Booking
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Membership Info Section -->
    <div class="bg-slate-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Sistem Membership</h2>
            <p class="text-slate-500 max-w-2xl mx-auto mb-12">Kami menyediakan tiga tipe keanggotaan untuk memberikan fleksibilitas dan keuntungan maksimal bagi Anda yang rutin bermain badminton (8x per bulan).</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-left">
                <!-- Tidak Member -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
                    <h3 class="text-xl font-bold mb-1">Reguler</h3>
                    <p class="text-sm text-slate-500 mb-6">Booking Harian</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-start"><span class="text-blue-500 mr-2">✓</span> Sistem poin & penukaran voucher promo.</li>
                        <li class="flex items-start"><span class="text-blue-500 mr-2">✓</span> Booking manual via website.</li>
                        <li class="flex items-start"><span class="text-blue-500 mr-2">✓</span> Akses semua lapangan.</li>
                    </ul>
                </div>
                <!-- Ano Member -->
                <div class="bg-blue-600 text-white p-8 rounded-3xl shadow-lg border border-blue-500 transform md:-translate-y-4">
                    <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-bl-xl rounded-tr-3xl">Paling Populer</div>
                    <h3 class="text-xl font-bold mb-1">Ano Member</h3>
                    <p class="text-sm text-blue-200 mb-6">Booking Rutin Otomatis</p>
                    <ul class="space-y-3 mb-8 text-sm">
                        <li class="flex items-start"><span class="text-white mr-2">✓</span> <strong>8x Pertemuan per bulan.</strong></li>
                        <li class="flex items-start"><span class="text-white mr-2">✓</span> <strong>Durasi 3 Jam per pertemuan.</strong></li>
                        <li class="flex items-start"><span class="text-white mr-2">✓</span> Jadwal tetap di-booking otomatis oleh admin.</li>
                        <li class="flex items-start"><span class="text-white mr-2">✓</span> Sistem Poin untuk ditukar voucher diskon tambahan.</li>
                    </ul>
                </div>
                <!-- Supah Ano -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
                    <h3 class="text-xl font-bold mb-1 bg-gradient-to-r from-amber-500 to-red-500 bg-clip-text text-transparent">Supah Ano</h3>
                    <p class="text-sm text-slate-500 mb-6">Pemain Pro & Klub</p>
                    <ul class="space-y-3 mb-8 text-sm">
                        <li class="flex items-start"><span class="text-amber-500 mr-2">✓</span> <strong>8x Pertemuan per bulan.</strong></li>
                        <li class="flex items-start"><span class="text-amber-500 mr-2">✓</span> <strong>Durasi Maksimal 4 Jam per pertemuan.</strong></li>
                        <li class="flex items-start"><span class="text-amber-500 mr-2">✓</span> Jadwal tetap di-booking otomatis oleh admin.</li>
                        <li class="flex items-start"><span class="text-amber-500 mr-2">✓</span> <strong class="text-green-600 bg-green-100 px-1 rounded">Gratis 2 Shuttlecock / Pertemuan</strong></li>
                        <li class="flex items-start"><span class="text-amber-500 mr-2">✓</span> <strong class="text-blue-600 bg-blue-100 px-1 rounded">Gratis 2 Air Mineral 600ml</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div id="bookingModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center opacity-0 transition-opacity duration-300 overflow-y-auto">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl my-8 overflow-hidden transform scale-95 transition-transform duration-300" id="modalContent">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50 sticky top-0 z-10">
                <h3 class="text-xl font-bold text-slate-800" id="modalCourtName">Booking Lapangan</h3>
                <button onclick="closeBookingModal()" class="text-slate-400 hover:text-red-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('book.guest') }}" method="POST" class="p-6 space-y-6" id="bookingForm" onsubmit="return validateForm()">
                @csrf
                <input type="hidden" name="court_id" id="modalCourtId">
                <input type="hidden" name="start_time" id="inputStartTime">
                <input type="hidden" name="duration" id="inputDuration">
                
                @guest
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="guest_name" required class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">No. WhatsApp</label>
                        <input type="text" name="guest_phone" required class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <div class="bg-amber-50 text-amber-700 text-sm p-3 rounded-lg border border-amber-200">
                    <p>💡 Tip: <a href="{{ route('login') }}" class="font-bold underline">Login</a> untuk mendapatkan poin dan rekomendasi promo!</p>
                </div>
                @endguest

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Tanggal</label>
                    <input type="date" name="date" id="modalDate" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" onchange="fetchSlots()" class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-medium text-slate-700">Pilih Jam (Klik jam berurutan untuk durasi lebih)</label>
                        <div class="text-xs text-slate-500"><span class="inline-block w-3 h-3 bg-red-100 rounded-full mr-1"></span> Terisi <span class="inline-block w-3 h-3 bg-green-500 rounded-full ml-2 mr-1"></span> Dipilih</div>
                    </div>
                    
                    <!-- Loading state -->
                    <div id="slotsLoading" class="text-center py-4 text-blue-600 hidden">
                        <svg class="animate-spin h-6 w-6 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>

                    <!-- Error state -->
                    <div id="slotsError" class="text-center py-4 text-red-500 font-medium hidden">
                        Gagal memuat jadwal. Silakan coba lagi.
                    </div>

                    <!-- Slots Grid -->
                    <div id="slotsGrid" class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                        <!-- Filled by JS -->
                    </div>
                    <p id="slotsError" class="text-red-500 text-sm mt-2 hidden"></p>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex justify-between items-center">
                    <span class="text-slate-600 font-medium">Total Harga (<span id="displayDuration">0</span> Jam)</span>
                    <span class="text-2xl font-black text-blue-600" id="modalTotalPrice">Rp 0</span>
                </div>

                @auth
                    <div class="mt-4 border border-blue-100 bg-blue-50 p-4 rounded-xl">
                        <label class="block text-sm font-medium text-blue-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            Gunakan Voucher Anda
                        </label>
                        @if(isset($ownedVouchers) && count($ownedVouchers) > 0)
                            <select name="promo_id" id="promoSelect" onchange="updatePriceDisplay()" class="w-full rounded-lg border-blue-200 focus:border-blue-500 focus:ring-blue-500 text-sm text-slate-700">
                                <option value="">-- Tidak Pakai Voucher --</option>
                                @foreach($ownedVouchers as $voucher)
                                    <option value="{{ $voucher->id }}" data-discount="{{ $voucher->discount_percent }}">{{ $voucher->code }} (Diskon {{ $voucher->discount_percent }}%)</option>
                                @endforeach
                            </select>
                        @else
                            <div class="text-sm text-blue-700 bg-white/60 p-3 rounded-lg border border-blue-100 flex items-center justify-between">
                                <span>Anda belum memiliki voucher aktif.</span>
                                <a href="{{ route('vouchers.index') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-blue-700">Tukar Poin</a>
                            </div>
                        @endif
                    </div>
                @endauth

                <button type="submit" id="btnSubmit" disabled class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white font-bold py-3 rounded-xl transition-transform active:scale-95">
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
                        btn.className = 'py-2 rounded border text-sm font-medium transition-colors hover:bg-blue-50 hover:border-blue-300 border-slate-200 bg-white text-slate-700';
                        btn.onclick = () => toggleSlot(index);
                    } else {
                        btn.className = 'py-2 rounded border border-red-200 bg-red-50 text-red-400 text-sm font-medium cursor-not-allowed';
                        btn.disabled = true;
                    }
                    
                    grid.appendChild(btn);
                });
                
                document.getElementById('slotsGrid').classList.remove('hidden');
                document.getElementById('slotsError').classList.add('hidden');
            } catch (e) {
                console.error(e);
                const grid = document.getElementById('slotsGrid');
                grid.innerHTML = '';
                grid.classList.remove('hidden');
                const errorEl = document.getElementById('slotsError');
                errorEl.textContent = 'Gagal memuat jadwal. Silakan coba lagi.';
                errorEl.classList.remove('hidden');
            } finally {
                document.getElementById('slotsLoading').classList.add('hidden');
            }
        }

        function toggleSlot(index) {
            const btn = document.querySelector(`button[data-index="${index}"]`);
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
            
            // Limit to 4 hours (based on Supah Ano rules max 4 hours usually, or general rule)
            if (selectedSlots.length > 4) {
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
                    btn.className = 'py-2 rounded border border-green-500 bg-green-500 text-white text-sm font-bold shadow-md transform scale-105 transition-all';
                } else {
                    btn.className = 'py-2 rounded border text-sm font-medium transition-colors hover:bg-blue-50 hover:border-blue-300 border-slate-200 bg-white text-slate-700';
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
            const error = document.getElementById('slotsError');
            
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
