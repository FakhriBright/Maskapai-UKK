@extends('layouts.admin')

@section('title', 'Manajemen User - SkyLine Airways')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Manajemen User</h1>
        <p class="text-sm text-slate-500 mt-0.5">{{ $users->total() }} akun terdaftar dalam sistem</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 bg-brand-accent hover:bg-amber-500 text-brand-900 font-extrabold py-2.5 px-5 rounded-xl shadow transition w-fit">
        <i data-lucide="user-plus" class="w-4 h-4"></i>
        Tambah User Baru
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200">
                <tr>
                    <th class="px-5 py-4">Pengguna</th>
                    <th class="px-5 py-4">Email</th>
                    <th class="px-5 py-4">Role</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4">Terdaftar</th>
                    <th class="px-5 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50/70 transition group">
                        <!-- Avatar + Name -->
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex-shrink-0 flex items-center justify-center font-extrabold text-sm text-white
                                    {{ $user->trashed() ? 'bg-slate-300' : 'bg-gradient-to-br from-brand-900 to-indigo-600' }}">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-extrabold text-slate-800 flex items-center gap-1.5">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                            <span class="text-[9px] font-bold bg-brand-accent/20 text-brand-900 px-1.5 py-0.5 rounded-full">Anda</span>
                                        @endif
                                    </div>
                                    @if($user->nik)
                                        <div class="text-xs text-slate-400">NIK: {{ $user->nik }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Email -->
                        <td class="px-5 py-4 text-slate-600">{{ $user->email }}</td>

                        <!-- Role Badge -->
                        <td class="px-5 py-4">
                            @php
                                $roleBadge = match($user->role) {
                                    'admin'    => 'bg-rose-100 text-rose-700 border-rose-200',
                                    'manager'  => 'bg-purple-100 text-purple-700 border-purple-200',
                                    'staff'    => 'bg-blue-100 text-blue-700 border-blue-200',
                                    default    => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                };
                            @endphp
                            <span class="text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full border {{ $roleBadge }}">
                                {{ $user->role }}
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="px-5 py-4">
                            @if($user->trashed())
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400 inline-block"></span> Non-Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span> Aktif
                                </span>
                            @endif
                        </td>

                        <!-- Date -->
                        <td class="px-5 py-4 text-xs text-slate-400 font-semibold">
                            {{ $user->created_at->format('d M Y') }}<br>
                            <span class="text-slate-300">{{ $user->created_at->diffForHumans() }}</span>
                        </td>

                        <!-- Actions -->
                        <td class="px-5 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                                @if(!$user->trashed())
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="inline-flex items-center gap-1 text-[11px] font-bold bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition">
                                        <i data-lucide="pencil" class="w-3 h-3"></i> Edit
                                    </a>
                                @endif

                                @if($user->trashed())
                                    <form action="{{ route('admin.users.activate', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1 text-[11px] font-bold bg-emerald-600 text-white px-3 py-1.5 rounded-lg hover:bg-emerald-700 transition">
                                            <i data-lucide="check-circle" class="w-3 h-3"></i> Aktifkan
                                        </button>
                                    </form>
                                @elseif($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.deactivate', $user) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Nonaktifkan user {{ addslashes($user->name) }}? User tidak bisa login sampai diaktifkan kembali.')">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1 text-[11px] font-bold bg-orange-500 text-white px-3 py-1.5 rounded-lg hover:bg-orange-600 transition">
                                            <i data-lucide="ban" class="w-3 h-3"></i> Nonaktifkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <i data-lucide="users" class="w-12 h-12 text-slate-200 mx-auto mb-3"></i>
                            <p class="font-semibold text-slate-400">Belum ada user terdaftar.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection