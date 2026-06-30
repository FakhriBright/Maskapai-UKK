<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsComplete
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Hanya berlaku untuk customer
            if ($user->role === 'customer') {
                // Periksa apakah profil masih kosong
                if (is_null($user->nik) || is_null($user->phone) || is_null($user->birth_date) || is_null($user->gender) || is_null($user->address) || is_null($user->nationality)) {
                    
                    // Bypass untuk rute lengkap profil agar tidak redirect loop
                    if ($request->routeIs('customer.profile.complete') || $request->routeIs('customer.profile.complete.store') || $request->routeIs('logout')) {
                        return $next($request);
                    }
                    
                    return redirect()->route('customer.profile.complete')
                        ->with('error', 'Silakan lengkapi profil Anda terlebih dahulu untuk melanjutkan pemesanan.');
                }
            }
        }

        return $next($request);
    }
}
