<!-- Sidebar Overlay for Mobile -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm z-40 md:hidden" 
     style="display: none;"></div>

<!-- Sidebar -->
<aside :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full', sidebarExpanded ? 'md:w-[260px]' : 'md:w-[88px]']" 
       class="fixed inset-y-0 left-0 z-40 bg-white dark:bg-slate-900 border-r border-slate-100 dark:border-slate-800/80 flex flex-col md:translate-x-0 overflow-visible w-[260px] transition-all duration-300 ease-in-out">
    
    <!-- Logo Area -->
    <div class="h-20 flex items-center flex-shrink-0 relative" :class="sidebarExpanded ? 'px-6' : 'px-0 justify-center'">
        <a href="{{ route('dashboard') }}" class="flex items-center overflow-hidden">
            <x-application-logo class="h-8 w-auto fill-current text-brand-500 dark:text-brand-450 flex-shrink-0" />
            <span x-show="sidebarExpanded" class="ml-3 font-bold text-xl text-slate-800 dark:text-white tracking-tight whitespace-nowrap">anoBadmin</span>
        </a>
        
        <!-- Desktop Sidebar Toggle Button -->
        <button @click="sidebarExpanded = !sidebarExpanded" 
                class="absolute -right-3 top-7 bg-white dark:bg-slate-850 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 hover:text-brand-500 dark:hover:text-brand-400 rounded-full p-1 shadow-soft hidden md:flex items-center justify-center transition-transform z-50"
                :class="sidebarExpanded ? '' : 'rotate-180'">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-4 space-y-1.5" :class="sidebarExpanded ? 'px-4' : 'px-4'">
        
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex items-center py-3 rounded-2xl {{ request()->routeIs('dashboard') ? 'bg-brand-500 text-white font-semibold shadow-soft shadow-brand-500/20' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-850/50 hover:text-slate-800 dark:hover:text-white font-medium' }}" :class="sidebarExpanded ? 'px-4 justify-start' : 'px-0 justify-center'" title="Dashboard">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 dark:text-slate-400' }}" :class="sidebarExpanded ? 'mr-3.5' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span x-show="sidebarExpanded" class="whitespace-nowrap">Dashboard</span>
        </a>

        @if(auth()->user()->role === 'user')
            <!-- My Bookings -->
            <a href="{{ route('bookings.index') }}" class="flex items-center py-3 rounded-2xl {{ request()->routeIs('bookings.index') ? 'bg-brand-500 text-white font-semibold shadow-soft shadow-brand-500/20' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-850/50 hover:text-slate-800 dark:hover:text-white font-medium' }}" :class="sidebarExpanded ? 'px-4 justify-start' : 'px-0 justify-center'" title="My Bookings">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('bookings.index') ? 'text-white' : 'text-slate-400 dark:text-slate-400' }}" :class="sidebarExpanded ? 'mr-3.5' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <span x-show="sidebarExpanded" class="whitespace-nowrap">My Bookings</span>
            </a>
            
            <!-- Vouchers -->
            <a href="{{ route('vouchers.index') }}" class="flex items-center py-3 rounded-2xl {{ request()->routeIs('vouchers.index') ? 'bg-brand-500 text-white font-semibold shadow-soft shadow-brand-500/20' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-850/50 hover:text-slate-800 dark:hover:text-white font-medium' }}" :class="sidebarExpanded ? 'px-4 justify-start' : 'px-0 justify-center'" title="Vouchers">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('vouchers.index') ? 'text-white' : 'text-slate-400 dark:text-slate-400' }}" :class="sidebarExpanded ? 'mr-3.5' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                <span x-show="sidebarExpanded" class="whitespace-nowrap">Vouchers</span>
            </a>
            
            <!-- Membership -->
            <a href="{{ route('membership.index') }}" class="flex items-center py-3 rounded-2xl {{ request()->routeIs('membership.index') ? 'bg-brand-500 text-white font-semibold shadow-soft shadow-brand-500/20' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-850/50 hover:text-slate-800 dark:hover:text-white font-medium' }}" :class="sidebarExpanded ? 'px-4 justify-start' : 'px-0 justify-center'" title="Membership">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('membership.index') ? 'text-white' : 'text-slate-400 dark:text-slate-400' }}" :class="sidebarExpanded ? 'mr-3.5' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                <span x-show="sidebarExpanded" class="whitespace-nowrap">Membership</span>
            </a>
            
            <!-- Lokasi Lapangan -->
            <a href="https://www.google.com/maps/place/Rumah+Au/@-0.8296195,119.8979851,17z/data=!3m1!4b1!4m6!3m5!1s0x2d8be9006cc3b017:0x32363121fb4b03be!8m2!3d-0.8296249!4d119.90056!16s%2Fg%2F11yc2k239j?entry=ttu&g_ep=EgoyMDI2MDUyMC4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="flex items-center py-3 rounded-2xl text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-850/50 hover:text-slate-800 dark:hover:text-white font-medium" :class="sidebarExpanded ? 'px-4 justify-start' : 'px-0 justify-center'" title="Lokasi Lapangan">
                <svg class="w-5 h-5 flex-shrink-0 text-slate-400 dark:text-slate-500" :class="sidebarExpanded ? 'mr-3.5' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span x-show="sidebarExpanded" class="whitespace-nowrap">Lokasi Lapangan</span>
            </a>
        @endif

        @if(auth()->user()->role === 'admin')
            <!-- Kelola Membership -->
            <a href="{{ route('admin.memberships.index') }}" class="flex items-center py-3 rounded-2xl {{ request()->routeIs('admin.memberships.index') ? 'bg-brand-500 text-white font-semibold shadow-soft shadow-brand-500/20' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-850/50 hover:text-slate-800 dark:hover:text-white font-medium' }}" :class="sidebarExpanded ? 'px-4 justify-start' : 'px-0 justify-center'" title="Kelola Membership">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.memberships.index') ? 'text-white' : 'text-slate-400 dark:text-slate-400' }}" :class="sidebarExpanded ? 'mr-3.5' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span x-show="sidebarExpanded" class="whitespace-nowrap">Kelola Membership</span>
            </a>
            
            <!-- Kelola Voucher -->
            <a href="{{ route('admin.vouchers.index') }}" class="flex items-center py-3 rounded-2xl {{ request()->routeIs('admin.vouchers.index') ? 'bg-brand-500 text-white font-semibold shadow-soft shadow-brand-500/20' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-850/50 hover:text-slate-800 dark:hover:text-white font-medium' }}" :class="sidebarExpanded ? 'px-4 justify-start' : 'px-0 justify-center'" title="Kelola Voucher">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.vouchers.index') ? 'text-white' : 'text-slate-400 dark:text-slate-400' }}" :class="sidebarExpanded ? 'mr-3.5' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                <span x-show="sidebarExpanded" class="whitespace-nowrap">Kelola Voucher</span>
            </a>

            <!-- Kelola Lapangan -->
            <a href="{{ route('admin.courts.index') }}" class="flex items-center py-3 rounded-2xl {{ request()->routeIs('admin.courts.*') ? 'bg-brand-500 text-white font-semibold shadow-soft shadow-brand-500/20' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-850/50 hover:text-slate-800 dark:hover:text-white font-medium' }}" :class="sidebarExpanded ? 'px-4 justify-start' : 'px-0 justify-center'" title="Kelola Lapangan">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.courts.*') ? 'text-white' : 'text-slate-400 dark:text-slate-400' }}" :class="sidebarExpanded ? 'mr-3.5' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span x-show="sidebarExpanded" class="whitespace-nowrap">Kelola Lapangan</span>
            </a>
        @endif
        
    </div>

    <!-- User Profile & Logout (Bottom of Sidebar) -->
    <div class="p-4 mb-2">
        <div class="flex items-center rounded-2xl" :class="sidebarExpanded ? 'bg-slate-50 dark:bg-slate-850/60 p-3 justify-between border border-slate-100/50 dark:border-slate-800/40' : 'justify-center p-0'">
            <div class="flex items-center" :class="sidebarExpanded ? '' : 'justify-center'">
                <div class="w-10 h-10 rounded-full bg-brand-100 dark:bg-brand-900/40 flex items-center justify-center flex-shrink-0 border border-brand-200 dark:border-brand-800/60">
                    <span class="text-brand-700 dark:text-brand-400 font-bold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <div x-show="sidebarExpanded" class="ml-3 overflow-hidden">
                    <div class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ Auth::user()->email }}</div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" x-show="sidebarExpanded">
                @csrf
                <button type="submit" class="text-slate-400 hover:text-rose-500 hover:bg-white dark:hover:bg-slate-800 rounded-xl p-1.5 transition-colors focus:outline-none" title="Log Out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
    </div>
</aside>

