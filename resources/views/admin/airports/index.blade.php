@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Manajemen Bandara</h1>
    <a href="{{ route('admin.airports.create') }}" class="bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-2 px-4 rounded-lg shadow transition">
        + Tambah Bandara
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-semibold">
            <tr>
                <th class="p-4 border-b">Kode IATA</th>
                <th class="p-4 border-b">Nama Bandara</th>
                <th class="p-4 border-b">Kota</th>
                <th class="p-4 border-b">Negara</th>
                <th class="p-4 border-b text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($airports as $airport)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 font-mono font-bold text-brand-600">{{ $airport->iata_code }}</td>
                    <td class="p-4 font-medium text-slate-800">{{ $airport->name }}</td>
                    <td class="p-4 text-slate-600">{{ $airport->city }}</td>
                    <td class="p-4 text-slate-600">{{ $airport->country }}</td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('admin.airports.edit', $airport) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                        <form action="{{ route('admin.airports.destroy', $airport) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-500">Belum ada data bandara.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-slate-200">
        {{ $airports->links() }}
    </div>
</div>
@endsection