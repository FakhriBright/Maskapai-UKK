<x-guest-layout>
    <div class="mb-7">
        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-accent">Verifikasi email</p>
        <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-brand-900">Cek email Anda</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500">Jika akun membutuhkan verifikasi, gunakan tombol di bawah untuk mengirim ulang link aktivasi.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
            Link verifikasi baru sudah dikirim ke email Anda.
        </div>
    @endif

    <div class="flex flex-col gap-3 sm:flex-row">
        <form method="POST" action="{{ route('verification.send') }}" class="flex-1" data-loading-form>
            @csrf
            <button type="submit" class="w-full rounded-xl bg-brand-900 px-5 py-3 font-bold text-white shadow-lg shadow-slate-300 transition hover:bg-brand-800">
                Kirim Ulang Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="flex-1">
            @csrf
            <button type="submit" class="w-full rounded-xl border border-slate-300 bg-white px-5 py-3 font-bold text-slate-700 transition hover:bg-slate-50">
                Logout
            </button>
        </form>
    </div>
</x-guest-layout>
