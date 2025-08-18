<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\AllowedLocation;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('location:bypass {action}', function ($action) {
    $envFile = base_path('.env');

    if (!file_exists($envFile)) {
        $this->error('.env file not found');
        return;
    }

    $content = file_get_contents($envFile);

    if ($action === 'enable') {
        // Add or update LOCATION_BYPASS=true
        if (strpos($content, 'LOCATION_BYPASS=') !== false) {
            $content = preg_replace('/LOCATION_BYPASS=.*/', 'LOCATION_BYPASS=true', $content);
        } else {
            $content .= "\nLOCATION_BYPASS=true";
        }
        file_put_contents($envFile, $content);
        $this->info('Location bypass ENABLED - System can be accessed from any location');
    } elseif ($action === 'disable') {
        // Set LOCATION_BYPASS=false
        if (strpos($content, 'LOCATION_BYPASS=') !== false) {
            $content = preg_replace('/LOCATION_BYPASS=.*/', 'LOCATION_BYPASS=false', $content);
        } else {
            $content .= "\nLOCATION_BYPASS=false";
        }
        file_put_contents($envFile, $content);
        $this->info('Location bypass DISABLED - Location restriction is active');
    } else {
        $this->error('Invalid action. Use: enable or disable');
        return;
    }

    $this->info('Please run: php artisan config:clear');
})->purpose('Enable/disable location restriction bypass');

Artisan::command('test:location {lat} {lng}', function ($lat, $lng) {
    $this->info("Testing location: $lat, $lng");

    // Test if we can fetch locations from database
    $locations = AllowedLocation::active()->get();
    $this->info("Found " . $locations->count() . " active locations");

    foreach ($locations as $location) {
        $this->info("Location: {$location->name} - Lat: {$location->latitude}, Lng: {$location->longitude}, Radius: {$location->radius_meters}m");

        $distance = AllowedLocation::calculateDistance($lat, $lng, $location->latitude, $location->longitude);
        $isAllowed = $distance <= $location->radius_meters;

        $this->info("Distance: " . round($distance, 2) . "m - " . ($isAllowed ? "ALLOWED" : "DENIED"));
    }

    // Test global method
    $globalCheck = AllowedLocation::isLocationAllowed($lat, $lng);
    $this->info("Global check result: " . ($globalCheck ? "ALLOWED" : "DENIED"));
})->purpose('Test location restriction');
