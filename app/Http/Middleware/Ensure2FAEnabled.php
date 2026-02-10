<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Ensure2FAEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        // Auth::user() now works because we set it in CheckSuperAdmin
        $user = Auth::user();

        if (! $user || ! $user->is_2fa_enabled) {
            
            // If browser request, redirect to login (or a specific 2FA setup page)
            if ($request->acceptsHtml()) {
                return redirect()->route('login.index')->withErrors('2FA Verification Required.');
            }

            return response()->json([
                'error' => '2FA not verified. Access denied.',
            ], 401);
        }

        return $next($request);
    }
}