<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        // 1. Cek signature valid
        if (! $request->hasValidSignature()) {
            abort(403, 'Link verifikasi tidak valid atau telah kedaluwarsa.');
        }

        // 2. Cek apakah user sudah login
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memverifikasi email Anda.');
        }

        $user = auth()->user();

        // 3. Cek apakah ID user cocok
        if (! hash_equals((string) $request->route('id'), (string) $user->getKey())) {
            // Jika login sebagai user lain, logout lalu minta login sebagai user yang sesuai
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->with('error', 'Link verifikasi ini ditujukan untuk akun lain. Silakan masuk menggunakan akun yang sesuai.');
        }

        // 4. Cek apakah Hash email cocok
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403, 'Link verifikasi tidak cocok dengan email akun ini.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
