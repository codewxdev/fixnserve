<?php

namespace App\Http\Middleware;

use App\Services\KillSwitchService;
use Closure;
use Illuminate\Http\Request;

class KillSwitch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $scope)
    {
        $service = app(KillSwitchService::class);

        // HARD KILL → block everything
        if ($service->isHardKilled($scope)) {
            return response()->json([
                'message' => ucfirst($scope).' service is temporarily unavailable',
            ], 503);
        }

        // SOFT KILL → block only write / critical actions
        if ($service->isSoftKilled($scope)) {

            if ($this->isWriteRequest($request)) {
                return response()->json([
                    'message' => ucfirst($scope).' is temporarily restricted',
                ], 403);
            }
        }

        return $next($request);
    }

    private function isWriteRequest(Request $request): bool
    {
        return in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE']);
    }
}
