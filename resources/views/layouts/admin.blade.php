@php
    $role = auth()->user()->role ?? 'admin';
    $panelLabel = match ($role) {
        'manager' => 'Manager',
        'staff' => 'Staff',
        default => 'Admin',
    };

    $dashboardRoute = match ($role) {
        'manager' => 'manager.dashboard',
        'staff' => 'staff.dashboard',
        default => 'admin.dashboard',
    };

    $navItems = match ($role) {
        'manager' => [
            ['label' => 'Dashboard', 'route' => 'manager.dashboard', 'active' => 'manager.dashboard', 'icon' => 'chart'],
            ['label' => 'Laporan', 'route' => 'manager.report.index', 'active' => 'manager.report.*', 'icon' => 'report'],
        ],
        'staff' => [
            ['label' => 'Dashboard', 'route' => 'staff.dashboard', 'active' => 'staff.dashboard', 'icon' => 'grid'],
        ],
        default => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'icon' => 'grid'],
            ['label' => 'Maskapai', 'route' => 'admin.airlines.index', 'active' => 'admin.airlines.*', 'icon' => 'plane'],
            ['label' => 'Bandara', 'route' => 'admin.airports.index', 'active' => 'admin.airports.*', 'icon' => 'globe'],
            ['label' => 'Pesawat', 'route' => 'admin.airplanes.index', 'active' => 'admin.airplanes.*', 'icon' => 'plane'],
            ['label' => 'Jadwal Penerbangan', 'route' => 'admin.flights.index', 'active' => 'admin.flights.*', 'icon' => 'clock'],
            ['label' => 'Manajemen User', 'route' => 'admin.users.index', 'active' => 'admin.users.*', 'icon' => 'users'],
        ],
    };
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $panelLabel . ' Panel - SkyLine Airways')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
</head>
<body class="bg-slate-100 text-slate-800 antialiased" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="flex h-screen overflow-hidden">
        <aside class="hidden w-72 flex-col bg-brand-900 text-white shadow-xl md:flex">
            <div class="flex h-16 items-center gap-3 border-b border-slate-700 px-6">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-accent text-brand-900">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </span>
                <div>
                    <div class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">SkyLine</div>
                    <div class="text-lg font-extrabold leading-none">{{ $panelLabel }} Panel</div>
                </div>
            </div>

            <nav class="flex-1 space-y-2 overflow-y-auto px-4 py-6">
                @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs($item['active']) ? 'bg-brand-accent text-brand-900 shadow-lg shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        @switch($item['icon'])
                            @case('chart')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3v18m4-14v14m4-10v10M3 13v8m4-12v12"></path></svg>
                                @break
                            @case('report')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m4 6V7m4 10v-3M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"></path></svg>
                                @break
                            @case('globe')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0 0c2.5-2.4 3.75-5.4 3.75-9S14.5 5.4 12 3m0 18c-2.5-2.4-3.75-5.4-3.75-9S9.5 5.4 12 3m-8 9h16"></path></svg>
                                @break
                            @case('clock')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @break
                            @case('users')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m6-6a4 4 0 11-8 0 4 4 0 018 0zm6 2a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                @break
                            @case('plane')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                @break
                            @default
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h4a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v12a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h4a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z"></path></svg>
                        @endswitch
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="border-t border-slate-700 p-4">
                <div class="mb-4 rounded-xl bg-slate-800/70 p-3">
                    <div class="text-sm font-bold">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="text-xs uppercase tracking-wide text-slate-400">{{ $role }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-red-300 transition hover:bg-slate-800 hover:text-red-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col overflow-hidden">
            <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 shadow-sm md:px-6">
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">{{ $panelLabel }} Area</div>
                    <div class="font-extrabold text-brand-900">SkyLine Airways</div>
                </div>
                <a href="{{ route($dashboardRoute) }}" class="rounded-xl bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-200">
                    Dashboard
                </a>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-100 p-4 md:p-6">
                @if(session('success'))
                    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('submit', function (event) {
            const form = event.target;
            const deleteMethod = form.querySelector('input[name="_method"][value="DELETE"]');

            if (form.matches('[data-confirm]') && !confirm(form.dataset.confirm)) {
                event.preventDefault();
                return;
            }

            if (deleteMethod && !confirm('Yakin ingin menghapus data ini?')) {
                event.preventDefault();
                return;
            }

            const button = form.querySelector('button[type="submit"]');
            if (button && form.matches('[data-loading-form]')) {
                button.disabled = true;
                button.dataset.originalText = button.textContent;
                button.textContent = 'Memproses...';
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
