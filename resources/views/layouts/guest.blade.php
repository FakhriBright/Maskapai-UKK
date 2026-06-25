<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SkyLine Airways') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-900">
    <main class="min-h-screen bg-slate-950">
        <div class="grid min-h-screen lg:grid-cols-[1.05fr_0.95fr]">
            <section class="relative hidden overflow-hidden lg:block">
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1800&auto=format&fit=crop')] bg-cover bg-center"></div>
                <div class="absolute inset-0 bg-slate-950/55"></div>
                <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-slate-950 to-transparent"></div>

                <div class="relative flex h-full flex-col justify-between p-12 text-white">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-accent text-brand-900 shadow-lg">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </span>
                        <span class="text-2xl font-extrabold tracking-tight">SkyLine <span class="text-brand-accent">Airways</span></span>
                    </a>

                    <div class="max-w-xl">
                        <p class="mb-4 text-sm font-semibold uppercase tracking-[0.28em] text-amber-300">Online flight system</p>
                        <h1 class="text-5xl font-extrabold leading-tight tracking-tight">Kelola perjalanan udara dengan alur yang lebih rapi.</h1>
                        <p class="mt-5 text-lg leading-8 text-slate-200">Cari penerbangan, kelola booking, check-in penumpang, dan pantau laporan dari satu sistem UKK yang konsisten.</p>
                    </div>
                </div>
            </section>

            <section class="flex min-h-screen items-center justify-center bg-slate-100 px-4 py-10 sm:px-6 lg:px-10">
                <div class="w-full max-w-md">
                    <div class="mb-8 text-center lg:hidden">
                        <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-accent text-brand-900 shadow">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </span>
                            <span class="text-2xl font-extrabold tracking-tight text-brand-900">SkyLine Airways</span>
                        </a>
                    </div>

                    <div class="rounded-2xl border border-white/70 bg-white p-6 shadow-xl shadow-slate-200/70 sm:p-8">
                        {{ $slot }}
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script>
        document.addEventListener('submit', function (event) {
            const form = event.target;
            const button = form.querySelector('button[type="submit"]');

            if (button && form.matches('[data-loading-form]')) {
                button.disabled = true;
                button.dataset.originalText = button.textContent;
                button.textContent = 'Memproses...';
            }
        });
    </script>
</body>
</html>
