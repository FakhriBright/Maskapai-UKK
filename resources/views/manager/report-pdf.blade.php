<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        h1 { margin: 0 0 4px; font-size: 22px; }
        .muted { color: #6b7280; }
        .summary { width: 100%; margin: 18px 0; border-collapse: collapse; }
        .summary td { border: 1px solid #d1d5db; padding: 10px; }
        .summary strong { display: block; font-size: 16px; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
        th { background: #f3f4f6; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <h1>Laporan Keuangan Maskapai</h1>
    <div class="muted">Periode {{ $startDate }} sampai {{ $endDate }}</div>

    <table class="summary">
        <tr>
            <td>
                Pendapatan
                <strong>Rp {{ number_format($kpi['revenue'] ?? 0, 0, ',', '.') }}</strong>
            </td>
            <td>
                Booking Confirmed
                <strong>{{ $kpi['total_bookings'] ?? 0 }}</strong>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Kode Booking</th>
                <th>Tanggal Bayar</th>
                <th>Maskapai</th>
                <th>Rute</th>
                <th class="right">Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($details as $payment)
                <tr>
                    <td>{{ $payment->booking->booking_code }}</td>
                    <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $payment->booking->flight->airline->name }}</td>
                    <td>
                        {{ $payment->booking->flight->departureAirport->city }}
                        ke
                        {{ $payment->booking->flight->arrivalAirport->city }}
                    </td>
                    <td class="right">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>{{ $payment->payment_status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="right">Tidak ada data pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
