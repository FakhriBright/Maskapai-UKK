@extends('layouts.app')

@section('title', 'Terbang Lebih Nyaman')

@section('content')
<!-- HERO SECTION -->
<section class="relative bg-brand-900 overflow-hidden">
    <!-- Background Pattern/Gradient -->
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center opacity-20"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-brand-900/80 via-brand-900/60 to-brand-900"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-32 text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-6">
            Terbang Lebih Nyaman <br>
            <span class="text-brand-accent">Bersama SkyLine Airways</span>
        </h1>
        <p class="text-lg md:text-xl text-slate-300 max-w-2xl mx-auto mb-10">
            Pesan tiket penerbangan domestik dengan mudah, aman, dan transparan. 
            Pilih kursimu secara visual dan dapatkan e-tiket instan.
        </p>
        
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('login') }}" class="bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:-translate-y-1 transition duration-300">
                Pesan Tiket Sekarang
            </a>
            <a href="#features" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-semibold py-3 px-8 rounded-xl border border-white/20 transition duration-300">
                Pelajari Lebih Lanjut
            </a>
        </div>
    </div>

    <!-- WAVE BOTTOM -->
    <div class="absolute bottom-0 w-full">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V120Z" fill="#f8fafc"/>
        </svg>
    </div>
</section>

<!-- FEATURES SECTION -->
<section id="features" class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-brand-900 mb-4">Mengapa Memilih SkyLine?</h2>
            <p class="text-slate-600 max-w-2xl mx-auto">Kami menghadirkan teknologi terkini untuk pengalaman pemesanan tiket yang tak terlupakan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 border border-slate-100">
                <div class="w-14 h-14 bg-brand-500/10 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-900 mb-3">Pembayaran Aman</h3>
                <p class="text-slate-600">Integrasi langsung dengan Midtrans. Transaksi terenkripsi dan terverifikasi secara real-time.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 border border-slate-100">
                <div class="w-14 h-14 bg-brand-accent/10 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-900 mb-3">Visual Seat Selection</h3>
                <p class="text-slate-600">Pilih kursi favoritmu secara langsung melalui denah interaktif. Tidak ada lagi sistem "asal duduk".</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 border border-slate-100">
                <div class="w-14 h-14 bg-brand-500/10 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-900 mb-3">E-Tiket Instan</h3>
                <p class="text-slate-600">Dapatkan e-tiket PDF lengkap dengan QR Code langsung di email Anda dalam hitungan detik.</p>
            </div>
        </div>
    </div>
</section>

<!-- STATS / TRUST SECTION -->
<section class="py-16 bg-brand-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-extrabold text-brand-accent mb-2">50+</div>
                <div class="text-slate-300 text-sm uppercase tracking-wider">Rute Domestik</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold text-brand-accent mb-2">100K+</div>
                <div class="text-slate-300 text-sm uppercase tracking-wider">Penumpang Puas</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold text-brand-accent mb-2">24/7</div>
                <div class="text-slate-300 text-sm uppercase tracking-wider">Layanan Support</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold text-brand-accent mb-2">100%</div>
                <div class="text-slate-300 text-sm uppercase tracking-wider">Aman & Terpercaya</div>
            </div>
        </div>
    </div>
</section>
@endsection