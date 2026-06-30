<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Booking;
use App\Models\Passenger;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Quick search by booking code
        if ($request->filled('booking_code')) {
            $booking = Booking::where('booking_code', trim(strtoupper($request->booking_code)))->first();
            if ($booking) {
                return redirect()->route('staff.checkin.show', $booking);
            }
            return back()->withErrors(['booking_code' => 'Kode booking tidak ditemukan.']);
        }

        $search = $request->query('search');

        // Stats for today
        $todayFlightsCount = Flight::whereDate('departure_time', today())->count();
        $todayBoardingCount = Flight::whereDate('departure_time', today())->where('status', 'boarding')->count();
        $todayPassengers = DB::table('passengers')
            ->join('bookings', 'passengers.booking_id', '=', 'bookings.id')
            ->join('flights',  'bookings.flight_id',   '=', 'flights.id')
            ->whereDate('flights.departure_time', today())
            ->where('bookings.status', 'confirmed')
            ->count();
        $pendingCheckinCount = Booking::where('status', 'pending')->count();

        // Upcoming departures (next 3 hours)
        $upcomingFlights = Flight::with(['airline', 'departureAirport', 'arrivalAirport'])
            ->whereBetween('departure_time', [now(), now()->addHours(3)])
            ->orderBy('departure_time')
            ->take(5)
            ->get();

        // Today's full schedule
        $flights = Flight::with(['airline', 'departureAirport', 'arrivalAirport'])
            ->when($search, fn($q) => $q->where('flight_number', 'like', "%{$search}%"))
            ->where('departure_time', '>=', now()->subDays(1))
            ->orderBy('departure_time')
            ->paginate(15);

        return view('staff.dashboard', compact(
            'flights', 'todayFlightsCount', 'todayBoardingCount',
            'todayPassengers', 'pendingCheckinCount', 'upcomingFlights', 'search'
        ));
    }

    public function manifest(Flight $flight)
    {
        $flight->load(['airline', 'departureAirport', 'arrivalAirport', 'airplane']);

        $bookings = Booking::where('flight_id', $flight->id)
            ->where('status', 'confirmed')
            ->with(['passengers', 'user'])
            ->get();

        return view('staff.manifest', compact('flight', 'bookings'));
    }
}