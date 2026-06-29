<x-guest-layout>
    @php
        $recaptchaSiteKey = (string) config('services.recaptcha.site_key');
        $recaptchaVersion = strtolower((string) config('services.recaptcha.version', 'v2'));
        $recaptchaEnabled = filled($recaptchaSiteKey)
            && ! \Illuminate\Support\Str::startsWith($recaptchaSiteKey, ['your_', '[']);
    @endphp

    <div class="mb-7">
        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-accent">Akun customer</p>
        <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-brand-900">Buat akun baru</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500">Akun baru otomatis aktif sebagai customer agar bisa langsung mencari dan memesan tiket.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5" id="registerForm" data-loading-form>
        @csrf

        <div>
            <x-input-label for="name" value="Nama lengkap" class="text-slate-700" />
            <x-text-input id="name" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 focus:border-brand-accent focus:ring-brand-accent" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email" class="text-slate-700" />
            <x-text-input id="email" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 focus:border-brand-accent focus:ring-brand-accent" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Password" class="text-slate-700" />
            <x-text-input id="password" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 focus:border-brand-accent focus:ring-brand-accent"
                type="password"
                name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi password" class="text-slate-700" />
            <x-text-input id="password_confirmation" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 focus:border-brand-accent focus:ring-brand-accent"
                type="password"
                name="password_confirmation"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        @if($recaptchaEnabled && $recaptchaVersion === 'v2')
            <div>
                <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
                <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
            </div>
        @else
            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
            <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
        @endif

        <button type="submit" class="w-full rounded-xl bg-brand-900 px-5 py-3 font-bold text-white shadow-lg shadow-slate-300 transition hover:bg-brand-800 disabled:cursor-not-allowed disabled:opacity-70">
            Daftar dan masuk
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-bold text-brand-900 hover:text-brand-accent">Masuk</a>
    </p>

    @if($recaptchaEnabled && $recaptchaVersion === 'v2')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @elseif($recaptchaEnabled && $recaptchaVersion === 'v3')
        <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptchaSiteKey }}"></script>
        <script>
            document.getElementById('registerForm').addEventListener('submit', function (event) {
                event.preventDefault();
                const form = event.target;

                grecaptcha.ready(function () {
                    grecaptcha.execute('{{ $recaptchaSiteKey }}', { action: 'register' }).then(function (token) {
                        document.getElementById('g-recaptcha-response').value = token;
                        form.submit();
                    });
                });
            });
        </script>
    @endif
</x-guest-layout>
