@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('staff.dashboard') }}" class="text-slate-500 hover:text-slate-800 text-sm">&larr; Kembali</a>
    <h1 class="text-2xl font-bold text-slate-800 mt-2">Check-in Booking: {{ $booking->booking_code }}</h1>
    <p class="text-slate-500">
        {{ $booking->flight->flight_number }} -
        {{ $booking->flight->departureAirport->city }} ke {{ $booking->flight->arrivalAirport->city }}
    </p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('staff.checkin.process', $booking) }}" method="POST">
            @csrf

            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="p-4 border-b w-12"></th>
                        <th class="p-4 border-b">Nama Penumpang</th>
                        <th class="p-4 border-b">Kursi</th>
                        <th class="p-4 border-b">Status Check-in</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($booking->passengers as $pax)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4">
                                @if(!$pax->checked_in_at && optional($booking->payment)->payment_status === 'paid')
                                    <input type="checkbox" name="passenger_ids[]" value="{{ $pax->id }}" class="rounded border-slate-300 text-brand-accent focus:ring-brand-accent">
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="font-medium text-slate-800">{{ $pax->full_name }}</div>
                                <div class="text-xs text-slate-500">{{ $pax->passport_number }}</div>
                            </td>
                            <td class="p-4 font-mono font-bold text-brand-600">{{ $pax->seat_number }}</td>
                            <td class="p-4">
                                @if($pax->checked_in_at)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold">Sudah Check-in</span>
                                    <div class="text-xs text-slate-400 mt-1">{{ $pax->checked_in_at->format('d M Y H:i') }}</div>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold">Belum</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4 border-t border-slate-200 flex justify-end">
                <button type="submit"
                    class="bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-2 px-5 rounded-lg transition disabled:opacity-50"
                    {{ optional($booking->payment)->payment_status !== 'paid' ? 'disabled' : '' }}>
                    Proses Check-in
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 h-fit">
        <h2 class="font-bold text-slate-800 mb-4">Status Booking</h2>

        <dl class="space-y-3 text-sm">
            <div class="flex justify-between">
                <dt class="text-slate-500">Booking</dt>
                <dd class="font-bold uppercase">{{ $booking->status }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-slate-500">Pembayaran</dt>
                <dd class="font-bold uppercase">{{ optional($booking->payment)->payment_status ?? 'pending' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-slate-500">Penumpang</dt>
                <dd class="font-bold">{{ $booking->passengers->count() }}</dd>
            </div>
        </dl>

        @if(optional($booking->payment)->payment_status !== 'paid')
            <div class="mt-6 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                Booking ini belum lunas, jadi belum bisa diproses check-in.
            </div>
        @endif
    </div>
</div>
@endsection
