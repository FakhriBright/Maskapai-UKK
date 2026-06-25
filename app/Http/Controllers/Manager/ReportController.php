<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Airline;

class ReportController extends Controller
{
    /**
     * Tampilkan Dashboard Laporan dengan KPI & Chart
     */
    public function index(Request $request)
    {
        // Default filter: Bulan ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $airlineId = $request->input('airline_id');

        // Query Dasar untuk Pembayaran Sukses
        $paymentQuery = Payment::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);

        if ($airlineId) {
            $paymentQuery->whereHas('booking.flight', fn($q) => $q->where('airline_id', $airlineId));
        }

        // 1. KPI Cards
        $kpi = [
            'revenue' => $paymentQuery->sum('amount'),
            'total_bookings' => Booking::where('status', 'confirmed')
                ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
                ->when($airlineId, fn($q) => $q->whereHas('flight', fn($f) => $f->where('airline_id', $airlineId)))
                ->count(),
            'total_passengers' => DB::table('passengers')
                ->join('bookings', 'passengers.booking_id', '=', 'bookings.id')
                ->where('bookings.status', 'confirmed')
                ->whereBetween('bookings.created_at', [$startDate, $endDate . ' 23:59:59'])
                ->count(),
        ];

        // 2. Data untuk Chart.js (Pendapatan Harian)
        $chartLabels = [];
        $chartData = [];
        
        $dailyRevenue = $paymentQuery->clone()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        foreach ($dailyRevenue as $row) {
            $chartLabels[] = Carbon::parse($row->date)->format('d M');
            $chartData[] = (float) $row->total;
        }

        // 3. Data Filter Dropdown
        $airlines = Airline::orderBy('name')->get();

        return view('manager.report', compact(
            'kpi', 'chartLabels', 'chartData', 
            'airlines', 'startDate', 'endDate', 'airlineId'
        ));
    }

    /**
     * Export Laporan ke PDF
     */
    public function exportPdf(Request $request)
    {
        // Ambil data yang sama seperti di index
        $data = $this->getReportData($request);
        
        $pdf = Pdf::loadView('manager.report-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('Laporan-Keuangan-' . $data['startDate'] . '-to-' . $data['endDate'] . '.pdf');
    }

    /**
     * Helper untuk mengambil data laporan (digunakan di index & export)
     */
    private function getReportData(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $airlineId = $request->input('airline_id');

        $paymentQuery = Payment::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);

        if ($airlineId) {
            $paymentQuery->whereHas('booking.flight', fn($q) => $q->where('airline_id', $airlineId));
        }

        $kpi = [
            'revenue' => $paymentQuery->sum('amount'),
            'total_bookings' => Booking::where('status', 'confirmed')
                ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
                ->count(),
        ];

        $details = $paymentQuery->with(['booking.flight.airline', 'booking.flight.departureAirport', 'booking.flight.arrivalAirport'])
            ->orderBy('created_at', 'desc')
            ->get();

        return compact('kpi', 'details', 'startDate', 'endDate');
    }
}