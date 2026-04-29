<?php

namespace App\Domains\Config\Middlewares;

use Closure;
use Illuminate\Http\Request;

class InitializeLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        LanguageMiddleware::initialize();

        return $next($request);
    }
}
