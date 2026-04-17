<?php

namespace App\Domains\Fraud\Middlewares;

use App\Domains\Fraud\Services\RiskScoringService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class DetectVelocityPattern
{
    public function __construct(
        protected RiskScoringService $riskService
    ) {}

    // ✅ Define thresholds per route
    protected array $velocityRules = [
        'api/*/payments' => ['limit' => 5,  'window' => 60],  // 5 per minute
        'api/*/orders' => ['limit' => 10, 'window' => 60],  // 10 per minute
        'api/*/wallet/*' => ['limit' => 3,  'window' => 60],  // 3 per minute
        'api/auth/login' => ['limit' => 5,  'window' => 300], // 5 per 5 minutes
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! auth()->check()) {
            return $response;
        }

        $rule = $this->getVelocityRule($request);
        if (! $rule) {
            return $response;
        }

        $userId = auth()->id();
        $route = $request->path();
        $cacheKey = "velocity:{$userId}:{$route}";

        // ✅ Increment counter
        $count = Cache::increment($cacheKey);

        // ✅ Set expiry on first hit
        if ($count === 1) {
            Cache::expire($cacheKey, $rule['window']);
        }

        // ✅ Threshold exceeded = velocity pattern detected
        if ($count > $rule['limit']) {
            $entityInfo = $this->getEntityInfo();

            $this->riskService->processEvent(
                entityType: $entityInfo['type'],
                entityId: $entityInfo['id'],
                eventType: 'velocity_pattern',
                eventData: [
                    'route' => $route,
                    'count' => $count,
                    'limit' => $rule['limit'],
                    'window_secs' => $rule['window'],
                ]
            );
        }

        return $response;
    }

    private function getVelocityRule(Request $request): ?array
    {
        foreach ($this->velocityRules as $pattern => $rule) {
            if ($request->is($pattern)) {
                return $rule;
            }
        }

        return null;
    }

    private function getEntityInfo(): array
    {
        $user = auth()->user();
        $entityType = match (true) {
            $user->hasRole('customer') => 'customer',
            $user->hasRole('rider') => 'rider',
            default => 'user',
        };

        return ['type' => $entityType, 'id' => $user->id];
    }
}
