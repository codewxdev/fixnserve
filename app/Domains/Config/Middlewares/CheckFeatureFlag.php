<?php

namespace App\Domains\Config\Middlewares;

use App\Domains\Config\Models\FeatureFlag;
use Closure;
use Illuminate\Http\Request;

class CheckFeatureFlag
{
    public function handle(Request $request, Closure $next, $feature)
    {
        $flag = FeatureFlag::where('key', $feature)->first();

        // Agar flag exist nahi karta
        if (! $flag) {
            abort(404);
        }

        // Boolean check
        if ($flag->type === 'boolean') {
            if (! ($flag->value['enabled'] ?? false)) {
                abort(404);
            }
        }

        return $next($request);
    }
}
