@extends('layouts.app')

@section('title', 'E-Tiket ' . $booking->booking_code)

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back and Print Action -->
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('customer.history') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Kembali ke Riwayat</span>
            </a>
            <a href="{{ route('customer.ticket.download', $booking) }}" class="inline-flex items-center gap-2 bg-brand-900 hover:bg-brand-800 text-white font-bold py-2.5 px-5 rounded-xl shadow-md transition transform hover:-translate-y-0.5 duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span>Unduh PDF</span>
            </a>
        </div>

        <!-- Premium Ticket Boarding Pass Card -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
            <!-- Header Section -->
            <div class="bg-brand-900 text-white px-8 py-6 flex flex-col sm:flex-row justify-between items-center gap-4 border-b-2 border-dashed border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="bg-brand-accent p-2 rounded-lg">
                        <svg class="w-6 h-6 text-brand-900 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-white font-extrabold text-xl tracking-tight">SkyLine<span class="text-brand-accent">Airways</span></span>
                        <div class="text-xs text-slate-400">Boarding Pass Resmi</div>
                    </div>
                </div>
                <div class="text-center sm:text-right">
                    <div class="text-xs text-slate-400 uppercase tracking-widest font-semibold">Kode Reservasi</div>
                    <div class="text-2xl font-mono font-bold text-brand-accent tracking-wider">{{ $booking->booking_code }}</div>
                </div>
            </div>

            <!-- Route Details -->
            <div class="p-8">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-8 bg-slate-50 rounded-2xl p-6 border border-slate-100">
                    <div class="text-center sm:text-left">
                        <span class="text-slate-400 text-xs uppercase tracking-wider block mb-1">Bandara Asal</span>
                        <span class="text-3xl font-extrabold text-brand-900 block">{{ $booking->flight->departureAirport->iata_code }}</span>
                        <span class="text-sm font-semibold text-slate-600 block">{{ $booking->flight->departureAirport->city }}</span>
                        <span class="text-xs text-slate-400 block mt-0.5">{{ $booking->flight->departureAirport->name }}</span>
                    </div>

                    <div class="flex-grow flex flex-col items-center max-w-[200px]">
                        <span class="text-slate-400 text-xs mb-2">
                            @php
                                $duration = $booking->flight->departure_time->diff($booking->flight->arrival_time);
                                echo $duration->h . 'j ' . $duration->i . 'm';
                            @endphp
                        </span>
                        <div class="relative w-full flex items-center justify-center">
                            <div class="h-0.5 bg-slate-300 w-full rounded-full"></div>
                            <div class="absolute bg-brand-accent text-brand-900 w-8 h-8 rounded-full flex items-center justify-center shadow-md">
                                ✈
                            </div>
                        </div>
                        <span class="text-xs font-bold text-brand-accent mt-2">Langsung</span>
                    </div>

                    <div class="text-center sm:text-right">
                        <span class="text-slate-400 text-xs uppercase tracking-wider block mb-1">Bandara Tujuan</span>
                        <span class="text-3xl font-extrabold text-brand-900 block">{{ $booking->flight->arrivalAirport->iata_code }}</span>
                        <span class="text-sm font-semibold text-slate-600 block">{{ $booking->flight->arrivalAirport->city }}</span>
                        <span class="text-xs text-slate-400 block mt-0.5">{{ $booking->flight->arrivalAirport->name }}</span>
                    </div>
                </div>

                <!-- Flight Details Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-8 border-b border-slate-100 pb-8">
                    <div>
                        <span class="text-slate-400 text-xs uppercase tracking-wider block mb-1">Maskapai</span>
                        <span class="font-bold text-slate-800 text-sm block">{{ $booking->flight->airline->name }}</span>
                        <span class="text-xs text-slate-500 block">{{ $booking->flight->flight_number }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs uppercase tracking-wider block mb-1">Tanggal</span>
                        <span class="font-bold text-slate-800 text-sm block">{{ $booking->flight->departure_time->format('d M Y') }}</span>
                        <span class="text-xs text-slate-500 block">Berangkat</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs uppercase tracking-wider block mb-1">Waktu</span>
                        <span class="font-bold text-slate-800 text-sm block">{{ $booking->flight->departure_time->format('H:i') }} WIB</span>
                        <span class="text-xs text-slate-500 block">Tiba {{ $booking->flight->arrival_time->format('H:i') }} WIB</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-xs uppercase tracking-wider block mb-1">Pesawat</span>
                        <span class="font-bold text-slate-800 text-sm block">{{ $booking->flight->airplane->model }}</span>
                        <span class="text-xs text-slate-500 block">Kelas Utama</span>
                    </div>
                </div>

                <!-- Passenger Details List & QR Code -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="w-full flex-grow space-y-5">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">Daftar Penumpang & Kursi</h3>
                        @foreach($booking->passengers as $pax)
                            <div class="flex justify-between items-center bg-slate-50 rounded-xl p-4 border border-slate-100">
                                <div>
                                    <div class="font-bold text-slate-800 text-sm">{{ $pax->full_name }}</div>
                                    <div class="text-xs text-slate-500">Paspor/NIK: {{ $pax->passport_number }} · {{ ucfirst($pax->gender) }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-slate-400 uppercase tracking-widest font-semibold">Kursi</div>
                                    <div class="text-xl font-extrabold text-brand-accent tracking-wider">{{ $pax->seat_number }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- QR Code & Details -->
                    <div class="flex-shrink-0 flex flex-col items-center border border-slate-200 rounded-2xl p-6 bg-slate-50 shadow-inner">
                        @if($qrCodeSvg)
                            <div class="bg-white p-3 rounded-xl shadow-md">
                                {!! $qrCodeSvg !!}
                            </div>
                        @else
                            <div class="w-36 h-36 bg-slate-200 flex items-center justify-center text-xs text-slate-500 text-center rounded-xl">
                                QR Code Preview
                            </div>
                        @endif
                        <span class="text-xs text-slate-400 uppercase tracking-widest font-bold mt-4">Scan Barcode</span>
                        <span class="text-xs text-slate-500 mt-1">Gunakan saat boarding check-in</span>
                    </div>
                </div>
            </div>

            <!-- Footer terms -->
            <div class="bg-slate-50 border-t border-slate-100 px-8 py-5 text-center text-xs text-slate-500">
                ⚠️ **PENTING:** Boarding gate ditutup 30 menit sebelum keberangkatan. Harap berada di bandara sekurang-kurangnya 2 jam sebelum waktu penerbangan.
            </div>
        </div>
    </div>
</div>
@endsection
