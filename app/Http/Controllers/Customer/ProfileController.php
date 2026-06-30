<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman lengkapi profil.
     */
    public function completeShow()
    {
        $user = auth()->user();
        return view('customer.profile.complete', compact('user'));
    }

    /**
     * Simpan kelengkapan data profil.
     */
    public function completeStore(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:users,nik,' . $user->id,
            'passport_number' => 'nullable|string|max:50',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:male,female',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'nationality' => 'required|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'nik' => $request->nik,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'nationality' => $request->nationality,
            'identity_type' => $request->filled('passport_number') ? 'passport' : 'ktp',
            'identity_number' => $request->filled('passport_number') ? $request->passport_number : $request->nik,
        ];

        // Upload foto profil jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('profile_photos', 'public');
        }

        $user->update($data);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Profil Anda berhasil dilengkapi! Selamat datang di SkyLine Airways.');
    }
}
