@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.airports.index') }}" class="text-slate-500 hover:text-slate-800 text-sm">← Kembali ke Daftar</a>
    <h1 class="text-2xl font-bold text-slate-800 mt-2">Tambah Bandara Baru</h1>
</div>

<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 max-w-2xl">
    <form action="{{ route('admin.airports.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Bandara</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kota</label>
                <input type="text" name="city" value="{{ old('city') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Negara</label>
                <input type="text" name="country" value="{{ old('country') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Kode IATA (3 huruf, unik)</label>
                <input type="text" name="iata_code" value="{{ old('iata_code') }}" maxlength="5" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent uppercase" required>
                <p class="text-xs text-slate-500 mt-1">Contoh: CGK, DPS, SUB</p>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.airports.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-brand-accent text-brand-900 font-bold rounded-lg hover:bg-amber-500">Simpan</button>
        </div>
    </form>
</div>
@endsection