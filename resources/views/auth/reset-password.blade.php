<x-guest-layout>
    <div class="mb-7">
        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-accent">Password baru</p>
        <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-brand-900">Reset password</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500">Buat password baru agar akun SkyLine Airways Anda bisa digunakan kembali.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5" data-loading-form>
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 focus:border-brand-accent focus:ring-brand-accent" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Password baru" />
            <x-text-input id="password" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 focus:border-brand-accent focus:ring-brand-accent" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi password" />
            <x-text-input id="password_confirmation" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 focus:border-brand-accent focus:ring-brand-accent" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full rounded-xl bg-brand-900 px-5 py-3 font-bold text-white shadow-lg shadow-slate-300 transition hover:bg-brand-800">
            Simpan Password Baru
        </button>
    </form>
</x-guest-layout>
