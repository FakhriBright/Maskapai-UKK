<x-guest-layout>
    <div class="mb-7">
        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-accent">Masuk akun</p>
        <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-brand-900">Selamat datang kembali</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500">Gunakan akun SkyLine Airways untuk masuk ke dashboard sesuai role Anda.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5" data-loading-form>
        @csrf

        <div>
            <x-input-label for="email" value="Email" class="text-slate-700" />
            <x-text-input id="email" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 focus:border-brand-accent focus:ring-brand-accent" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" value="Password" class="text-slate-700" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-semibold text-brand-900 hover:text-brand-accent" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 focus:border-brand-accent focus:ring-brand-accent"
                type="password"
                name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="flex items-center gap-3 text-sm text-slate-600">
            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-brand-accent shadow-sm focus:ring-brand-accent" name="remember">
            Ingat saya di perangkat ini
        </label>

        <button type="submit" class="w-full rounded-xl bg-brand-900 px-5 py-3 font-bold text-white shadow-lg shadow-slate-300 transition hover:bg-brand-800 disabled:cursor-not-allowed disabled:opacity-70">
            Masuk
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-bold text-brand-900 hover:text-brand-accent">Daftar sebagai customer</a>
    </p>
</x-guest-layout>
