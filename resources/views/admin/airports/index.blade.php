@extends('layouts.admin')

@section('title', 'Manajemen Bandara - SkyLine Airways')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Manajemen Bandara</h1>
        <p class="text-sm text-slate-500 mt-0.5">{{ $airports->total() }} bandara terdaftar dalam sistem</p>
    </div>
    <a href="{{ route('admin.airports.create') }}" class="inline-flex items-center gap-2 bg-brand-accent hover:bg-amber-500 text-brand-900 font-extrabold py-2.5 px-5 rounded-xl shadow transition w-fit">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Tambah Bandara
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200">
                <tr>
                    <th class="px-5 py-4">Kode IATA</th>
                    <th class="px-5 py-4">Nama Bandara</th>
                    <th class="px-5 py-4">Kota</th>
                    <th class="px-5 py-4">Negara</th>
                    <th class="px-5 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($airports as $airport)
                    <tr class="hover:bg-slate-50/70 transition group">
                        <td class="px-5 py-4">
                            <span class="bg-brand-900 text-brand-accent font-extrabold text-xs px-2.5 py-1.5 rounded-lg font-mono tracking-widest">
                                {{ $airport->iata_code }}
                            </span>
                        </td>
                        <td class="px-5 py-4 font-extrabold text-slate-800">{{ $airport->name }}</td>
                        <td class="px-5 py-4 text-slate-600 font-semibold">{{ $airport->city }}</td>
                        <td class="px-5 py-4 text-slate-500">{{ $airport->country }}</td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                                <a href="{{ route('admin.airports.edit', $airport) }}"
                                    class="inline-flex items-center gap-1.5 text-[11px] font-bold bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition">
                                    <i data-lucide="pencil" class="w-3 h-3"></i> Edit
                                </a>
                                <form action="{{ route('admin.airports.destroy', $airport) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus bandara ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 text-[11px] font-bold bg-rose-600 text-white px-3 py-1.5 rounded-lg hover:bg-rose-700 transition">
                                        <i data-lucide="trash-2" class="w-3 h-3"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center">
                            <i data-lucide="map-pin" class="w-12 h-12 text-slate-200 mx-auto mb-3"></i>
                            <p class="font-semibold text-slate-400">Belum ada data bandara.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($airports->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $airports->links() }}
    </div>
    @endif
</div>
@endsection