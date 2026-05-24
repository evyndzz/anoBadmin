<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
            {{ __('Pengaturan Profil') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-950 transition-colors duration-300 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Update Profile Information Card -->
            <div class="card bg-white dark:bg-slate-900 border border-slate-150 dark:border-slate-850 shadow-soft rounded-4xl p-6 sm:p-8 transition-all duration-300">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="card bg-white dark:bg-slate-900 border border-slate-150 dark:border-slate-850 shadow-soft rounded-4xl p-6 sm:p-8 transition-all duration-300">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Logout Securely Card -->
            <div class="card bg-white dark:bg-slate-900 border border-slate-150 dark:border-slate-850 shadow-soft rounded-4xl p-6 sm:p-8 transition-all duration-300">
                <div class="max-w-xl">
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-lg font-extrabold text-slate-800 dark:text-slate-100">
                                {{ __('Logout dari Sistem') }}
                            </h2>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                {{ __('Akhiri sesi Anda saat ini dengan aman.') }}
                            </p>
                        </header>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-danger shadow-soft shadow-rose-500/20 active:scale-98 transition-transform">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </section>
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="card bg-white dark:bg-slate-900 border border-slate-150 dark:border-slate-850 shadow-soft rounded-4xl p-6 sm:p-8 transition-all duration-300">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
