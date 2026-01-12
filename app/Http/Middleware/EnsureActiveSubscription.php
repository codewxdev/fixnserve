<?php

namespace App\Http\Middleware;

use App\Models\App;
use App\Services\SubscriptionService;
use Closure;
use Illuminate\Http\Request;

class EnsureActiveSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $appKey)
    {
        $app = App::where('app_key', $appKey)->firstOrFail();

        if (! app(SubscriptionService::class)
            ->isActive(auth()->user(), $app->id)) {

            return response()->json([
                'message' => 'Active subscription required',
            ], 402);
        }

        return $next($request);
    }
}
