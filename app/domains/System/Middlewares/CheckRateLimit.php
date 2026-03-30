<?php

namespace App\Domains\System\Middlewares;

use App\Domains\System\Services\RateLimitService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckRateLimit
{
    public function __construct(protected RateLimitService $rateLimitService) {}

    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $userId = auth()->id();

        $result = $this->rateLimitService->check($ip, $userId);

        // ✅ Log throttled requests
        if (! $result['allowed']) {
            Log::warning('Rate limit exceeded', [
                'ip' => $ip,
                'user' => $userId,
                'reason' => $result['reason'],
                'url' => $request->fullUrl(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $result['message'],
                'reason' => $result['reason'],
                'retry_after' => $result['retry_after'] ?? 60,
            ], 429);
        }

        $response = $next($request);

        // ✅ Add rate limit headers to response
        $config = $this->rateLimitService->getConfig();
        $response->headers->set('X-RateLimit-Limit', $config->api_rate_limit);
        $response->headers->set('X-RateLimit-UserLimit', $config->per_user_limit);
        $response->headers->set('X-RateLimit-IPLimit', $config->per_ip_limit);

        return $response;
    }
}
