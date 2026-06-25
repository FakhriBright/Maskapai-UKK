<x-guest-layout>
    <div class="mb-7">
        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-accent">Konfirmasi keamanan</p>
        <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-brand-900">Masukkan password</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500">Area ini membutuhkan verifikasi ulang sebelum Anda melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5" data-loading-form>
        @csrf

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 focus:border-brand-accent focus:ring-brand-accent"
                type="password"
                name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit" class="w-full rounded-xl bg-brand-900 px-5 py-3 font-bold text-white shadow-lg shadow-slate-300 transition hover:bg-brand-800">
            Konfirmasi
        </button>
    </form>
</x-guest-layout>
