<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllowedLocation;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    /**
     * Halaman untuk meminta izin lokasi
     */
    public function checkLocation()
    {
        return view('location.check');
    }

    /**
     * Proses koordinat yang dikirim user
     */
    public function storeLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180'
        ]);

        $userLat = $request->latitude;
        $userLng = $request->longitude;

        // Log untuk debugging
        Log::info('Location Store Debug:', [
            'user_lat' => $userLat,
            'user_lng' => $userLng,
            'session_before' => [
                'lat' => session('user_latitude'),
                'lng' => session('user_longitude')
            ]
        ]);

        // Simpan koordinat ke session
        session([
            'user_latitude' => $userLat,
            'user_longitude' => $userLng
        ]);

        // Log setelah session disimpan
        Log::info('Location Store After Session:', [
            'session_after' => [
                'lat' => session('user_latitude'),
                'lng' => session('user_longitude')
            ]
        ]);

        // Cek apakah lokasi diizinkan
        $isAllowed = AllowedLocation::isLocationAllowed($userLat, $userLng);
        
        Log::info('Location Check Result:', [
            'is_allowed' => $isAllowed,
            'user_coordinates' => [$userLat, $userLng]
        ]);

        if ($isAllowed) {
            return response()->json([
                'success' => true,
                'message' => 'Lokasi diverifikasi. Mengalihkan ke dashboard...',
                'redirect_url' => route('dashboard')
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat mengakses sistem dari lokasi ini. Sistem hanya dapat diakses dari area SMPN 02 Klakah.'
            ]);
        }
    }

    /**
     * Halaman akses ditolak
     */
    public function denied()
    {
        return view('location.denied');
    }

    /**
     * Get informasi lokasi yang diizinkan (untuk debugging)
     */
    public function getAllowedLocations()
    {
        $locations = AllowedLocation::where('is_active', true)->get();
        return response()->json($locations);
    }

    /**
     * Debug lokasi untuk troubleshooting
     */
    public function debugLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180'
        ]);

        $userLat = $request->latitude;
        $userLng = $request->longitude;

        $allowedLocations = AllowedLocation::where('is_active', true)->get();
        $results = [];

        foreach ($allowedLocations as $location) {
            $distance = AllowedLocation::calculateDistance(
                $userLat, 
                $userLng, 
                $location->latitude, 
                $location->longitude
            );
            
            $results[] = [
                'location' => $location,
                'distance' => round($distance),
                'radius' => $location->radius_meters,
                'is_allowed' => $distance <= $location->radius_meters
            ];
        }

        return response()->json([
            'user_coordinates' => [
                'latitude' => $userLat,
                'longitude' => $userLng
            ],
            'session_coordinates' => [
                'latitude' => session('user_latitude'),
                'longitude' => session('user_longitude')
            ],
            'results' => $results,
            'is_access_allowed' => AllowedLocation::isLocationAllowed($userLat, $userLng)
        ]);
    }
}
