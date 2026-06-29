@extends('layouts.app')

@section('title', 'Pembayaran - ' . $booking->booking_code)

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Selesaikan Pembayaran</h1>
            <p class="text-slate-500">Kode Booking: <strong class="text-brand-accent">{{ $booking->booking_code }}</strong></p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Booking Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-xl font-bold text-slate-800 mb-4">Detail Pemesanan</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between pb-4 border-b border-slate-200">
                            <div>
                                <div class="text-sm text-slate-500">Penerbangan</div>
                                <div class="font-bold text-lg">{{ $booking->flight->flight_number }}</div>
                                <div class="text-sm text-slate-600">{{ $booking->flight->airline->name }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-slate-500">Rute</div>
                                <div class="font-bold">
                                    {{ $booking->flight->departureAirport->city }} → {{ $booking->flight->arrivalAirport->city }}
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between pb-4 border-b border-slate-200">
                            <div>
                                <div class="text-sm text-slate-500">Tanggal Berangkat</div>
                                <div class="font-bold">{{ $booking->flight->departure_time->format('d M Y') }}</div>
                                <div class="text-sm text-slate-600">{{ $booking->flight->departure_time->format('H:i') }} - {{ $booking->flight->arrival_time->format('H:i') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-slate-500">Jumlah Penumpang</div>
                                <div class="font-bold text-lg">{{ $booking->total_passengers }} orang</div>
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-slate-500 mb-2">Daftar Penumpang</div>
                            @foreach($booking->passengers as $pax)
                                <div class="flex justify-between py-2 text-sm">
                                    <span>{{ $pax->full_name }}</span>
                                    <span class="text-slate-500">Kursi {{ $pax->seat_number }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-slate-800 mb-4">Total Pembayaran</h2>
                    
                    <div class="space-y-2 mb-6">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Harga Tiket</span>
                            <span>Rp {{ number_format($booking->total_price / 1.11, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">PPN (11%)</span>
                            <span>Rp {{ number_format($booking->total_price - ($booking->total_price / 1.11), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold border-t border-slate-200 pt-2">
                            <span>Total</span>
                            <span class="text-brand-accent">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($snapToken)
                        <button id="pay-button" class="w-full bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-3 rounded-lg transition shadow-lg hover:-translate-y-0.5 duration-200">
                            Bayar Sekarang (Midtrans)
                        </button>
                        <p class="text-xs text-slate-500 text-center mt-4">
                            Pembayaran aman terenkripsi melalui Midtrans Snap.
                        </p>
                    @else
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-4 text-left">
                            <div class="flex gap-2 text-amber-800 font-bold text-sm mb-1">
                                <svg class="w-5 h-5 flex-shrink-0 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <span>Mode Uji Coba Offline</span>
                            </div>
                            <p class="text-xs text-amber-700 leading-relaxed">
                                Kredensial Midtrans belum dikonfigurasi. Anda dapat menggunakan simulator pembayaran di bawah untuk menyelesaikan proses pemesanan tiket Anda secara offline.
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('customer.pay.simulate', $booking) }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg transition shadow-md hover:-translate-y-0.5 duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Simulasi Pembayaran Sukses</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if($snapToken)
    <!-- Midtrans Snap JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    @push('scripts')
    <script>
        document.getElementById('pay-button').addEventListener('click', function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    alert('Pembayaran berhasil!');
                    window.location.href = '{{ route('customer.history') }}';
                },
                onPending: function(result) {
                    alert('Pembayaran sedang diproses. Silakan cek riwayat booking Anda.');
                    window.location.href = '{{ route('customer.history') }}';
                },
                onError: function(result) {
                    alert('Pembayaran gagal. Silakan coba lagi.');
                },
                onClose: function() {
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran.');
                }
            });
        });
    </script>
    @endpush
@endif
@endsection