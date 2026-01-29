<?php

// app/Http/Middleware/CheckUserStatus.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or missing token',
            ], 401);
        }

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        if (strtolower(trim($user->status)) !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Your account is not active',
                'user_status' => $user->status,
            ], 403);
        }

        // Attach user to request (optional but useful)
        auth()->setUser($user);

        return $next($request);
    }
}
