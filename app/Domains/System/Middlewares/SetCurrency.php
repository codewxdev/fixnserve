<?php

namespace App\Domains\System\Middlewares;

use Closure;
use Illuminate\Http\Request;

class SetCurrency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (app()->bound('country')) {

            $country = app('country');

            config([
                'app.currency' => $country->currency_code,
            ]);
        }

        return $next($request);
    }
}
