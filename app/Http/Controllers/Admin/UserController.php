<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. List User
public function index() {
    $users = User::withTrashed()
        ->where('id', '!=', auth()->id())
        ->orderBy('deleted_at') // User non-aktif muncul di bawah
        ->paginate(15);
    
    return view('admin.users.index', compact('users'));
}

    // 2. Form Tambah User
    public function create() {
        return view('admin.users.create');
    }

    // 3. Simpan User Baru
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,staff,customer,manager',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now(); // Auto-verify karena dibuat oleh admin

        User::create($validated);
        return redirect()->route('admin.users.index')->with('success', 'User baru berhasil ditambahkan!');
    }

    // 4. Form Edit User
    public function edit(User $user) {
        return view('admin.users.edit', compact('user'));
    }

    // 5. Update User (Termasuk Ganti Password)
    public function update(Request $request, User $user) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,staff,customer,manager',
            'password' => 'nullable|string|min:8|confirmed', // Password opsional saat edit
        ]);

        // Hanya update password jika diisi
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    // 6. Hapus User
// Non-aktifkan User (Soft Delete)
public function deactivate(User $user) {
    if ($user->id === auth()->id()) {
        return back()->withErrors('Anda tidak bisa menonaktifkan akun sendiri.');
    }
    
    $user->delete(); // Ini akan set deleted_at, bukan hapus permanen
    return back()->with('success', 'User dinonaktifkan.');
}

// Aktifkan Kembali User
public function activate($userId) {
    $user = User::withTrashed()->findOrFail($userId);
    $user->restore(); // Restore dari soft delete
    return back()->with('success', 'User diaktifkan kembali.');
}

// Hapus Permanen (Hanya untuk Admin utama, sangat hati-hati!)
public function destroy(User $user) {
    if ($user->id === auth()->id()) {
        return back()->withErrors('Anda tidak bisa menghapus akun sendiri.');
    }
    
    // Cek apakah user punya booking
    if ($user->bookings()->count() > 0) {
        return back()->withErrors('User tidak bisa dihapus karena memiliki riwayat booking.');
    }
    
    $user->forceDelete(); // Hard delete permanen
    return back()->with('success', 'User dihapus permanen.');
}
}