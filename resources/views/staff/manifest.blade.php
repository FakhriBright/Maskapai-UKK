@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('staff.dashboard') }}" class="text-slate-500 hover:text-slate-800 text-sm">&larr; Kembali</a>
    <h1 class="text-2xl font-bold text-slate-800 mt-2">Manifest Penumpang</h1>
    <p class="text-slate-500">
        {{ $flight->flight_number }} -
        {{ $flight->departureAirport->city }} ke {{ $flight->arrivalAirport->city }}
    </p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-semibold">
            <tr>
                <th class="p-4 border-b">Kode Booking</th>
                <th class="p-4 border-b">Customer</th>
                <th class="p-4 border-b">Penumpang</th>
                <th class="p-4 border-b">Kursi</th>
                <th class="p-4 border-b">Check-in</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($bookings as $booking)
                @foreach($booking->passengers as $pax)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-4 font-mono font-bold text-brand-600">{{ $booking->booking_code }}</td>
                        <td class="p-4">{{ $booking->user->name }}</td>
                        <td class="p-4">
                            <div class="font-medium text-slate-800">{{ $pax->full_name }}</div>
                            <div class="text-xs text-slate-500">{{ $pax->gender }}</div>
                        </td>
                        <td class="p-4 font-mono font-bold">{{ $pax->seat_number }}</td>
                        <td class="p-4">
                            @if($pax->checked_in_at)
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold">Sudah</span>
                            @else
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold">Belum</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-500">Belum ada penumpang terkonfirmasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
