@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-slate-800 text-sm">← Kembali ke Daftar</a>
    <h1 class="text-2xl font-bold text-slate-800 mt-2">Edit User: {{ $user->name }}</h1>
</div>

<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 max-w-2xl">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru <span class="text-xs text-slate-400">(Kosongkan jika tidak ingin mengubah)</span></label>
                    <input type="password" name="password" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Role / Hak Akses</label>
                <select name="role" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-brand-accent focus:border-brand-accent" required>
                    <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff Operasional</option>
                    <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-brand-accent text-brand-900 font-bold rounded-lg hover:bg-amber-500">Update User</button>
        </div>
    </form>
</div>
@endsection