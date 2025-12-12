<?php

// app/Http/Middleware/CheckUserStatus.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.',
            ], 401);
        }

        // Check if user is active
        if ($user->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Your account is not active. Please contact support.',
                'user_status' => $user->status,
            ], 403);
        }

        return $next($request);
    }
}
