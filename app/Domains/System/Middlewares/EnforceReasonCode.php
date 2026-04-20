<?php

namespace App\Domains\System\Middlewares;

use App\Domains\System\Models\ReasonCode;
use App\Domains\System\Models\ReasonCodePolicy;
use Closure;
use Illuminate\Http\Request;

class EnforceReasonCode
{
    // ✅ High risk routes
    protected array $highRiskRoutes = [
        'api/rate-limits/save',
        'api/geo/geofences',
        // 'api/dual-approvals',
        'api/access-control/grants',
    ];

    public function handle(Request $request, Closure $next)
    {
        $isHighRisk = $this->isHighRiskRoute($request);

        // ✅ Check if reason required
        if (ReasonCodePolicy::requiresReason($isHighRisk)) {

            // ✅ Reason code must be in request
            if (! $request->has('reason_code')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Reason code is required',
                    'codes' => ReasonCode::where('is_active', true)
                        ->pluck('label', 'code'),
                ], 422);
            }

            // ✅ Validate reason code exists
            if (! ReasonCode::isValid($request->reason_code)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid reason code',
                    'codes' => ReasonCode::where('is_active', true)
                        ->pluck('label', 'code'),
                ], 422);
            }
        }

        return $next($request);
    }

    private function isHighRiskRoute(Request $request): bool
    {
        foreach ($this->highRiskRoutes as $route) {
            if ($request->is($route)) {
                return true;
            }
        }

        return false;
    }
}
