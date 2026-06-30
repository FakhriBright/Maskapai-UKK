@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Penerbangan - SkyLine Airways')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Jadwal Penerbangan</h1>
        <p class="text-sm text-slate-500 mt-0.5">{{ $flights->total() }} jadwal terdaftar dalam sistem</p>
    </div>
    <a href="{{ route('admin.flights.create') }}" class="inline-flex items-center gap-2 bg-brand-accent hover:bg-amber-500 text-brand-900 font-extrabold py-2.5 px-5 rounded-xl shadow transition w-fit">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Tambah Jadwal
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200 sticky top-0">
                <tr>
                    <th class="px-5 py-4">No. Penerbangan</th>
                    <th class="px-5 py-4">Maskapai</th>
                    <th class="px-5 py-4">Rute</th>
                    <th class="px-5 py-4">Berangkat</th>
                    <th class="px-5 py-4">Tiba</th>
                    <th class="px-5 py-4">Harga</th>
                    <th class="px-5 py-4">Sisa Kursi</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($flights as $flight)
                    <tr class="hover:bg-slate-50/70 transition group">
                        <td class="px-5 py-4 font-extrabold text-brand-900 font-mono tracking-wider">{{ $flight->flight_number }}</td>
                        <td class="px-5 py-4 font-semibold text-slate-700">{{ $flight->airline->name }}</td>
                        <td class="px-5 py-4">
                            <div class="font-extrabold text-slate-800">{{ $flight->departureAirport->iata_code }} → {{ $flight->arrivalAirport->iata_code }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">{{ $flight->departureAirport->city }} — {{ $flight->arrivalAirport->city }}</div>
                        </td>
                        <td class="px-5 py-4 text-slate-600 text-xs font-semibold">{{ $flight->departure_time->format('d M Y') }}<br>{{ $flight->departure_time->format('H:i') }} WIB</td>
                        <td class="px-5 py-4 text-slate-600 text-xs font-semibold">{{ $flight->arrival_time->format('d M Y') }}<br>{{ $flight->arrival_time->format('H:i') }} WIB</td>
                        <td class="px-5 py-4 font-extrabold text-slate-800">Rp {{ number_format($flight->price, 0, ',', '.') }}</td>
                        <td class="px-5 py-4">
                            <span class="text-xs font-extrabold px-2.5 py-1 rounded-full {{ $flight->available_seats > 20 ? 'bg-emerald-100 text-emerald-700' : ($flight->available_seats > 0 ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                                {{ $flight->available_seats }} kursi
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            @php $fsc = match($flight->status ?? 'scheduled') { 'boarding'=>'bg-blue-100 text-blue-700', 'delayed'=>'bg-rose-100 text-rose-700', default=>'bg-slate-100 text-slate-600' }; @endphp
                            <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded {{ $fsc }}">{{ $flight->status ?? 'scheduled' }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                                <a href="{{ route('admin.flights.edit', $flight) }}"
                                    class="inline-flex items-center gap-1 text-[11px] font-bold bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition">
                                    <i data-lucide="pencil" class="w-3 h-3"></i> Edit
                                </a>
                                <form action="{{ route('admin.flights.destroy', $flight) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 text-[11px] font-bold bg-rose-600 text-white px-3 py-1.5 rounded-lg hover:bg-rose-700 transition">
                                        <i data-lucide="trash-2" class="w-3 h-3"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-5 py-16 text-center">
                            <i data-lucide="calendar-x" class="w-12 h-12 text-slate-200 mx-auto mb-3"></i>
                            <p class="font-semibold text-slate-400">Belum ada jadwal penerbangan.</p>
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