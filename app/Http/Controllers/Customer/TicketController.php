<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{
    public function history() {
        $bookings = auth()->user()->bookings()->with(['flight.airline', 'flight.departureAirport', 'flight.arrivalAirport'])->latest()->paginate(10);
        return view('customer.history', compact('bookings'));
    }

    public function show(Booking $booking) {
        if ($booking->user_id !== auth()->id()) abort(403);
        $booking->load(['flight.airline', 'flight.departureAirport', 'flight.arrivalAirport', 'passengers.seat']);
        
        // Generate SVG QR Code (aman, tidak butuh ekstensi PHP GD)
        try {
            $qrCodeSvg = QrCode::size(150)->generate($booking->booking_code);
        } catch (\Exception $e) {
            $qrCodeSvg = null;
        }

        return view('customer.ticket', compact('booking', 'qrCodeSvg'));
    }

    public function download(Booking $booking) {
        if ($booking->user_id !== auth()->id()) abort(403);
        $booking->load(['flight.airline', 'flight.departureAirport', 'flight.arrivalAirport', 'passengers.seat']);
        
        try {
            $qrCode = QrCode::format('png')->size(200)->generate($booking->booking_code);
            $base64Qr = base64_encode($qrCode);
        } catch (\Exception $e) {
            $base64Qr = null; // Fallback jika ekstensi GD tidak aktif
        }
        
        $pdf = Pdf::loadView('customer.ticket-pdf', compact('booking', 'base64Qr'));
        return $pdf->download('e-ticket-' . $booking->booking_code . '.pdf');
    }
}