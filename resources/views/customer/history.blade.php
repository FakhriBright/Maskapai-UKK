@extends('layouts.app')

@section('title', 'Riwayat Pemesanan - SkyLine Airways')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Riwayat Pemesanan</h1>
                <p class="text-slate-500 mt-1 text-sm">Semua tiket penerbangan yang pernah Anda pesan bersama SkyLine Airways.</p>
            </div>
            <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center gap-2 bg-brand-accent hover:bg-amber-500 text-brand-900 font-extrabold py-2.5 px-5 rounded-xl shadow transition text-sm w-fit">
                + Pesan Tiket Baru
            </a>
        </div>

        @if($bookings->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200 p-16 text-center max-w-lg mx-auto">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5 text-4xl">🎫</div>
                <h3 class="text-xl font-extrabold text-slate-800 mb-2">Belum Ada Riwayat Pemesanan</h3>
                <p class="text-slate-500 text-sm mb-6">Anda belum pernah memesan tiket. Mulai perjalanan pertama Anda sekarang!</p>
                <a href="{{ route('customer.dashboard') }}" class="inline-block bg-brand-accent hover:bg-amber-500 text-brand-900 font-extrabold py-3 px-8 rounded-xl transition shadow-md">
                    Cari Penerbangan
                </a>
            </div>
        @else
            <div class="space-y-5">
                @foreach($bookings as $booking)
                    @php
                        $statusColor = match($booking->status) {
                            'confirmed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'pending'   => 'bg-amber-100 text-amber-700 border-amber-200',
                            default     => 'bg-rose-100 text-rose-700 border-rose-200',
                        };
                        $statusLabel = match($booking->status) {
                            'confirmed' => '✓ Terkonfirmasi',
                            'pending'   => '⏳ Menunggu Pembayaran',
                            default     => '✕ Dibatalkan',
                        };
                    @endphp

                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                        
                        <!-- Status stripe for confirmed -->
                        @if($booking->status === 'confirmed')
                            <div class="h-1.5 w-full bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                        @elseif($booking->status === 'pending')
                            <div class="h-1.5 w-full bg-gradient-to-r from-amber-400 to-orange-400"></div>
                        @else
                            <div class="h-1.5 w-full bg-slate-200"></div>
                        @endif

                        <div class="p-6">
                            <!-- Top: Code + Status -->
                            <div class="flex items-start justify-between mb-5">
                                <div>
                                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Kode Pemesanan</div>
                                    <div class="text-2xl font-black text-brand-900 tracking-wider">{{ $booking->booking_code }}</div>
                                    <div class="text-xs text-slate-400 mt-0.5">Dipesan {{ $booking->created_at->diffForHumans() }}</div>
                                </div>
                                <span class="text-xs font-extrabold px-3 py-1.5 rounded-full border {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <!-- Flight info row -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center bg-slate-50/80 rounded-2xl p-5 border border-slate-100 mb-5">
                                <!-- Airline -->
                                <div class="sm:col-span-1">
                                    @if($booking->flight->airline->logo)
                                        <img src="{{ asset('storage/' . $booking->flight->airline->logo) }}" class="w-10 h-10 object-contain rounded-xl border border-slate-200 p-1 mb-1.5">
                                    @else
                                        <div class="w-10 h-10 bg-brand-900 rounded-xl flex items-center justify-center mb-1.5">
                                            <span class="text-white font-extrabold text-xs">{{ $booking->flight->airline->code }}</span>
                                        </div>
                                    @endif
                                    <div class="font-extrabold text-slate-800 text-sm">{{ $booking->flight->airline->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $booking->flight->flight_number }}</div>
                                </div>

                                <!-- Route + Time -->
                                <div class="sm:col-span-2 flex items-center gap-4">
                                    <div class="text-center flex-1">
                                        <div class="text-2xl font-black text-brand-900">{{ $booking->flight->departure_time->format('H:i') }}</div>
                                        <div class="font-extrabold text-slate-700">{{ $booking->flight->departureAirport->iata_code }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $booking->flight->departure_time->format('d M Y') }}</div>
                                    </div>
                                    <div class="flex-1 text-center">
                                        <div class="h-[2px] bg-slate-200 w-full rounded relative">
                                            <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 text-brand-accent">✈️</span>
                                        </div>
                                        <div class="text-[10px] font-bold text-slate-400 mt-2">Direct Flight</div>
                                    </div>
                                    <div class="text-center flex-1">
                                        <div class="text-2xl font-black text-brand-900">{{ $booking->flight->arrival_time->format('H:i') }}</div>
                                        <div class="font-extrabold text-slate-700">{{ $booking->flight->arrivalAirport->iata_code }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $booking->flight->arrival_time->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom: price + actions -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div>
                                    <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Tagihan</div>
                                    <div class="text-xl font-extrabold text-brand-accent">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                    <div class="text-xs text-slate-400 mt-0.5">{{ $booking->total_passengers }} penumpang</div>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @if($booking->status === 'pending')
                                        <a href="{{ route('customer.pay', $booking) }}"
                                            class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-extrabold py-2.5 px-5 rounded-xl text-sm transition shadow-md">
                                            💳 Bayar Sekarang
                                        </a>
                                    @endif
                                    @if($booking->status === 'confirmed')
                                        <a href="{{ route('customer.ticket.show', $booking) }}"
                                            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-2.5 px-5 rounded-xl text-sm transition shadow-md">
                                            🎫 Lihat E-Tiket
                                        </a>
                                        <a href="{{ route('customer.ticket.download', $booking) }}"
                                            class="inline-flex items-center gap-2 bg-brand-900 hover:bg-brand-800 text-white font-extrabold py-2.5 px-5 rounded-xl text-sm transition shadow-md">
                                            ⬇️ Unduh PDF
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($bookings->hasPages())
            <div class="mt-8">
                {{ $bookings->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection