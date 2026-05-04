<?php

namespace App\Domains\System\Controllers\Cp\V1;

use App\Domains\System\Models\GeoConfiguration;
use App\Domains\System\Models\Geofence;
use App\Domains\System\Services\GeoService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class GeoConfigurationController extends BaseApiController
{
    protected GeoService $geoService;

    public function __construct(GeoService $geoService)
    {
        $this->geoService = $geoService;
    }

    // ✅ GET core settings
    public function getCoreSettings()
    {
        $config = GeoConfiguration::first() ?? new GeoConfiguration;

        return $this->success($config, 'geo_config_fetched');
    }

    // ✅ SAVE core settings
    public function saveCoreSettings(Request $request)
    {
        $validated = $request->validate([
            'map_provider' => 'required|in:google,mapbox,osm',
            'distance_calculation_mode' => 'required|in:routing,straight',
            'default_service_radius' => 'required|numeric|min:1|max:500',
        ]);

        $config = GeoConfiguration::updateOrCreate(
            ['id' => 1],
            $validated
        );

        // ✅ Update global config cache
        $this->geoService->refreshConfig();

        return $this->success($config, 'geo_config_saved');
    }

    // ✅ GET all geofences
    public function getGeofences()
    {
        $geofences = Geofence::paginate(10);

        return $this->success($geofences, 'geofences_fetched');
    }

    // ✅ ADD geofence
    public function addGeofence(Request $request)
    {
        $validated = $request->validate([
            // ✅ Basic fields from form
            'zone_name' => 'required|string|max:255',
            'type' => 'required|in:service_area,restricted_zone,surcharge_zone',
            'boundary_type' => 'required|in:polygon,radius',
            'status' => 'boolean',

            // ✅ Polygon fields
            'coordinates' => 'required_if:boundary_type,polygon|array|min:3',
            'coordinates.*.lat' => 'required_if:boundary_type,polygon|numeric|between:-90,90',
            'coordinates.*.lng' => 'required_if:boundary_type,polygon|numeric|between:-180,180',

            // ✅ Circle fields
            'center_lat' => 'required_if:boundary_type,radius|numeric|between:-90,90',
            'center_lng' => 'required_if:boundary_type,radius|numeric|between:-180,180',
            'radius_km' => 'required_if:boundary_type,radius|numeric|min:0.1|max:500',

            // ✅ Details based on type
            'details' => 'nullable|array',
            'details.fare_multiplier' => 'required_if:type,service_area|numeric|min:0',
            'details.fee' => 'required_if:type,surcharge_zone|numeric|min:0',
            'details.currency' => 'required_if:type,surcharge_zone|string',
            'details.restriction' => 'required_if:type,restricted_zone|string',
        ]);

        $geofence = Geofence::create($validated);
        $this->geoService->refreshGeofences();

        return $this->success($geofence, 'geofence_created', 201);
    }

    // ✅ EDIT geofence
    public function updateGeofence(Request $request, Geofence $geofence)
    {
        $validated = $request->validate([
            'zone_name' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:service_area,restricted_zone,surcharge_zone',
            'boundary_type' => 'sometimes|in:polygon,radius',
            'coordinates' => 'sometimes|array',
            'radius_km' => 'sometimes|numeric|min:0',
            'center_lat' => 'sometimes|numeric',
            'center_lng' => 'sometimes|numeric',
            'details' => 'sometimes|array',
            'status' => 'sometimes|boolean',
        ]);

        $geofence->update($validated);
        $this->geoService->refreshGeofences();

        return $this->success($geofence, 'geofence_updated');
    }

    // ✅ DELETE geofence
    public function deleteGeofence(Geofence $geofence)
    {
        $geofence->delete();
        $this->geoService->refreshGeofences();

        return $this->success(null, 'geofence_deleted');
    }

    // ✅ TOGGLE geofence status
    public function toggleGeofence(Geofence $geofence)
    {
        $geofence->update(['status' => ! $geofence->status]);
        $this->geoService->refreshGeofences();

        return $this->success($geofence, 'geofence_toggled');
    }
}
