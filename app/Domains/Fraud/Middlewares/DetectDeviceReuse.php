<?php

namespace App\Domains\Fraud\Middlewares;

use App\Domains\Fraud\Services\RiskScoringService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class DetectDeviceReuse
{
    public function __construct(
        protected RiskScoringService $riskService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // ✅ Only check if logged in
        if (! auth()->check()) {
            return $response;
        }

        $deviceId = $request->header('X-Device-ID')
                 ?? $request->fingerprint
                 ?? null;

        if (! $deviceId) {
            return $response;
        }

        $userId = auth()->id();

        // ✅ Check if this device used by multiple accounts
        $cacheKey = "device:{$deviceId}:users";
        $usersList = Cache::get($cacheKey, []);

        if (! in_array($userId, $usersList)) {
            $usersList[] = $userId;
            Cache::put($cacheKey, $usersList, now()->addDays(30));
        }

        // ✅ Multiple users on same device = FRAUD signal
        if (count($usersList) > 1) {
            $entityInfo = $this->getEntityInfo();

            $this->riskService->processEvent(
                entityType: $entityInfo['type'],
                entityId: $entityInfo['id'],
                eventType: 'device_reuse',
                eventData: [
                    'device_id' => $deviceId,
                    'accounts_count' => count($usersList),
                    'ip' => $request->ip(),
                ]
            );
        }

        return $response;
    }

    private function getEntityInfo(): array
    {
        $user = auth()->user();

        $entityType = match (true) {
            $user->hasRole('customer') => 'customer',
            $user->hasRole('rider') => 'rider',
            $user->hasRole('mart_vendor') => 'vendor',
            default => 'user',
        };

        return ['type' => $entityType, 'id' => $user->id];
    }
}
