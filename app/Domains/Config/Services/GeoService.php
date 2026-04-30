<?php

namespace App\Domains\Config\Services;

use App\Domains\Config\Models\GeoConfiguration;
use App\Domains\Config\Models\Geofence;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GeoService
{
    // ✅ Check if location is allowed globally
    public function checkLocation(float $lat, float $lng): array
    {
        $config = $this->getConfig();

        // ✅ Emergency lock — block everything
        if ($config->emergency_geo_lock) {
            return [
                'allowed' => false,
                'reason' => 'emergency_geo_lock',
                'message' => 'Service temporarily unavailable',
                'surcharge' => 0,
            ];
        }

        $geofences = $this->getGeofences();
        $inService = false;
        $isRestricted = false;
        $surcharge = 0;

        foreach ($geofences as $zone) {
            if (! $zone->status) {
                continue;
            }

            $isInside = $this->isPointInZone($lat, $lng, $zone);

            if (! $isInside) {
                continue;
            }

            switch ($zone->type) {
                case 'restricted_zone':
                    $isRestricted = true;
                    break;

                case 'service_area':
                    $inService = true;
                    break;

                case 'surcharge_zone':
                    $surcharge += $zone->details['fee'] ?? 0;
                    break;
            }
        }

        if ($isRestricted) {
            return [
                'allowed' => false,
                'reason' => 'restricted_zone',
                'message' => 'Location is in restricted zone',
                'surcharge' => 0,
            ];
        }

        return [
            'allowed' => $inService,
            'reason' => $inService ? 'in_service_area' : 'outside_service_area',
            'message' => $inService ? 'Location is serviceable' : 'Outside service area',
            'surcharge' => $surcharge,
        ];
    }

    // ✅ Check if point is inside zone
    private function isPointInZone(float $lat, float $lng, Geofence $zone): bool
    {
        if ($zone->boundary_type === 'radius') {
            return $this->isPointInRadius(
                $lat, $lng,
                $zone->center_lat,
                $zone->center_lng,
                $zone->radius_km
            );
        }

        return $this->isPointInPolygon($lat, $lng, $zone->coordinates);
    }

    // ✅ Radius check using Haversine formula
    private function isPointInRadius(
        float $lat, float $lng,
        float $centerLat, float $centerLng,
        float $radiusKm
    ): bool {
        $earthRadius = 6371;
        $dLat = deg2rad($centerLat - $lat);
        $dLng = deg2rad($centerLng - $lng);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat)) * cos(deg2rad($centerLat)) *
             sin($dLng / 2) * sin($dLng / 2);

        $distance = $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $distance <= $radiusKm;
    }

    // ✅ Polygon check using ray casting
    private function isPointInPolygon(float $lat, float $lng, array $polygon): bool
    {
        $inside = false;
        $n = count($polygon);

        for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {
            $xi = $polygon[$i]['lat'];
            $yi = $polygon[$i]['lng'];
            $xj = $polygon[$j]['lat'];
            $yj = $polygon[$j]['lng'];

            if ((($yi > $lng) !== ($yj > $lng)) &&
                ($lat < ($xj - $xi) * ($lng - $yi) / ($yj - $yi) + $xi)) {
                $inside = ! $inside;
            }
        }

        return $inside;
    }

    // ✅ Cache config for performance
    public function getConfig(): GeoConfiguration
    {
        return Cache::remember('geo_config', 3600, function () {
            return GeoConfiguration::firstOrCreate(['id' => 1]);
        });
    }

    public function getGeofences(): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember('geofences', 3600, function () {
            return Geofence::where('status', true)->get();
        });
    }

    public function refreshConfig(): void
    {
        Cache::forget('geo_config');
    }

    public function refreshGeofences(): void
    {
        Cache::forget('geofences');
    }

    public function handleEmergencyLock(bool $locked): void
    {
        Cache::forget('geo_config');
        Log::warning('🚨 Emergency Geo-Lock: '.($locked ? 'ACTIVATED' : 'DEACTIVATED'));
    }
}
