@extends('layouts.app')

@section('title', 'Cari Penerbangan')

@section('content')
<!-- HERO SECTION WITH SEARCH FORM -->
<section class="relative bg-brand-900 overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1920')] bg-cover bg-center opacity-20"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-brand-900/80 via-brand-900/70 to-brand-900"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-32">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">
                Mau Terbang ke Mana Hari Ini?
            </h1>
            <p class="text-lg text-slate-300">Temukan penerbangan terbaik dengan harga terjangkau</p>
        </div>

        <!-- SEARCH FORM CARD -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-6 md:p-8 max-w-5xl mx-auto">
            <form action="{{ route('customer.dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                
                <!-- Origin -->
                <div class="md:col-span-3">
                    <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">Dari</label>
                    <select name="origin" required class="w-full border-2 border-slate-200 rounded-lg px-4 py-3 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition">
                        <option value="">Pilih Kota Asal</option>
                        @foreach($airports as $airport)
                            <option value="{{ $airport->id }}" {{ request('origin') == $airport->id ? 'selected' : '' }}>
                                {{ $airport->city }} ({{ $airport->iata_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Swap Button -->
                <div class="md:col-span-1 flex justify-center">
                    <button type="button" id="swapBtn" class="w-10 h-10 bg-brand-accent text-brand-900 rounded-full flex items-center justify-center hover:rotate-180 transition-transform duration-300 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    </button>
                </div>

                <!-- Destination -->
                <div class="md:col-span-3">
                    <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">Ke</label>
                    <select name="destination" required class="w-full border-2 border-slate-200 rounded-lg px-4 py-3 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition">
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
                    <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}" min="{{ date('Y-m-d') }}" required class="w-full border-2 border-slate-200 rounded-lg px-4 py-3 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition">
                </div>

                <!-- Submit -->
                <div class="md:col-span-2">
                    <button type="submit" class="w-full bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-3 px-6 rounded-lg shadow-lg transform hover:-translate-y-0.5 transition duration-300">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Wave -->
    <div class="absolute bottom-0 w-full">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H0V120Z" fill="#f8fafc"/>
        </svg>
    </div>
</section>

<!-- SEARCH RESULTS -->
<section class="py-12 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(request()->has('origin'))
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-slate-800">
                    Hasil Pencarian
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    Ditemukan <strong>{{ $flights->count() }}</strong> penerbangan untuk rute yang Anda cari
                </p>
            </div>

            @if($flights->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                    <svg class="w-20 h-20 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Tidak Ada Penerbangan</h3>
                    <p class="text-slate-500">Maaf, tidak ada penerbangan yang tersedia untuk rute dan tanggal yang Anda pilih.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($flights as $flight)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                            <div class="p-6">
                                <div class="grid grid-cols-12 gap-4 items-center">
                                    
                                    <!-- Airline Info -->
                                    <div class="col-span-3">
                                        <div class="flex items-center gap-3 mb-2">
                                            @if($flight->airline->logo)
                                                <img src="{{ asset('storage/' . $flight->airline->logo) }}" class="w-10 h-10 object-contain rounded">
                                            @else
                                                <div class="w-10 h-10 bg-brand-900 rounded-lg flex items-center justify-center">
                                                    <span class="text-white font-bold text-xs">{{ $flight->airline->code }}</span>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-bold text-slate-800">{{ $flight->airline->name }}</div>
                                                <div class="text-xs text-slate-500">{{ $flight->flight_number }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Departure -->
                                    <div class="col-span-2 text-center">
                                        <div class="text-2xl font-bold text-brand-900">{{ $flight->departure_time->format('H:i') }}</div>
                                        <div class="text-sm font-semibold text-slate-700">{{ $flight->departureAirport->iata_code }}</div>
                                        <div class="text-xs text-slate-500">{{ $flight->departure_time->format('d M Y') }}</div>
                                    </div>

                                    <!-- Duration -->
                                    <div class="col-span-2 text-center">
                                        <div class="text-xs text-slate-500 mb-1">
                                            @php
                                                $duration = $flight->departure_time->diff($flight->arrival_time);
                                                $hours = $duration->h;
                                                $minutes = $duration->i;
                                            @endphp
                                            {{ $hours }}j {{ $minutes }}m
                                        </div>
                                        <div class="relative">
                                            <div class="h-0.5 bg-slate-300 w-full"></div>
                                            <svg class="w-4 h-4 text-brand-accent absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                                        </div>
                                        <div class="text-xs text-slate-500 mt-1">Direct</div>
                                    </div>

                                    <!-- Arrival -->
                                    <div class="col-span-2 text-center">
                                        <div class="text-2xl font-bold text-brand-900">{{ $flight->arrival_time->format('H:i') }}</div>
                                        <div class="text-sm font-semibold text-slate-700">{{ $flight->arrivalAirport->iata_code }}</div>
                                        <div class="text-xs text-slate-500">{{ $flight->arrival_time->format('d M Y') }}</div>
                                    </div>

                                    <!-- Price & Action -->
                                    <div class="col-span-3 text-right">
                                        <div class="text-xs text-slate-500 mb-1">Mulai dari</div>
                                        <div class="text-2xl font-bold text-brand-accent">Rp {{ number_format($flight->price, 0, ',', '.') }}</div>
                                        <div class="text-xs text-slate-500 mb-3">{{ $flight->available_seats }} kursi tersedia</div>
                                        <a href="{{ route('customer.booking.show', $flight) }}" class="inline-block bg-brand-900 hover:bg-brand-800 text-white font-bold py-2 px-6 rounded-lg transition">
                                            Pilih
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            <!-- Default State: Popular Routes -->
            <div class="text-center py-12">
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Mulai Pencarian Anda</h2>
                <p class="text-slate-500">Isi form di atas untuk menemukan penerbangan terbaik</p>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
    // Swap Origin-Destination
    document.getElementById('swapBtn').addEventListener('click', function() {
        const origin = document.querySelector('[name="origin"]');
        const destination = document.querySelector('[name="destination"]');
        const temp = origin.value;
        origin.value = destination.value;
        destination.value = temp;
    });
</script>
@endpush
@endsection