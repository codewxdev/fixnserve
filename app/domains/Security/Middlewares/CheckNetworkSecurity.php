<?php

namespace App\Domains\Security\Middlewares;

use App\Domains\Security\Models\GeoRule;
use App\Domains\Security\Models\IpRule;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNetworkSecurity
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $role = $user?->role ?? 'guest';

        $ip = $request->ip();

        // 🟢 Local fallback
        if (app()->environment('local') && in_array($ip, ['127.0.0.1', '::1'])) {
            $ip = '8.8.8.8';
        }

        // ==============================
        // 1️⃣ CHECK IP RULES
        // ==============================

        $ipRules = IpRule::where('is_active', true)
            ->where(function ($q) use ($role) {
                $q->where('applies_to', 'global')
                    ->orWhere('applies_to', $role);
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->get();

        foreach ($ipRules as $rule) {

            if ($this->ipMatchesCidr($ip, $rule->cidr)) {

                if ($rule->type === 'deny') {
                    return response()->json(['error' => 'Access denied by IP rule'], 403);
                    // abort(403, 'Access denied by IP rule');
                }

                if ($rule->type === 'allow') {
                    return $next($request);
                }
            }
        }

        // ==============================
        // 2️⃣ GEO RESOLVE
        // ==============================

        try {
            $geo = geoip($ip);
            $country = $geo->iso_code ?? null;
        } catch (\Exception $e) {
            $country = null;
        }

        // ==============================
        // 3️⃣ GEO POLICY CHECK
        // ==============================

        $geoRule = GeoRule::where('country_code', $country)->first();

        if ($geoRule) {
            if ($geoRule->status === 'blocked') {
                // abort(403, 'Access denied from your location');
                return response()->json(['error' => 'Access denied from your location'], 403);
            }

            if ($geoRule->status === 'allowed') {
                return $next($request);
            }
        }

        // Default Policy
        $defaultRule = GeoRule::where('is_default', true)->first();

        if ($defaultRule && $defaultRule->status === 'blocked') {

            // abort(403, 'Access denied by default geo policy');
            return response()->json(['error' => 'Access denied by default geo policy'], 403);
        }

        return $next($request);
    }

    // ====================================
    // CIDR MATCHING FUNCTION
    // ====================================
    private function ipMatchesCidr(string $ip, string $cidr): bool
    {
        if (! str_contains($cidr, '/')) {
            return $ip === $cidr;
        }

        [$subnet, $mask] = explode('/', $cidr);

        return (ip2long($ip) & ~((1 << (32 - $mask)) - 1))
            === (ip2long($subnet) & ~((1 << (32 - $mask)) - 1));
    }
}
