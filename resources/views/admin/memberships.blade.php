<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Membership') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Active Members Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-slate-100">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Daftar Pelanggan Membership Aktif
                    </h3>
                    @if($activeMembers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border rounded-xl overflow-hidden">
                                <thead class="bg-indigo-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Nama & Kontak</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Paket Membership</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Jadwal Sesi Terisi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($activeMembers as $user)
                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-800 shadow-sm">{{ $user->membership->name }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 space-y-1">
                                                    @forelse($user->memberSchedules as $sched)
                                                        <div class="flex items-center space-x-2 bg-slate-50 px-2 py-1 rounded border border-slate-100">
                                                            <div class="w-8 text-center text-xs font-bold uppercase text-indigo-600 bg-indigo-50 rounded">{{ substr($sched->days, 0, 3) }}</div>
                                                            <span class="font-mono text-xs">{{ \Carbon\Carbon::parse($sched->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($sched->end_time)->format('H:i') }}</span>
                                                            <span class="text-xs text-gray-500">• {{ $sched->court->name ?? '-' }}</span>
                                                        </div>
                                                    @empty
                                                        <span class="text-slate-400 italic">Belum mengambil sesi</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Belum ada pelanggan yang berlangganan membership saat ini.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Manajemen Sesi (Copied from previous dashboard) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-slate-100">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Manajemen Alokasi Sesi Membership
                    </h3>
                    <div class="text-sm text-slate-500 mb-6">Buat alokasi jadwal kosong yang nantinya dapat dipilih oleh pelanggan saat mereka membeli paket membership.</div>

                    <!-- List Memberships -->
                    <div class="space-y-6">
                        @foreach($memberships as $membership)
                        <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                            <div class="bg-indigo-50 px-4 py-3 flex justify-between items-center border-b border-indigo-100">
                                <div>
                                    <h4 class="font-bold text-indigo-900 text-lg">{{ $membership->name }}</h4>
                                    <p class="text-xs text-indigo-700">Rp {{ number_format($membership->price, 0, ',', '.') }} • {{ $membership->duration_months }} Bulan</p>
                                </div>
                            </div>
                            
                            <div class="p-5">
                                <!-- Tambah Jadwal Sesi -->
                                <form action="{{ route('admin.schedules.store', $membership) }}" method="POST" class="bg-slate-50 p-4 rounded-xl border border-slate-200 mb-5" id="form_schedule_{{ $membership->id }}" onsubmit="return validateScheduleForm({{ $membership->id }})">
                                    <div class="mb-3 text-sm font-bold text-slate-700 flex items-center">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        Buat Sesi Lapangan Baru
                                    </div>
                                    @csrf
                                    <input type="hidden" name="start_time" id="start_time_{{ $membership->id }}">
                                    <input type="hidden" name="end_time" id="end_time_{{ $membership->id }}">
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Lapangan</label>
                                            <select name="court_id" id="court_{{ $membership->id }}" required class="w-full text-sm rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm" onchange="renderSlots({{ $membership->id }})">
                                                @foreach(\App\Models\Court::all() as $court)
                                                    <option value="{{ $court->id }}">{{ $court->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Hari Main</label>
                                            <select name="days" id="day_{{ $membership->id }}" required class="w-full text-sm rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm" onchange="renderSlots({{ $membership->id }})">
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
                                            <button type="submit" id="btn_submit_{{ $membership->id }}" disabled class="w-full bg-indigo-600 disabled:bg-slate-300 disabled:cursor-not-allowed text-white py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition shadow-sm">Simpan Sesi</button>
                                        </div>
                                        <div class="md:col-span-5 mt-1">
                                            <label class="block text-xs font-bold text-slate-700 mb-2">Pilih Jam (Pilih berurutan. Jam merah = sudah terisi membership lain)</label>
                                            <div id="slots_grid_{{ $membership->id }}" class="flex flex-wrap gap-2">
                                                <!-- JS will populate this -->
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- List Sesi -->
                                @if($membership->schedules->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @foreach($membership->schedules as $schedule)
                                        <div class="flex justify-between items-center bg-white border border-slate-200 p-3 rounded-xl hover:border-indigo-300 hover:shadow-sm transition group">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 rounded-lg {{ $schedule->is_available ? 'bg-indigo-50 text-indigo-600' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center font-bold text-xs uppercase">
                                                    {{ substr($schedule->days, 0, 3) }}
                                                </div>
                                                <div>
                                                    <div class="font-bold {{ $schedule->is_available ? 'text-slate-800' : 'text-slate-500' }} text-sm flex items-center">
                                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB
                                                        @if(!$schedule->is_available)
                                                            <span class="ml-2 text-[10px] bg-amber-100 text-amber-800 px-1.5 py-0.5 rounded font-bold">Terisi</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-xs text-slate-500 flex items-center mt-0.5">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                        {{ $schedule->court->name ?? '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Hapus sesi ini?')" class="text-red-400 hover:text-red-600 p-1.5 rounded-lg hover:bg-red-50 transition opacity-0 group-hover:opacity-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-6 bg-slate-50 border border-slate-100 rounded-xl border-dashed">
                                        <p class="text-sm font-medium text-slate-500">Belum ada sesi pertemuan yang diatur.</p>
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
                    btn.className = 'px-3 py-1.5 rounded-lg bg-red-50 text-red-400 text-xs font-bold cursor-not-allowed border border-red-100 opacity-60';
                    btn.disabled = true;
                } else {
                    btn.className = 'slot-btn px-3 py-1.5 rounded-lg bg-white text-indigo-600 text-xs font-bold border border-indigo-200 hover:bg-indigo-50 hover:border-indigo-300 transition-colors shadow-sm';
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
                    btn.className = 'slot-btn px-3 py-1.5 rounded-lg bg-indigo-600 text-white text-xs font-bold border border-indigo-600 shadow transition-all transform scale-105';
                } else {
                    btn.className = 'slot-btn px-3 py-1.5 rounded-lg bg-white text-indigo-600 text-xs font-bold border border-indigo-200 hover:bg-indigo-50 hover:border-indigo-300 transition-colors shadow-sm';
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
