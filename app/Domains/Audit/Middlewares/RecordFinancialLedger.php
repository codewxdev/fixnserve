<?php

namespace App\Domains\Audit\Middlewares;

use App\Domains\Audit\Services\FinancialAuditService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RecordFinancialLedger
{
    public function __construct(
        protected FinancialAuditService $auditService
    ) {}

    // ✅ Routes that trigger ledger entries
    protected array $triggerRoutes = [
        'api/wallet/topup' => 'wallet_credit',
        'api/wallet/withdraw' => 'wallet_debit',
        'api/payouts' => 'payout',
        'api/refunds' => 'refund',
        'api/cod/deposit' => 'cod_deposit',
        'api/orders/*/complete' => 'commission',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // ✅ Post to ledger on successful transactions
        if (
            auth()->check() &&
            in_array($request->method(), ['POST']) &&
            $response->getStatusCode() === 201
        ) {
            $entryType = $this->getEntryType($request);

            if ($entryType) {
                $this->postToLedger($request, $response, $entryType);
            }
        }

        return $response;
    }

    private function postToLedger(
        Request $request,
        Response $response,
        string $entryType
    ): void {

        try {
            $user = auth()->user();
            $resData = json_decode($response->getContent(), true);
            $data = $resData['data'] ?? [];

            $this->auditService->postEntry(
                entityType: $this->getEntityType($user),
                entityId: $user->id,
                entityRef: $this->getEntityRef($user),
                entryType: $entryType,
                amount: (float) ($request->amount ?? $data['amount'] ?? 0),
                sourceModule: $this->getSourceModule($request),
                sourceId: $data['id'] ?? null,
                sourceRef: $data['refund_id'] ?? $data['order_ref'] ?? null,
                orderId: $request->order_id ?? null,
                orderRef: $request->order_ref ?? null,
                meta: [
                    'transaction_ref' => $data['id'] ?? null,
                    'description' => $this->getDescription($entryType, $request),
                    'initiated_by' => 'user',
                ]
            );
        } catch (\Exception $e) {
            Log::error('Ledger post failed: '.$e->getMessage());
        }
    }

    private function getEntryType(Request $request): ?string
    {
        foreach ($this->triggerRoutes as $pattern => $type) {
            if ($request->is($pattern)) {
                return $type;
            }
        }

        return null;
    }

    private function getSourceModule(Request $request): string
    {
        if ($request->is('api/refunds*')) {
            return 'refund';
        }
        if ($request->is('api/payouts*')) {
            return 'payout';
        }
        if ($request->is('api/wallet*')) {
            return 'wallet';
        }
        if ($request->is('api/orders*')) {
            return 'order';
        }
        if ($request->is('api/cod*')) {
            return 'cod';
        }

        return 'system';
    }

    private function getDescription(string $type, Request $request): string
    {
        return match ($type) {
            'wallet_credit' => 'Wallet top-up',
            'wallet_debit' => 'Wallet withdrawal',
            'payout' => 'Payout processed',
            'refund' => 'Refund credited',
            'cod_deposit' => 'COD deposit',
            'commission' => "Commission: {$request->order_ref}",
            default => ucfirst(str_replace('_', ' ', $type)),
        };
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
