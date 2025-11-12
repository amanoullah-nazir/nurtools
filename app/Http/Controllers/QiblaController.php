<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class QiblaController extends Controller
{
    /**
     * Makkah (Kaaba) coordinates
     */
    private const MAKKAH_LAT = 21.4225;
    private const MAKKAH_LNG = 39.8262;

    /**
     * Display the Qibla compass page
     */
    public function index()
    {
        return Inertia::render('QiblaCompass', [
            'makkahCoordinates' => [
                'lat' => self::MAKKAH_LAT,
                'lng' => self::MAKKAH_LNG,
            ],
        ]);
    }

    /**
     * Calculate Qibla direction from given coordinates
     */
    public function calculate(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $userLat = $request->latitude;
        $userLng = $request->longitude;

        // Calculate bearing to Makkah
        $bearing = $this->calculateBearing($userLat, $userLng);
        
        // Calculate distance to Makkah
        $distance = $this->calculateDistance($userLat, $userLng);

        return response()->json([
            'bearing' => $bearing,
            'distance' => $distance,
            'makkah' => [
                'lat' => self::MAKKAH_LAT,
                'lng' => self::MAKKAH_LNG,
            ],
            'user' => [
                'lat' => $userLat,
                'lng' => $userLng,
            ],
        ]);
    }

    /**
     * Calculate bearing from user location to Makkah
     * Returns bearing in degrees (0-360)
     */
    private function calculateBearing($lat1, $lng1)
    {
        $lat1 = deg2rad($lat1);
        $lng1 = deg2rad($lng1);
        $lat2 = deg2rad(self::MAKKAH_LAT);
        $lng2 = deg2rad(self::MAKKAH_LNG);

        $dLng = $lng2 - $lng1;

        $y = sin($dLng) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dLng);
        
        $bearing = atan2($y, $x);
        $bearing = rad2deg($bearing);
        
        // Normalize to 0-360
        $bearing = fmod(($bearing + 360), 360);

        return round($bearing, 2);
    }

    /**
     * Calculate distance from user location to Makkah using Haversine formula
     * Returns distance in kilometers
     */
    private function calculateDistance($lat1, $lng1)
    {
        $earthRadius = 6371; // km

        $lat1 = deg2rad($lat1);
        $lng1 = deg2rad($lng1);
        $lat2 = deg2rad(self::MAKKAH_LAT);
        $lng2 = deg2rad(self::MAKKAH_LNG);

        $dLat = $lat2 - $lat1;
        $dLng = $lng2 - $lng1;

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos($lat1) * cos($lat2) *
             sin($dLng / 2) * sin($dLng / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return round($distance, 2);
    }
}
