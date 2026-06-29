<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'SkyLine Airways'))</title>

    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Flatpickr (Untuk Date Picker di pencarian tiket) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">
    <div class="min-h-screen flex flex-col">
        
        <!-- Navbar Dinamis -->
        @include('layouts.navigation')

        <!-- Page Heading (Optional - untuk halaman yang butuh header khusus) -->
        @hasSection('header')
            <header class="bg-white shadow-sm border-b border-slate-200">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer Simple -->
        <footer class="bg-brand-900 text-slate-400 py-8 mt-auto">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p class="text-sm">&copy; {{ date('Y') }} SkyLine Airways. Project UKK SMK TI BAZMA.</p>
            </div>
        </footer>
    </div>

    <!-- Beautiful Toast Notification System using Alpine.js -->
    <div x-data="{ 
            toasts: [],
            add(message, type = 'success') {
                const id = Date.now();
                this.toasts.push({ id, message, type });
                setTimeout(() => this.remove(id), 5000);
            },
            remove(id) {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }
         }" 
         x-init="
            @if(session('success')) add('{{ session('success') }}', 'success'); @endif
            @if(session('error')) add('{{ session('error') }}', 'danger'); @endif
            @if(session('status')) add('{{ session('status') }}', 'info'); @endif
            @if($errors->any()) add('{{ $errors->first() }}', 'danger'); @endif
         "
         class="fixed bottom-5 right-5 z-[9999] flex flex-col gap-3 max-w-sm w-full pointer-events-none">
        
        <template x-for="toast in toasts" :key="toast.id">
            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-2 transform scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-2"
                 class="p-4 rounded-2xl shadow-xl flex items-center justify-between gap-3 border pointer-events-auto cursor-pointer"
                 :class="{
                    'bg-emerald-50 border-emerald-200 text-emerald-800': toast.type === 'success',
                    'bg-rose-50 border-rose-200 text-rose-800': toast.type === 'danger',
                    'bg-amber-50 border-amber-200 text-amber-800': toast.type === 'warning',
                    'bg-sky-50 border-sky-200 text-sky-800': toast.type === 'info',
                 }"
                 @click="remove(toast.id)">
                <div class="flex items-center gap-3">
                    <template x-if="toast.type === 'success'">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </template>
                    <template x-if="toast.type === 'danger'">
                        <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </template>
                    <template x-if="toast.type === 'info'">
                        <svg class="w-5 h-5 text-sky-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </template>
                    <span class="text-sm font-semibold" x-text="toast.message"></span>
                </div>
                <button class="text-slate-400 hover:text-slate-600 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </template>
    </div>

    <!-- Stack untuk script tambahan per halaman -->
    @stack('scripts')
</body>
</html>