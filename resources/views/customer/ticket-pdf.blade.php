<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket {{ $booking->booking_code }}</title>
    <style>
        body { font-family: sans-serif; color: #333; margin: 0; padding: 20px; }
        .ticket-container { border: 1px solid #ddd; border-radius: 8px; overflow: hidden; width: 100%; max-width: 800px; margin: 0 auto; }
        
        /* Header */
        .header { background: #0f172a; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { margin: 0; font-size: 18px; letter-spacing: 1px; }
        .header .logo { font-weight: bold; font-size: 20px; color: #f59e0b; }
        
        /* Body Layout */
        .body { display: flex; }
        .left-panel { flex: 2; padding: 20px; border-right: 2px dashed #ddd; }
        .right-panel { flex: 1; padding: 20px; text-align: center; background: #f8fafc; }
        
        /* Flight Info */
        .route { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .city-code { font-size: 32px; font-weight: bold; color: #0f172a; }
        .city-name { font-size: 12px; color: #666; }
        .plane-icon { font-size: 24px; color: #f59e0b; }
        
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
        .info-item label { display: block; font-size: 10px; color: #888; text-transform: uppercase; margin-bottom: 4px; }
        .info-item div { font-size: 14px; font-weight: bold; color: #333; }
        
        /* Passenger Info */
        .passenger-box { margin-bottom: 15px; text-align: left; }
        .passenger-box label { font-size: 10px; color: #888; text-transform: uppercase; }
        .passenger-box div { font-size: 16px; font-weight: bold; margin-bottom: 10px; }
        
        .qr-code img { width: 150px; height: 150px; }
        .booking-code { font-family: monospace; font-size: 14px; font-weight: bold; margin-top: 10px; letter-spacing: 2px; }

        /* Footer */
        .footer { background: #f1f5f9; padding: 10px 20px; font-size: 10px; color: #666; text-align: center; border-top: 1px solid #ddd; }
    </style>
</head>
<body>

    <div class="ticket-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">SkyLine Airways</div>
            <h1>BOARDING PASS / E-TIKET</h1>
            <div style="font-size: 12px;">{{ $booking->created_at->format('d M Y') }}</div>
        </div>

        <div class="body">
            <!-- Left: Flight Details -->
            <div class="left-panel">
                <div class="route">
                    <div style="text-align: left;">
                        <div class="city-code">{{ $booking->flight->departureAirport->iata_code }}</div>
                        <div class="city-name">{{ $booking->flight->departureAirport->city }}</div>
                    </div>
                    <div class="plane-icon">✈</div>
                    <div style="text-align: right;">
                        <div class="city-code">{{ $booking->flight->arrivalAirport->iata_code }}</div>
                        <div class="city-name">{{ $booking->flight->arrivalAirport->city }}</div>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <label>Maskapai</label>
                        <div>{{ $booking->flight->airline->name }}</div>
                    </div>
                    <div class="info-item">
                        <label>No. Penerbangan</label>
                        <div>{{ $booking->flight->flight_number }}</div>
                    </div>
                    <div class="info-item">
                        <label>Tanggal</label>
                        <div>{{ $booking->flight->departure_time->format('d M Y') }}</div>
                    </div>
                    <div class="info-item">
                        <label>Waktu Berangkat</label>
                        <div>{{ $booking->flight->departure_time->format('H:i') }} WIB</div>
                    </div>
                    <div class="info-item">
                        <label>Pesawat</label>
                        <div>{{ $booking->flight->airplane->model }}</div>
                    </div>
                    <div class="info-item">
                        <label>Gerbang (Gate)</label>
                        <div>-</div>
                    </div>
                </div>
            </div>

            <!-- Right: Passenger & QR -->
            <div class="right-panel">
                @foreach($booking->passengers as $index => $pax)
                    <div class="passenger-box">
                        <label>Penumpang {{ $index + 1 }}</label>
                        <div>{{ $pax->full_name }}</div>
                        
                        <label>Kursi</label>
                        <div style="font-size: 24px; color: #f59e0b;">{{ $pax->seat_number }}</div>
                        <label>Kelas: {{ ucfirst($pax->seat->class ?? 'Economy') }}</label>
                    </div>
                @endforeach

                <div class="qr-code">
                    <!-- Render QR Code dari Base64 -->
                    <img src="data:image/png;base64,{{ $base64Qr }}" alt="QR Code">
                    <div class="booking-code">{{ $booking->booking_code }}</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            Tunjukkan E-Tiket ini saat Check-in di Bandara. Harap hadir 2 jam sebelum keberangkatan.
            <br>Terima kasih telah terbang bersama SkyLine Airways.
        </div>
    </div>

</body>
</html>