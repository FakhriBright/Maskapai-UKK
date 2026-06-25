@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.airlines.index') }}" class="text-slate-500 hover:text-slate-800 text-sm">← Kembali ke Daftar</a>
    <h1 class="text-2xl font-bold text-slate-800 mt-2">Edit Maskapai</h1>
</div>

<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 max-w-2xl">
    <form action="{{ route('admin.airlines.update', $airline) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Maskapai</label>
                <input type="text" name="name" value="{{ old('name', $airline->name) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kode IATA (Max 10 char)</label>
                <input type="text" name="code" value="{{ old('code', $airline->code) }}" maxlength="10" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent">{{ old('description', $airline->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Logo Maskapai</label>
                @if($airline->logo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $airline->logo) }}" class="w-20 h-20 object-contain rounded border">
                        <p class="text-xs text-slate-500 mt-1">Logo saat ini</p>
                    </div>
                @endif
                <input type="file" name="logo" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-accent file:text-brand-900 hover:file:bg-amber-500">
                <p class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah logo</p>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.airlines.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-brand-accent text-brand-900 font-bold rounded-lg hover:bg-amber-500">Update</button>
        </div>
    </form>
</div>
@endsection