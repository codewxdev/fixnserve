<?php

namespace App\Domains\Disputes\Middlewares;

use App\Domains\Disputes\Services\AbuseEnforcementService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAbuseRestrictions
{
    public function __construct(
        protected AbuseEnforcementService $abuseService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();
        $entityType = $this->getEntityType($user);
        $entityId = $user->id;

        // ✅ Gate 1: Account restricted?
        if (
            $this->abuseService->hasActiveRestriction(
                $entityType, $entityId, 'account'
            )
        ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Account restricted due to policy violations',
                'reason' => 'abuse_restriction',
            ], 403);
        }

        // ✅ Gate 2: Refund limited?
        if (
            $request->is('api/refunds*') &&
            $this->abuseService->hasActiveRestriction(
                $entityType, $entityId, 'refund'
            )
        ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Refund requests temporarily limited',
                'reason' => 'refund_limit_active',
            ], 403);
        }

        // ✅ Gate 3: Wallet locked?
        if (
            $request->is('api/wallet*') &&
            $this->abuseService->hasActiveRestriction(
                $entityType, $entityId, 'wallet'
            )
        ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Wallet is locked due to suspicious activity',
                'reason' => 'wallet_locked',
            ], 403);
        }

        // ✅ Proceed with request
        $response = $next($request);

        // ✅ Scan after successful dispute/refund
        if (
            $response->getStatusCode() === 201 &&
            $this->shouldScan($request)
        ) {
            app(AbuseEnforcementService::class)->scanEntity(
                entityType: $entityType,
                entityId: $entityId,
                entityRef: strtoupper(substr($entityType, 0, 1)).'-'.$entityId,
                triggerEvent: $this->getTriggerEvent($request)
            );
        }

        return $response;
    }

    private function shouldScan(Request $request): bool
    {
        return $request->isMethod('POST') && (
            $request->is('api/complaints') ||
            $request->is('api/refunds') ||
            $request->is('api/appeals')
        );
    }

    private function getTriggerEvent(Request $request): string
    {
        if ($request->is('api/refunds')) {
            return 'refund_submitted';
        }
        if ($request->is('api/complaints')) {
            return 'dispute_submitted';
        }
        if ($request->is('api/appeals')) {
            return 'appeal_submitted';
        }

        return 'unknown';
    }

    private function getEntityType($user): string
    {
        return match (true) {
            $user->hasRole('customer') => 'customer',
            $user->hasRole('rider') => 'rider',
            $user->hasRole('mart_vendor') => 'vendor',
            $user->hasRole('service_provider') => 'provider',
            default => 'user',
        };
    }
}
