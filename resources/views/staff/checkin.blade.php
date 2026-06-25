@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('staff.dashboard') }}" class="text-slate-500 hover:text-slate-800 text-sm">← Kembali</a>
    <h1 class="text-2xl font-bold text-slate-800 mt-2">Check-in: {{ $flight->flight_number }}</h1>
    <p class="text-slate-500">{{ $flight->departureAirport->city }} → {{ $flight->arrivalAirport->city }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-semibold">
            <tr>
                <th class="p-4 border-b">Nama Penumpang</th>
                <th class="p-4 border-b">Kursi</th>
                <th class="p-4 border-b">Status Check-in</th>
                <th class="p-4 border-b text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($passengers as $pax)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4">
                        <div class="font-medium text-slate-800">{{ $pax->full_name }}</div>
                        <div class="text-xs text-slate-500">{{ $pax->booking->booking_code }}</div>
                    </td>
                    <td class="p-4 font-mono font-bold text-brand-600">{{ $pax->seat_number }}</td>
                    <td class="p-4">
                        @if($pax->checked_in_at)
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold">Sudah Check-in</span>
                            <div class="text-xs text-slate-400 mt-1">{{ $pax->checked_in_at->format('H:i') }}</div>
                        @else
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold">Belum</span>
                        @endif
                    </td>
                    <td class="p-4 text-right">
                        @if(!$pax->checked_in_at)
                            <form action="{{ route('staff.checkin.process', $pax->booking) }}" method="POST">
                                @csrf
                                <input type="hidden" name="passenger_ids[]" value="{{ $pax->id }}">
                                <button type="submit" class="bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-1 px-3 rounded text-sm transition">
                                    Proses Check-in
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-slate-500">Belum ada penumpang terkonfirmasi untuk penerbangan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
