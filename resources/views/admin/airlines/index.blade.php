@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Manajemen Maskapai</h1>
    <a href="{{ route('admin.airlines.create') }}" class="bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-2 px-4 rounded-lg shadow transition">
        + Tambah Maskapai
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-semibold">
            <tr>
                <th class="p-4 border-b">Logo</th>
                <th class="p-4 border-b">Nama Maskapai</th>
                <th class="p-4 border-b">Kode</th>
                <th class="p-4 border-b text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($airlines as $airline)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4">
                        @if($airline->logo)
                            <img src="{{ asset('storage/' . $airline->logo) }}" class="w-10 h-10 object-contain rounded">
                        @else
                            <div class="w-10 h-10 bg-slate-200 rounded flex items-center justify-center text-slate-500">No Logo</div>
                        @endif
                    </td>
                    <td class="p-4 font-medium text-slate-800">{{ $airline->name }}</td>
                    <td class="p-4 text-slate-600">{{ $airline->code }}</td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('admin.airlines.edit', $airline) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                        <form action="{{ route('admin.airlines.destroy', $airline) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-slate-500">Belum ada data maskapai.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-slate-200">
        {{ $airlines->links() }}
    </div>
</div>
@endsection