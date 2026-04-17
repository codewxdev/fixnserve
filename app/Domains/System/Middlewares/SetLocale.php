<?php

namespace App\Domains\System\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $country = app('country');

        // ✅ Check request locale first, fallback to country default
        $requestedLocale = $request->header('Accept-Language')
                        ?? $request->query('Accept-Language')
                        ?? $request->query('locale')
                        ?? null;

        // ✅ Clean locale format (e.g. "ar-SA" → "ar")
        if ($requestedLocale) {
            $requestedLocale = strtolower(explode(',', $requestedLocale)[0]);
            $requestedLocale = explode('-', $requestedLocale)[0];
        }

        // ✅ Use requested locale if valid, otherwise use country default
        $availableLocales = config('app.available_locales', ['en', 'ar', 'fr', 'es', 'de', 'ur']);

        $locale = ($requestedLocale && in_array($requestedLocale, $availableLocales))
                    ? $requestedLocale
                    : $country->default_language;

        app()->setLocale($locale);

        return $next($request);
    }
}
