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
        ];

        // Data untuk Chart.js (Tren Booking Harian)
        $chartData = DB::table('bookings')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('status', 'confirmed')
            ->where('created_at', '>=', $startOfMonth)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $chartData->pluck('date')->map(fn ($date) => Carbon::parse($date)->format('d M'));
        $chartTotals = $chartData->pluck('total');

        $recentBookings = Booking::with(['payment', 'flight.airline'])
            ->latest()
            ->take(5)
            ->get();

        return view('manager.dashboard', compact('kpi', 'chartData', 'chartLabels', 'chartTotals', 'recentBookings'));
    }
}
