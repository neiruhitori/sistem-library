<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class AllowedLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'latitude', 
        'longitude',
        'radius_meters',
        'is_active',
        'description'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean'
    ];

    /**
     * Cek apakah koordinat user berada dalam radius yang diizinkan
     */
    public static function isLocationAllowed($userLat, $userLng)
    {
        $allowedLocations = self::where('is_active', true)->get();
        
        // Log untuk debug
        Log::info('Location Check Debug:', [
            'user_lat' => $userLat,
            'user_lng' => $userLng,
            'active_locations_count' => $allowedLocations->count()
        ]);
        
        foreach ($allowedLocations as $location) {
            $distance = self::calculateDistance(
                $userLat, 
                $userLng, 
                $location->latitude, 
                $location->longitude
            );
            
            // Log detail setiap lokasi
            Log::info('Checking location:', [
                'location_name' => $location->name,
                'location_lat' => $location->latitude,
                'location_lng' => $location->longitude,
                'radius' => $location->radius_meters,
                'calculated_distance' => round($distance),
                'is_allowed' => $distance <= $location->radius_meters
            ]);
            
            if ($distance <= $location->radius_meters) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Hitung jarak antara dua koordinat menggunakan formula Haversine
     */
    public static function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
             sin($dLng/2) * sin($dLng/2);
             
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        return $earthRadius * $c; // Jarak dalam meter
    }

    /**
     * Get lokasi terdekat dari koordinat user
     */
    public static function getNearestLocation($userLat, $userLng)
    {
        $allowedLocations = self::where('is_active', true)->get();
        $nearest = null;
        $minDistance = PHP_FLOAT_MAX;
        
        foreach ($allowedLocations as $location) {
            $distance = self::calculateDistance(
                $userLat, 
                $userLng, 
                $location->latitude, 
                $location->longitude
            );
            
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearest = $location;
                $nearest->distance = round($distance);
            }
        }
        
        return $nearest;
    }

    /**
     * Scope untuk lokasi aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
