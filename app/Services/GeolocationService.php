<?php

namespace App\Services;

use App\Models\Toko;
use Illuminate\Support\Facades\DB;

class GeolocationService
{
    /**
     * Calculate distance between two points using Haversine formula in SQL.
     * Returns active stores sorted by distance.
     *
     * @param float $latitude
     * @param float $longitude
     * @param int|null $radius In kilometers
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getNearbyStores($latitude, $longitude, $radius = null, $limit = 20)
    {
        // Haversine formula in SQL (distance in KM)
        // 6371 is Earth's radius in KM
        $haversine = "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))";

        $query = Toko::active()
            ->select('*')
            ->selectRaw("{$haversine} AS distance", [$latitude, $longitude, $latitude]);

        if ($radius) {
            $query->having('distance', '<=', $radius);
        }

        return $query->orderBy('distance', 'asc')
            ->paginate($limit);
    }

    /**
     * Fallback Haversine in PHP if needed.
     */
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
