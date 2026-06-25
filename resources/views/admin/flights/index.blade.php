@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Manajemen Jadwal Penerbangan</h1>
    <a href="{{ route('admin.flights.create') }}" class="bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-2 px-4 rounded-lg shadow transition">
        + Tambah Jadwal
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="p-4 border-b">No. Penerbangan</th>
                    <th class="p-4 border-b">Maskapai</th>
                    <th class="p-4 border-b">Rute</th>
                    <th class="p-4 border-b">Berangkat</th>
                    <th class="p-4 border-b">Tiba</th>
                    <th class="p-4 border-b">Harga</th>
                    <th class="p-4 border-b">Sisa Kursi</th>
                    <th class="p-4 border-b text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($flights as $flight)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-4 font-mono font-bold text-brand-600">{{ $flight->flight_number }}</td>
                        <td class="p-4 font-medium text-slate-800">{{ $flight->airline->name }}</td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-700">{{ $flight->departureAirport->iata_code }}</span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                <span class="font-bold text-slate-700">{{ $flight->arrivalAirport->iata_code }}</span>
                            </div>
                            <div class="text-xs text-slate-500 mt-1">{{ $flight->departureAirport->city }} → {{ $flight->arrivalAirport->city }}</div>
                        </td>
                        <td class="p-4 text-slate-600">{{ $flight->departure_time->format('d M Y, H:i') }}</td>
                        <td class="p-4 text-slate-600">{{ $flight->arrival_time->format('d M Y, H:i') }}</td>
                        <td class="p-4 font-medium text-slate-800">Rp {{ number_format($flight->price, 0, ',', '.') }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 {{ $flight->available_seats > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded text-xs font-bold">
                                {{ $flight->available_seats }}
                            </span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.flights.edit', $flight) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                            <form action="{{ route('admin.flights.destroy', $flight) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-slate-500">Belum ada jadwal penerbangan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-slate-200">
        {{ $flights->links() }}
    </div>
</div>
@endsection