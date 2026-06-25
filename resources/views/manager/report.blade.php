@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Laporan Manager</h1>
    <p class="text-slate-500 text-sm">Filter pendapatan dan booking terkonfirmasi berdasarkan periode dan maskapai.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
    <form action="{{ route('manager.report.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="w-full border-slate-300 rounded-lg focus:ring-brand-accent focus:border-brand-accent">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Tanggal Akhir</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="w-full border-slate-300 rounded-lg focus:ring-brand-accent focus:border-brand-accent">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Maskapai</label>
            <select name="airline_id" class="w-full border-slate-300 rounded-lg focus:ring-brand-accent focus:border-brand-accent">
                <option value="">Semua Maskapai</option>
                @foreach($airlines as $airline)
                    <option value="{{ $airline->id }}" @selected((string) $airlineId === (string) $airline->id)>
                        {{ $airline->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-2 px-4 rounded-lg transition">
                Filter
            </button>
            <a href="{{ route('manager.report.exportPdf', request()->query()) }}" class="bg-brand-900 hover:bg-brand-800 text-white font-bold py-2 px-4 rounded-lg transition">
                PDF
            </a>
        </div>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <div class="text-slate-500 text-sm font-medium uppercase mb-2">Pendapatan</div>
        <div class="text-3xl font-bold text-brand-accent">Rp {{ number_format($kpi['revenue'] ?? 0, 0, ',', '.') }}</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <div class="text-slate-500 text-sm font-medium uppercase mb-2">Booking Confirmed</div>
        <div class="text-3xl font-bold text-brand-900">{{ $kpi['total_bookings'] ?? 0 }}</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <div class="text-slate-500 text-sm font-medium uppercase mb-2">Total Penumpang</div>
        <div class="text-3xl font-bold text-brand-900">{{ $kpi['total_passengers'] ?? 0 }}</div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Pendapatan Harian</h2>
    <canvas id="revenueChart" height="110"></canvas>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Pendapatan',
                data: @json($chartData),
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245, 158, 11, 0.12)',
                tension: 0.25,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'Rp ' + Number(value).toLocaleString('id-ID')
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
