@extends('layouts.app')

@section('title', 'Pilih Kursi - ' . $flight->flight_number)

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Flight Summary Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-brand-900 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold">{{ $flight->airline->code }}</span>
                    </div>
                    <div>
                        <div class="font-bold text-lg text-slate-800">{{ $flight->airline->name }}</div>
                        <div class="text-sm text-slate-500">{{ $flight->flight_number }} · {{ $flight->airplane->model }}</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-brand-900">
                        {{ $flight->departureAirport->iata_code }} → {{ $flight->arrivalAirport->iata_code }}
                    </div>
                    <div class="text-sm text-slate-500">
                        {{ $flight->departure_time->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('customer.booking.store', $flight) }}" method="POST" id="bookingForm">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- LEFT: Seat Map -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h2 class="text-xl font-bold text-slate-800 mb-4">Pilih Kursi Anda</h2>
                        
                        <!-- Legend -->
                        <div class="flex flex-wrap gap-4 mb-6 text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 bg-green-500 rounded"></div>
                                <span>Tersedia</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 bg-red-500 rounded"></div>
                                <span>Terisi</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 bg-brand-accent rounded"></div>
                                <span>Dipilih</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 bg-purple-500 rounded"></div>
                                <span>Business</span>
                            </div>
                        </div>

                        <!-- Seat Grid -->
                        <div class="bg-slate-50 rounded-xl p-6 overflow-x-auto">
                            <div class="min-w-[400px]">
                                @php
                                    $seatsByRow = $seats->groupBy(function($seat) {
                                        return preg_replace('/[A-F]/', '', $seat->seat_number);
                                    })->sortBy(function($row, $rowNum) {
                                        return (int) $rowNum;
                                    });
                                    
                                    // Get booked seats
                                    $bookedSeats = \App\Models\Passenger::whereHas('booking', function($q) use ($flight) {
                                        $q->where('flight_id', $flight->id)->where('status', 'confirmed');
                                    })->pluck('seat_number')->toArray();
                                @endphp

                                @foreach($seatsByRow as $rowNum => $rowSeats)
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <span class="w-8 text-center text-sm font-bold text-slate-500">{{ $rowNum }}</span>
                                        
                                        @foreach(['A', 'B', 'C'] as $col)
                                            @php
                                                $seat = $rowSeats->firstWhere('seat_number', $rowNum . $col);
                                                $isBooked = in_array($rowNum . $col, $bookedSeats);
                                                $isBusiness = $seat && $seat->class === 'business';
                                            @endphp
                                            @if($seat)
                                                <button type="button" 
                                                    class="seat-btn w-10 h-10 rounded-lg font-bold text-xs transition
                                                        {{ $isBooked ? 'bg-red-500 text-white cursor-not-allowed' : ($isBusiness ? 'bg-purple-500 text-white hover:bg-purple-600' : 'bg-green-500 text-white hover:bg-green-600') }}"
                                                    data-seat="{{ $seat->id }}"
                                                    data-number="{{ $seat->seat_number }}"
                                                    data-class="{{ $seat->class }}"
                                                    {{ $isBooked ? 'disabled' : '' }}>
                                                    {{ $col }}
                                                </button>
                                            @else
                                                <div class="w-10 h-10"></div>
                                            @endif
                                        @endforeach

                                        <div class="w-8"></div> <!-- Aisle -->

                                        @foreach(['D', 'E', 'F'] as $col)
                                            @php
                                                $seat = $rowSeats->firstWhere('seat_number', $rowNum . $col);
                                                $isBooked = in_array($rowNum . $col, $bookedSeats);
                                                $isBusiness = $seat && $seat->class === 'business';
                                            @endphp
                                            @if($seat)
                                                <button type="button" 
                                                    class="seat-btn w-10 h-10 rounded-lg font-bold text-xs transition
                                                        {{ $isBooked ? 'bg-red-500 text-white cursor-not-allowed' : ($isBusiness ? 'bg-purple-500 text-white hover:bg-purple-600' : 'bg-green-500 text-white hover:bg-green-600') }}"
                                                    data-seat="{{ $seat->id }}"
                                                    data-number="{{ $seat->seat_number }}"
                                                    data-class="{{ $seat->class }}"
                                                    {{ $isBooked ? 'disabled' : '' }}>
                                                    {{ $col }}
                                                </button>
                                            @else
                                                <div class="w-10 h-10"></div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Hidden Input for Selected Seats -->
                        <div id="selectedSeatsContainer" class="mt-4"></div>
                    </div>
                </div>

                <!-- RIGHT: Passenger Form & Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-slate-800 mb-4">Data Penumpang</h2>
                        
                        <div id="passengerForms">
                            <div class="text-center text-slate-500 py-8">
                                <p>Pilih kursi terlebih dahulu</p>
                            </div>
                        </div>

                        <!-- Price Summary -->
                        <div id="priceSummary" class="hidden border-t border-slate-200 mt-6 pt-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-slate-600">Subtotal</span>
                                <span id="subtotal" class="font-bold">Rp 0</span>
                            </div>
                            <div class="flex justify-between mb-4">
                                <span class="text-slate-600">PPN (11%)</span>
                                <span id="tax" class="font-bold">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold border-t border-slate-200 pt-4">
                                <span>Total</span>
                                <span id="total" class="text-brand-accent">Rp 0</span>
                            </div>
                        </div>

                        <button type="submit" id="submitBtn" class="w-full bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-3 rounded-lg mt-6 transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            Lanjut ke Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const flightPrice = {{ $flight->price }};
    const selectedSeats = new Map();

    document.querySelectorAll('.seat-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const seatId = this.dataset.seat;
            const seatNumber = this.dataset.number;
            const seatClass = this.dataset.class;
            
            const originalBg = seatClass === 'business' ? 'bg-purple-500' : 'bg-green-500';
            const originalHover = seatClass === 'business' ? 'hover:bg-purple-600' : 'hover:bg-green-600';

            if (selectedSeats.has(seatId)) {
                selectedSeats.delete(seatId);
                this.classList.remove('ring-4', 'ring-brand-accent', 'scale-105', 'bg-brand-accent', 'text-brand-900');
                this.classList.add(originalBg, 'text-white', originalHover);
            } else {
                selectedSeats.set(seatId, { number: seatNumber, class: seatClass });
                this.classList.remove(originalBg, originalHover, 'text-white');
                this.classList.add('ring-4', 'ring-brand-accent', 'scale-105', 'bg-brand-accent', 'text-brand-900');
            }

            updatePassengerForms();
            updatePriceSummary();
        });
    });

    function updatePassengerForms() {
        const container = document.getElementById('passengerForms');
        
        if (selectedSeats.size === 0) {
            container.innerHTML = '<div class="text-center text-slate-500 py-8"><p>Pilih kursi terlebih dahulu</p></div>';
            return;
        }

        let html = '';
        let index = 0;
        selectedSeats.forEach((seat, seatId) => {
            html += `
                <div class="mb-4 p-4 bg-slate-50 rounded-lg">
                    <div class="font-bold text-sm text-slate-700 mb-2">Penumpang ${index + 1} - Kursi ${seat.number} (${seat.class})</div>
                    <input type="hidden" name="selected_seats[]" value="${seat.number}">
                    <input type="text" name="passengers[${index}][full_name]" placeholder="Nama Lengkap" required class="w-full border border-slate-300 rounded px-3 py-2 text-sm mb-2">
                    <input type="text" name="passengers[${index}][passport_number]" placeholder="No. Paspor/NIK" required class="w-full border border-slate-300 rounded px-3 py-2 text-sm mb-2">
                    <div class="grid grid-cols-2 gap-2">
                        <select name="passengers[${index}][gender]" required class="border border-slate-300 rounded px-3 py-2 text-sm">
                            <option value="male">Laki-laki</option>
                            <option value="female">Perempuan</option>
                        </select>
                        <input type="date" name="passengers[${index}][birth_date]" required class="border border-slate-300 rounded px-3 py-2 text-sm">
                    </div>
                </div>
            `;
            index++;
        });

        container.innerHTML = html;
        document.getElementById('submitBtn').disabled = false;
    }

    function updatePriceSummary() {
        const summary = document.getElementById('priceSummary');
        
        if (selectedSeats.size === 0) {
            summary.classList.add('hidden');
            return;
        }

        summary.classList.remove('hidden');

        let subtotal = 0;
        selectedSeats.forEach(seat => {
            let multiplier = 1;
            if (seat.class === 'business') multiplier = 1.5;
            if (seat.class === 'first') multiplier = 2.0;
            subtotal += flightPrice * multiplier;
        });

        const tax = subtotal * 0.11;
        const total = subtotal + tax;

        document.getElementById('subtotal').textContent = 'Rp ' + formatNumber(subtotal);
        document.getElementById('tax').textContent = 'Rp ' + formatNumber(tax);
        document.getElementById('total').textContent = 'Rp ' + formatNumber(total);
    }

    function formatNumber(num) {
        return Math.round(num).toLocaleString('id-ID');
    }
</script>
@endpush
@endsection