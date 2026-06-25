<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'g-recaptcha-response' => [$this->recaptchaEnabled() ? 'required' : 'nullable', 'string'],
        ]);

        if ($this->recaptchaEnabled()) {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]);

            $result = $response->json();

            if (!$response->successful() || !($result['success'] ?? false) || ($result['score'] ?? 0) < 0.5) {
                throw ValidationException::withMessages([
                    'g-recaptcha-response' => 'Gagal verifikasi keamanan (Terdeteksi sebagai bot/spam). Silakan coba lagi.',
                ]);
            }
        }

        // Buat user baru dengan auto-verify email
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Default role untuk registrasi publik
            'email_verified_at' => now(), // ✅ AUTO VERIFY - biar gak perlu kirim email
        ]);

        // Hapus event Registered karena kita auto-verify (gak perlu kirim email verifikasi)
        // event(new Registered($user)); // <-- DI-COMMENT

        Auth::login($user);

        // ✅ Redirect ke customer dashboard (bukan 'dashboard' yang sudah tidak ada)
        return redirect()->route('customer.dashboard');
    }

    private function recaptchaEnabled(): bool
    {
        $siteKey = (string) config('services.recaptcha.site_key');
        $secretKey = (string) config('services.recaptcha.secret_key');

        return filled($siteKey)
            && filled($secretKey)
            && ! Str::startsWith($siteKey, ['your_', '['])
            && ! Str::startsWith($secretKey, ['your_', '[']);
    }
}
