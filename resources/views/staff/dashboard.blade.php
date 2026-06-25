@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Panel Operasional Staff</h1>
    <p class="text-slate-500 text-sm">Kelola check-in penumpang dan status penerbangan hari ini.</p>
</div>

<!-- Search Bar -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
        <form action="{{ route('staff.dashboard') }}" method="GET" class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nomor Penerbangan (contoh: GA-123)" class="flex-1 border-slate-300 rounded-lg focus:ring-brand-accent focus:border-brand-accent">
            <button type="submit" class="bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-2 px-6 rounded-lg transition">Cari</button>
        </form>
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
        <form action="{{ route('staff.dashboard') }}" method="GET" class="flex gap-4">
            <input type="text" name="booking_code" value="{{ request('booking_code') }}" placeholder="Input kode booking (contoh: MSK-ABC123)" class="flex-1 border-slate-300 rounded-lg focus:ring-brand-accent focus:border-brand-accent">
            <button type="submit" class="bg-brand-900 hover:bg-brand-800 text-white font-bold py-2 px-6 rounded-lg transition">Check-in</button>
        </form>
    </div>
</div>

<!-- Flight List -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-semibold">
            <tr>
                <th class="p-4 border-b">No. Penerbangan</th>
                <th class="p-4 border-b">Rute</th>
                <th class="p-4 border-b">Waktu</th>
                <th class="p-4 border-b">Status</th>
                <th class="p-4 border-b text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($flights as $flight)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 font-mono font-bold text-brand-600">{{ $flight->flight_number }}</td>
                    <td class="p-4">
                        <div class="font-medium text-slate-800">{{ $flight->departureAirport->city }} → {{ $flight->arrivalAirport->city }}</div>
                        <div class="text-xs text-slate-500">{{ $flight->airline->name }}</div>
                    </td>
                    <td class="p-4 text-sm text-slate-600">{{ $flight->departure_time->format('d M Y, H:i') }}</td>
                    <td class="p-4">
                        @if($flight->departure_time->isFuture())
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-bold">Akan Berangkat</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold">Berangkat</span>
                        @endif
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('staff.flights.manifest', $flight) }}" class="bg-white hover:bg-slate-50 text-brand-900 border border-slate-300 font-bold py-1 px-3 rounded text-sm transition">
                                Manifest
                            </a>
                            <a href="{{ route('staff.flights.checkin', $flight) }}" class="bg-brand-900 hover:bg-brand-800 text-white font-bold py-1 px-3 rounded text-sm transition">
                                Check-in
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-500">Tidak ada penerbangan ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-slate-200">
        {{ $flights->links() }}
    </div>
</div>
@endsection
