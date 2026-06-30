@extends('layouts.app')

@section('title', 'Pembayaran · ' . $booking->booking_code . ' - SkyLine Airways')

@section('content')
<div class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 bg-amber-100 text-amber-800 border border-amber-200 text-xs font-extrabold px-4 py-1.5 rounded-full mb-4 uppercase tracking-wider">
                ⏳ Menunggu Pembayaran
            </div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Selesaikan Pembayaran</h1>
            <p class="text-slate-500 mt-2">
                Kode Booking: <strong class="text-brand-accent font-extrabold tracking-widest">{{ $booking->booking_code }}</strong>
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- ──────────────────────────────────────────────────────────────
                 LEFT: BOOKING DETAILS
            ────────────────────────────────────────────────────────────── --}}
            <div class="lg:col-span-3 space-y-5">

                <!-- Flight Card -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="font-extrabold text-slate-800 text-lg">Detail Penerbangan</h2>
                        <span class="text-xs font-bold text-slate-400">{{ $booking->flight->flight_number }}</span>
                    </div>

                    <!-- Airline + Route -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-5 bg-slate-50 rounded-2xl p-5 border border-slate-100 mb-5">
                        <div class="flex-shrink-0">
                            @if($booking->flight->airline->logo)
                                <img src="{{ asset('storage/' . $booking->flight->airline->logo) }}" class="w-14 h-14 object-contain rounded-xl border border-slate-200 p-1.5">
                            @else
                                <div class="w-14 h-14 bg-brand-900 rounded-xl flex items-center justify-center">
                                    <span class="text-white font-extrabold">{{ $booking->flight->airline->code }}</span>
                                </div>
                            @endif
                            <div class="text-xs font-extrabold text-slate-600 text-center mt-1">{{ $booking->flight->airline->name }}</div>
                        </div>

                        <div class="flex-1 flex items-center gap-3">
                            <div class="text-center flex-1">
                                <div class="text-3xl font-black text-brand-900">{{ $booking->flight->departure_time->format('H:i') }}</div>
                                <div class="text-base font-extrabold text-slate-700">{{ $booking->flight->departureAirport->iata_code }}</div>
                                <div class="text-xs text-slate-400">{{ $booking->flight->departureAirport->city }}</div>
                                <div class="text-xs text-slate-400">{{ $booking->flight->departure_time->format('d M Y') }}</div>
                            </div>
                            <div class="flex-1 text-center px-2">
                                <div class="h-px bg-slate-200 relative">
                                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 text-xl">✈️</span>
                                </div>
                                <div class="text-[10px] font-bold text-slate-400 mt-4">Direct Flight</div>
                            </div>
                            <div class="text-center flex-1">
                                <div class="text-3xl font-black text-brand-900">{{ $booking->flight->arrival_time->format('H:i') }}</div>
                                <div class="text-base font-extrabold text-slate-700">{{ $booking->flight->arrivalAirport->iata_code }}</div>
                                <div class="text-xs text-slate-400">{{ $booking->flight->arrivalAirport->city }}</div>
                                <div class="text-xs text-slate-400">{{ $booking->flight->arrival_time->format('d M Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Passengers -->
                    <div>
                        <div class="text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-3">
                            Daftar Penumpang ({{ $booking->total_passengers }} orang)
                        </div>
                        <div class="space-y-2">
                            @foreach($booking->passengers as $i => $pax)
                                <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3 border border-slate-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-7 h-7 rounded-full bg-brand-900 text-white flex items-center justify-center text-xs font-extrabold flex-shrink-0">
                                            {{ $i + 1 }}
                                        </div>
                                        <span class="font-bold text-sm text-slate-800">{{ $pax->full_name }}</span>
                                    </div>
                                    <span class="text-xs font-extrabold text-brand-accent bg-brand-900 px-2.5 py-1 rounded-lg">
                                        {{ $pax->seat_number }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- ──────────────────────────────────────────────────────────────
                 RIGHT: PAYMENT SUMMARY
            ────────────────────────────────────────────────────────────── --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sticky top-24">
                    <h2 class="font-extrabold text-slate-800 text-lg mb-5">Ringkasan Pembayaran</h2>

                    <!-- Price Breakdown -->
                    <div class="space-y-3 mb-5">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">Harga tiket ({{ $booking->total_passengers }} pax)</span>
                            <span class="font-semibold text-slate-700">Rp {{ number_format($booking->total_price / 1.11, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">PPN (11%)</span>
                            <span class="font-semibold text-slate-700">Rp {{ number_format($booking->total_price - ($booking->total_price / 1.11), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">Biaya layanan</span>
                            <span class="font-semibold text-emerald-600">Gratis</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center py-4 border-t border-b border-slate-100 mb-5">
                        <span class="font-extrabold text-slate-800 text-base">Total Tagihan</span>
                        <span class="text-xl font-black text-brand-accent">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>

                    @if($snapToken)
                        <button id="pay-button"
                            class="w-full bg-brand-accent hover:bg-amber-500 text-brand-900 font-extrabold py-4 rounded-2xl transition shadow-lg hover:-translate-y-0.5 duration-200 text-sm flex items-center justify-center gap-2 mb-3">
                            💳 Bayar via Midtrans
                        </button>
                    @else
                        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-4">
                            <div class="flex gap-2 text-amber-800 font-bold text-sm mb-1">
                                <span>⚠️</span><span>Mode Offline / Demo</span>
                            </div>
                            <p class="text-xs text-amber-700 leading-relaxed">
                                Midtrans belum dikonfigurasi. Gunakan tombol simulasi di bawah untuk menyelesaikan pembayaran.
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('customer.pay.simulate', $booking) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3.5 rounded-2xl transition shadow-md hover:-translate-y-0.5 duration-200 text-sm flex items-center justify-center gap-2">
                            ✅ Simulasi Pembayaran Sukses
                        </button>
                    </form>

                    <p class="text-[10px] text-slate-400 text-center mt-4 leading-relaxed">
                        Pembayaran dilindungi enkripsi SSL 256-bit.<br>Data Anda aman bersama kami.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@if($snapToken)
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    @push('scripts')
    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function () { window.location.href = '{{ route('customer.history') }}'; },
                onPending: function () { window.location.href = '{{ route('customer.history') }}'; },
                onError:   function () { alert('Pembayaran gagal. Silakan coba lagi.'); },
                onClose:   function () { /* user closed popup */ }
            });
        });
    </script>
    @endpush
@endif

@endsection