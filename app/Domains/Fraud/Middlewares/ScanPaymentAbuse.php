<?php

namespace App\Domains\Fraud\Middlewares;

use App\Domains\Fraud\Services\PaymentAbuseService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ScanPaymentAbuse
{
    public function __construct(
        protected PaymentAbuseService $abuseService
    ) {}

    // ✅ Routes to scan
    protected array $scanRoutes = [
        'api/*/wallet/topup' => 'topup',
        'api/*/wallet/withdraw' => 'withdrawal',
        'api/*/wallet/transfer' => 'transfer',
        'api/*/payouts' => 'payout',
        'api/*/cod/deposit' => 'cod',
        'api/*/refunds' => 'refund',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Check if wallet/payout frozen
        if (auth()->check()) {
            $userId = auth()->id();

            // Check wallet freeze
            $isFrozen = DB::table('risk_enforcements')
                ->where('entity_id', $userId)
                ->where('action', 'wallet_freeze')
                ->where('is_active', true)
                ->exists();

            if ($isFrozen && $this->isWalletRoute($request)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Wallet is frozen due to suspicious activity',
                    'reason' => 'wallet_frozen',
                ], 403);
            }

            // Check payout delay
            $payoutDelay = Cache::get("payout_delay:{$userId}");
            if ($payoutDelay && $request->is('api/*/payouts')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payout delayed',
                    'available_at' => $payoutDelay,
                    'reason' => 'payout_delay',
                ], 403);
            }

            // Check COD blocked
            $codBlocked = Cache::get("cod_blocked:{$userId}");
            if ($codBlocked && $request->is('api/*/cod/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'COD option blocked',
                    'reason' => 'cod_blocked',
                ], 403);
            }

            // Check dispatch suspended
            $dispatchSuspended = Cache::get("dispatch_suspended:{$userId}");
            if ($dispatchSuspended && $request->is('api/*/dispatch/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Dispatch suspended',
                    'reason' => 'dispatch_suspended',
                ], 403);
            }
        }

        // ✅ Proceed
        $response = $next($request);

        // ✅ Scan after successful transaction
        if (
            auth()->check() &&
            $response->getStatusCode() >= 200 &&
            $response->getStatusCode() < 300
        ) {
            $transactionType = $this->getTransactionType($request);

            if ($transactionType) {
                $user = auth()->user();
                $amount = (float) ($request->amount ?? 0);

                // Increment velocity counter
                $this->abuseService->incrementVelocity(
                    $this->getEntityType($user),
                    $user->id,
                    $transactionType
                );

                // Scan for abuse
                $this->abuseService->scanTransaction(
                    entityType: $this->getEntityType($user),
                    entityId: $user->id,
                    entityRef: $this->getEntityRef($user),
                    transactionType: $transactionType,
                    amount: $amount,
                    meta: [
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ]
                );
            }
        }

        return $response;
    }

    private function getTransactionType(Request $request): ?string
    {
        foreach ($this->scanRoutes as $pattern => $type) {
            if ($request->is($pattern)) {
                return $type;
            }
        }

        return null;
    }

    private function isWalletRoute(Request $request): bool
    {
        return $request->is('api/*/wallet/*');
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
