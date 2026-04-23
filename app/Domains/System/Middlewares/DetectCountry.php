<?php

namespace App\Domains\System\Middlewares;

use App\Models\Country;
use Closure;

class DetectCountry
{
    public function handle($request, Closure $next)
    {
        $countryCode = strtolower($request->input('country', 'ae'));

        $country = Country::where('iso2', $countryCode)
            ->where('status', 'enabled')
            ->firstOrFail();

        app()->instance('country', $country);

        return $next($request);
    }
}
