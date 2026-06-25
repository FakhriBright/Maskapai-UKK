@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Manajemen User</h1>
    <a href="{{ route('admin.users.create') }}" class="bg-brand-accent hover:bg-amber-500 text-brand-900 font-bold py-2 px-4 rounded-lg shadow transition">
        + Tambah User Baru
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-semibold">
            <tr>
                <th class="p-4 border-b">Nama</th>
                <th class="p-4 border-b">Email</th>
                <th class="p-4 border-b">Role</th>
                <th class="p-4 border-b">Terdaftar</th>
                <th class="p-4 border-b text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($users as $user)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 font-medium text-slate-800">{{ $user->name }}</td>
                    <td class="p-4 text-slate-600">{{ $user->email }}</td>
<td class="p-4">
    @if($user->trashed())
        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-bold uppercase">
            Non-Aktif
        </span>
    @else
        @php
            $roleColors = [
                'admin' => 'bg-red-100 text-red-700',
                'manager' => 'bg-purple-100 text-purple-700',
                'staff' => 'bg-blue-100 text-blue-700',
                'customer' => 'bg-green-100 text-green-700',
            ];
            $colorClass = $roleColors[$user->role] ?? 'bg-slate-100 text-slate-700';
        @endphp
        <span class="px-2 py-1 {{ $colorClass }} rounded text-xs font-bold uppercase">
            {{ $user->role }}
        </span>
    @endif
</td>
                    <td class="p-4 text-slate-500 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                   <td class="p-4 text-right space-x-2">
    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:underline text-sm font-medium">Edit</a>
    
    @if($user->trashed())
        <!-- User Non-Aktif → Tampilkan tombol Aktifkan -->
        <form action="{{ route('admin.users.activate', $user->id) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-green-600 hover:underline text-sm font-medium">Aktifkan</button>
        </form>
    @elseif($user->id !== auth()->id())
        <!-- User Aktif → Tampilkan tombol Nonaktifkan -->
<form action="{{ route('admin.users.deactivate', $user) }}" method="POST" class="inline" onsubmit="return confirm('Nonaktifkan user ini? User tidak bisa login sampai diaktifkan kembali.')">
    @csrf
    {{-- Tidak perlu @method('DELETE') karena route sudah POST --}}
    <button type="submit" class="text-orange-600 hover:underline text-sm font-medium">Nonaktifkan</button>
</form>
    @else
        <span class="text-xs text-slate-400 italic">Anda</span>
    @endif
</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-500">Tidak ada user lain.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-slate-200">
        {{ $users->links() }}
    </div>
</div>
@endsection