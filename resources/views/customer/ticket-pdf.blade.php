<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket {{ $booking->booking_code }}</title>
    <style>
        body { font-family: sans-serif; color: #1f2937; margin: 0; padding: 10px; font-size: 13px; }
        .ticket-container { border: 1px solid #d1d5db; border-radius: 12px; overflow: hidden; width: 100%; margin: 0 auto; background-color: #ffffff; }
        
        /* Table Layout structures */
        .w-full { width: 100%; border-collapse: collapse; }
        
        /* Header */
        .header-table { background-color: #0f172a; color: #ffffff; padding: 15px 20px; }
        .logo { font-size: 22px; font-weight: bold; color: #f59e0b; }
        .title { text-align: right; }
        .title h1 { margin: 0; font-size: 16px; letter-spacing: 1px; color: #ffffff; }
        .title .date { font-size: 11px; color: #9ca3af; margin-top: 3px; }
        
        /* Inner Content Panel Layout */
        .content-td-left { width: 68%; padding: 20px; vertical-align: top; border-right: 2px dashed #d1d5db; }
        .content-td-right { width: 32%; padding: 20px; vertical-align: top; background-color: #f8fafc; text-align: center; }
        
        /* Route detail codes */
        .route-table { margin-bottom: 20px; }
        .city-code { font-size: 28px; font-weight: 800; color: #0f172a; margin: 0; }
        .city-name { font-size: 12px; color: #4b5563; margin-top: 2px; }
        .plane-symbol { font-size: 26px; color: #f59e0b; text-align: center; }
        
        /* Flight Detail Grid */
        .detail-table { margin-top: 20px; border-top: 1px solid #e5e7eb; padding-top: 15px; }
        .detail-label { font-size: 9px; color: #6b7280; text-transform: uppercase; margin-bottom: 2px; letter-spacing: 0.5px; }
        .detail-value { font-size: 13px; font-weight: bold; color: #1f2937; }
        .detail-cell { padding-bottom: 12px; width: 50%; }
        
        /* Passengers */
        .passenger-box { margin-bottom: 15px; text-align: left; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px; }
        .passenger-title { font-size: 9px; color: #6b7280; text-transform: uppercase; margin-bottom: 3px; }
        .passenger-name { font-size: 13px; font-weight: bold; color: #0f172a; }
        .passenger-seat { font-size: 24px; font-weight: 800; color: #f59e0b; margin-top: 4px; }
        .passenger-class { font-size: 10px; color: #4b5563; margin-top: 2px; }
        
        /* QR Code */
        .qr-code-img { width: 140px; height: 140px; margin-top: 10px; }
        .booking-code { font-family: monospace; font-size: 14px; font-weight: bold; margin-top: 8px; letter-spacing: 2px; color: #0f172a; }
        
        /* Footer */
        .footer-banner { background-color: #f1f5f9; padding: 12px 20px; font-size: 10px; color: #4b5563; text-align: center; border-top: 1px solid #e5e7eb; }
    </style>
</head>
<body>

    <div class="ticket-container">
        <!-- Header -->
        <table class="w-full header-table">
            <tr>
                <td style="padding: 15px 20px;">
                    <span class="logo">SkyLine Airways</span>
                </td>
                <td class="title" style="padding: 15px 20px;">
                    <h1>BOARDING PASS / E-TIKET</h1>
                    <div class="date">Pemesanan: {{ $booking->created_at->format('d M Y') }}</div>
                </td>
            </tr>
        </table>

        <!-- Main Ticket Sections -->
        <table class="w-full" style="border-collapse: collapse;">
            <tr>
                <!-- Left Details -->
                <td class="content-td-left">
                    <table class="w-full route-table">
                        <tr>
                            <td style="width: 40%; text-align: left;">
                                <div class="city-code">{{ $booking->flight->departureAirport->iata_code }}</div>
                                <div class="city-name">{{ $booking->flight->departureAirport->city }}</div>
                            </td>
                            <td class="plane-symbol" style="width: 20%; vertical-align: middle;">
                                ✈
                            </td>
                            <td style="width: 40%; text-align: right;">
                                <div class="city-code">{{ $booking->flight->arrivalAirport->iata_code }}</div>
                                <div class="city-name">{{ $booking->flight->arrivalAirport->city }}</div>
                            </td>
                        </tr>
                    </table>

                    <table class="w-full detail-table">
                        <tr>
                            <td class="detail-cell">
                                <div class="detail-label">Maskapai</div>
                                <div class="detail-value">{{ $booking->flight->airline->name }}</div>
                            </td>
                            <td class="detail-cell">
                                <div class="detail-cell">
                                    <div class="detail-label">Nomor Penerbangan</div>
                                    <div class="detail-value">{{ $booking->flight->flight_number }}</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="detail-cell">
                                <div class="detail-label">Tanggal Berangkat</div>
                                <div class="detail-value">{{ $booking->flight->departure_time->format('d M Y') }}</div>
                            </td>
                            <td class="detail-cell">
                                <div class="detail-label">Waktu Keberangkatan</div>
                                <div class="detail-value">{{ $booking->flight->departure_time->format('H:i') }} WIB</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="detail-cell">
                                <div class="detail-label">Pesawat / Armada</div>
                                <div class="detail-value">{{ $booking->flight->airplane->model }}</div>
                            </td>
                            <td class="detail-cell">
                                <div class="detail-label">Waktu Kedatangan</div>
                                <div class="detail-value">{{ $booking->flight->arrival_time->format('H:i') }} WIB</div>
                            </td>
                        </tr>
                    </table>
                </td>

                <!-- Right Side QR & Seat -->
                <td class="content-td-right">
                    @foreach($booking->passengers as $index => $pax)
                        <div class="passenger-box">
                            <div class="passenger-title">Penumpang {{ $index + 1 }}</div>
                            <div class="passenger-name">{{ $pax->full_name }}</div>
                            
                            <table class="w-full" style="margin-top: 5px;">
                                <tr>
                                    <td>
                                        <div class="passenger-title">Kursi</div>
                                        <div class="passenger-seat">{{ $pax->seat_number }}</div>
                                    </td>
                                    <td style="text-align: right; vertical-align: bottom;">
                                        <div class="passenger-class">{{ ucfirst($pax->seat->class ?? 'Economy') }} Class</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    @endforeach

                    @if($base64Qr)
                        <img class="qr-code-img" src="data:image/png;base64,{{ $base64Qr }}" alt="QR Code">
                    @else
                        <div style="width: 140px; height: 140px; border: 1px solid #d1d5db; background: #e5e7eb; margin: 10px auto; padding: 20px 0; box-sizing: border-box; font-size: 11px;">
                            [QR Code]
                        </div>
                    @endif
                    <div class="booking-code">{{ $booking->booking_code }}</div>
                </td>
            </tr>
        </table>

        <!-- Footer -->
        <table class="w-full">
            <tr>
                <td class="footer-banner">
                    ⚠️ Tunjukkan E-Tiket ini saat Check-in di Bandara. Boarding gate ditutup 30 menit sebelum jadwal keberangkatan. Harap hadir 2 jam lebih awal.
                    <br>Terima kasih telah terbang bersama SkyLine Airways.
                </td>
            </tr>
        </table>
    </div>

</body>
</html>