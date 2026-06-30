@extends('layouts.admin')

@section('title', 'Manager Executive Dashboard - SkyLine Airways')

@section('content')

{{-- ═══════════════════════════════════════════════════════════
     HEADER
═══════════════════════════════════════════════════════════ --}}
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Executive Dashboard</h1>
            <p class="text-sm text-slate-500 mt-0.5">Analitik kinerja bisnis SkyLine Airways · {{ now()->format('F Y') }}</p>
        </div>
        <a href="{{ route('manager.report.index') }}" class="inline-flex items-center gap-2 bg-brand-900 hover:bg-brand-800 text-white font-bold py-2.5 px-5 rounded-xl transition text-sm shadow-sm">
            <i data-lucide="file-bar-chart-2" class="w-4 h-4"></i>
            Lihat Laporan Lengkap
        </a>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
        @php $mgKpis = [
            ['label'=>'Pendapatan Bulan Ini','value'=>'Rp '.number_format($kpi['revenue'],0,',','.'),'icon'=>'dollar-sign','color'=>'emerald','sub'=>'Total pembayaran sukses bulan ini'],
            ['label'=>'Total Booking Confirmed','value'=>$kpi['bookings'],'icon'=>'ticket','color'=>'blue','sub'=>'Reservasi terkonfirmasi bulan ini'],
            ['label'=>'Penumpang Dilayani','value'=>$kpi['passengers'],'icon'=>'users','color'=>'purple','sub'=>'Total penumpang boarding bulan ini'],
            ['label'=>'Total Penerbangan','value'=>$kpi['total_flights'],'icon'=>'send','color'=>'amber','sub'=>'Jadwal aktif terdaftar di sistem'],
            ['label'=>'Cancellation Rate','value'=>$kpi['cancellation_rate'].'%','icon'=>'x-circle','color'=>'rose','sub'=>'Persentase pembatalan booking'],
            ['label'=>'Total Pendapatan Kumulatif','value'=>'Rp '.number_format($kpi['revenue_all'],0,',','.'),'icon'=>'trending-up','color'=>'indigo','sub'=>'Seluruh waktu, semua maskapai'],
        ]; @endphp

        @foreach($mgKpis as $k)
        @php
            $cc = ['emerald'=>'bg-emerald-50 text-emerald-600 border-emerald-100','blue'=>'bg-blue-50 text-blue-600 border-blue-100','purple'=>'bg-purple-50 text-purple-600 border-purple-100','amber'=>'bg-amber-50 text-amber-600 border-amber-100','rose'=>'bg-rose-50 text-rose-600 border-rose-100','indigo'=>'bg-indigo-50 text-indigo-600 border-indigo-100'][$k['color']];
        @endphp
        <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:shadow-md transition-shadow">
            <div class="p-2.5 rounded-xl border {{ $cc }} w-fit mb-3">
                <i data-lucide="{{ $k['icon'] }}" class="w-5 h-5"></i>
            </div>
            <div class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ $k['value'] }}</div>
            <div class="text-xs font-bold text-slate-500 mt-0.5 uppercase tracking-wide">{{ $k['label'] }}</div>
            <div class="text-[10px] text-slate-400 mt-1">{{ $k['sub'] }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     MAIN AREA CHART: Revenue 30 Hari
═══════════════════════════════════════════════════════════ --}}
<div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h3 class="font-extrabold text-slate-800 text-lg">Tren Pendapatan Harian</h3>
            <p class="text-xs text-slate-400 mt-0.5">30 hari terakhir — gradient area chart</p>
        </div>
        <div class="flex gap-3 text-xs font-bold text-slate-500">
            <span class="flex items-center gap-1.5"><span class="w-3 h-0.5 bg-emerald-500 inline-block rounded-full"></span>Revenue</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-0.5 bg-indigo-400 inline-block rounded-full"></span>Booking</span>
        </div>
    </div>
    <div id="mgRevenueChart" class="h-72"></div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     CHARTS ROW: Airline Bar + Status Donut + Routes
═══════════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    <!-- Revenue per Airline -->
    <div class="lg:col-span-1 bg-white rounded-2xl border border-slate-200 p-6">
        <h3 class="font-extrabold text-slate-800 mb-1">Revenue per Maskapai</h3>
        <p class="text-xs text-slate-400 mb-5">Dari semua pembayaran sukses</p>
        <div id="mgAirlineBar" class="h-56"></div>
    </div>

    <!-- Donut Status -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <h3 class="font-extrabold text-slate-800 mb-1">Distribusi Booking</h3>
        <p class="text-xs text-slate-400 mb-5">Status keseluruhan booking sistem</p>
        <div id="mgStatusDonut" class="h-56"></div>
        <div class="mt-3 space-y-1.5">
            <div class="flex justify-between text-xs font-bold"><span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>Confirmed</span><span>{{ $confirmed }}</span></div>
            <div class="flex justify-between text-xs font-bold"><span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block"></span>Pending</span><span>{{ $pending }}</span></div>
            <div class="flex justify-between text-xs font-bold"><span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-rose-500 inline-block"></span>Cancelled</span><span>{{ $cancelled }}</span></div>
        </div>
    </div>

    <!-- Top Routes -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <h3 class="font-extrabold text-slate-800 mb-5">Rute Paling Profitable</h3>
        <div class="space-y-4">
            @foreach($popularRoutes as $r)
            <div>
                <div class="flex justify-between items-center text-xs font-bold mb-1">
                    <span class="text-slate-700">{{ $r->origin_code }} → {{ $r->dest_code }}</span>
                    <span class="text-brand-accent">{{ $r->booking_count }} booking</span>
                </div>
                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-brand-900 to-brand-accent transition-all duration-700"
                         style="width: {{ min(100, ($r->booking_count / max($popularRoutes->max('booking_count'), 1)) * 100) }}%"></div>
                </div>
                <div class="text-[10px] text-slate-400 mt-0.5">{{ $r->origin_city }} ke {{ $r->dest_city }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     RECENT BOOKINGS TABLE
═══════════════════════════════════════════════════════════ --}}
<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <div class="flex items-center justify-between p-5 border-b border-slate-100">
        <h3 class="font-extrabold text-slate-800">Transaksi Terbaru</h3>
        <a href="{{ route('manager.report.index') }}" class="text-xs font-bold text-brand-accent hover:underline">Lihat laporan lengkap →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-100">
                <tr>
                    <th class="px-5 py-3.5">Kode Booking</th>
                    <th class="px-5 py-3.5">Pelanggan</th>
                    <th class="px-5 py-3.5">Rute</th>
                    <th class="px-5 py-3.5">Maskapai</th>
                    <th class="px-5 py-3.5 text-right">Total</th>
                    <th class="px-5 py-3.5">Status</th>
                    <th class="px-5 py-3.5">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($recentBookings as $b)
                <tr class="hover:bg-slate-50/60 transition">
                    <td class="px-5 py-3.5 font-extrabold text-slate-800">{{ $b->booking_code }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $b->user->name ?? '—' }}</td>
                    <td class="px-5 py-3.5 font-bold">{{ $b->flight->departureAirport->iata_code ?? '?' }} → {{ $b->flight->arrivalAirport->iata_code ?? '?' }}</td>
                    <td class="px-5 py-3.5 text-slate-500">{{ $b->flight->airline->name ?? '—' }}</td>
                    <td class="px-5 py-3.5 text-right font-extrabold text-brand-accent">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                    <td class="px-5 py-3.5">
                        @php $sc = match($b->status) { 'confirmed'=>'bg-emerald-100 text-emerald-700', 'pending'=>'bg-amber-100 text-amber-700', default=>'bg-rose-100 text-rose-700' }; @endphp
                        <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full {{ $sc }}">{{ $b->status }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-xs text-slate-400">{{ $b->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400 font-semibold">Belum ada data transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
const rl = @json($revenueLabels);
const rt = @json($revenueTotals);
const bl = @json($bookingLabels);
const bt = @json($bookingTotals);

// Main Revenue & Booking 30-day Area Chart
new ApexCharts(document.querySelector('#mgRevenueChart'), {
    chart: { type: 'area', height: 290, toolbar: { show: false }, zoom: { enabled: false }, animations: { enabled: true, easing: 'easeinout', speed: 1000 } },
    series: [
        { name: 'Pendapatan (Rp)', data: rt },
        { name: 'Booking', data: bt },
    ],
    xaxis: { categories: rl, tickAmount: 8, labels: { style: { fontSize: '11px', fontWeight: 600 } } },
    yaxis: [
        { labels: { formatter: v => 'Rp' + (v/1e6).toFixed(1)+'jt', style: { fontSize: '11px' } }, seriesName: 'Pendapatan (Rp)' },
        { opposite: true, labels: { formatter: v => v + ' bkg', style: { fontSize: '11px' } }, seriesName: 'Booking', min: 0 },
    ],
    stroke: { curve: 'smooth', width: [3, 2.5] },
    fill: {
        type: 'gradient',
        gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.02, stops: [0, 100] }
    },
    colors: ['#10b981', '#6366f1'],
    grid: { borderColor: '#f1f5f9', strokeDashArray: 4, padding: { right: 20 } },
    tooltip: { theme: 'light', shared: true, intersect: false, y: [
        { formatter: v => 'Rp ' + Number(v).toLocaleString('id-ID') },
        { formatter: v => v + ' booking' }
    ]},
    dataLabels: { enabled: false },
    legend: { show: false },
    markers: { size: 0 },
}).render();

// Airline Revenue Bar
const airlineNames = @json($airlineRevenue->pluck('name'));
const airlineTotals = @json($airlineRevenue->pluck('total'));
new ApexCharts(document.querySelector('#mgAirlineBar'), {
    chart: { type: 'bar', height: 224, toolbar: { show: false }, animations: { enabled: true } },
    series: [{ name: 'Revenue', data: airlineTotals }],
    xaxis: { categories: airlineNames.map(n => n.length > 14 ? n.substring(0,14)+'…' : n), labels: { style: { fontSize: '10px', fontWeight: 600 } } },
    yaxis: { labels: { formatter: v => (v/1e6).toFixed(1)+'jt', style: { fontSize: '10px' } } },
    colors: ['#0F172A'],
    fill: { type: 'gradient', gradient: { shade: 'light', type: 'vertical', shadeIntensity: 0.3, gradientToColors: ['#F59E0B'], inverseColors: false, opacityFrom: 1, opacityTo: 1 } },
    plotOptions: { bar: { borderRadius: 6, columnWidth: '60%' } },
    dataLabels: { enabled: false },
    grid: { borderColor: '#f1f5f9' },
    tooltip: { theme: 'light', y: { formatter: v => 'Rp '+Number(v).toLocaleString('id-ID') } },
}).render();

// Status Donut
new ApexCharts(document.querySelector('#mgStatusDonut'), {
    chart: { type: 'donut', height: 224, toolbar: { show: false } },
    series: [{{ $confirmed }}, {{ $pending }}, {{ $cancelled }}],
    labels: ['Confirmed', 'Pending', 'Cancelled'],
    colors: ['#10b981', '#f59e0b', '#f43f5e'],
    legend: { show: false },
    dataLabels: { enabled: false },
    stroke: { width: 0 },
    plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', fontSize: '13px', fontWeight: 700, color: '#334155', formatter: w => w.globals.seriesTotals.reduce((a,b)=>a+b,0) } } } } },
    tooltip: { theme: 'light' },
}).render();
</script>
@endpush

@endsection
