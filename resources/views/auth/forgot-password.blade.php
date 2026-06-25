<x-guest-layout>
    <div class="mb-7">
        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-accent">Reset akses</p>
        <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-brand-900">Lupa password?</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500">Masukkan email akun Anda, lalu sistem akan mengirim link reset password.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5" data-loading-form>
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 focus:border-brand-accent focus:ring-brand-accent" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="w-full rounded-xl bg-brand-900 px-5 py-3 font-bold text-white shadow-lg shadow-slate-300 transition hover:bg-brand-800">
            Kirim Link Reset
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Ingat password?
        <a href="{{ route('login') }}" class="font-bold text-brand-900 hover:text-brand-accent">Masuk</a>
    </p>
</x-guest-layout>
