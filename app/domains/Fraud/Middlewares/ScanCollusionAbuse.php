<?php

namespace App\Domains\Fraud\Middlewares;

use App\Domains\Fraud\Services\CollusionDetectionService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ScanCollusionAbuse
{
    public function __construct(
        protected CollusionDetectionService $collusionService
    ) {}

    // ✅ Routes to monitor
    protected array $monitorRoutes = [
        'api/*/orders/*/complete' => 'job_completion',
        'api/*/deliveries/*/complete' => 'delivery_completion',
        'api/*/reviews' => 'review',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return $next($request);
        }

        $userId = auth()->id();

        // ✅ Gate 1: Shadow banned?
        $entityType = $this->getEntityType(auth()->user());
        if (Cache::get("shadow_banned:{$entityType}:{$userId}")) {
            // Shadow ban = user thinks it works but silently blocked
            return response()->json([
                'status' => 'success',
                'message' => 'Action completed',
                // Silently does nothing ← shadow ban behavior
            ]);
        }

        // ✅ Gate 2: Ranking suppressed check (only affects visibility)
        $response = $next($request);

        // ✅ Scan after completion
        if (
            $response->getStatusCode() >= 200 &&
            $response->getStatusCode() < 300
        ) {
            $interactionType = $this->getInteractionType($request);

            if ($interactionType && $request->has(['provider_id', 'rider_id', 'vendor_id'])) {
                $this->scanInteraction($request, $userId, $interactionType);
            }
        }

        return $response;
    }

    private function scanInteraction(
        Request $request,
        int $userId,
        string $interactionType
    ): void {

        $user = auth()->user();
        $entityType = $this->getEntityType($user);
        $entityRef = $this->getEntityRef($user);

        // Determine partner
        $partnerId = $request->provider_id ?? $request->rider_id ?? $request->vendor_id;
        $partnerType = $request->provider_id
            ? 'provider'
            : ($request->rider_id ? 'rider' : 'vendor');
        $partnerRef = strtoupper(substr($partnerType, 0, 1)).'-'.$partnerId;

        $this->collusionService->scanInteraction(
            actorAType: $entityType,
            actorAId: $userId,
            actorARef: $entityRef,
            actorBType: $partnerType,
            actorBId: $partnerId,
            actorBRef: $partnerRef,
            interactionType: $interactionType,
            meta: [
                'ip' => $request->ip(),
                'shared_gps' => $this->checkSharedGps($request),
                'no_chat' => ! $this->hasChatHistory($userId, $partnerId),
                'job_id' => $request->route('order'),
            ]
        );
    }

    private function checkSharedGps(Request $request): bool
    {
        $userLat = $request->header('X-Latitude');
        $partnerLat = $request->partner_lat ?? null;

        if (! $userLat || ! $partnerLat) {
            return false;
        }

        return abs((float) $userLat - (float) $partnerLat) < 0.001;
    }

    private function hasChatHistory(int $userId, int $partnerId): bool
    {
        return DB::table('messages')
            ->where('sender_id', $userId)
            ->where('receiver_id', $partnerId)
            ->where('created_at', '>=', now()->subHours(4))
            ->exists();
    }

    private function getInteractionType(Request $request): ?string
    {
        foreach ($this->monitorRoutes as $pattern => $type) {
            if ($request->is($pattern)) {
                return $type;
            }
        }

        return null;
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

    private function getEntityRef($user): string
    {
        $prefix = match (true) {
            $user->hasRole('customer') => 'C',
            $user->hasRole('rider') => 'R',
            $user->hasRole('mart_vendor') => 'V',
            $user->hasRole('service_provider') => 'P',
            default => 'U',
        };

        return "{$prefix}-{$user->id}";
    }
}
