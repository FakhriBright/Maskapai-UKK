@extends('layouts.app')

@section('title', 'Cari Penerbangan - SkyLine Airways')

@section('content')
<!-- HERO SECTION WITH SEARCH FORM -->
<section class="relative bg-brand-900 overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1920')] bg-cover bg-center opacity-25"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-brand-900/80 via-brand-900/60 to-brand-900"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-32">
        <div class="text-center mb-12">
            <span class="bg-brand-accent/20 text-brand-accent font-extrabold text-xs uppercase tracking-widest px-4 py-2 rounded-full border border-brand-accent/30 inline-block mb-4">
                Premium Air Travel Experience
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight leading-tight">
                Mau Terbang ke Mana Hari Ini?
            </h1>
            <p class="text-lg text-slate-300 mt-3 max-w-2xl mx-auto">
                Cari dan pesan tiket penerbangan ke destinasi favorit Anda dengan armada terbaik dunia.
            </p>
        </div>

        <!-- SEARCH FORM CARD -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 md:p-8 max-w-5xl mx-auto border border-slate-100">
            <form action="{{ route('customer.dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-5 items-end">
                
                <!-- Origin -->
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        🛫 Kota Asal
                    </label>
                    <select name="origin" required class="w-full border-2 border-slate-100 bg-slate-50/50 rounded-xl px-4 py-3.5 focus:border-brand-accent focus:bg-white focus:ring-4 focus:ring-brand-accent/10 transition font-bold text-slate-700">
                        <option value="">Pilih Kota Asal</option>
                        @foreach($airports as $airport)
                            <option value="{{ $airport->id }}" {{ request('origin') == $airport->id ? 'selected' : '' }}>
                                {{ $airport->city }} ({{ $airport->iata_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Swap Button -->
                <div class="md:col-span-1 flex justify-center pb-2">
                    <button type="button" id="swapBtn" class="w-11 h-11 bg-brand-900 text-brand-accent rounded-full flex items-center justify-center hover:scale-105 active:scale-95 transition shadow-lg border border-slate-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    </button>
                </div>

                <!-- Destination -->
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        🛬 Kota Tujuan
                    </label>
                    <select name="destination" required class="w-full border-2 border-slate-100 bg-slate-50/50 rounded-xl px-4 py-3.5 focus:border-brand-accent focus:bg-white focus:ring-4 focus:ring-brand-accent/10 transition font-bold text-slate-700">
                        <option value="">Pilih Kota Tujuan</option>
                        @foreach($airports as $airport)
                            <option value="{{ $airport->id }}" {{ request('destination') == $airport->id ? 'selected' : '' }}>
                                {{ $airport->city }} ({{ $airport->iata_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date -->
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        📅 Tanggal Penerbangan
                    </label>
                    <input type="date" name="date" value="{{ request('date') }}" min="{{ date('Y-m-d') }}" required class="w-full border-2 border-slate-100 bg-slate-50/50 rounded-xl px-4 py-3.5 focus:border-brand-accent focus:bg-white focus:ring-4 focus:ring-brand-accent/10 transition font-bold text-slate-700">
                </div>

                <!-- Submit -->
                <div class="md:col-span-2">
                    <button type="submit" class="w-full bg-brand-accent hover:bg-amber-500 text-brand-900 font-extrabold py-3.5 px-6 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition duration-300">
                        Cari Tiket
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Wave divider -->
    <div class="absolute bottom-0 w-full">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H0V120Z" fill="#f8fafc"/>
        </svg>
    </div>
</section>

<!-- SEARCH RESULTS -->
<section class="py-12 bg-slate-50 min-h-[500px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(request()->has('origin'))
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                        Hasil Pencarian Penerbangan
                    </h2>
                    <p class="text-slate-500 text-sm mt-1">
                        Ditemukan <strong class="text-brand-900">{{ $flights->count() }}</strong> jadwal penerbangan terbaik untuk Anda.
                    </p>
                </div>
            </div>

            @if($flights->isEmpty())
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-16 text-center max-w-xl mx-auto">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-400">
                        🛫
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Penerbangan Tidak Ditemukan</h3>
                    <p class="text-slate-500">Maaf, belum ada penerbangan yang dijadwalkan pada rute atau tanggal yang Anda tentukan. Silakan cari rute lain.</p>
                </div>
            @else
                @php
                    $cheapestPrice = $flights->min('price');
                @endphp
                
                <div class="space-y-6">
                    @foreach($flights as $flight)
                        @php
                            $isCheapest = $flight->price == $cheapestPrice;
                            
                            // Mock ratings berdasarkan nama maskapai
                            $rating = match ($flight->airline->name) {
                                'Garuda Indonesia' => '4.9 ★ Excellent',
                                'SkyLine Airways' => '4.8 ★ Premium',
                                'Citilink' => '4.6 ★ Highly Rated',
                                'Pelita Air' => '4.5 ★ Recommended',
                                'Batik Air' => '4.4 ★ Comfort Class',
                                default => '4.2 ★ Good Service'
                            };
                        @endphp
                        
                        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden relative group">
                            
                            <!-- Cheapest Badge Indicator -->
                            @if($isCheapest)
                                <div class="absolute left-0 top-0 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-extrabold text-[10px] uppercase tracking-wider py-1 px-4 rounded-br-2xl shadow-sm z-10">
                                    👍 Pilihan Termurah
                                </div>
                            @endif

                            <div class="p-6 md:p-8">
                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                                    
                                    <!-- Airline details -->
                                    <div class="lg:col-span-3">
                                        <div class="flex items-center gap-4">
                                            @if($flight->airline->logo)
                                                <img src="{{ asset('storage/' . $flight->airline->logo) }}" class="w-14 h-14 object-contain rounded-2xl border border-slate-100 p-1.5 shadow-sm">
                                            @else
                                                <div class="w-14 h-14 bg-brand-900 rounded-2xl flex items-center justify-center shadow-sm">
                                                    <span class="text-white font-black text-sm">{{ $flight->airline->code }}</span>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-extrabold text-slate-800 text-base group-hover:text-brand-900 transition">{{ $flight->airline->name }}</div>
                                                <div class="text-xs text-slate-500 mt-0.5">{{ $flight->flight_number }} · {{ $flight->airplane->model }}</div>
                                                
                                                <!-- Rating badge -->
                                                <span class="inline-block mt-2 text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-100">
                                                    {{ $rating }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Route & Times -->
                                    <div class="lg:col-span-5 flex items-center justify-between gap-4 px-4 border-l border-r border-slate-100">
                                        <!-- Departure -->
                                        <div class="text-center flex-1">
                                            <div class="text-2xl font-black text-brand-900 tracking-tight">{{ $flight->departure_time->format('H:i') }}</div>
                                            <div class="text-sm font-bold text-slate-700 mt-1">{{ $flight->departureAirport->iata_code }}</div>
                                            <div class="text-xs text-slate-400 mt-0.5">{{ $flight->departureAirport->city }}</div>
                                        </div>

                                        <!-- Connection Graphic -->
                                        <div class="flex-1 text-center">
                                            @php
                                                $duration = $flight->departure_time->diff($flight->arrival_time);
                                                $hours = $duration->h;
                                                $minutes = $duration->i;
                                            @endphp
                                            <div class="text-xs font-bold text-slate-500 mb-1.5">{{ $hours }}j {{ $minutes }}m</div>
                                            <div class="relative flex items-center justify-center">
                                                <div class="h-[2px] bg-slate-200 w-full rounded-full"></div>
                                                <span class="absolute text-brand-accent transform rotate-90 text-sm">✈️</span>
                                            </div>
                                            <div class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest mt-1.5 flex items-center justify-center gap-1">
                                                <span>●</span> Langsung (Direct)
                                            </div>
                                        </div>

                                        <!-- Arrival -->
                                        <div class="text-center flex-1">
                                            <div class="text-2xl font-black text-brand-900 tracking-tight">{{ $flight->arrival_time->format('H:i') }}</div>
                                            <div class="text-sm font-bold text-slate-700 mt-1">{{ $flight->arrivalAirport->iata_code }}</div>
                                            <div class="text-xs text-slate-400 mt-0.5">{{ $flight->arrivalAirport->city }}</div>
                                        </div>
                                    </div>

                                    <!-- Price & Booking -->
                                    <div class="lg:col-span-4 text-right flex flex-col justify-between h-full">
                                        <div>
                                            <span class="text-xs text-slate-400 block font-bold uppercase tracking-wider mb-1">Harga Mulai Dari</span>
                                            <div class="text-3xl font-black text-brand-accent tracking-tight">
                                                Rp {{ number_format($flight->price, 0, ',', '.') }}
                                            </div>
                                            
                                            <!-- Available seats alert -->
                                            @if($flight->available_seats <= 15)
                                                <span class="inline-block text-[10px] font-extrabold text-red-600 bg-red-50 px-2 py-0.5 rounded-full border border-red-100 mt-1.5">
                                                    ⚠️ Tersisa {{ $flight->available_seats }} kursi!
                                                </span>
                                            @else
                                                <span class="inline-block text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full mt-1.5">
                                                    {{ $flight->available_seats }} kursi tersedia
                                                </span>
                                            @endif
                                        </div>

                                        <div class="mt-5 flex items-center justify-end gap-3">
                                            <!-- Class Badge Indicators -->
                                            <div class="flex gap-1">
                                                <span class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[8px] font-black" title="Economy Class">E</span>
                                                <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[8px] font-black" title="Business Class">B</span>
                                                <span class="w-5 h-5 rounded-full bg-amber-500 text-white flex items-center justify-center text-[8px] font-black" title="First Class">F</span>
                                            </div>

                                            <a href="{{ route('customer.booking.show', $flight) }}" class="bg-brand-900 hover:bg-brand-800 text-white font-extrabold py-2.5 px-6 rounded-xl transition text-xs sm:text-sm shadow-md">
                                                Pilih Penerbangan
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            
                            <!-- Footer Facilities Info bar -->
                            <div class="bg-slate-50 border-t border-slate-100 px-8 py-3 flex items-center justify-between text-xs font-bold text-slate-500">
                                <div class="flex items-center gap-6">
                                    <span>🧳 Bagasi Kabin gratis: 7 kg</span>
                                    <span>🎒 Bagasi terdaftar mulai: 20 kg</span>
                                    <span>🍽️ Pilihan makanan premium tersedia</span>
                                    <span>🔌 USB Port & Power Outlet</span>
                                </div>
                                <div class="text-brand-900">
                                    Refund & Reschedule Terjamin
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        @else
            <!-- Default State: Popular Routes / Promo Cards -->
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 text-center tracking-tight mb-8">
                    Rute Penerbangan Populer
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-lg transition">
                        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=500" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <span class="text-[10px] bg-amber-100 text-amber-800 border border-amber-200 px-2 py-0.5 rounded font-black uppercase">Promo Liburan</span>
                            <h3 class="font-extrabold text-lg text-slate-800 mt-2">Jakarta (CGK) ke Bali (DPS)</h3>
                            <p class="text-xs text-slate-400 mt-1">Rasakan keindahan pantai Bali dengan armada terbaik kami.</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="font-black text-brand-accent text-lg">Rp 1.200.000</span>
                                <span class="text-xs text-slate-500 font-semibold">One-way</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-lg transition">
                        <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=500" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <span class="text-[10px] bg-blue-100 text-blue-800 border border-blue-200 px-2 py-0.5 rounded font-black uppercase">Business Trip</span>
                            <h3 class="font-extrabold text-lg text-slate-800 mt-2">Jakarta (CGK) ke Surabaya (SUB)</h3>
                            <p class="text-xs text-slate-400 mt-1">Penerbangan bisnis lancar dengan fasilitas lounge eksekutif.</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="font-black text-brand-accent text-lg">Rp 900.000</span>
                                <span class="text-xs text-slate-500 font-semibold">One-way</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-lg transition">
                        <img src="https://images.unsplash.com/photo-1582672060674-bc2bd808a8b5?w=500" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <span class="text-[10px] bg-purple-100 text-purple-800 border border-purple-200 px-2 py-0.5 rounded font-black uppercase">Adventure</span>
                            <h3 class="font-extrabold text-lg text-slate-800 mt-2">Jakarta (CGK) ke Medan (KNO)</h3>
                            <p class="text-xs text-slate-400 mt-1">Kunjungi Danau Toba dengan penerbangan langsung nyaman.</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="font-black text-brand-accent text-lg">Rp 1.100.000</span>
                                <span class="text-xs text-slate-500 font-semibold">One-way</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
    // Swap Origin-Destination
    const swapBtn = document.getElementById('swapBtn');
    if (swapBtn) {
        swapBtn.addEventListener('click', function() {
            const origin = document.querySelector('[name="origin"]');
            const destination = document.querySelector('[name="destination"]');
            const temp = origin.value;
            origin.value = destination.value;
            destination.value = temp;
        });
    }
</script>
@endpush
@endsection