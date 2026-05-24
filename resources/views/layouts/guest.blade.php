<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" 
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" 
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Anti-FOUC Script -->
        <script>
            if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 dark:text-slate-100 bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
        <!-- Pastel Emerald Gradient Background -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-tr from-brand-50 via-teal-50/30 to-emerald-100/50 dark:from-slate-950 dark:via-slate-900/40 dark:to-brand-950/20 relative">
            
            <!-- Fixed Top-Right Dark Mode Toggle -->
            <div class="absolute top-4 right-4">
                <button @click="darkMode = !darkMode" aria-label="Toggle Dark Mode" class="p-2.5 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border border-slate-200/50 dark:border-slate-800 shadow-soft hover:shadow-soft-lg text-slate-500 dark:text-slate-400 hover:text-brand-500 dark:hover:text-brand-450 rounded-full transition-all duration-300 focus:outline-none">
                    <svg x-show="darkMode" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>
            </div>

            <!-- Logo -->
            <div class="mb-6 transform hover:scale-105 transition-transform duration-300">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-brand-500" />
                </a>
            </div>

            <!-- Centered Card -->
            <div class="w-full sm:max-w-md px-8 py-8 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md shadow-soft-lg border border-slate-100 dark:border-slate-800/80 rounded-3xl overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
