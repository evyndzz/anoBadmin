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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-slate-900 dark:text-white transition-colors duration-300" 
          x-data="{ 
              sidebarOpen: false, 
              sidebarExpanded: localStorage.getItem('sidebarExpanded') === null ? true : localStorage.getItem('sidebarExpanded') === 'true' 
          }"
          x-init="$watch('sidebarExpanded', val => localStorage.setItem('sidebarExpanded', val))">
        
        @include('layouts.navigation')

        <!-- Main Content Wrapper -->
        <div class="flex flex-col min-h-screen transition-all duration-300 ease-in-out" :class="sidebarExpanded ? 'md:pl-[260px]' : 'md:pl-[88px]'">
            <!-- Mobile Header & Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-slate-900 border-b border-gray-100 dark:border-slate-800 sticky top-0 z-30 transition-colors duration-300">
                    <div class="w-full py-4 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                        <div class="flex items-center">
                            <!-- Hamburger button for mobile -->
                            <button @click="sidebarOpen = true" class="md:hidden mr-4 p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg focus:outline-none transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                            


                            {{ $header }}
                        </div>
                        
                        <!-- Top Right Tools (Dark Mode Toggle) -->
                        <div class="flex items-center space-x-3 relative">
                            <button @click="darkMode = !darkMode" class="p-2 text-gray-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-full transition-colors focus:outline-none">
                                <svg x-show="darkMode" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                            </button>
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                <div class="p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
