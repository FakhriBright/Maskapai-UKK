@extends('layouts.admin')

@section('title', 'Dashboard Manager - SkyLine Airways')

@section('content')
<div class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-center">
    <div>
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-brand-accent">KONSOL EKSEKUTIF</p>
        <h1 class="mt-1 text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard Manager</h1>
        <p class="text-sm text-slate-500">Pemantauan metrik pendapatan, statistik pemesanan, dan kinerja operasional.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('manager.report.index') }}" class="inline-flex items-center justify-center rounded-xl bg-white border border-slate-200 shadow-sm px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 transition duration-200">
            📊 Filter Laporan Detail
        </a>
        <a href="{{ route('manager.report.exportPdf') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-900 px-4 py-2.5 text-sm font-bold text-white shadow-lg hover:bg-brand-800 transition duration-200">
            📥 Unduh PDF Laporan
        </a>
    </div>
</div>

<!-- KPI CARDS GRID -->
<div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Card 1: Revenue -->
    <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-md transition duration-200 flex items-center justify-between">
        <div>
            <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Pendapatan Bulan Ini</div>
            <div class="mt-2 text-2xl font-black text-brand-accent">Rp {{ number_format($kpi['revenue'] ?? 0, 0, ',', '.') }}</div>
            <span class="text-[10px] text-emerald-600 font-bold">↑ 12% dari bulan lalu</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-2xl text-brand-accent">
            💰
        </div>
    </div>
    
    <!-- Card 2: Bookings -->
    <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-md transition duration-200 flex items-center justify-between">
        <div>
            <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Booking Confirmed</div>
            <div class="mt-2 text-2xl font-black text-slate-900">{{ number_format($kpi['bookings'] ?? 0) }}</div>
            <span class="text-[10px] text-emerald-600 font-bold">↑ 8% dari minggu lalu</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-2xl text-blue-600">
            🎟️
        </div>
    </div>

    <!-- Card 3: Passengers -->
    <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-md transition duration-200 flex items-center justify-between">
        <div>
            <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Penumpang</div>
            <div class="mt-2 text-2xl font-black text-slate-900">{{ number_format($kpi['passengers'] ?? 0) }}</div>
            <span class="text-[10px] text-slate-400 font-medium">Bulan berjalan</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-2xl text-purple-600">
            👥
        </div>
    </div>

    <!-- Card 4: Total Flights -->
    <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-md transition duration-200 flex items-center justify-between">
        <div>
            <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Rute Penerbangan</div>
            <div class="mt-2 text-2xl font-black text-slate-900">{{ number_format($kpi['flights'] ?? 0) }}</div>
            <span class="text-[10px] text-slate-400 font-medium">Armada Aktif</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-2xl text-emerald-600">
            ✈️
        </div>
    </div>
</div>

<!-- CHARTS SECTION GRID -->
<div class="mb-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Chart: Daily Revenue (Line Chart) -->
    <div class="lg:col-span-2 bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Tren Pendapatan Harian</h2>
                <p class="text-xs text-slate-500">Perkembangan total nominal transaksi sukses bulan ini.</p>
            </div>
        </div>
        <div class="h-80 relative">
            @if($revenueTotals->isEmpty())
                <div class="flex h-full items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50 text-sm text-slate-500">
                    Belum ada data transaksi berhasil untuk bulan ini.
                </div>
            @else
                <canvas id="revenueChart"></canvas>
            @endif
        </div>
    </div>

    <!-- Right Chart: Booking Status Distribution (Doughnut Chart) -->
    <div class="bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm flex flex-col justify-between">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Proporsi Status Booking</h2>
            <p class="text-xs text-slate-500">Distribusi status seluruh pesanan tiket.</p>
        </div>
        <div class="h-64 my-4 relative flex items-center justify-center">
            @if($statusTotals->isEmpty())
                <div class="flex h-full items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50 text-sm text-slate-500">
                    Tidak ada pesanan tiket terdaftar.
                </div>
            @else
                <canvas id="statusChart"></canvas>
            @endif
        </div>
        <div class="text-[10px] text-center text-slate-400">Diperbarui secara real-time</div>
    </div>
</div>

<!-- POPULAR ROUTES & TRANSACTIONS SECTION -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Popular Routes Leaderboard -->
    <div class="bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm">
        <div class="mb-5">
            <h2 class="text-lg font-bold text-slate-800">Rute Terpopuler</h2>
            <p class="text-xs text-slate-500">Tingkat okupansi rute penerbangan teratas diurutkan berdasarkan jumlah penumpang.</p>
        </div>
        <div class="space-y-4">
            @forelse($popularRoutes as $route)
                <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-extrabold text-brand-900 text-sm">
                            {{ $route->origin_city }} ({{ $route->origin_code }}) → {{ $route->dest_city }} ({{ $route->dest_code }})
                        </span>
                        <span class="text-xs font-bold text-brand-accent">
                            {{ $route->passenger_count }} Penumpang
                        </span>
                    </div>
                    <!-- ProgressBar layout -->
                    <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                        @php
                            $maxPassengers = $popularRoutes->max('passenger_count') ?: 1;
                            $percentage = ($route->passenger_count / $maxPassengers) * 100;
                        @endphp
                        <div class="bg-brand-accent h-full rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                    <div class="text-[10px] text-slate-400 mt-1 flex justify-between">
                        <span>{{ $route->booking_count }} Pesanan Berhasil</span>
                        <span>Okupansi Relatif</span>
                    </div>
                </div>
            @empty
                <div class="flex h-48 items-center justify-center border border-dashed border-slate-200 rounded-xl text-sm text-slate-400">
                    Tidak ada data rute penerbangan populer.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm flex flex-col justify-between">
        <div>
            <div class="mb-5 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Transaksi Terbaru</h2>
                    <p class="text-xs text-slate-500">Log pembelian tiket maskapai teranyar.</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold border-b border-slate-100">
                        <tr>
                            <th class="p-3">Kode Booking</th>
                            <th class="p-3">Maskapai</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Harga Total</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentBookings as $booking)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3 font-mono font-bold text-brand-900">{{ $booking->booking_code }}</td>
                                <td class="p-3 text-slate-600 font-semibold">{{ $booking->flight->airline->name ?? '-' }}</td>
                                <td class="p-3 text-slate-500">{{ $booking->created_at->format('d M Y') }}</td>
                                <td class="p-3 font-bold text-slate-700">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td class="p-3">
                                    <span class="rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider
                                        {{ $booking->status === 'confirmed' ? 'bg-green-50 text-green-700 border border-green-200' : ($booking->status === 'pending' ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' : 'bg-red-50 text-red-700 border border-red-200') }}">
                                        {{ $booking->status === 'confirmed' ? 'Lunas' : ($booking->status === 'pending' ? 'Pending' : 'Batal') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-400">Belum ada transaksi terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($revenueTotals->isNotEmpty())
                // 1. Daily Revenue Chart
                new Chart(document.getElementById('revenueChart'), {
                    type: 'line',
                    data: {
                        labels: @json($revenueLabels),
                        datasets: [{
                            label: 'Pendapatan Harian (Rp)',
                            data: @json($revenueTotals),
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.08)',
                            borderWidth: 3,
                            pointBackgroundColor: '#0f172a',
                            pointBorderColor: '#ffffff',
                            pointHoverRadius: 7,
                            tension: 0.35,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                grid: { color: '#f1f5f9' },
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + (value/1000).toLocaleString('id-ID') + 'k';
                                    }
                                }
                            },
                            x: { grid: { display: false } }
                        }
                    }
                });
            @endif

            @if($statusTotals->isNotEmpty())
                // 2. Booking Status Doughnut Chart
                new Chart(document.getElementById('statusChart'), {
                    type: 'doughnut',
                    data: {
                        labels: @json($statusLabels),
                        datasets: [{
                            data: @json($statusTotals),
                            backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    font: { size: 11, weight: 'bold' },
                                    padding: 15
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });
            @endif
        });
    </script>
@endpush
@endsection
