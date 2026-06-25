<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Flight;

class CheckinController extends Controller
{
    /**
     * Tampilkan daftar penumpang yang bisa check-in untuk satu penerbangan.
     */
    public function flight(Flight $flight) {
        $flight->load(['airline', 'departureAirport', 'arrivalAirport']);

        $passengers = Passenger::with(['booking.payment'])
            ->whereHas('booking', function ($query) use ($flight) {
                $query->where('flight_id', $flight->id)
                    ->where('status', 'confirmed');
            })
            ->orderBy('seat_number')
            ->get();

        return view('staff.checkin', compact('flight', 'passengers'));
    }

    /**
     * Tampilkan halaman check-in untuk booking tertentu.
     */
    public function show(Booking $booking) {
        $booking->load(['passengers', 'payment', 'flight.airline', 'flight.departureAirport', 'flight.arrivalAirport']);
        return view('staff.booking-checkin', compact('booking'));
    }

    /**
     * Proses check-in penumpang terpilih.
     */
    public function process(Request $request, Booking $booking) {
        $booking->load('payment');
        
        if (!$booking->payment || $booking->payment->payment_status !== 'paid') {
            return back()->withErrors(['error' => 'Gagal check-in: Pemesanan ini belum diselesaikan pembayarannya (belum lunas).']);
        }

        $validated = $request->validate([
            'passenger_ids' => 'required|array',
            'passenger_ids.*' => 'exists:passengers,id'
        ]);
        
        DB::beginTransaction();
        try {
            foreach ($validated['passenger_ids'] as $pid) {
                $passenger = Passenger::where('id', $pid)->where('booking_id', $booking->id)->first();
                if ($passenger && !$passenger->checked_in_at) {
                    $passenger->update(['checked_in_at' => now()]);
                }
            }
            DB::commit();
            return back()->with('success', 'Check-in penumpang berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memproses check-in: ' . $e->getMessage()]);
        }
    }
}
