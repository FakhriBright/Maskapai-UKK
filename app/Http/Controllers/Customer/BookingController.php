<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Flight;
use App\Models\Booking;
use App\Models\Passenger;

class BookingController extends Controller
{
    /**
     * Tampilkan denah kursi dan form penumpang untuk booking.
     */
    public function show(Flight $flight)
    {
        $flight->load(['airline', 'departureAirport', 'arrivalAirport']);
        $seats = $flight->airplane->seats()->orderBy('seat_number')->get();
        return view('customer.book', compact('flight', 'seats'));
    }

    /**
     * Simpan reservasi booking tiket baru.
     */
    public function store(Request $request, Flight $flight)
    {
        // Validasi input
        $validated = $request->validate([
            'selected_seats' => 'required|array|min:1',
            'selected_seats.*' => 'required|string|max:10',
            'passengers' => 'required|array|min:1',
            'passengers.*.full_name' => 'required|string|max:255',
            'passengers.*.passport_number' => 'required|string|max:255',
            'passengers.*.gender' => 'required|in:male,female',
            'passengers.*.birth_date' => 'required|date|before:today',
        ]);

        // Pastikan jumlah kursi sama dengan jumlah data penumpang
        if (count($validated['selected_seats']) !== count($validated['passengers'])) {
            return back()->withInput()->withErrors(['seats' => 'Jumlah kursi yang dipilih harus sama dengan jumlah data penumpang.']);
        }

        // Ambil data kursi yang dipilih dari pesawat ini
        $seats = $flight->airplane->seats()
            ->whereIn('seat_number', $validated['selected_seats'])
            ->get();

        if ($seats->count() !== count($validated['selected_seats'])) {
            return back()->withInput()->withErrors(['seats' => 'Beberapa nomor kursi yang Anda pilih tidak terdaftar.']);
        }

        // Cek ketersediaan kursi lagi (Double Check terhadap booking confirmed)
        $bookedSeats = Passenger::whereIn('seat_number', $validated['selected_seats'])
            ->whereHas('booking', fn($q) => $q->where('flight_id', $flight->id)->where('status', 'confirmed'))
            ->exists();

        if ($bookedSeats) {
            return back()->withInput()->withErrors(['seats' => 'Maaf, salah satu kursi yang Anda pilih baru saja dipesan orang lain.']);
        }

        // Hitung total harga berdasarkan kelas kursi & PPN 11%
        $subtotal = 0;
        foreach ($validated['selected_seats'] as $seatNum) {
            $seat = $seats->firstWhere('seat_number', $seatNum);
            $multiplier = 1.0;
            if ($seat->class === 'business') {
                $multiplier = 1.5;
            } elseif ($seat->class === 'first') {
                $multiplier = 2.0;
            }
            $subtotal += $flight->price * $multiplier;
        }

        $totalPrice = $subtotal * 1.11; // PPN 11%

        DB::beginTransaction();
        try {
            // Buat Booking
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'flight_id' => $flight->id,
                'booking_code' => 'MSK-' . strtoupper(Str::random(6)),
                'total_passengers' => count($validated['passengers']),
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            // Simpan Penumpang
            foreach ($validated['passengers'] as $index => $pax) {
                Passenger::create([
                    'booking_id' => $booking->id,
                    'user_id' => auth()->id(),
                    'full_name' => $pax['full_name'],
                    'passport_number' => $pax['passport_number'],
                    'seat_number' => $validated['selected_seats'][$index],
                    'gender' => $pax['gender'],
                    'birth_date' => $pax['birth_date'],
                ]);
            }

            // Simpan Pembayaran Awal
            \App\Models\Payment::create([
                'booking_id' => $booking->id,
                'amount' => $totalPrice,
                'payment_status' => 'pending',
            ]);

            DB::commit();
            return redirect()->route('customer.pay', $booking);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal memproses booking: ' . $e->getMessage()]);
        }
    }
}
