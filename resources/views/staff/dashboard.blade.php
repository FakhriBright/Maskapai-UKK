@extends('layouts.admin')

@section('title', 'Staff Control Center - SkyLine Airways')

@section('content')

{{-- ═══════════════════════════════════════════════════════════
     HEADER
═══════════════════════════════════════════════════════════ --}}
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Staff Control Center</h1>
            <p class="text-sm text-slate-500 mt-0.5">Operasional penerbangan · {{ now()->format('l, d F Y · H:i') }} WIB</p>
        </div>
        <span class="bg-emerald-100 text-emerald-700 font-bold text-xs px-3 py-1.5 rounded-full border border-emerald-200 w-fit">● Shift Aktif</span>
    </div>

    {{-- KPI Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php $staffStats = [
            ['label'=>"Penerbangan Hari Ini",'value'=>$todayFlightsCount,'icon'=>'calendar','color'=>'blue','sub'=>'Jadwal keberangkatan'],
            ['label'=>'Sedang Boarding','value'=>$todayBoardingCount,'icon'=>'door-open','color'=>'amber','sub'=>'Status boarding aktif'],
            ['label'=>'Total Penumpang','value'=>$todayPassengers,'icon'=>'users','color'=>'emerald','sub'=>'Confirmed hari ini'],
            ['label'=>'Booking Pending','value'=>$pendingCheckinCount,'icon'=>'clock','color'=>'rose','sub'=>'Menunggu konfirmasi'],
        ]; @endphp

        @foreach($staffStats as $s)
        @php $scc=['blue'=>'bg-blue-50 text-blue-600 border-blue-100','amber'=>'bg-amber-50 text-amber-600 border-amber-100','emerald'=>'bg-emerald-50 text-emerald-600 border-emerald-100','rose'=>'bg-rose-50 text-rose-600 border-rose-100'][$s['color']]; @endphp
        <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:shadow-sm transition">
            <div class="p-2.5 rounded-xl border {{ $scc }} w-fit mb-3">
                <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5"></i>
            </div>
            <div class="text-2xl font-extrabold text-slate-800">{{ $s['value'] }}</div>
            <div class="text-xs font-bold text-slate-500 mt-0.5 uppercase tracking-wide">{{ $s['label'] }}</div>
            <div class="text-[10px] text-slate-400 mt-1">{{ $s['sub'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Quick Search Booking --}}
    <div class="bg-brand-900 rounded-3xl p-6 mb-6 flex flex-col sm:flex-row items-center gap-5">
        <div class="text-white flex-1">
            <div class="font-extrabold text-lg mb-0.5">Quick Search Penumpang</div>
            <div class="text-sm text-slate-300">Masukkan kode booking untuk langsung ke halaman check-in</div>
        </div>
        <form action="{{ route('staff.dashboard') }}" method="GET" class="flex gap-3 w-full sm:w-auto">
            @error('booking_code')
                <span class="text-red-400 text-xs font-semibold block sm:hidden">{{ $message }}</span>
            @enderror
            <input type="text" name="booking_code" placeholder="Contoh: MSK-XYZABC"
                class="flex-1 sm:w-64 border-2 border-slate-700 bg-slate-800 text-white placeholder-slate-400 rounded-xl px-4 py-2.5 focus:border-brand-accent focus:outline-none font-bold uppercase tracking-wider transition text-sm"
                value="{{ request('booking_code') }}">
            <button type="submit" class="bg-brand-accent hover:bg-amber-400 text-brand-900 font-extrabold px-5 py-2.5 rounded-xl transition flex-shrink-0">
                Cari
            </button>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     UPCOMING BOARDING
═══════════════════════════════════════════════════════════ --}}
@if($upcomingFlights->count() > 0)
<div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-6">
    <div class="flex items-center gap-2 mb-4">
        <i data-lucide="zap" class="w-5 h-5 text-amber-600"></i>
        <h3 class="font-extrabold text-amber-800">Boarding Dalam 3 Jam</h3>
        <span class="bg-amber-500 text-white font-extrabold text-xs px-2 py-0.5 rounded-full">{{ $upcomingFlights->count() }}</span>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach($upcomingFlights as $uf)
        <div class="bg-white rounded-xl p-4 border border-amber-100 flex justify-between items-center">
            <div>
                <div class="font-extrabold text-slate-800 text-sm">{{ $uf->flight_number }}</div>
                <div class="text-xs text-slate-500">{{ $uf->airline->name }}</div>
                <div class="text-xs font-bold text-slate-700 mt-1">{{ $uf->departureAirport->iata_code }} → {{ $uf->arrivalAirport->iata_code }}</div>
            </div>
            <div class="text-right">
                <div class="text-xl font-black text-amber-700">{{ $uf->departure_time->format('H:i') }}</div>
                <a href="{{ route('staff.manifest', $uf) }}" class="text-[10px] font-bold text-amber-600 hover:underline">Manifest →</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- ═══════════════════════════════════════════════════════════
     FLIGHT SCHEDULE TABLE
═══════════════════════════════════════════════════════════ --}}
<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 border-b border-slate-100">
        <h3 class="font-extrabold text-slate-800">Jadwal Penerbangan</h3>
        <form action="{{ route('staff.dashboard') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                placeholder="Cari nomor penerbangan..."
                class="border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 outline-none transition w-52">
            <button class="bg-brand-900 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-brand-800 transition">Cari</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-100">
                <tr>
                    <th class="px-5 py-3.5">Penerbangan</th>
                    <th class="px-5 py-3.5">Maskapai</th>
                    <th class="px-5 py-3.5">Rute</th>
                    <th class="px-5 py-3.5">Keberangkatan</th>
                    <th class="px-5 py-3.5">Tiba</th>
                    <th class="px-5 py-3.5">Status</th>
                    <th class="px-5 py-3.5">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($flights as $flight)
                <tr class="hover:bg-slate-50/60 transition group">
                    <td class="px-5 py-4 font-extrabold text-slate-800">{{ $flight->flight_number }}</td>
                    <td class="px-5 py-4 text-slate-600">{{ $flight->airline->name }}</td>
                    <td class="px-5 py-4 font-bold text-slate-700">
                        {{ $flight->departureAirport->iata_code }} → {{ $flight->arrivalAirport->iata_code }}
                    </td>
                    <td class="px-5 py-4 text-slate-700 font-bold">{{ $flight->departure_time->format('d M H:i') }}</td>
                    <td class="px-5 py-4 text-slate-500">{{ $flight->arrival_time->format('d M H:i') }}</td>
                    <td class="px-5 py-4">
                        @php
                            $fsc = match($flight->status ?? 'scheduled') {
                                'boarding' => 'bg-blue-100 text-blue-700',
                                'delayed'  => 'bg-rose-100 text-rose-700',
                                default    => 'bg-slate-100 text-slate-600',
                            };
                        @endphp
                        <span class="text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full {{ $fsc }}">{{ $flight->status ?? 'scheduled' }}</span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition">
                            <a href="{{ route('staff.manifest', $flight) }}"
                                class="text-[11px] font-bold bg-brand-900 text-white px-3 py-1.5 rounded-lg hover:bg-brand-800 transition">
                                Manifest
                            </a>
                            <a href="{{ route('staff.checkin.index', ['flight_id' => $flight->id]) }}"
                                class="text-[11px] font-bold bg-emerald-600 text-white px-3 py-1.5 rounded-lg hover:bg-emerald-700 transition">
                                Check-In
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center">
                        <div class="text-slate-300 text-4xl mb-2">✈️</div>
                        <div class="text-slate-500 font-semibold">Tidak ada penerbangan tersedia</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($flights->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $flights->links() }}
    </div>
    @endif
</div>

@endsection
