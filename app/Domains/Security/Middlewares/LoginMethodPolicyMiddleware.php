<?php

namespace App\Domains\Security\Middlewares;

use App\Domains\Security\Models\AuthPolicy;
use Closure;
use Illuminate\Http\Request;

class LoginMethodPolicyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $policy = AuthPolicy::current();

        if ($request->filled('login') && $request->filled('password')) {

            $login = $request->input('login');

            // Detect login type
            $isEmail = filter_var($login, FILTER_VALIDATE_EMAIL);
            $isPhone = preg_match('/^[0-9+\-\s]+$/', $login);

            // Email + Password
            if ($isEmail) {
                if (! $policy->login_email_password) {
                    return response()->json([
                        'message' => 'Email login disabled by policy',
                    ], 403);
                }
            }

            // Phone + Password / OTP
            elseif ($isPhone) {
                if (! $policy->login_phone_otp) {
                    return response()->json([
                        'message' => 'Phone login disabled by policy',
                    ], 403);
                }
            }

            // Unknown format
            else {
                return response()->json([
                    'message' => 'Invalid login identifier',
                ], 422);
            }
        }

        // OAuth
        if ($request->filled('provider') && $request->filled('access_token')) {
            if (! $policy->login_oauth) {
                return response()->json([
                    'message' => 'OAuth login disabled by policy',
                ], 403);
            }
        }

        return $next($request);
    }
}
