@extends('layouts.app')

@section('title', 'Pilih Kursi & Data Penumpang - SkyLine Airways')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-between max-w-3xl mx-auto text-xs sm:text-sm font-bold text-slate-400">
                <div class="flex flex-col items-center gap-2 text-brand-900">
                    <span class="w-8 h-8 rounded-full bg-brand-accent text-brand-900 flex items-center justify-center font-black">1</span>
                    <span>Cari Tiket</span>
                </div>
                <div class="h-0.5 bg-brand-accent flex-grow mx-4"></div>
                <div class="flex flex-col items-center gap-2 text-brand-900">
                    <span class="w-8 h-8 rounded-full bg-brand-accent text-brand-900 flex items-center justify-center font-black">2</span>
                    <span>Pilih Penerbangan</span>
                </div>
                <div class="h-0.5 bg-brand-accent flex-grow mx-4"></div>
                <div class="flex flex-col items-center gap-2 text-brand-900">
                    <span class="w-8 h-8 rounded-full bg-brand-900 text-white flex items-center justify-center font-black">3</span>
                    <span class="text-brand-900 font-extrabold">Pilih Kursi & Data</span>
                </div>
                <div class="h-0.5 bg-slate-200 flex-grow mx-4"></div>
                <div class="flex flex-col items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center">4</span>
                    <span>Pembayaran</span>
                </div>
                <div class="h-0.5 bg-slate-200 flex-grow mx-4"></div>
                <div class="flex flex-col items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center">5</span>
                    <span>E-Ticket</span>
                </div>
            </div>
        </div>
        
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
                        {{ $flight->departure_time->format('d M Y, H:i') }} WIB
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('customer.booking.store', $flight) }}" method="POST" id="bookingForm">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- LEFT: Cabin & Seat Map -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                        
                        <!-- Cabin Class Tabs -->
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Kelas Kabin</label>
                            <input type="hidden" name="cabin_class" id="cabinClassInput" value="economy">
                            <div class="grid grid-cols-3 gap-3">
                                @foreach($flight->flightClasses as $fc)
                                    <button type="button" 
                                        class="cabin-tab-btn p-4 rounded-2xl border-2 text-left transition flex flex-col justify-between h-28 focus:outline-none"
                                        data-class="{{ $fc->class_name }}"
                                        data-multiplier="{{ $fc->price_multiplier }}"
                                        data-baggage="{{ $fc->baggage_allowance }}"
                                        data-meal="{{ $fc->meal_type }}"
                                        data-lounge="{{ $fc->lounge_access ? 'Lounge VIP Gratis' : 'Tidak Tersedia' }}"
                                        data-seattype="{{ $fc->class_name === 'first' ? 'Sleeper Pod Suite' : ($fc->class_name === 'business' ? 'Flat-bed Ergonomic' : 'Standard Coach') }}"
                                        data-refund="{{ $fc->class_name === 'first' ? 'Full Refund Bebas Biaya' : ($fc->class_name === 'business' ? 'Bisa Refund 90%' : 'Tidak Bisa Refund') }}">
                                        
                                        <div class="flex justify-between items-center w-full">
                                            <span class="font-extrabold text-sm capitalize">{{ $fc->class_name }}</span>
                                            <span class="class-dot w-3.5 h-3.5 rounded-full inline-block
                                                {{ $fc->class_name === 'first' ? 'bg-amber-500' : ($fc->class_name === 'business' ? 'bg-blue-600' : 'bg-emerald-500') }}"></span>
                                        </div>
                                        <div>
                                            <span class="text-[10px] text-slate-400 block uppercase font-bold tracking-wider">Mulai</span>
                                            <span class="text-sm font-extrabold text-slate-800">Rp {{ number_format($flight->price * $fc->price_multiplier, 0, ',', '.') }}</span>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Cabin Class Facilities Card -->
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 mb-6" id="facilityCard">
                            <h3 class="font-extrabold text-xs text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Fasilitas Layanan Kelas
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-xs font-semibold text-slate-700">
                                <div class="flex items-center gap-2 bg-white px-3 py-2 rounded-xl border border-slate-100">
                                    🧳 <span id="facBaggage">20 kg</span> Bagasi
                                </div>
                                <div class="flex items-center gap-2 bg-white px-3 py-2 rounded-xl border border-slate-100">
                                    🍽️ <span id="facMeal">Snack</span>
                                </div>
                                <div class="flex items-center gap-2 bg-white px-3 py-2 rounded-xl border border-slate-100">
                                    💺 <span id="facSeatType">Standard</span>
                                </div>
                                <div class="flex items-center gap-2 bg-white px-3 py-2 rounded-xl border border-slate-100">
                                    🍸 Lounge: <span id="facLounge">Tidak Ada</span>
                                </div>
                                <div class="flex items-center gap-2 bg-white px-3 py-2 rounded-xl border border-slate-100 col-span-2">
                                    🔄 Kebijakan: <span id="facRefund">No Refund</span>
                                </div>
                            </div>
                        </div>

                        <h2 class="text-xl font-bold text-slate-800 mb-4">Pilih Kursi Anda</h2>
                        
                        <!-- Legend -->
                        <div class="flex flex-wrap gap-4 mb-6 text-xs font-bold text-slate-500 border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 bg-emerald-500 rounded-lg"></div>
                                <span>Tersedia (Economy)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 bg-blue-600 rounded-lg"></div>
                                <span>Tersedia (Business)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 bg-amber-500 rounded-lg"></div>
                                <span>Tersedia (First Class)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 bg-red-500 rounded-lg"></div>
                                <span>Terisi</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 bg-brand-accent rounded-lg"></div>
                                <span>Pilihan Anda</span>
                            </div>
                        </div>

                        <!-- Seat Grid -->
                        <div class="bg-slate-50 rounded-2xl p-6 overflow-x-auto border border-slate-200/80">
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
                                    <div class="row-container flex items-center justify-center gap-2 mb-2" data-row="{{ $rowNum }}">
                                        <span class="w-8 text-center text-sm font-bold text-slate-400">{{ $rowNum }}</span>
                                        
                                        <!-- Column Left -->
                                        @foreach(['A', 'B', 'C'] as $col)
                                            @php
                                                $seat = $rowSeats->firstWhere('seat_number', $rowNum . $col);
                                                $isBooked = $seat && in_array($rowNum . $col, $bookedSeats);
                                                $class = $seat ? $seat->class : '';
                                            @endphp
                                            @if($seat)
                                                <button type="button" 
                                                    class="seat-btn w-10 h-10 rounded-lg font-bold text-xs transition text-white"
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

                                        <!-- Aisle Space -->
                                        <div class="w-8 flex items-center justify-center text-[10px] font-bold text-slate-300 uppercase tracking-widest">
                                            AISLE
                                        </div>

                                        <!-- Column Right -->
                                        @foreach(['D', 'E', 'F'] as $col)
                                            @php
                                                $seat = $rowSeats->firstWhere('seat_number', $rowNum . $col);
                                                $isBooked = $seat && in_array($rowNum . $col, $bookedSeats);
                                                $class = $seat ? $seat->class : '';
                                            @endphp
                                            @if($seat)
                                                <button type="button" 
                                                    class="seat-btn w-10 h-10 rounded-lg font-bold text-xs transition text-white"
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
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-slate-800 mb-4">Data Penumpang</h2>
                        
                        <div id="passengerForms">
                            <div class="text-center text-slate-500 py-8">
                                <p class="text-sm font-semibold">Pilih kursi di sebelah kiri terlebih dahulu</p>
                            </div>
                        </div>

                        <!-- Price Summary -->
                        <div id="priceSummary" class="hidden border-t border-slate-200 mt-6 pt-6">
                            <div class="flex justify-between mb-2 text-sm font-medium">
                                <span class="text-slate-600">Subtotal</span>
                                <span id="subtotal" class="font-bold text-slate-850">Rp 0</span>
                            </div>
                            <div class="flex justify-between mb-4 text-sm font-medium">
                                <span class="text-slate-600">PPN (11%)</span>
                                <span id="tax" class="font-bold text-slate-850">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold border-t border-slate-200 pt-4">
                                <span class="text-brand-900">Total Tagihan</span>
                                <span id="total" class="text-brand-accent">Rp 0</span>
                            </div>
                        </div>

                        <button type="submit" id="submitBtn" class="w-full bg-brand-accent hover:bg-amber-500 text-brand-900 font-extrabold py-3.5 rounded-xl mt-6 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-lg" disabled>
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
    let currentClass = 'economy';
    let classMultiplier = 1.0;

    const classTabs = document.querySelectorAll('.cabin-tab-btn');
    const cabinClassInput = document.getElementById('cabinClassInput');

    classTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const cabinClass = this.dataset.class;
            classMultiplier = parseFloat(this.dataset.multiplier);
            
            // Set input value
            cabinClassInput.value = cabinClass;
            currentClass = cabinClass;

            // Reset active tab styling
            classTabs.forEach(t => {
                t.classList.remove('border-brand-900', 'bg-slate-50', 'ring-2', 'ring-brand-900/10');
                t.classList.add('border-slate-200', 'bg-white');
            });
            // Set active styling on current tab
            this.classList.remove('border-slate-200', 'bg-white');
            this.classList.add('border-brand-900', 'bg-slate-50', 'ring-2', 'ring-brand-900/10');

            // Update facilities display
            document.getElementById('facBaggage').textContent = this.dataset.baggage + ' kg';
            document.getElementById('facMeal').textContent = this.dataset.meal;
            document.getElementById('facLounge').textContent = this.dataset.lounge;
            document.getElementById('facSeatType').textContent = this.dataset.seattype;
            document.getElementById('facRefund').textContent = this.dataset.refund;

            // Clear selected seats map
            selectedSeats.clear();

            // Refresh seats list visibility
            document.querySelectorAll('.seat-btn').forEach(btn => {
                const btnClass = btn.dataset.class;
                // Reset select state
                btn.classList.remove('ring-4', 'ring-brand-accent', 'scale-105', 'bg-brand-accent', 'text-brand-900');
                
                const originalBg = btnClass === 'first' ? 'bg-amber-500' : (btnClass === 'business' ? 'bg-blue-600' : 'bg-emerald-500');
                const originalHover = btnClass === 'first' ? 'hover:bg-amber-600' : (btnClass === 'business' ? 'hover:bg-blue-700' : 'hover:bg-emerald-600');
                
                btn.className = `seat-btn w-10 h-10 rounded-lg font-bold text-xs transition text-white ${originalBg} ${originalHover}`;
                
                if (btn.disabled) {
                    btn.className = `seat-btn w-10 h-10 rounded-lg font-bold text-xs bg-red-500 text-white cursor-not-allowed`;
                }

                // Show only seats of selected class
                const parentRow = btn.closest('.row-container');
                if (btnClass === cabinClass) {
                    btn.style.display = 'inline-block';
                } else {
                    btn.style.display = 'none';
                }
            });

            // Adjust parents rows: if a row container has no visible seats, hide the row!
            document.querySelectorAll('.row-container').forEach(row => {
                const visibleSeats = Array.from(row.querySelectorAll('.seat-btn')).filter(b => b.style.display !== 'none');
                if (visibleSeats.length === 0) {
                    row.style.display = 'none';
                } else {
                    row.style.display = 'flex';
                }
            });

            updatePassengerForms();
            updatePriceSummary();
        });
    });

    document.querySelectorAll('.seat-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const seatId = this.dataset.seat;
            const seatNumber = this.dataset.number;
            const seatClass = this.dataset.class;
            
            const originalBg = seatClass === 'first' ? 'bg-amber-500' : (seatClass === 'business' ? 'bg-blue-600' : 'bg-emerald-500');
            const originalHover = seatClass === 'first' ? 'hover:bg-amber-600' : (seatClass === 'business' ? 'hover:bg-blue-700' : 'hover:bg-emerald-600');

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
            container.innerHTML = '<div class="text-center text-slate-500 py-8"><p class="text-sm font-semibold">Pilih kursi di sebelah kiri terlebih dahulu</p></div>';
            document.getElementById('submitBtn').disabled = true;
            return;
        }

        let html = '';
        let index = 0;
        selectedSeats.forEach((seat, seatId) => {
            html += `
                <div class="mb-4 p-4 bg-slate-50 border border-slate-200 rounded-2xl">
                    <div class="font-extrabold text-xs text-slate-600 uppercase mb-2 flex justify-between">
                        <span>Penumpang ${index + 1}</span>
                        <span class="text-brand-accent">Kursi ${seat.number} (${seat.class.toUpperCase()})</span>
                    </div>
                    <input type="hidden" name="selected_seats[]" value="${seat.number}">
                    
                    <div class="space-y-3">
                        <input type="text" name="passengers[${index}][full_name]" placeholder="Nama Lengkap Sesuai Identitas" required 
                            class="w-full border border-slate-300 bg-white rounded-xl px-3 py-2.5 text-xs focus:ring-1 focus:ring-brand-accent">
                            
                        <input type="text" name="passengers[${index}][passport_number]" placeholder="No. KTP / Paspor" required 
                            class="w-full border border-slate-300 bg-white rounded-xl px-3 py-2.5 text-xs focus:ring-1 focus:ring-brand-accent">
                            
                        <div class="grid grid-cols-2 gap-2">
                            <select name="passengers[${index}][gender]" required class="border border-slate-300 bg-white rounded-xl px-3 py-2.5 text-xs">
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                            <input type="date" name="passengers[${index}][birth_date]" required class="border border-slate-300 bg-white rounded-xl px-3 py-2.5 text-xs">
                        </div>
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

        const seatCount = selectedSeats.size;
        const subtotal = flightPrice * classMultiplier * seatCount;
        const tax = subtotal * 0.11;
        const total = subtotal + tax;

        document.getElementById('subtotal').textContent = 'Rp ' + formatNumber(subtotal);
        document.getElementById('tax').textContent = 'Rp ' + formatNumber(tax);
        document.getElementById('total').textContent = 'Rp ' + formatNumber(total);
    }

    function formatNumber(num) {
        return Math.round(num).toLocaleString('id-ID');
    }

    // Trigger click on default tab (Economy) on page load
    document.addEventListener('DOMContentLoaded', () => {
        const economyTab = document.querySelector('.cabin-tab-btn[data-class="economy"]');
        if (economyTab) {
            economyTab.click();
        }
    });
</script>
@endpush
@endsection