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

            if (
                !$response->successful()
                || !($result['success'] ?? false)
                || ($this->recaptchaVersion() === 'v3' && ($result['score'] ?? 0) < 0.5)
            ) {
                throw ValidationException::withMessages([
                    'g-recaptcha-response' => 'Gagal verifikasi keamanan (Terdeteksi sebagai bot/spam). Silakan coba lagi.',
                ]);
            }
        }

        // Buat user baru dengan status verifikasi kondisional
        $verificationEnabled = filter_var(env('MAIL_VERIFICATION_ENABLED', false), FILTER_VALIDATE_BOOLEAN);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Default role untuk registrasi publik
            'email_verified_at' => $verificationEnabled ? null : now(),
        ]);

        if ($verificationEnabled) {
            event(new \Illuminate\Auth\Events\Registered($user));
            Auth::login($user);
            return redirect()->route('verification.notice')
                ->with('success', 'Registrasi berhasil! Silakan periksa email Anda untuk memverifikasi akun.');
        }

        Auth::login($user);

        // ✅ Redirect ke customer dashboard dengan flash message
        return redirect()->route('customer.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang di SkyLine Airways.');
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

    private function recaptchaVersion(): string
    {
        return strtolower((string) config('services.recaptcha.version', 'v2'));
    }
}
