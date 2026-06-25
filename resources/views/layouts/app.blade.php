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

    <!-- Stack untuk script tambahan per halaman -->
    @stack('scripts')
</body>
</html>