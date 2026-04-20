<?php

namespace App\Domains\System\Middlewares;

use App\Domains\System\Services\GeoService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckGeoLocation
{
    public function __construct(protected GeoService $geoService) {}

    public function handle(Request $request, Closure $next)
    {
        // ✅ Step 1: Emergency lock check
        $config = $this->geoService->getConfig();
        if ($config->emergency_geo_lock) {
            return response()->json([
                'status' => 'error',
                'message' => 'Service temporarily unavailable due to emergency geo-lock',
            ], 503);
        }

        // ✅ Step 2: Get lat/lng from request OR user table
        $lat = $request->lat ?? null;
        $lng = $request->lng ?? null;

        // ✅ Step 3: Agar request mein nahi hai → user table se lo
        if (! $lat || ! $lng) {
            $user = Auth::user();

            if ($user && $user->lat && $user->lng) {
                $lat = $user->lat;
                $lng = $user->lng;
            }
        }

        // ✅ Step 4: Agar koi bhi lat/lng nahi mili → allow
        if (! $lat || ! $lng) {
            return $next($request);
        }

        // ✅ Step 5: Location check karo
        $result = $this->geoService->checkLocation($lat, $lng);

        if (! $result['allowed']) {
            return response()->json([
                'status' => 'error',
                'message' => $result['message'],
                'reason' => $result['reason'],
            ], 403);
        }

        // ✅ Step 6: Surcharge aur location request mein merge karo
        $request->merge([
            'surcharge' => $result['surcharge'],
            'checked_lat' => $lat,
            'checked_lng' => $lng,
            'location_source' => $request->has('lat') ? 'request' : 'user_profile',
        ]);

        return $next($request);
    }
}
