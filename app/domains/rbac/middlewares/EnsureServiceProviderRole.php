<?php

// app/Http/Middleware/CheckServiceProviderRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureServiceProviderRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.',
            ], 401);
        }

        // If no specific roles provided, default to 'Service Provider'
        if (empty($roles)) {
            $roles = ['service provider'];
        }

        $hasRequiredRole = false;

        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                $hasRequiredRole = true;
                break;
            }
        }

        if (! $hasRequiredRole) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Required role: '.implode(' or ', $roles),
            ], 403);
        }

        return $next($request);
    }
}
