@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.airplanes.index') }}" class="text-slate-500 hover:text-slate-800 text-sm">← Kembali ke Daftar</a>
    <h1 class="text-2xl font-bold text-slate-800 mt-2">Tambah Pesawat Baru</h1>
</div>

<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 max-w-2xl">
    <form action="{{ route('admin.airplanes.store') }}" method="POST">
        @csrf
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Maskapai</label>
                <select name="airline_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
                    <option value="">-- Pilih Maskapai --</option>
                    @foreach($airlines as $airline)
                        <option value="{{ $airline->id }}" {{ old('airline_id') == $airline->id ? 'selected' : '' }}>
                            {{ $airline->name }} ({{ $airline->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Model Pesawat</label>
                <input type="text" name="model" value="{{ old('model') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
                <p class="text-xs text-slate-500 mt-1">Contoh: Boeing 737-800, Airbus A320</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Registrasi</label>
                <input type="text" name="registration_number" value="{{ old('registration_number') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent uppercase" required>
                <p class="text-xs text-slate-500 mt-1">Contoh: PK-GMA, PK-LQM</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kapasitas Kursi</label>
                <input type="number" name="capacity" value="{{ old('capacity') }}" min="10" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
                <p class="text-xs text-slate-500 mt-1">Kursi akan di-generate otomatis berdasarkan kapasitas ini</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.airplanes.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-brand-accent text-brand-900 font-bold rounded-lg hover:bg-amber-500">Simpan & Generate Kursi</button>
        </div>
    </form>
</div>
@endsection