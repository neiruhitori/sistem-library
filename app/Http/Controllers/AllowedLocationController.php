<?php

namespace App\Http\Controllers;

use App\Models\AllowedLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllowedLocationController extends Controller
{
    public function index()
    {
        $locations = AllowedLocation::all();
        return view('admin.allowed-locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.allowed-locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_meters' => 'required|integer|min:1|max:5000',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean'
        ]);

        AllowedLocation::create([
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius_meters' => $request->radius_meters,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.allowed-locations.index')
            ->with('success', 'Lokasi berhasil ditambahkan');
    }

    public function destroy(AllowedLocation $allowedLocation)
    {
        $allowedLocation->delete();
        
        return redirect()->route('admin.allowed-locations.index')
            ->with('success', 'Lokasi berhasil dihapus');
    }

    public function edit(AllowedLocation $allowedLocation)
    {
        return view('admin.allowed-locations.edit', compact('allowedLocation'));
    }

    public function update(Request $request, AllowedLocation $allowedLocation)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_meters' => 'required|integer|min:1|max:5000',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean'
        ]);

        $allowedLocation->update([
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius_meters' => $request->radius_meters,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.allowed-locations.index')
            ->with('success', 'Lokasi berhasil diperbarui');
    }

    public function toggleStatus(AllowedLocation $allowedLocation)
    {
        $allowedLocation->update([
            'is_active' => !$allowedLocation->is_active
        ]);

        $status = $allowedLocation->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
            ->with('success', "Lokasi berhasil {$status}");
    }

    public function testLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180'
        ]);

        $userLat = $request->latitude;
        $userLng = $request->longitude;
        
        $activeLocations = AllowedLocation::active()->get();
        $results = [];
        
        foreach ($activeLocations as $location) {
            $distance = $location->calculateDistance($userLat, $userLng);
            $isAllowed = $distance <= $location->radius_meters;
            
            $results[] = [
                'location' => $location,
                'distance' => round($distance, 2),
                'is_allowed' => $isAllowed,
                'radius' => $location->radius_meters
            ];
        }
        
        return response()->json([
            'success' => true,
            'user_coordinates' => [
                'latitude' => $userLat,
                'longitude' => $userLng
            ],
            'results' => $results,
            'is_access_allowed' => collect($results)->contains('is_allowed', true)
        ]);
    }
}
