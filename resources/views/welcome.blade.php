@extends('layouts.app')

@section('title', 'SkyLine Airways - Terbang Lebih Nyaman')

@section('content')
<!-- HERO SECTION & SEARCH WIDGET -->
<section class="relative min-h-[90vh] bg-brand-900 overflow-hidden flex flex-col justify-center">
    <!-- Unsplash Premium Aviation Background -->
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1540962351504-03099e0a754b?q=80&w=1920')] bg-cover bg-center opacity-30"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-brand-900/90 via-brand-900/60 to-brand-900"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20 z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Hero Left: Headlines -->
            <div class="lg:col-span-6 text-center lg:text-left text-white">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand-accent/15 border border-brand-accent/30 text-brand-accent font-bold text-xs uppercase tracking-[0.2em] mb-6">
                    ✨ KEMAPANAN PENERBANGAN KELAS DUNIA
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.1] mb-6">
                    Terbang Lebih Nyaman <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-accent to-amber-300">Bersama SkyLine Airways</span>
                </h1>
                <p class="text-slate-300 text-base sm:text-lg leading-relaxed max-w-xl mb-8">
                    Menghubungkan Anda ke destinasi favorit dengan kenyamanan kabin eksklusif, armada modern, dan layanan visual pemilihan kursi terbaik.
                </p>
                <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                    <a href="#destinations" class="bg-brand-accent hover:bg-amber-500 text-brand-900 font-extrabold px-8 py-3.5 rounded-xl shadow-lg shadow-brand-accent/25 transform hover:-translate-y-0.5 duration-200">
                        Jelajahi Rute
                    </a>
                    <a href="#services" class="bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md text-white font-bold px-8 py-3.5 rounded-xl transition duration-200">
                        Layanan Premium
                    </a>
                </div>
            </div>

            <!-- Hero Right: Glassmorphism Search Panel -->
            <div class="lg:col-span-6">
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-6 sm:p-8 shadow-2xl shadow-slate-950/50">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-white mb-1">Cari Penerbangan Anda</h2>
                        <p class="text-xs text-slate-300">Dapatkan tarif eksklusif anggota dengan memesan secara online</p>
                    </div>

                    <form action="{{ auth()->check() ? route('customer.dashboard') : route('login') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Origin -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Kota Asal</label>
                                <select name="origin" required class="w-full bg-brand-900/50 border border-white/20 text-white rounded-xl px-4 py-3 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent/50 outline-none text-sm transition">
                                    <option value="" class="bg-brand-900 text-slate-400">Pilih Bandara Asal</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}" class="bg-brand-900 text-white">
                                            {{ $airport->city }} ({{ $airport->iata_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Destination -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Kota Tujuan</label>
                                <select name="destination" required class="w-full bg-brand-900/50 border border-white/20 text-white rounded-xl px-4 py-3 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent/50 outline-none text-sm transition">
                                    <option value="" class="bg-brand-900 text-slate-400">Pilih Bandara Tujuan</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}" class="bg-brand-900 text-white">
                                            {{ $airport->city }} ({{ $airport->iata_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Departure Date -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Tanggal Perjalanan</label>
                                <input type="date" name="date" min="{{ date('Y-m-d') }}" required class="w-full bg-brand-900/50 border border-white/20 text-white rounded-xl px-4 py-3 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent/50 outline-none text-sm transition">
                            </div>
                            
                            <!-- Class Option -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Kelas Kabin</label>
                                <select class="w-full bg-brand-900/50 border border-white/20 text-white rounded-xl px-4 py-3 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent/50 outline-none text-sm transition">
                                    <option class="bg-brand-900 text-white" value="economy">Economy Class</option>
                                    <option class="bg-brand-900 text-white" value="business">Business Class</option>
                                    <option class="bg-brand-900 text-white" value="first">First Class</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-brand-accent hover:bg-amber-500 text-brand-900 font-extrabold py-3.5 rounded-xl shadow-lg transition duration-200 mt-2 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <span>Cari Penerbangan Terkini</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- POPULAR DESTINATIONS SECTION -->
<section id="destinations" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-sm font-semibold uppercase tracking-widest text-brand-accent">DESTINASI IMPIAN</span>
            <h2 class="text-3xl font-extrabold text-brand-900 mt-2">Populer di Kalangan Pelancong</h2>
            <p class="text-slate-500 max-w-2xl mx-auto mt-3">Jelajahi keindahan Indonesia dengan penerbangan langsung paling nyaman.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Destination 1 -->
            <div class="group rounded-3xl overflow-hidden shadow-md border border-slate-100 hover:shadow-2xl duration-300 bg-slate-50">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=600" class="w-full h-full object-cover group-hover:scale-110 duration-500" alt="Bali">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                    <span class="absolute bottom-5 left-6 text-white text-2xl font-extrabold">Bali</span>
                </div>
                <div class="p-6">
                    <p class="text-sm text-slate-500 mb-4">Rasakan kedamaian pantai tropis dan budaya yang kental di pulau para dewa.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-400">Tarif Mulai Dari</span>
                        <span class="text-lg font-bold text-brand-accent">Rp 980.000</span>
                    </div>
                </div>
            </div>

            <!-- Destination 2 -->
            <div class="group rounded-3xl overflow-hidden shadow-md border border-slate-100 hover:shadow-2xl duration-300 bg-slate-50">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1584810359583-96fc3448beaa?q=80&w=600" class="w-full h-full object-cover group-hover:scale-110 duration-500" alt="Jakarta">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                    <span class="absolute bottom-5 left-6 text-white text-2xl font-extrabold">Jakarta</span>
                </div>
                <div class="p-6">
                    <p class="text-sm text-slate-500 mb-4">Pusat metropolitan yang dinamis, menawarkan destinasi hiburan belanja premium.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-400">Tarif Mulai Dari</span>
                        <span class="text-lg font-bold text-brand-accent">Rp 750.000</span>
                    </div>
                </div>
            </div>

            <!-- Destination 3 -->
            <div class="group rounded-3xl overflow-hidden shadow-md border border-slate-100 hover:shadow-2xl duration-300 bg-slate-50">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1601999109332-542b18dbec57?q=80&w=600" class="w-full h-full object-cover group-hover:scale-110 duration-500" alt="Yogyakarta">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                    <span class="absolute bottom-5 left-6 text-white text-2xl font-extrabold">Yogyakarta</span>
                </div>
                <div class="p-6">
                    <p class="text-sm text-slate-500 mb-4">Kota budaya legendaris dengan Candi Borobudur megah dan cita rasa kuliner orisinil.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-400">Tarif Mulai Dari</span>
                        <span class="text-lg font-bold text-brand-accent">Rp 820.000</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURED FLIGHTS SECTION -->
<section class="py-24 bg-slate-50 border-t border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-16">
            <div>
                <span class="text-sm font-semibold uppercase tracking-widest text-brand-accent">PILIHAN HARI INI</span>
                <h2 class="text-3xl font-extrabold text-brand-900 mt-2">Penerbangan Rekomendasi</h2>
            </div>
            <a href="{{ route('login') }}" class="text-brand-900 hover:text-brand-accent font-bold flex items-center gap-1 mt-4 md:mt-0 text-sm group">
                Cari Jadwal Lebih Lengkap <span class="group-hover:translate-x-1 duration-200">→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Mock Flight 1 -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-lg duration-200">
                <div class="flex justify-between items-center border-b border-slate-100 pb-4 mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-brand-900 rounded-lg flex items-center justify-center font-bold text-white text-xs">SL</div>
                        <div>
                            <div class="font-bold text-slate-800 text-sm">SkyLine Airways</div>
                            <div class="text-slate-400 text-xs">Flight SL-301</div>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 font-bold text-xs">Direct</span>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <div class="text-lg font-bold text-slate-800">CGK (Jakarta)</div>
                        <div class="text-xs text-slate-500">08:00 WIB</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="text-slate-400 text-[10px]">1j 30m</span>
                        <div class="w-24 h-0.5 bg-slate-300 relative my-1">
                            <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-1 text-slate-400 text-xs">✈</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-slate-800">SUB (Surabaya)</div>
                        <div class="text-xs text-slate-500">09:30 WIB</div>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                    <div class="text-slate-500 text-xs">Ekonomi · PPN Termasuk</div>
                    <div class="text-right">
                        <span class="text-slate-400 text-[10px] block">Mulai</span>
                        <span class="font-extrabold text-brand-accent text-xl">Rp 840.000</span>
                    </div>
                </div>
            </div>

            <!-- Mock Flight 2 -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-lg duration-200">
                <div class="flex justify-between items-center border-b border-slate-100 pb-4 mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-brand-900 rounded-lg flex items-center justify-center font-bold text-white text-xs">SL</div>
                        <div>
                            <div class="font-bold text-slate-800 text-sm">SkyLine Airways</div>
                            <div class="text-slate-400 text-xs">Flight SL-512</div>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 font-bold text-xs">Direct</span>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <div class="text-lg font-bold text-slate-800">CGK (Jakarta)</div>
                        <div class="text-xs text-slate-500">14:15 WIB</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="text-slate-400 text-[10px]">1j 50m</span>
                        <div class="w-24 h-0.5 bg-slate-300 relative my-1">
                            <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-1 text-slate-400 text-xs">✈</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-slate-800">DPS (Bali)</div>
                        <div class="text-xs text-slate-500">17:05 WITA</div>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                    <div class="text-slate-500 text-xs">Ekonomi · PPN Termasuk</div>
                    <div class="text-right">
                        <span class="text-slate-400 text-[10px] block">Mulai</span>
                        <span class="font-extrabold text-brand-accent text-xl">Rp 990.000</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FLEET SHOWCASE SECTION -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-sm font-semibold uppercase tracking-widest text-brand-accent">ARMADA MODERN</span>
            <h2 class="text-3xl font-extrabold text-brand-900 mt-2">Komitmen Kenyamanan & Keselamatan</h2>
            <p class="text-slate-500 max-w-2xl mx-auto mt-3">Kami mengoperasikan armada berteknologi paling mutakhir untuk emisi rendah dan interior senyap.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl h-80 md:h-[400px]">
                <img src="https://images.unsplash.com/photo-1517999144091-3d9dca6d1e43?q=80&w=800" class="w-full h-full object-cover" alt="Armada Boeing">
            </div>
            <div>
                <h3 class="text-2xl font-bold text-brand-900 mb-4">Armada Boeing 737-800 NG & Airbus A320</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">
                    Setiap pesawat SkyLine Airways dikonfigurasikan dengan ruang kaki ekstra di seluruh kabin ekonomi, serta sistem sirkulasi udara HEPA filters berstandar rumah sakit, menyaring 99.9% bakteri dan virus setiap 3 menit.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-brand-accent/20 flex items-center justify-center text-brand-accent text-xs">✓</span>
                        <span class="font-semibold text-slate-800 text-sm">Visual seat layout untuk kenyamanan pilih kursi</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-brand-accent/20 flex items-center justify-center text-brand-accent text-xs">✓</span>
                        <span class="font-semibold text-slate-800 text-sm">Stopkontak & pengisi daya USB di setiap kursi</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-brand-accent/20 flex items-center justify-center text-brand-accent text-xs">✓</span>
                        <span class="font-semibold text-slate-800 text-sm">Hiburan nirkabel langsung di perangkat seluler Anda</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES & BENEFITS SECTION -->
<section id="services" class="py-24 bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-sm font-semibold uppercase tracking-widest text-brand-accent">LAYANAN UNGGULAN</span>
            <h2 class="text-3xl font-extrabold text-white mt-2">Kabin Eksklusif & Keramahan Indonesia</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Service 1 -->
            <div class="p-8 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 duration-200">
                <div class="w-12 h-12 rounded-xl bg-brand-accent/20 flex items-center justify-center text-brand-accent mb-6 font-bold text-xl">
                    🍽️
                </div>
                <h3 class="text-lg font-bold mb-3">Kuliner Nusantara Premium</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Nikmati sajian hangat khas Indonesia yang dikurasi oleh chef berpengalaman untuk perjalanan Anda.</p>
            </div>

            <!-- Service 2 -->
            <div class="p-8 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 duration-200">
                <div class="w-12 h-12 rounded-xl bg-brand-accent/20 flex items-center justify-center text-brand-accent mb-6 font-bold text-xl">
                    🛋️
                </div>
                <h3 class="text-lg font-bold mb-3">Airport Lounge Mewah</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Ruang santai premium sebelum keberangkatan dengan buffet lengkap dan ruang pertemuan privat.</p>
            </div>

            <!-- Service 3 -->
            <div class="p-8 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 duration-200">
                <div class="w-12 h-12 rounded-xl bg-brand-accent/20 flex items-center justify-center text-brand-accent mb-6 font-bold text-xl">
                    🧳
                </div>
                <h3 class="text-lg font-bold mb-3">Bagasi Ekstra 20 Kg</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Berpergian tanpa khawatir dengan jatah bagasi terdaftar cuma-cuma sebesar 20 kg untuk semua rute.</p>
            </div>
        </div>
    </div>
</section>

<!-- STATISTICS / TRUST SECTION -->
<section class="py-20 bg-brand-accent text-brand-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-5xl font-extrabold mb-2">99.8%</div>
                <div class="text-brand-900/70 text-xs font-bold uppercase tracking-wider">Tingkat Ketepatan Waktu (OTP)</div>
            </div>
            <div>
                <div class="text-5xl font-extrabold mb-2">48+</div>
                <div class="text-brand-900/70 text-xs font-bold uppercase tracking-wider">Rute Penerbangan Domestik</div>
            </div>
            <div>
                <div class="text-5xl font-extrabold mb-2">120K+</div>
                <div class="text-brand-900/70 text-xs font-bold uppercase tracking-wider">Penumpang Terlayani Aman</div>
            </div>
            <div>
                <div class="text-5xl font-extrabold mb-2">24/7</div>
                <div class="text-brand-900/70 text-xs font-bold uppercase tracking-wider">Dukungan Call Center</div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS SECTION -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-sm font-semibold uppercase tracking-widest text-brand-accent">TESTIMONI</span>
            <h2 class="text-3xl font-extrabold text-brand-900 mt-2">Suara Pelanggan Kami</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Review 1 -->
            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-8 shadow-sm">
                <div class="text-amber-500 mb-4">★★★★★</div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">"Proses memilih kursi secara visual sangat membantu, tidak membingungkan seperti aplikasi maskapai lain. E-tiket langsung terbit cepat setelah pembayaran."</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-300 font-bold flex items-center justify-center text-slate-700">A</div>
                    <div>
                        <div class="font-bold text-slate-800 text-sm">Aditya Nugroho</div>
                        <div class="text-xs text-slate-400">Pebisnis Mandiri</div>
                    </div>
                </div>
            </div>

            <!-- Review 2 -->
            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-8 shadow-sm">
                <div class="text-amber-500 mb-4">★★★★★</div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">"Pelayanan ramah di pesawat dan ketepatan waktu terbang sangat memuaskan. Sangat menyukai makanan hangat gratis di kelas bisnis!"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-300 font-bold flex items-center justify-center text-slate-700">R</div>
                    <div>
                        <div class="font-bold text-slate-800 text-sm">Rina Kartika</div>
                        <div class="text-xs text-slate-400">Travel Blogger</div>
                    </div>
                </div>
            </div>

            <!-- Review 3 -->
            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-8 shadow-sm">
                <div class="text-amber-500 mb-4">★★★★★</div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">"Platform reservasi online-nya sangat aman. CS siap membantu kapan saja dan refund tiket bisa diselesaikan cepat tanpa kendala."</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-300 font-bold flex items-center justify-center text-slate-700">H</div>
                    <div>
                        <div class="font-bold text-slate-800 text-sm">Hendry Widjaja</div>
                        <div class="text-xs text-slate-400">Keluarga Pelancong</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ SECTION USING ALPINE.JS ACCORDION -->
<section class="py-24 bg-slate-50 border-t border-b border-slate-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-sm font-semibold uppercase tracking-widest text-brand-accent">PERTANYAAN UMUM</span>
            <h2 class="text-3xl font-extrabold text-brand-900 mt-2">Punya Pertanyaan?</h2>
        </div>

        <div x-data="{ activeAccordion: null }" class="space-y-4">
            <!-- FAQ 1 -->
            <div class="bg-white rounded-2xl border border-slate-200/60 overflow-hidden shadow-sm">
                <button @click="activeAccordion = (activeAccordion === 1 ? null : 1)" class="w-full px-6 py-5 text-left font-bold text-brand-900 flex justify-between items-center focus:outline-none">
                    <span>Bagaimana cara melakukan pemilihan kursi?</span>
                    <span x-text="activeAccordion === 1 ? '−' : '+'" class="text-lg text-brand-accent font-bold"></span>
                </button>
                <div x-show="activeAccordion === 1" x-collapse class="px-6 pb-5 text-sm text-slate-600 leading-relaxed">
                    Setelah Anda memilih penerbangan, halaman pemesanan akan menyajikan denah kursi interaktif pesawat. Anda dapat mengklik kursi yang berwarna hijau (tersedia) untuk memilikinya dan memasukkan identitas penumpang yang bersangkutan.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white rounded-2xl border border-slate-200/60 overflow-hidden shadow-sm">
                <button @click="activeAccordion = (activeAccordion === 2 ? null : 2)" class="w-full px-6 py-5 text-left font-bold text-brand-900 flex justify-between items-center focus:outline-none">
                    <span>Apakah saya dapat membayar secara offline jika tidak memiliki kartu?</span>
                    <span x-text="activeAccordion === 2 ? '−' : '+'" class="text-lg text-brand-accent font-bold"></span>
                </button>
                <div x-show="activeAccordion === 2" x-collapse class="px-6 pb-5 text-sm text-slate-600 leading-relaxed">
                    Kami mendukung transaksi online melalui gerbang pembayaran Midtrans. Namun, demi kemudahan pengujian sistem ini, kami juga telah melengkapi mode **Simulasi Uji Coba Offline** sehingga pesanan Anda dapat diselesaikan langsung tanpa konfigurasi tambahan.
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-white rounded-2xl border border-slate-200/60 overflow-hidden shadow-sm">
                <button @click="activeAccordion = (activeAccordion === 3 ? null : 3)" class="w-full px-6 py-5 text-left font-bold text-brand-900 flex justify-between items-center focus:outline-none">
                    <span>Kapan saya harus mencetak e-tiket saya?</span>
                    <span x-text="activeAccordion === 3 ? '−' : '+'" class="text-lg text-brand-accent font-bold"></span>
                </button>
                <div x-show="activeAccordion === 3" x-collapse class="px-6 pb-5 text-sm text-slate-600 leading-relaxed">
                    E-tiket PDF Anda dilengkapi dengan QR Code resmi. Anda dapat langsung mengunduhnya di menu riwayat pemesanan Anda setelah status lunas, lalu menunjukkannya di bandara keberangkatan baik secara digital (di ponsel) maupun dicetak kertas.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CALL TO ACTION (CTA) SECTION -->
<section class="relative py-24 bg-brand-900 text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?q=80&w=1920')] bg-cover bg-center opacity-10"></div>
    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-4">Siap Memulai Perjalanan Impian Anda?</h2>
        <p class="text-slate-300 max-w-xl mx-auto mb-8 text-sm sm:text-base leading-relaxed">Daftar sekarang sebagai customer dan dapatkan promo cashback 10% untuk tiket penerbangan perdana Anda!</p>
        <div class="flex justify-center gap-4 flex-wrap">
            <a href="{{ route('register') }}" class="bg-brand-accent hover:bg-amber-500 text-brand-900 font-extrabold py-3 px-8 rounded-xl shadow-lg transition">
                Daftar Akun Baru
            </a>
            <a href="{{ route('login') }}" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold py-3 px-8 rounded-xl transition">
                Masuk Sekarang
            </a>
        </div>
    </div>
</section>
@endsection