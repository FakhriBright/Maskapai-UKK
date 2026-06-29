<?php
namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index() {
        $startOfMonth = Carbon::now()->startOfMonth();
        
        $kpi = [
            'revenue' => DB::table('payments')->where('payment_status', 'paid')->where('created_at', '>=', $startOfMonth)->sum('amount'),
            'bookings' => DB::table('bookings')->where('status', 'confirmed')->where('created_at', '>=', $startOfMonth)->count(),
            'passengers' => DB::table('passengers')->join('bookings', 'passengers.booking_id', '=', 'bookings.id')->where('bookings.status', 'confirmed')->where('bookings.created_at', '>=', $startOfMonth)->count(),
            'flights' => DB::table('flights')->count(),
        ];

        // 1. Data Chart Tren Booking Harian
        $chartData = DB::table('bookings')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('status', 'confirmed')
            ->where('created_at', '>=', $startOfMonth)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $chartData->pluck('date')->map(fn ($date) => Carbon::parse($date)->format('d M'));
        $chartTotals = $chartData->pluck('total');

        // 2. Data Chart Pendapatan Harian
        $revenueData = DB::table('payments')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(amount) as total'))
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', $startOfMonth)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        $revenueLabels = $revenueData->pluck('date')->map(fn ($date) => Carbon::parse($date)->format('d M'));
        $revenueTotals = $revenueData->pluck('total');

        // 3. Data Chart Distribusi Status Booking
        $statusData = DB::table('bookings')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
        $statusLabels = $statusData->pluck('status')->map(function($status) {
            return match($status) {
                'confirmed' => 'Terkonfirmasi',
                'pending' => 'Menunggu Pembayaran',
                'cancelled' => 'Dibatalkan',
                default => ucfirst($status)
            };
        });
        $statusTotals = $statusData->pluck('total');

        // 4. Rute Penerbangan Terpopuler
        $popularRoutes = DB::table('bookings')
            ->join('flights', 'bookings.flight_id', '=', 'flights.id')
            ->join('airports as dep', 'flights.departure_airport_id', '=', 'dep.id')
            ->join('airports as arr', 'flights.arrival_airport_id', '=', 'arr.id')
            ->select(
                'dep.city as origin_city',
                'dep.iata_code as origin_code',
                'arr.city as dest_city',
                'arr.iata_code as dest_code',
                DB::raw('count(bookings.id) as booking_count'),
                DB::raw('sum(bookings.total_passengers) as passenger_count')
            )
            ->where('bookings.status', 'confirmed')
            ->groupBy('flights.departure_airport_id', 'flights.arrival_airport_id', 'dep.city', 'dep.iata_code', 'arr.city', 'arr.iata_code')
            ->orderByDesc('passenger_count')
            ->take(5)
            ->get();

        $recentBookings = Booking::with(['payment', 'flight.airline'])
            ->latest()
            ->take(6)
            ->get();

        return view('manager.dashboard', compact(
            'kpi', 'chartLabels', 'chartTotals', 
            'revenueLabels', 'revenueTotals',
            'statusLabels', 'statusTotals',
            'popularRoutes', 'recentBookings'
        ));
    }
}
