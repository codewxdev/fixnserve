<?php

namespace App\Domains\System\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplyPlatformDefaults
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $platform = config('platform');

        // COUNTRY DEFAULT
        if (! $request->has('country_id') &&
            isset($platform['localization']['default_country_id'])) {

            $request->merge([
                'country_id' => $platform['localization']['default_country_id'],
            ]);
        }

        // CURRENCY DEFAULT
        if (! $request->has('currency_id') &&
            isset($platform['currency']['default_currency_id'])) {

            $request->merge([
                'currency_id' => $platform['currency']['default_currency_id'],
            ]);
        }

        // VALIDATE ALLOWED CURRENCY
        if ($request->has('currency_id')) {

            $allowed = $platform['currency']['allowed_ids'] ?? [];

            if (! empty($allowed) &&
                ! in_array($request->currency_id, $allowed)) {

                return response()->json([
                    'error' => 'Currency not allowed by platform policy',
                ], 403);
            }
        }

        return $next($request);
    }
}
