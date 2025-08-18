<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AllowedLocation;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LocationRestriction
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if location restriction is bypassed
        if (config('app.location_bypass', false)) {
            return $next($request);
        }
        
        // Skip location check untuk route tertentu
        $excludedRoutes = [
            'location.denied',
            'location.check',
            'location.store',
            'logout'
        ];
        
        if (in_array($request->route()->getName(), $excludedRoutes)) {
            return $next($request);
        }
        
        // Ambil koordinat dari session atau request
        $userLat = $request->session()->get('user_latitude');
        $userLng = $request->session()->get('user_longitude');
        
        // Jika belum ada koordinat, redirect ke halaman location check
        if (!$userLat || !$userLng) {
            return redirect()->route('location.check')
                ->with('error', 'Silakan izinkan akses lokasi untuk menggunakan sistem ini.');
        }
        
        // Cek apakah lokasi user diizinkan
        if (!AllowedLocation::isLocationAllowed($userLat, $userLng)) {
            return redirect()->route('location.denied')
                ->with('error', 'Anda tidak dapat mengakses sistem dari lokasi ini. Sistem hanya dapat diakses dari area SMPN 02 Klakah.');
        }
        
        return $next($request);
    }
}
