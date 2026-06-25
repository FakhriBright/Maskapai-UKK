@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.flights.index') }}" class="text-slate-500 hover:text-slate-800 text-sm">← Kembali ke Daftar</a>
    <h1 class="text-2xl font-bold text-slate-800 mt-2">Edit Jadwal Penerbangan</h1>
</div>

<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 max-w-4xl">
    <form action="{{ route('admin.flights.update', $flight) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Maskapai</label>
                <select name="airline_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
                    @foreach($airlines as $airline)
                        <option value="{{ $airline->id }}" {{ old('airline_id', $flight->airline_id) == $airline->id ? 'selected' : '' }}>{{ $airline->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Pesawat</label>
                <select name="airplane_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
                    @foreach($airplanes as $plane)
                        <option value="{{ $plane->id }}" {{ old('airplane_id', $flight->airplane_id) == $plane->id ? 'selected' : '' }}>
                            {{ $plane->model }} ({{ $plane->registration_number }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Bandara Asal</label>
                <select name="departure_airport_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
                    @foreach($airports as $airport)
                        <option value="{{ $airport->id }}" {{ old('departure_airport_id', $flight->departure_airport_id) == $airport->id ? 'selected' : '' }}>
                            {{ $airport->city }} ({{ $airport->iata_code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Bandara Tujuan</label>
                <select name="arrival_airport_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
                    @foreach($airports as $airport)
                        <option value="{{ $airport->id }}" {{ old('arrival_airport_id', $flight->arrival_airport_id) == $airport->id ? 'selected' : '' }}>
                            {{ $airport->city }} ({{ $airport->iata_code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Penerbangan</label>
                <input type="text" name="flight_number" value="{{ old('flight_number', $flight->flight_number) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent uppercase" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Harga Tiket (IDR)</label>
                <input type="number" name="price" value="{{ old('price', $flight->price) }}" min="0" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Waktu Berangkat</label>
                <!-- Format datetime-local butuh Y-m-d\TH:i -->
                <input type="datetime-local" name="departure_time" value="{{ old('departure_time', $flight->departure_time->format('Y-m-d\TH:i')) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Waktu Tiba</label>
                <input type="datetime-local" name="arrival_time" value="{{ old('arrival_time', $flight->arrival_time->format('Y-m-d\TH:i')) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 border-t border-slate-200 pt-6">
            <a href="{{ route('admin.flights.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Batal</a>
            <button type="submit" class="px-6 py-2 bg-brand-accent text-brand-900 font-bold rounded-lg hover:bg-amber-500 shadow-sm">Update Jadwal</button>
        </div>
    </form>
</div>
@endsection