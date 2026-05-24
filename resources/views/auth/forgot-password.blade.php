<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-slate-850 dark:text-white">Lupa Password?</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
            Masukkan email Anda, dan kami akan mengirimkan link reset password untuk membuat yang baru.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6 flex flex-col items-center space-y-4">
            <x-primary-button class="w-full">
                {{ __('Kirim Link Reset Password') }}
            </x-primary-button>
            
            <a href="{{ route('login') }}" class="text-sm font-semibold text-brand-500 dark:text-brand-400 hover:underline">
                Kembali ke halaman masuk
            </a>
        </div>
    </form>
</x-guest-layout>
