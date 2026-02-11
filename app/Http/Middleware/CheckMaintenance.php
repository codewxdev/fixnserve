<?php

namespace App\Http\Middleware;

use App\Services\MaintenanceService;
use Closure;
use Illuminate\Http\Request;

class CheckMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $module = null)
    {
        $service = app(MaintenanceService::class);

        // Global maintenance
        if ($m = $service->global()) {
            return $this->blocked($m);
        }

        // Module-specific
        if ($module && ($m = $service->module($module))) {
            return $this->blocked($m);
        }

        // Region-specific
        if (auth()->check()) {
            if ($m = $service->region(auth()->user()->country_id)) {
                return $this->blocked($m);
            }
        }

        return $next($request);
    }

    private function blocked($maintenance)
    {
        return response()->json([
            'maintenance' => true,
            'message' => $maintenance->user_message,
            'ends_at' => $maintenance->ends_at,
        ], 503);
    }
}
