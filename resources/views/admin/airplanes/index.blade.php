@extends('layouts.admin')

@section('title', 'Manajemen Pesawat - SkyLine Airways')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Manajemen Armada Pesawat</h1>
        <p class="text-sm text-slate-500 mt-0.5">{{ $airplanes->total() }} unit pesawat terdaftar dalam armada SkyLine</p>
    </div>
    <a href="{{ route('admin.airplanes.create') }}" class="inline-flex items-center gap-2 bg-brand-accent hover:bg-amber-500 text-brand-900 font-extrabold py-2.5 px-5 rounded-xl shadow transition w-fit">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Tambah Pesawat
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200">
                <tr>
                    <th class="px-5 py-4">Maskapai</th>
                    <th class="px-5 py-4">Model Pesawat</th>
                    <th class="px-5 py-4">No. Registrasi</th>
                    <th class="px-5 py-4">Konfigurasi Kabin</th>
                    <th class="px-5 py-4">Kapasitas</th>
                    <th class="px-5 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($airplanes as $plane)
                    <tr class="hover:bg-slate-50/70 transition group">
                        <td class="px-5 py-4 font-extrabold text-slate-800">{{ $plane->airline->name }}</td>
                        <td class="px-5 py-4 font-semibold text-slate-700">{{ $plane->model }}</td>
                        <td class="px-5 py-4">
                            <span class="font-mono font-extrabold text-xs text-brand-900 bg-brand-900/10 px-2.5 py-1 rounded-lg tracking-wider">
                                {{ $plane->registration_number }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex gap-1.5">
                                <span class="text-[9px] font-extrabold px-1.5 py-0.5 bg-amber-100 text-amber-700 rounded uppercase">F</span>
                                <span class="text-[9px] font-extrabold px-1.5 py-0.5 bg-blue-100 text-blue-700 rounded uppercase">C</span>
                                <span class="text-[9px] font-extrabold px-1.5 py-0.5 bg-emerald-100 text-emerald-700 rounded uppercase">Y</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-xs font-extrabold px-2.5 py-1 bg-indigo-100 text-indigo-700 rounded-full">
                                {{ $plane->capacity }} kursi
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                                <a href="{{ route('admin.airplanes.edit', $plane) }}"
                                    class="inline-flex items-center gap-1.5 text-[11px] font-bold bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition">
                                    <i data-lucide="pencil" class="w-3 h-3"></i> Edit
                                </a>
                                <form action="{{ route('admin.airplanes.destroy', $plane) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus pesawat ini? Semua kursi terkait akan ikut terhapus.')">
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
                        <td colspan="6" class="px-5 py-16 text-center">
                            <i data-lucide="send" class="w-12 h-12 text-slate-200 mx-auto mb-3"></i>
                            <p class="font-semibold text-slate-400">Belum ada data pesawat.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($airplanes->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $airplanes->links() }}
    </div>
    @endif
</div>
@endsection