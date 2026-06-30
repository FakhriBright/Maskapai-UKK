@extends('layouts.admin')

@section('title', 'Admin Dashboard - SkyLine Airways')

@section('content')
{{-- ═══════════════════════════════════════════════════════════
     HERO STAT CARDS
═══════════════════════════════════════════════════════════ --}}
<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Dashboard Overview</h1>
            <p class="text-sm text-slate-500 mt-0.5">{{ now()->format('l, d F Y') }} · Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong></p>
        </div>
        <span class="bg-emerald-100 text-emerald-700 font-bold text-xs px-3 py-1.5 rounded-full border border-emerald-200">
            ● System Online
        </span>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php $kpis = [
            ['label'=>'Total Maskapai','value'=>$stats['total_airlines'],'icon'=>'plane','color'=>'blue','sub'=>'Maskapai aktif terdaftar'],
            ['label'=>'Total Bandara','value'=>$stats['total_airports'],'icon'=>'map-pin','color'=>'teal','sub'=>'Destinasi domestik tersedia'],
            ['label'=>'Penerbangan Aktif','value'=>$stats['active_flights'],'icon'=>'calendar','color'=>'amber','sub'=>'Jadwal tersedia ke depan'],
            ['label'=>'Booking Pending','value'=>$stats['pending_bookings'],'icon'=>'clock','color'=>'rose','sub'=>'Menunggu konfirmasi bayar'],
            ['label'=>'Booking Terkonfirmasi','value'=>$stats['confirmed_bookings'],'icon'=>'check-circle','color'=>'emerald','sub'=>'Tiket sudah dibayar'],
            ['label'=>'Total Pelanggan','value'=>$stats['total_customers'],'icon'=>'users','color'=>'purple','sub'=>'Customer terdaftar'],
            ['label'=>'Penerbangan Hari Ini','value'=>$stats['today_flights'],'icon'=>'zap','color'=>'orange','sub'=>'Jadwal keberangkatan hari ini'],
            ['label'=>'Total Pendapatan','value'=>'Rp '.number_format($stats['total_revenue'],0,',','.'),'icon'=>'trending-up','color'=>'indigo','sub'=>'Dari semua pembayaran sukses'],
        ]; @endphp

        @foreach($kpis as $kpi)
        @php
            $colorMap = [
                'blue'   => 'bg-blue-50 text-blue-600 border-blue-100',
                'teal'   => 'bg-teal-50 text-teal-600 border-teal-100',
                'amber'  => 'bg-amber-50 text-amber-600 border-amber-100',
                'rose'   => 'bg-rose-50 text-rose-600 border-rose-100',
                'emerald'=> 'bg-emerald-50 text-emerald-600 border-emerald-100',
                'purple' => 'bg-purple-50 text-purple-600 border-purple-100',
                'orange' => 'bg-orange-50 text-orange-600 border-orange-100',
                'indigo' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
            ];
            $c = $colorMap[$kpi['color']];
        @endphp
        <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:shadow-md transition-shadow duration-200 group">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2.5 rounded-xl border {{ $c }}">
                    <i data-lucide="{{ $kpi['icon'] }}" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ $kpi['value'] }}</div>
            <div class="text-xs font-bold text-slate-500 mt-0.5 uppercase tracking-wide">{{ $kpi['label'] }}</div>
            <div class="text-[10px] text-slate-400 mt-1">{{ $kpi['sub'] }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     CHARTS ROW
═══════════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    <!-- Booking & Revenue Trend -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-extrabold text-slate-800">Tren 7 Hari Terakhir</h3>
                <p class="text-xs text-slate-400 mt-0.5">Jumlah booking & pendapatan harian</p>
            </div>
            <div class="flex gap-3 text-xs font-bold">
                <span class="flex items-center gap-1.5"><span class="w-3 h-0.5 bg-brand-accent inline-block"></span> Booking</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-0.5 bg-indigo-500 inline-block"></span> Revenue</span>
            </div>
        </div>
        <div id="trendChart" class="h-60"></div>
    </div>

    <!-- Booking Status Donut Chart -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <div class="mb-6">
            <h3 class="font-extrabold text-slate-800">Status Booking</h3>
            <p class="text-xs text-slate-400 mt-0.5">Distribusi status seluruh booking</p>
        </div>
        <div id="statusDonut" class="h-60"></div>
        <div class="mt-4 space-y-2">
            <div class="flex justify-between items-center text-xs font-bold">
                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>Confirmed</span>
                <span>{{ $bookingStatusCounts['confirmed'] }}</span>
            </div>
            <div class="flex justify-between items-center text-xs font-bold">
                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-500 inline-block"></span>Pending</span>
                <span>{{ $bookingStatusCounts['pending'] }}</span>
            </div>
            <div class="flex justify-between items-center text-xs font-bold">
                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-rose-500 inline-block"></span>Cancelled</span>
                <span>{{ $bookingStatusCounts['cancelled'] }}</span>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     QUICK ACCESS GRID
═══════════════════════════════════════════════════════════ --}}
<div class="bg-white rounded-2xl border border-slate-200 p-6 mb-8">
    <h3 class="font-extrabold text-slate-800 mb-5">Akses Cepat</h3>
    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-9 gap-3">
        @php
        $shortcuts = [
            ['label'=>'Tambah Maskapai','icon'=>'plane','href'=>route('admin.airlines.create'),'color'=>'bg-blue-100 text-blue-700'],
            ['label'=>'Tambah Bandara','icon'=>'map-pin','href'=>route('admin.airports.create'),'color'=>'bg-teal-100 text-teal-700'],
            ['label'=>'Tambah Pesawat','icon'=>'send','href'=>route('admin.airplanes.create'),'color'=>'bg-indigo-100 text-indigo-700'],
            ['label'=>'Tambah Jadwal','icon'=>'calendar-plus','href'=>route('admin.flights.create'),'color'=>'bg-amber-100 text-amber-700'],
            ['label'=>'Kelola User','icon'=>'users','href'=>route('admin.users.index'),'color'=>'bg-purple-100 text-purple-700'],
            ['label'=>'Kelola Maskapai','icon'=>'layers','href'=>route('admin.airlines.index'),'color'=>'bg-sky-100 text-sky-700'],
            ['label'=>'Semua Penerbangan','icon'=>'list','href'=>route('admin.flights.index'),'color'=>'bg-slate-100 text-slate-700'],
            ['label'=>'Semua Bandara','icon'=>'globe','href'=>route('admin.airports.index'),'color'=>'bg-emerald-100 text-emerald-700'],
            ['label'=>'Semua Pesawat','icon'=>'cpu','href'=>route('admin.airplanes.index'),'color'=>'bg-rose-100 text-rose-700'],
        ];
        @endphp

        @foreach($shortcuts as $s)
        <a href="{{ $s['href'] }}" class="flex flex-col items-center gap-2 p-3 rounded-2xl border border-slate-100 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer">
            <div class="w-11 h-11 rounded-xl {{ $s['color'] }} flex items-center justify-center shadow-sm">
                <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5"></i>
            </div>
            <span class="text-[10px] font-bold text-slate-600 text-center leading-tight">{{ $s['label'] }}</span>
        </a>
        @endforeach
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     DATA TABLES: Booking Terbaru + Penerbangan Hari Ini
═══════════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    <!-- Recent Bookings -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-slate-100">
            <h3 class="font-extrabold text-slate-800">Booking Terbaru</h3>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">6 Terakhir</span>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($recentBookings as $booking)
            <div class="flex items-center gap-4 px-5 py-4 hover:bg-slate-50 transition">
                <div class="w-10 h-10 rounded-xl bg-brand-900/10 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="ticket" class="w-5 h-5 text-brand-900"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-bold text-sm text-slate-800 truncate">{{ $booking->booking_code }}</div>
                    <div class="text-xs text-slate-500">{{ $booking->user->name }} · {{ $booking->flight->departureAirport->iata_code ?? '—' }} → {{ $booking->flight->arrivalAirport->iata_code ?? '—' }}</div>
                </div>
                <div class="text-right">
                    @php
                        $sc = match($booking->status) {
                            'confirmed' => 'bg-emerald-100 text-emerald-700',
                            'pending'   => 'bg-amber-100 text-amber-700',
                            default     => 'bg-rose-100 text-rose-700',
                        };
                    @endphp
                    <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full {{ $sc }}">{{ $booking->status }}</span>
                    <div class="text-xs text-slate-400 mt-1">{{ $booking->created_at->diffForHumans() }}</div>
                </div>
            </div>
            @empty
            <div class="px-5 py-10 text-center text-slate-400 text-sm font-semibold">Belum ada booking</div>
            @endforelse
        </div>
    </div>

    <!-- Today's Flights -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-slate-100">
            <h3 class="font-extrabold text-slate-800">Penerbangan Hari Ini</h3>
            <span class="bg-brand-accent/20 text-brand-900 font-extrabold text-[10px] px-2 py-0.5 rounded-full border border-brand-accent/40">
                {{ $stats['today_flights'] }} jadwal
            </span>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($todayFlights as $f)
            <div class="flex items-center gap-3 px-5 py-4 hover:bg-slate-50 transition">
                <div class="text-center w-14 flex-shrink-0">
                    <div class="text-base font-extrabold text-brand-900">{{ $f->departure_time->format('H:i') }}</div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase">{{ $f->departureAirport->iata_code }}</div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-bold text-xs text-slate-800 truncate">{{ $f->airline->name }}</div>
                    <div class="text-[10px] text-slate-500">{{ $f->flight_number }} · → {{ $f->arrivalAirport->iata_code }}</div>
                </div>
                @php
                    $fsc = match($f->status ?? 'scheduled') {
                        'boarding' => 'bg-blue-100 text-blue-700',
                        'delayed'  => 'bg-rose-100 text-rose-700',
                        default    => 'bg-slate-100 text-slate-600',
                    };
                @endphp
                <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded {{ $fsc }}">{{ $f->status ?? 'scheduled' }}</span>
            </div>
            @empty
            <div class="px-5 py-10 text-center text-slate-400 text-sm font-semibold">Tidak ada penerbangan hari ini</div>
            @endforelse
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     TOP AIRLINES + TOP ROUTES + RECENT USERS
═══════════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Top Airlines Bar Chart -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <h3 class="font-extrabold text-slate-800 mb-1">Maskapai Terpopuler</h3>
        <p class="text-xs text-slate-400 mb-5">Berdasarkan jumlah penerbangan confirmed</p>
        <div id="topAirlinesChart" class="h-52"></div>
    </div>

    <!-- Top Routes -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <h3 class="font-extrabold text-slate-800 mb-5">Rute Terpopuler</h3>
        <div class="space-y-3">
            @foreach($topRoutes as $route)
            <div class="flex items-center gap-3">
                <div class="flex-1 min-w-0">
                    <div class="font-bold text-xs text-slate-700">{{ $route->from_code }} → {{ $route->to_code }}</div>
                    <div class="text-[10px] text-slate-400">{{ $route->from_city }} ke {{ $route->to_city }}</div>
                    <div class="mt-1.5 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-brand-accent rounded-full" style="width:{{ min(100, ($route->flight_count / ($topRoutes->max('flight_count') ?: 1)) * 100) }}%"></div>
                    </div>
                </div>
                <div class="text-xs font-extrabold text-brand-900">{{ $route->flight_count }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-extrabold text-slate-800">Pelanggan Terbaru</h3>
        </div>
        <div class="divide-y divide-slate-50">
            @foreach($recentUsers as $u)
            <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-slate-50 transition">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-900 to-indigo-700 flex items-center justify-center flex-shrink-0 text-white font-extrabold text-sm">
                    {{ strtoupper(substr($u->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-bold text-sm text-slate-800 truncate">{{ $u->name }}</div>
                    <div class="text-xs text-slate-400 truncate">{{ $u->email }}</div>
                </div>
                <div class="text-[10px] font-bold text-slate-400">{{ $u->created_at->diffForHumans() }}</div>
            </div>
            @endforeach
        </div>
    </div>

</div>

@push('scripts')
<script>
// Booking & Revenue Trend Chart
const trendLabels = @json($trendLabels);
const bookingTrend = @json($bookingTrend);
const revenueTrend = @json($revenueTrend);

new ApexCharts(document.querySelector('#trendChart'), {
    chart: { type: 'area', height: 240, toolbar: { show: false }, zoom: { enabled: false }, animations: { enabled: true, easing: 'easeinout', speed: 800 } },
    series: [
        { name: 'Booking', data: bookingTrend },
        { name: 'Revenue (Rp)', data: revenueTrend },
    ],
    xaxis: { categories: trendLabels, labels: { style: { fontSize: '11px', fontWeight: 600 } } },
    yaxis: [
        { labels: { style: { fontSize: '11px' }, formatter: v => v }, seriesName: 'Booking' },
        { opposite: true, labels: { style: { fontSize: '11px' }, formatter: v => 'Rp ' + (v / 1000000).toFixed(1) + 'jt' }, seriesName: 'Revenue (Rp)' },
    ],
    stroke: { curve: 'smooth', width: [2.5, 2.5] },
    fill: {
        type: 'gradient',
        gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.01 }
    },
    colors: ['#F59E0B', '#6366F1'],
    grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
    tooltip: { theme: 'light', shared: true, intersect: false },
    legend: { show: false },
    dataLabels: { enabled: false },
}).render();

// Status Donut
const statusData = @json($bookingStatusCounts);
new ApexCharts(document.querySelector('#statusDonut'), {
    chart: { type: 'donut', height: 240, toolbar: { show: false } },
    series: [statusData.confirmed, statusData.pending, statusData.cancelled],
    labels: ['Confirmed', 'Pending', 'Cancelled'],
    colors: ['#10b981', '#f59e0b', '#f43f5e'],
    legend: { show: false },
    dataLabels: { enabled: false },
    stroke: { width: 0 },
    plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', fontSize: '13px', fontWeight: 700, color: '#334155', formatter: w => w.globals.seriesTotals.reduce((a,b)=>a+b,0) } } } } },
    tooltip: { theme: 'light' },
}).render();

// Top Airlines Bar
const airlineNames = @json($topAirlines->pluck('name'));
const airlineCounts = @json($topAirlines->pluck('flights_count'));
new ApexCharts(document.querySelector('#topAirlinesChart'), {
    chart: { type: 'bar', height: 210, toolbar: { show: false }, animations: { enabled: true, easing: 'easeinout', speed: 600 } },
    series: [{ name: 'Penerbangan', data: airlineCounts }],
    xaxis: { categories: airlineNames.map(n => n.length > 12 ? n.substring(0,12)+'…' : n), labels: { style: { fontSize: '10px', fontWeight: 600 } } },
    colors: ['#0F172A'],
    fill: {
        type: 'gradient',
        gradient: { shade: 'light', type: 'vertical', shadeIntensity: 0.3, gradientToColors: ['#F59E0B'], inverseColors: false, opacityFrom: 1, opacityTo: 1 }
    },
    plotOptions: { bar: { borderRadius: 8, columnWidth: '55%', distributed: false } },
    dataLabels: { enabled: false },
    grid: { borderColor: '#f1f5f9' },
    tooltip: { theme: 'light' },
    legend: { show: false },
}).render();
</script>
@endpush

@endsection