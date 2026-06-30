<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats Cards
        $stats = [
            'total_airlines'    => Airline::count(),
            'total_airports'    => Airport::count(),
            'active_flights'    => Flight::where('departure_time', '>', now())->count(),
            'pending_bookings'  => Booking::where('status', 'pending')->count(),
            'confirmed_bookings'=> Booking::where('status', 'confirmed')->count(),
            'total_customers'   => User::where('role', 'customer')->count(),
            'total_revenue'     => DB::table('payments')->where('payment_status', 'paid')->sum('amount'),
            'today_flights'     => Flight::whereDate('departure_time', today())->count(),
        ];

        // Recent Bookings (latest 6)
        $recentBookings = Booking::with(['user', 'flight.airline', 'flight.departureAirport', 'flight.arrivalAirport'])
            ->latest()
            ->take(6)
            ->get();

        // Recent Users (latest 5)
        $recentUsers = User::where('role', 'customer')
            ->latest()
            ->take(5)
            ->get();

        // Today's Flights
        $todayFlights = Flight::with(['airline', 'departureAirport', 'arrivalAirport'])
            ->whereDate('departure_time', today())
            ->orderBy('departure_time')
            ->take(5)
            ->get();

        // Top Airlines by booking count
        $topAirlines = Airline::withCount(['flights' => function ($q) {
            $q->whereHas('bookings', fn($b) => $b->where('status', 'confirmed'));
        }])
        ->orderByDesc('flights_count')
        ->take(5)
        ->get();

        // Top Routes
        $topRoutes = DB::table('flights')
            ->join('airports as dep', 'flights.departure_airport_id', '=', 'dep.id')
            ->join('airports as arr', 'flights.arrival_airport_id', '=', 'arr.id')
            ->select(
                'dep.city as from_city', 'dep.iata_code as from_code',
                'arr.city as to_city', 'arr.iata_code as to_code',
                DB::raw('COUNT(flights.id) as flight_count')
            )
            ->groupBy('flights.departure_airport_id', 'flights.arrival_airport_id', 'dep.city', 'dep.iata_code', 'arr.city', 'arr.iata_code')
            ->orderByDesc('flight_count')
            ->take(5)
            ->get();

        // Booking Trend – last 7 days
        $bookingTrend = [];
        $trendLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $trendLabels[] = $day->format('d M');
            $bookingTrend[] = Booking::whereDate('created_at', $day)->count();
        }

        // Revenue trend – last 7 days
        $revenueTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $revenueTrend[] = (float) DB::table('payments')
                ->where('payment_status', 'paid')
                ->whereDate('created_at', $day)
                ->sum('amount');
        }

        // Status breakdown for pie chart
        $bookingStatusCounts = [
            'pending'   => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.dashboard', compact(
            'stats', 'recentBookings', 'recentUsers', 'todayFlights',
            'topAirlines', 'topRoutes', 'bookingTrend', 'trendLabels',
            'revenueTrend', 'bookingStatusCounts'
        ));
    }
}