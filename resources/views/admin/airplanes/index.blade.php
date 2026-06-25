@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Manajemen Pesawat</h1>
    <a href="{{ route('admin.airplanes.create') }}" class="bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-2 px-4 rounded-lg shadow transition">
        + Tambah Pesawat
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-semibold">
            <tr>
                <th class="p-4 border-b">Maskapai</th>
                <th class="p-4 border-b">Model</th>
                <th class="p-4 border-b">No. Registrasi</th>
                <th class="p-4 border-b">Kapasitas</th>
                <th class="p-4 border-b text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($airplanes as $plane)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 font-medium text-slate-800">{{ $plane->airline->name }}</td>
                    <td class="p-4 text-slate-600">{{ $plane->model }}</td>
                    <td class="p-4 font-mono text-sm text-slate-600">{{ $plane->registration_number }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-bold">
                            {{ $plane->capacity }} kursi
                        </span>
                    </td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('admin.airplanes.edit', $plane) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                        <form action="{{ route('admin.airplanes.destroy', $plane) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-500">Belum ada data pesawat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-slate-200">
        {{ $airplanes->links() }}
    </div>
</div>
@endsection