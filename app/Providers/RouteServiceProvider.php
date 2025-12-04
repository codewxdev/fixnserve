<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected function configureRateLimiting()
    {
        // Login route → strict limit
        RateLimiter::for('login', function ($request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        // 2FA verify route → stricter limit
        RateLimiter::for('2fa', function ($request) {
            $email = (string) $request->email;

            return Limit::perMinute(20)->by($email.$request->ip());
        });

        // General API route → higher limit
        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(1000)->by($request->ip());
        });
    }

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
