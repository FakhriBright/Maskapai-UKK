<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Booking;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard Staff dengan daftar penerbangan aktif dan pencarian booking code.
     */
    public function index(Request $request) {
        // Jika mencari berdasarkan kode booking, langsung alihkan ke halaman check-in
        if ($request->filled('booking_code')) {
            $booking = Booking::where('booking_code', trim(strtoupper($request->booking_code)))->first();
            if ($booking) {
                return redirect()->route('staff.checkin.show', $booking);
            }
            return back()->withErrors(['booking_code' => 'Kode booking tidak ditemukan.']);
        }

        $search = $request->query('search');
        $flights = Flight::with(['airline', 'departureAirport', 'arrivalAirport'])
            ->when($search, fn($q) => $q->where('flight_number', 'like', "%{$search}%"))
            ->where('departure_time', '>=', now()->subDays(1))
            ->orderBy('departure_time')
            ->paginate(15);
            
        return view('staff.dashboard', compact('flights'));
    }

    /**
     * Tampilkan manifest penumpang untuk penerbangan tertentu.
     */
    public function manifest(Flight $flight) {
        $flight->load(['airline', 'departureAirport', 'arrivalAirport', 'airplane']);
        
        $bookings = Booking::where('flight_id', $flight->id)
            ->where('status', 'confirmed')
            ->with(['passengers', 'user'])
            ->get();
            
        return view('staff.manifest', compact('flight', 'bookings'));
    }
}