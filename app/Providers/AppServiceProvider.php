<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function (HttpRequest $request) {
            return Limit::perMinute(5)->by($request->email ?? $request->ip());
        });

        if (Cache::has('platform_preferences')) {
            config(['platform' => Cache::get('platform_preferences')]);
        }
    }
}
