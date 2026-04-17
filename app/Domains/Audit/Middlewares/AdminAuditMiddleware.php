<?php

namespace App\Domains\Audit\Middlewares;

use Closure;

class AdminAuditMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('GET')) {
            return $next($request);
        }

        if (! auth()->check()) {
            return $next($request);
        }

        if (! auth()->user()->hasRole('Admin')) {
            return $next($request);
        }

        if (! $request->has('reason_code')) {
            return response()->json([
                'message' => 'Reason code is required for admin actions.',
            ], 422);
        }

        return $next($request);
    }
}
