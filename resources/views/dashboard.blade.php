<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-slate-850 dark:text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-white dark:bg-slate-900 shadow-soft rounded-3xl p-6 text-slate-800 dark:text-slate-100">
                {{ __("Anda berhasil masuk!") }}
            </div>
        </div>
    </div>
</x-app-layout>
