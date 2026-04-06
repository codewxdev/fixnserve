<?php

namespace App\Domains\Fraud\Middlewares;

use App\Domains\Fraud\Services\PromoAbuseService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ScanPromoAbuse
{
    public function __construct(
        protected PromoAbuseService $promoService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return $next($request);
        }

        $userId = auth()->id();

        // ✅ Gate 1: Account restricted from promos?
        if (Cache::get("promo_restricted:{$userId}")) {
            return response()->json([
                'status' => 'error',
                'message' => 'Account restricted from promotional offers',
                'reason' => 'promo_restricted',
            ], 403);
        }

        // ✅ Gate 2: Promo stacking blocked?
        if (
            Cache::get("promo_stacking_blocked:{$userId}") &&
            $request->has('promo_code')
        ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Promo stacking detected - checkout reset to standard',
                'reason' => 'promo_stacking_blocked',
            ], 403);
        }

        // ✅ Proceed
        $response = $next($request);

        // ✅ Scan after successful promo application
        if (
            $response->getStatusCode() >= 200 &&
            $response->getStatusCode() < 300 &&
            $request->has('promo_code')
        ) {
            $user = auth()->user();
            $promoCode = $request->promo_code;
            $promoType = $request->promo_type ?? 'discount';
            $amount = (float) ($request->promo_amount ?? 0);

            // ✅ Get entity info
            $entityType = $this->getEntityType($user);
            $entityRef = $this->getEntityRef($user);

            // ✅ Increment velocity
            $this->promoService->incrementPromoVelocity($user->id, $promoType);

            // ✅ Scan
            $this->promoService->scanPromoAttempt(
                entityType: $entityType,
                entityId: $user->id,
                entityRef: $entityRef,
                promoCode: $promoCode,
                promoType: $promoType,
                promoAmount: $amount,
                meta: [
                    'device_hash' => $request->header('X-Device-ID'),
                    'ip_address' => $request->ip(),
                    'job_id' => $request->job_id ?? null,
                    'provider_lat' => $request->header('X-Latitude'),
                    'provider_lng' => $request->header('X-Longitude'),
                    'customer_lat' => $request->customer_lat ?? null,
                    'customer_lng' => $request->customer_lng ?? null,
                    'applied_promo_codes' => $request->applied_promo_codes ?? [],
                    'card_fingerprint' => $request->card_fingerprint ?? null,
                ]
            );
        }

        return $response;
    }

    private function getEntityType($user): string
    {
        return match (true) {
            $user->hasRole('customer') => 'customer',
            $user->hasRole('service_provider') => 'provider',
            $user->hasRole('mart_vendor') => 'vendor',
            default => 'user',
        };
    }

    private function getEntityRef($user): string
    {
        $prefix = match (true) {
            $user->hasRole('customer') => 'C',
            $user->hasRole('service_provider') => 'P',
            $user->hasRole('mart_vendor') => 'V',
            default => 'U',
        };

        return "{$prefix}-{$user->id}";
    }
}
