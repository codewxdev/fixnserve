<?php

namespace App\Domains\Security\Middlewares;

use App\Domains\Security\Models\MFAPolicy;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MFAPolicyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $policy = MFAPolicy::current();

        if ($policy->enforcement_policy === 'off') {
            return $next($request);
        }

        if (
            $policy->enforcement_policy === 'admins_only'
            && ! $user->hasRole('Super Admin')
        ) {
            return $next($request);
        }

        if (! $user->is_2fa_enabled || ! $user->google2fa_secret) {
            return response()->json([
                'mfa_required' => true,
                'allowed_methods' => $policy->allowed_methods,
            ], 403);
        }

        return $next($request);
    }
}
