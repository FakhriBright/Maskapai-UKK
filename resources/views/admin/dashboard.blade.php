@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Dashboard Overview</h1>
    <p class="text-slate-500 text-sm">Selamat datang di panel administrasi SkyLine Airways.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-500 text-sm font-medium uppercase">Total Maskapai</h3>
            <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $stats['total_airlines'] }}</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-500 text-sm font-medium uppercase">Total Bandara</h3>
            <div class="p-2 bg-green-100 rounded-lg text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $stats['total_airports'] }}</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-500 text-sm font-medium uppercase">Penerbangan Aktif</h3>
            <div class="p-2 bg-amber-100 rounded-lg text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $stats['active_flights'] }}</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-500 text-sm font-medium uppercase">Booking Pending</h3>
            <div class="p-2 bg-red-100 rounded-lg text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $stats['pending_bookings'] }}</p>
    </div>
</div>

<!-- Quick Actions / Recent Data -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Akses Cepat</h3>
        <div class="space-y-3">
            <a href="{{ route('admin.airlines.create') }}" class="block p-4 border border-slate-200 rounded-lg hover:bg-slate-50 transition flex justify-between items-center">
                <span class="font-medium text-slate-700">Tambah Maskapai Baru</span>
                <span class="text-brand-accent">→</span>
            </a>
            <a href="{{ route('admin.flights.create') }}" class="block p-4 border border-slate-200 rounded-lg hover:bg-slate-50 transition flex justify-between items-center">
                <span class="font-medium text-slate-700">Buat Jadwal Penerbangan</span>
                <span class="text-brand-accent">→</span>
            </a>
        </div>
    </div>
</div>
@endsection