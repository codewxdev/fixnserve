<?php

namespace App\Domains\Fraud\Middlewares;

use App\Domains\Fraud\Services\RiskScoringService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackRiskEvent
{
    public function __construct(
        protected RiskScoringService $riskService
    ) {}

    // ✅ Define which routes map to which events
    protected array $routeEventMap = [

        // ✅ Payment Events
        'api/*/payments' => 'payment_initiated',
        'api/*/payments/*/failed' => 'payment_failed',
        'api/*/payments/*/refund' => 'refund_requested',

        // ✅ Order Events
        'api/*/orders' => 'order_placed',
        'api/*/orders/*/cancel' => 'order_cancelled',
        'api/*/orders/*/dispute' => 'dispute_raised',

        // ✅ Auth Events
        'api/auth/login' => 'login_attempt',
        'api/auth/logout' => 'logout',

        // ✅ Wallet Events
        'api/*/wallet/withdraw' => 'wallet_withdrawal',
        'api/*/wallet/transfer' => 'wallet_transfer',

        // ✅ Profile Events
        'api/*/profile/update' => 'profile_updated',
        'api/*/kyc/submit' => 'kyc_submitted',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Process request first
        $response = $next($request);

        // ✅ Only track if user is logged in
        if (! auth()->check()) {
            return $response;
        }

        // ✅ Only track POST/PUT/PATCH methods
        if (! in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return $response;
        }

        // ✅ Get event type for this route
        $eventType = $this->getEventType($request);
        if (! $eventType) {
            return $response;
        }

        // ✅ Get entity info
        $entityInfo = $this->getEntityInfo($request);

        // ✅ Collect event data
        $eventData = $this->collectEventData(
            $request,
            $response,
            $eventType
        );

        // ✅ Create risk event
        $this->riskService->processEvent(
            entityType: $entityInfo['type'],
            entityId: $entityInfo['id'],
            eventType: $eventType,
            eventData: $eventData
        );

        return $response;
    }

    // ✅ Match route to event
    private function getEventType(Request $request): ?string
    {
        foreach ($this->routeEventMap as $pattern => $eventType) {
            if ($request->is($pattern)) {
                return $eventType;
            }
        }

        return null;
    }

    // ✅ Get entity type and id from auth user
    private function getEntityInfo(Request $request): array
    {
        $user = auth()->user();

        // Determine entity type from user role
        $entityType = match (true) {
            $user->hasRole('customer') => 'customer',
            $user->hasRole('rider') => 'rider',
            $user->hasRole('mart_vendor') => 'vendor',
            $user->hasRole('service_provider') => 'provider',
            $user->hasRole('consultant') => 'consultant',
            default => 'user',
        };

        return [
            'type' => $entityType,
            'id' => $user->id,
        ];
    }

    // ✅ Collect relevant event data
    private function collectEventData(
        Request $request,
        Response $response,
        string $eventType
    ): array {

        $data = [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_id' => $request->header('X-Device-ID'),
            'response_code' => $response->getStatusCode(),
            'timestamp' => now()->toDateTimeString(),
        ];

        // ✅ Add event specific data
        return match ($eventType) {

            'payment_failed', 'payment_initiated' => array_merge($data, [
                'amount' => $request->amount,
                'method' => $request->payment_method,
                'currency' => $request->currency,
            ]),

            'order_placed', 'order_cancelled' => array_merge($data, [
                'order_id' => $request->route('order'),
                'amount' => $request->total_amount,
            ]),

            'dispute_raised' => array_merge($data, [
                'order_id' => $request->route('order'),
                'reason' => $request->reason,
            ]),

            'login_attempt' => array_merge($data, [
                'success' => $response->getStatusCode() === 200,
                'email' => $request->login,
            ]),

            'wallet_withdrawal', 'wallet_transfer' => array_merge($data, [
                'amount' => $request->amount,
                'to' => $request->to_user_id,
            ]),

            default => $data,
        };
    }
}
