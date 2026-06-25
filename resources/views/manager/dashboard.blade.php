@extends('layouts.admin')

@section('title', 'Dashboard Manager - SkyLine Airways')

@section('content')
<div class="mb-6 flex flex-col justify-between gap-4 md:flex-row md:items-end">
    <div>
        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-brand-accent">Executive dashboard</p>
        <h1 class="mt-1 text-2xl font-extrabold text-slate-800">Dashboard Manager</h1>
        <p class="text-sm text-slate-500">Ringkasan performa booking dan pendapatan bulan ini.</p>
    </div>
    <a href="{{ route('manager.report.index') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-900 px-4 py-2 text-sm font-bold text-white transition hover:bg-brand-800">
        Buka Laporan
    </a>
</div>

<div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="text-sm font-semibold uppercase text-slate-500">Pendapatan Bulan Ini</div>
        <div class="mt-3 text-3xl font-extrabold text-brand-accent">Rp {{ number_format($kpi['revenue'] ?? 0, 0, ',', '.') }}</div>
    </div>
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="text-sm font-semibold uppercase text-slate-500">Booking Confirmed</div>
        <div class="mt-3 text-3xl font-extrabold text-brand-900">{{ $kpi['bookings'] ?? 0 }}</div>
    </div>
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="text-sm font-semibold uppercase text-slate-500">Total Penumpang</div>
        <div class="mt-3 text-3xl font-extrabold text-brand-900">{{ $kpi['passengers'] ?? 0 }}</div>
    </div>
</div>

<div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Tren Booking Harian</h2>
            <p class="text-sm text-slate-500">Data booking confirmed sejak awal bulan.</p>
        </div>
        <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700">{{ $chartData->count() }} hari</span>
    </div>

    @if($chartData->isEmpty())
        <div class="flex h-64 items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50 text-sm text-slate-500">
            Belum ada booking confirmed bulan ini.
        </div>
    @else
        <canvas id="bookingChart" height="110"></canvas>
    @endif
</div>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 bg-slate-50 p-4">
        <h2 class="font-bold text-slate-800">Transaksi Terbaru</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-white text-xs uppercase text-slate-500">
                <tr>
                    <th class="p-4">Kode Booking</th>
                    <th class="p-4">Maskapai</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">Jumlah</th>
                    <th class="p-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($recentBookings as $booking)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-mono font-bold text-brand-900">{{ $booking->booking_code }}</td>
                        <td class="p-4 text-slate-600">{{ $booking->flight->airline->name ?? '-' }}</td>
                        <td class="p-4 text-slate-600">{{ $booking->created_at->format('d M Y') }}</td>
                        <td class="p-4 font-semibold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td class="p-4">
                            <span class="rounded-full px-3 py-1 text-xs font-bold uppercase {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $booking->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-500">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($chartData->isNotEmpty())
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            new Chart(document.getElementById('bookingChart'), {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Booking',
                        data: @json($chartTotals),
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.14)',
                        tension: 0.25,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });
        </script>
    @endpush
@endif
@endsection
