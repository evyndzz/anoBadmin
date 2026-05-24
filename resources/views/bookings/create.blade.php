<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
            {{ __('Tambah Transaksi (Booking Lapangan)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 shadow-soft rounded-4xl p-6 sm:p-8 transition-all duration-300">
                <h3 class="text-xl font-extrabold text-slate-800 dark:text-white mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">Pilih Lapangan & Jadwal</h3>
                
                <form action="{{ route('book.store') }}" method="POST" id="bookingForm" onsubmit="return validateForm()">
                    @csrf
                    <input type="hidden" name="start_time" id="inputStartTime">
                    <input type="hidden" name="duration" id="inputDuration">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <label class="label block text-sm font-bold text-slate-700 dark:text-slate-400 mb-2">Pilih Lapangan</label>
                            <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($courts as $court)
                                <label class="flex items-center p-4 border border-slate-200 dark:border-slate-800 rounded-2xl cursor-pointer hover:bg-brand-50/50 dark:hover:bg-brand-950/20 hover:border-brand-300 dark:hover:border-brand-800 transition-all duration-300 has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50/40 dark:has-[:checked]:bg-brand-950/15 has-[:checked]:ring-1 has-[:checked]:ring-brand-500 dark:bg-slate-900/50">
                                    <input type="radio" name="court_id" value="{{ $court->id }}" required class="text-brand-500 focus:ring-brand-500 dark:bg-slate-850 dark:border-slate-750 mr-4 cursor-pointer" onchange="selectCourt({{ $court->id }}, {{ $court->price_per_hour }})">
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl overflow-hidden flex-shrink-0 mr-4 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-750">
                                        <img src="{{ $court->image ?? 'https://storage.googleapis.com/data.ayo.co.id/photos/77445/SEO%20HDI%202/16.%20Kelebihan%20dan%20Kekurangan%20Lapangan%20Badminton%20Sintetis%20yang%20Perlu%20Diketahui.jpg' }}" alt="{{ $court->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-extrabold text-slate-800 dark:text-slate-100 text-lg">{{ $court->name }}</div>
                                        <div class="text-sm text-brand-600 dark:text-brand-400 font-bold mb-1">Rp {{ number_format($court->price_per_hour, 0, ',', '.') }} <span class="font-normal text-slate-500 dark:text-slate-400">/ jam</span></div>
                                        @if($court->description)
                                            <div class="text-xs text-slate-500 dark:text-slate-450 line-clamp-1">{{ $court->description }}</div>
                                        @endif
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                             <div class="mb-6">
                                <label class="label block text-sm font-bold text-slate-700 dark:text-slate-400 mb-2">Tanggal Main</label>
                                <input type="date" name="date" id="inputDate" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" onchange="fetchSlots()" class="input w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:border-brand-400 dark:focus:border-brand-500 focus:ring-2 focus:ring-brand-400/20 dark:focus:ring-brand-500/20 shadow-inner outline-none transition duration-200">
                            </div>

                            <div id="slotsContainer" class="opacity-50 pointer-events-none transition-opacity duration-300">
                                <div class="flex justify-between items-center mb-2">
                                    <label class="label block text-sm font-bold text-slate-700 dark:text-slate-400">Pilih Jam</label>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">Pilih lapangan terlebih dahulu, lalu klik jam yang tersedia (bisa lebih dari 1 jam berurutan).</p>
                                
                                <div id="slotsLoading" class="text-center py-4 text-brand-500 hidden">
                                    <svg class="animate-spin h-6 w-6 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </div>

                                <div id="slotsError" class="text-center py-4 text-rose-500 text-sm font-semibold hidden">
                                    Gagal memuat jadwal.
                                </div>

                                <div id="slotsGrid" class="grid grid-cols-4 sm:grid-cols-5 gap-2">
                                    <!-- Filled by JS -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50/50 dark:bg-slate-900/40 p-6 rounded-3xl border border-slate-200 dark:border-slate-800/85 mb-6 shadow-inner">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-slate-600 dark:text-slate-350 font-bold">Total Harga (<span id="displayDuration" class="font-extrabold text-brand-600 dark:text-brand-400">0</span> Jam)</span>
                            <span class="text-3xl font-black text-brand-500 dark:text-brand-400" id="displayPrice">Rp 0</span>
                        </div>

                        @if(auth()->user()->role === 'user')
                            <div class="mt-4 border-t border-slate-200 dark:border-slate-800 pt-4">
                                <label class="label block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                    Voucher Promo
                                </label>
                                @if(isset($promos) && count($promos) > 0)
                                    <select name="promo_id" id="promoSelect" onchange="updatePriceDisplay()" class="input w-full md:w-1/2 rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:border-brand-400 dark:focus:border-brand-500 focus:ring-2 focus:ring-brand-400/20 dark:focus:ring-brand-500/20 shadow-inner outline-none transition duration-200 text-sm">
                                        <option value="">-- Tidak Pakai Voucher --</option>
                                        @foreach($promos as $promo)
                                            <option value="{{ $promo->id }}" data-discount="{{ $promo->discount_percent }}">{{ $promo->code }} (Diskon {{ $promo->discount_percent }}%)</option>
                                        @endforeach
                                    </select>
                                @else
                                    <div class="text-sm text-slate-500 dark:text-slate-450 italic">Anda tidak memiliki voucher aktif.</div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('dashboard') }}" class="btn-secondary">Batal</a>
                        <button type="submit" id="btnSubmit" disabled class="btn-primary disabled:bg-slate-200 dark:disabled:bg-slate-800 disabled:text-slate-400 dark:disabled:text-slate-600 disabled:shadow-none disabled:transform-none">
                            Konfirmasi Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentCourtId = null;
        let currentPrice = 0;
        let selectedSlots = [];
        let slotsData = [];

        function selectCourt(courtId, price) {
            currentCourtId = courtId;
            currentPrice = price;
            
            const container = document.getElementById('slotsContainer');
            container.classList.remove('opacity-50', 'pointer-events-none');
            
            fetchSlots();
        }

        async function fetchSlots() {
            if (!currentCourtId) return;
            
            const date = document.getElementById('inputDate').value;
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
                        btn.className = 'py-2.5 rounded-2xl border text-sm font-semibold transition-all duration-200 hover:bg-brand-50/50 dark:hover:bg-brand-950/20 hover:border-brand-400 dark:hover:border-brand-700 border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 shadow-sm';
                        btn.onclick = () => toggleSlot(index);
                    } else {
                        btn.className = 'py-2.5 rounded-2xl border border-slate-100/50 dark:border-slate-800/40 bg-slate-50/50 dark:bg-slate-950/50 text-slate-400 dark:text-slate-600 text-sm font-semibold cursor-not-allowed opacity-50';
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
                errorEl.classList.remove('hidden');
            } finally {
                document.getElementById('slotsLoading').classList.add('hidden');
            }
        }

        function toggleSlot(index) {
            const slotIndex = selectedSlots.indexOf(index);
            
            if (slotIndex > -1) {
                selectedSlots = selectedSlots.filter(i => i < index);
            } else {
                if (selectedSlots.length > 0) {
                    const maxSelected = Math.max(...selectedSlots);
                    if (index !== maxSelected + 1) {
                        selectedSlots = [index];
                    } else {
                        selectedSlots.push(index);
                    }
                } else {
                    selectedSlots.push(index);
                }
            }
            
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
                    btn.className = 'py-2.5 rounded-2xl border border-brand-500 bg-brand-500 text-white text-sm font-extrabold shadow-soft shadow-brand-500/20 transform scale-105 transition-all duration-200';
                } else {
                    btn.className = 'py-2.5 rounded-2xl border text-sm font-semibold transition-all duration-200 hover:bg-brand-50/50 dark:hover:bg-brand-950/20 hover:border-brand-400 dark:hover:border-brand-700 border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 shadow-sm';
                }
            });
        }

        function updatePriceDisplay() {
            const duration = selectedSlots.length;
            let total = currentPrice * duration;
            
            const promoSelect = document.getElementById('promoSelect');
            if (promoSelect && promoSelect.value && duration > 0) {
                const discountOption = promoSelect.options[promoSelect.selectedIndex];
                const discountPercent = parseFloat(discountOption.getAttribute('data-discount'));
                if (!isNaN(discountPercent)) {
                    total = total - (total * (discountPercent / 100));
                }
            }

            document.getElementById('displayDuration').textContent = duration;
            document.getElementById('displayPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
            
            const btnSubmit = document.getElementById('btnSubmit');
            
            if (duration > 0) {
                btnSubmit.disabled = false;
                
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
                alert('Silakan pilih minimal 1 jam permainan.');
                return false;
            }
            return true;
        }
    </script>
</x-app-layout>
