<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AllowedLocation;

class TestLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:test {lat} {lng} {--debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test location coordinates against allowed locations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userLat = floatval($this->argument('lat'));
        $userLng = floatval($this->argument('lng'));
        
        $this->info("Testing coordinates: {$userLat}, {$userLng}");
        $this->newLine();
        
        // Get all active locations
        $allowedLocations = AllowedLocation::where('is_active', true)->get();
        $this->info("Active locations found: " . $allowedLocations->count());
        
        // Also show all locations for debugging
        $allLocations = AllowedLocation::all();
        $this->info("Total locations in database: " . $allLocations->count());
        $this->newLine();
        
        $isAllowed = false;
        
        foreach ($allLocations as $location) {
            $distance = AllowedLocation::calculateDistance(
                $userLat, 
                $userLng, 
                $location->latitude, 
                $location->longitude
            );
            
            $allowed = $distance <= $location->radius_meters && $location->is_active;
            
            if ($allowed) {
                $isAllowed = true;
            }
            
            $this->line("Location: {$location->name}");
            $this->line("  Coordinates: {$location->latitude}, {$location->longitude}");
            $this->line("  Radius: {$location->radius_meters}m");
            $this->line("  Distance: " . round($distance) . "m");
            $this->line("  Active: " . ($location->is_active ? 'YES' : 'NO'));
            $this->line("  Within Range: " . ($distance <= $location->radius_meters ? 'YES' : 'NO'));
            $this->line("  Final Allowed: " . ($allowed ? 'YES' : 'NO'));
            $this->newLine();
        }
        
        $this->info("Final result: " . ($isAllowed ? 'ACCESS ALLOWED' : 'ACCESS DENIED'));
        
        // Test the static method
        $staticResult = AllowedLocation::isLocationAllowed($userLat, $userLng);
        $this->info("Static method result: " . ($staticResult ? 'ACCESS ALLOWED' : 'ACCESS DENIED'));
        
        return 0;
    }
}
