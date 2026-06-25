@extends('layouts.app')

@section('title', 'Riwayat Booking')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-800">Riwayat Booking</h1>
            <p class="text-slate-500 mt-1">Semua pemesanan tiket Anda</p>
        </div>

        @if($bookings->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                <svg class="w-20 h-20 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Booking</h3>
                <p class="text-slate-500 mb-4">Anda belum melakukan pemesanan tiket apapun.</p>
                <a href="{{ route('customer.dashboard') }}" class="inline-block bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-2 px-6 rounded-lg transition">
                    Cari Penerbangan
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($bookings as $booking)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <div class="text-sm text-slate-500">Kode Booking</div>
                                <div class="text-2xl font-bold text-brand-900">{{ $booking->booking_code }}</div>
                            </div>
                            <div class="text-right">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'confirmed' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu Pembayaran',
                                        'confirmed' => 'Terkonfirmasi',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                @endphp
                                <span class="px-3 py-1 {{ $statusColors[$booking->status] }} rounded-full text-sm font-bold">
                                    {{ $statusLabels[$booking->status] }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-4 items-center">
                            <div class="col-span-3">
                                <div class="font-bold text-slate-800">{{ $booking->flight->airline->name }}</div>
                                <div class="text-sm text-slate-500">{{ $booking->flight->flight_number }}</div>
                            </div>

                            <div class="col-span-3">
                                <div class="text-lg font-bold">{{ $booking->flight->departureAirport->iata_code }}</div>
                                <div class="text-sm text-slate-500">{{ $booking->flight->departure_time->format('d M Y, H:i') }}</div>
                            </div>

                            <div class="col-span-1 text-center">
                                <svg class="w-6 h-6 mx-auto text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>

                            <div class="col-span-3">
                                <div class="text-lg font-bold">{{ $booking->flight->arrivalAirport->iata_code }}</div>
                                <div class="text-sm text-slate-500">{{ $booking->flight->arrival_time->format('d M Y, H:i') }}</div>
                            </div>

                            <div class="col-span-2 text-right">
                                <div class="text-xl font-bold text-brand-accent">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                <div class="text-xs text-slate-500">{{ $booking->total_passengers }} penumpang</div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 mt-4 pt-4 border-t border-slate-200">
                            @if($booking->status === 'pending')
                                <a href="{{ route('customer.pay', $booking) }}" class="bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-2 px-4 rounded-lg text-sm transition">
                                    Bayar Sekarang
                                </a>
                            @endif
                            @if($booking->status === 'confirmed')
                                <a href="{{ route('customer.ticket.download', $booking) }}" class="bg-brand-900 hover:bg-brand-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
                                    Unduh E-Tiket
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection