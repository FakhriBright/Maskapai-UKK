@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.flights.index') }}" class="text-slate-500 hover:text-slate-800 text-sm">← Kembali ke Daftar</a>
    <h1 class="text-2xl font-bold text-slate-800 mt-2">Tambah Jadwal Penerbangan</h1>
</div>

<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 max-w-4xl">
    <form action="{{ route('admin.flights.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Baris 1: Maskapai & Pesawat -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Maskapai</label>
                <select name="airline_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
                    <option value="">-- Pilih Maskapai --</option>
                    @foreach($airlines as $airline)
                        <option value="{{ $airline->id }}" {{ old('airline_id') == $airline->id ? 'selected' : '' }}>{{ $airline->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Pesawat</label>
                <select name="airplane_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
                    <option value="">-- Pilih Pesawat --</option>
                    @foreach($airplanes as $plane)
                        <option value="{{ $plane->id }}" {{ old('airplane_id') == $plane->id ? 'selected' : '' }}>
                            {{ $plane->model }} ({{ $plane->registration_number }}) - Kap: {{ $plane->capacity }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Baris 2: Bandara Asal & Tujuan -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Bandara Asal (Departure)</label>
                <select name="departure_airport_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
                    <option value="">-- Pilih Bandara Asal --</option>
                    @foreach($airports as $airport)
                        <option value="{{ $airport->id }}" {{ old('departure_airport_id') == $airport->id ? 'selected' : '' }}>
                            {{ $airport->city }} - {{ $airport->name }} ({{ $airport->iata_code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Bandara Tujuan (Arrival)</label>
                <select name="arrival_airport_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
                    <option value="">-- Pilih Bandara Tujuan --</option>
                    @foreach($airports as $airport)
                        <option value="{{ $airport->id }}" {{ old('arrival_airport_id') == $airport->id ? 'selected' : '' }}>
                            {{ $airport->city }} - {{ $airport->name }} ({{ $airport->iata_code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Baris 3: Detail Penerbangan -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Penerbangan</label>
                <input type="text" name="flight_number" value="{{ old('flight_number') }}" placeholder="Contoh: GA-123" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent uppercase" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Harga Tiket (IDR)</label>
                <input type="number" name="price" value="{{ old('price') }}" min="0" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Waktu Berangkat</label>
                <input type="datetime-local" name="departure_time" value="{{ old('departure_time') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Waktu Tiba</label>
                <input type="datetime-local" name="arrival_time" value="{{ old('arrival_time') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 border-t border-slate-200 pt-6">
            <a href="{{ route('admin.flights.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Batal</a>
            <button type="submit" class="px-6 py-2 bg-brand-accent text-brand-900 font-bold rounded-lg hover:bg-amber-500 shadow-sm">Simpan Jadwal</button>
        </div>
    </form>
</div>
@endsection