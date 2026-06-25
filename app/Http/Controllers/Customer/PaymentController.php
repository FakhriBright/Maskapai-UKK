<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    /**
     * Tampilkan tombol pembayaran dan inisialisasi token Midtrans Snap.
     */
    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Setup Midtrans Config
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $booking->booking_code,
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
            ],
            'item_details' => [[
                'id' => $booking->flight->flight_number,
                'price' => (int) $booking->flight->price,
                'quantity' => $booking->total_passengers,
                'name' => 'Tiket ' . $booking->flight->departureAirport->city . ' - ' . $booking->flight->arrivalAirport->city,
            ]]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            $snapToken = null;
            Log::error('Gagal mengambil Snap Token Midtrans: ' . $e->getMessage());
        }

        return view('customer.pay', compact('booking', 'snapToken'));
    }

    /**
     * Handle notifikasi webhook dari Midtrans.
     */
    public function handleWebhook(Request $request)
    {
        // Catat seluruh payload notifikasi untuk debugging
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/webhook.log')
        ])->info('Payload Webhook Midtrans:', $request->all());

        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');

        // Verifikasi Signature Key
        $serverKey = config('services.midtrans.server_key');
        $localSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($localSignature !== $signatureKey) {
            Log::warning('Signature webhook tidak cocok: ' . $orderId);
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');

        DB::beginTransaction();
        try {
            // Ambil data booking dengan Pessimistic Locking
            $booking = Booking::where('booking_code', $orderId)->lockForUpdate()->first();

            if (!$booking) {
                DB::rollBack();
                return response()->json(['message' => 'Booking not found'], 404);
            }

            $payment = Payment::where('booking_id', $booking->id)->lockForUpdate()->first();
            if (!$payment) {
                $payment = new Payment([
                    'booking_id' => $booking->id,
                    'amount' => $booking->total_price,
                ]);
            }

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $booking->update(['status' => 'pending']);
                    $payment->update(['payment_status' => 'pending']);
                } else if ($fraudStatus == 'accept') {
                    $this->confirmBooking($booking, $payment, $request);
                }
            } else if ($transactionStatus == 'settlement') {
                $this->confirmBooking($booking, $payment, $request);
            } else if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $booking->update(['status' => 'cancelled']);
                $payment->update(['payment_status' => 'failed']);
            }

            DB::commit();
            return response()->json(['message' => 'Webhook handled successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat memproses webhook Midtrans: ' . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }

    /**
     * Konfirmasi booking, update pembayaran, dan kurangi kursi pesawat.
     */
    private function confirmBooking($booking, $payment, Request $request)
    {
        // Jika sudah confirmed sebelumnya, lewati
        if ($booking->status === 'confirmed') {
            return;
        }

        $booking->update(['status' => 'confirmed']);
        $payment->update([
            'payment_status' => 'paid',
            'payment_method' => $request->input('payment_type') ?? 'midtrans',
            'transaction_code' => $request->input('transaction_id'),
        ]);

        // Kurangi available_seats pada flight
        $flight = $booking->flight()->lockForUpdate()->first();
        if ($flight) {
            $newSeats = max(0, $flight->available_seats - $booking->total_passengers);
            $flight->update(['available_seats' => $newSeats]);
        }

        // Jalankan queue job untuk kirim e-tiket jika diimplementasikan
        try {
            // dispatch(new \App\Jobs\SendETicketJob($booking->id));
        } catch (\Exception $e) {
            Log::error('Gagal mengirim antrean E-Tiket: ' . $e->getMessage());
        }
    }
}