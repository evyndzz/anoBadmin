<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
            {{ __('Kelola Membership') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-950 transition-colors duration-300 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Active Members Section -->
            <div class="card bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 shadow-soft rounded-4xl p-6 sm:p-8 transition-all duration-300">
                <div class="text-slate-800 dark:text-slate-100">
                    <h3 class="text-xl font-extrabold mb-5 flex items-center tracking-tight border-b border-slate-100 dark:border-slate-800 pb-3">
                        <svg class="w-6 h-6 mr-2.5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Daftar Pelanggan Membership Aktif
                    </h3>
                    @if($activeMembers->count() > 0)
                        <div class="overflow-x-auto rounded-2xl border border-slate-100 dark:border-slate-800 shadow-inner">
                            <table class="table-soft">
                                <thead>
                                    <tr>
                                        <th>Nama & Kontak</th>
                                        <th>Paket Membership</th>
                                        <th>Jadwal Sesi Terisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeMembers as $user)
                                        <tr>
                                            <td>
                                                <div class="font-extrabold text-slate-800 dark:text-slate-100 text-sm">{{ $user->name }}</div>
                                                <div class="text-xs text-slate-500 dark:text-slate-400 font-semibold mt-0.5">{{ $user->email }}</div>
                                            </td>
                                            <td>
                                                <span class="badge badge-success text-[10px] px-2.5 py-1 shadow-sm">{{ $user->membership->name }}</span>
                                            </td>
                                            <td>
                                                <div class="text-sm text-slate-800 dark:text-slate-200 space-y-1.5 py-1">
                                                    @forelse($user->memberSchedules as $sched)
                                                             <div class="flex items-center space-x-2 bg-slate-50/50 dark:bg-slate-950/40 px-3 py-1.5 rounded-xl border border-slate-100 dark:border-slate-850">
                                                            <div class="w-10 text-center text-[10px] font-black uppercase text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-950/40 border border-brand-100/30 dark:border-brand-900/20 px-1 py-0.5 rounded-lg">{{ substr($sched->days, 0, 3) }}</div>
                                                            <span class="font-mono text-xs font-bold text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse($sched->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($sched->end_time)->format('H:i') }}</span>
                                                            <span class="text-xs text-slate-400 dark:text-slate-500">• {{ $sched->court->name ?? '-' }}</span>
                                                        </div>
                                                    @empty
                                                        <span class="text-slate-400 dark:text-slate-600 italic font-medium text-xs">Belum mengambil sesi</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12 text-slate-500 dark:text-slate-450 bg-slate-50/50 dark:bg-slate-900/30 rounded-3xl border border-dashed border-slate-200 dark:border-slate-850">
                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <p class="text-sm font-semibold">Belum ada pelanggan yang berlangganan membership saat ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Manajemen Sesi -->
            <div class="card bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 shadow-soft rounded-4xl p-6 sm:p-8 transition-all duration-300">
                <div class="text-slate-800 dark:text-slate-100">
                    <h3 class="text-xl font-extrabold mb-2 flex items-center tracking-tight">
                        <svg class="w-6 h-6 mr-2.5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Manajemen Alokasi Sesi Membership
                    </h3>
                    <div class="text-sm text-slate-500 dark:text-slate-400 mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">Buat alokasi jadwal kosong yang nantinya dapat dipilih oleh pelanggan saat mereka membeli paket membership.</div>

                    <!-- List Memberships -->
                    <div class="space-y-8">
                        @foreach($memberships as $membership)
                        <div class="border border-slate-200 dark:border-slate-850 rounded-3xl overflow-hidden shadow-soft bg-white dark:bg-slate-900">
                            <div class="bg-brand-50/40 dark:bg-brand-950/20 px-6 py-4 flex justify-between items-center border-b border-brand-100/30 dark:border-brand-900/20">
                                <div>
                                    <h4 class="font-extrabold text-brand-700 dark:text-brand-400 text-lg tracking-tight">{{ $membership->name }}</h4>
                                    <p class="text-xs text-brand-600 dark:text-brand-500 font-bold mt-0.5">Rp {{ number_format($membership->price, 0, ',', '.') }} • {{ $membership->duration_months }} Bulan</p>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <!-- Tambah Jadwal Sesi -->
                                <form action="{{ route('admin.schedules.store', $membership) }}" method="POST" class="bg-slate-50/50 dark:bg-slate-950/40 p-5 rounded-3xl border border-slate-200 dark:border-slate-850 shadow-inner mb-6 space-y-4" id="form_schedule_{{ $membership->id }}" onsubmit="return validateScheduleForm({{ $membership->id }})">
                                    <div class="text-sm font-extrabold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        Buat Sesi Lapangan Baru
                                    </div>
                                    @csrf
                                    <input type="hidden" name="start_time" id="start_time_{{ $membership->id }}">
                                    <input type="hidden" name="end_time" id="end_time_{{ $membership->id }}">
                                                                      <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                                        <div class="md:col-span-2">
                                            <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">Pilih Lapangan</label>
                                            <select name="court_id" id="court_{{ $membership->id }}" required class="input text-sm" onchange="renderSlots({{ $membership->id }})">
                                                @foreach(\App\Models\Court::all() as $court)
                                                    <option value="{{ $court->id }}">{{ $court->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-1.5">Hari Main</label>
                                            <select name="days" id="day_{{ $membership->id }}" required class="input text-sm" onchange="renderSlots({{ $membership->id }})">
                                                <option value="Senin">Senin</option>
                                                <option value="Selasa">Selasa</option>
                                                <option value="Rabu">Rabu</option>
                                                <option value="Kamis">Kamis</option>
                                                <option value="Jumat">Jumat</option>
                                                <option value="Sabtu">Sabtu</option>
                                                <option value="Minggu">Minggu</option>
                                            </select>
                                        </div>
                                        <div>
                                            <button type="submit" id="btn_submit_{{ $membership->id }}" disabled class="btn-primary w-full py-3 rounded-2xl text-xs disabled:bg-slate-200 dark:disabled:bg-slate-800 disabled:text-slate-400 dark:disabled:text-slate-600 disabled:shadow-none disabled:transform-none">Simpan Sesi</button>
                                        </div>
                                        <div class="md:col-span-5 mt-1">
                                            <label class="label block text-xs font-bold text-slate-700 dark:text-slate-400 mb-2.5">Pilih Jam (Pilih berurutan. Jam merah = sudah terisi membership lain)</label>
                                            <div id="slots_grid_{{ $membership->id }}" class="flex flex-wrap gap-2.5">
                                                <!-- JS will populate this -->
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- List Sesi -->
                                @if($membership->schedules->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($membership->schedules as $schedule)
                                        <div class="flex justify-between items-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 p-4 rounded-2xl hover:border-brand-300 dark:hover:border-brand-700 shadow-soft hover:shadow-soft-lg transition-all duration-300 group">
                                            <div class="flex items-center space-x-3.5">
                                                <div class="w-12 h-12 rounded-xl {{ $schedule->is_available ? 'bg-brand-50 dark:bg-brand-950/40 text-brand-600 dark:text-brand-400 border border-brand-100/50 dark:border-brand-900/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }} flex items-center justify-center font-black text-xs uppercase shadow-sm shrink-0">
                                                    {{ substr($schedule->days, 0, 3) }}
                                                </div>
                                                <div>
                                                    <div class="font-extrabold {{ $schedule->is_available ? 'text-slate-800 dark:text-slate-200' : 'text-slate-500' }} text-sm flex items-center">
                                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB
                                                        @if(!$schedule->is_available)
                                                            <span class="ml-2 text-[9px] uppercase tracking-wider bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 border border-rose-100/30 dark:border-rose-900/20 px-2 py-0.5 rounded-lg font-black">Terisi</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center mt-1 font-semibold">
                                                        <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                        {{ $schedule->court->name ?? '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Hapus sesi ini?')" class="text-rose-500 hover:text-rose-600 p-2 rounded-xl hover:bg-rose-50 dark:hover:bg-rose-950/30 border border-transparent hover:border-rose-100 dark:hover:border-rose-900/30 transition shadow-sm md:opacity-0 md:group-hover:opacity-100 shrink-0">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-10 bg-slate-50/50 dark:bg-slate-900/20 border border-slate-200 dark:border-slate-850 rounded-3xl border-dashed">
                                        <p class="text-sm font-bold text-slate-500 dark:text-slate-450">Belum ada sesi pertemuan yang diatur.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script moved from admin dashboard -->
    <script>
        const allSchedules = @json($memberships->pluck('schedules')->flatten());
        const memberships = @json($memberships->pluck('id'));

        let selectedSlots = {};

        function renderSlots(membershipId) {
            const courtId = document.getElementById(`court_${membershipId}`).value;
            const day = document.getElementById(`day_${membershipId}`).value;
            const grid = document.getElementById(`slots_grid_${membershipId}`);
            
            if (!grid) return;
            grid.innerHTML = '';
            
            selectedSlots[membershipId] = [];
            updateFormInputs(membershipId);

            if (!courtId || !day) return;

            const isDark = document.documentElement.classList.contains('dark');

            for (let i = 8; i <= 23; i++) {
                const timeStr = i.toString().padStart(2, '0') + ':00';
                
                let isBooked = false;
                allSchedules.forEach(sched => {
                    if (sched.court_id == courtId && sched.days.toLowerCase() === day.toLowerCase()) {
                        const sH = parseInt(sched.start_time.split(':')[0]);
                        const eH = parseInt(sched.end_time.split(':')[0]);
                        if (i >= sH && i < eH) {
                            isBooked = true;
                        }
                    }
                });

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = timeStr;
                btn.dataset.hour = i;
                
                if (isBooked) {
                    btn.className = 'px-3 py-2.5 rounded-2xl bg-rose-50/50 dark:bg-rose-950/20 text-rose-600 dark:text-rose-400 text-xs font-extrabold cursor-not-allowed border border-rose-100/50 dark:border-rose-900/10 opacity-50';
                    btn.disabled = true;
                } else {
                    btn.className = 'slot-btn px-3 py-2.5 rounded-2xl bg-white dark:bg-slate-900 text-brand-600 dark:text-brand-450 border border-slate-200 dark:border-slate-800 hover:bg-brand-50/50 dark:hover:bg-brand-950/20 hover:border-brand-300 dark:hover:border-brand-700 transition-all shadow-sm font-bold text-xs';
                    btn.onclick = () => toggleAdminSlot(membershipId, i);
                }
                
                grid.appendChild(btn);
            }
        }

        function toggleAdminSlot(membershipId, hour) {
            let slots = selectedSlots[membershipId] || [];
            const idx = slots.indexOf(hour);
            
            if (idx > -1) {
                slots = slots.filter(h => h < hour);
            } else {
                if (slots.length > 0) {
                    const maxH = Math.max(...slots);
                    if (hour !== maxH + 1) {
                        slots = [hour];
                    } else {
                        slots.push(hour);
                    }
                } else {
                    slots.push(hour);
                }
            }
            selectedSlots[membershipId] = slots;
            
            const grid = document.getElementById(`slots_grid_${membershipId}`);
            grid.querySelectorAll('.slot-btn').forEach(btn => {
                const h = parseInt(btn.dataset.hour);
                if (slots.includes(h)) {
                    btn.className = 'slot-btn px-3 py-2.5 rounded-2xl bg-brand-500 text-white border-brand-500 shadow-soft shadow-brand-500/20 transition-all font-bold text-xs transform scale-105';
                } else {
                    btn.className = 'slot-btn px-3 py-2.5 rounded-2xl bg-white dark:bg-slate-900 text-brand-600 dark:text-brand-450 border border-slate-200 dark:border-slate-800 hover:bg-brand-50/50 dark:hover:bg-brand-950/20 hover:border-brand-300 dark:hover:border-brand-700 transition-all shadow-sm font-bold text-xs';
                }
            });

            updateFormInputs(membershipId);
        }

        function updateFormInputs(membershipId) {
            const slots = selectedSlots[membershipId] || [];
            const startInput = document.getElementById(`start_time_${membershipId}`);
            const endInput = document.getElementById(`end_time_${membershipId}`);
            const btnSubmit = document.getElementById(`btn_submit_${membershipId}`);
            
            if (slots.length > 0) {
                const minH = Math.min(...slots);
                const maxH = Math.max(...slots) + 1;
                startInput.value = minH.toString().padStart(2, '0') + ':00';
                endInput.value = maxH.toString().padStart(2, '0') + ':00';
                btnSubmit.disabled = false;
            } else {
                startInput.value = '';
                endInput.value = '';
                btnSubmit.disabled = true;
            }
        }

        function validateScheduleForm(membershipId) {
            const slots = selectedSlots[membershipId] || [];
            if (slots.length === 0) {
                alert('Silakan pilih minimal 1 jam untuk jadwal sesi.');
                return false;
            }
            return true;
        }

        document.addEventListener('DOMContentLoaded', () => {
            memberships.forEach(id => {
                renderSlots(id);
            });
        });
    </script>
</x-app-layout>
