<?php

namespace App\Domains\Disputes\Middlewares;

use App\Domains\Disputes\Models\Complaint;
use App\Domains\Disputes\Services\ComplaintClassificationService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AutoGenerateComplaint
{
    public function __construct(
        protected ComplaintClassificationService $classifier
    ) {}

    // ✅ Routes that auto-generate complaints
    protected array $triggerRoutes = [
        'api/*/orders/*/dispute' => 'delivery_issues',
        'api/*/payments/*/dispute' => 'payment_issues',
        'api/*/refunds' => 'payment_issues',
        'api/*/reports/misconduct' => 'behavior_misconduct',
    ];

    // ✅ System anomaly triggers (from risk/fraud modules)
    protected array $systemTriggers = [
        'fraud_allegations',
        'payment_failed',
        'unrecognized_charge',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // ✅ Auto-generate on successful dispute/report submission
        if (
            auth()->check() &&
            $response->getStatusCode() >= 200 &&
            $response->getStatusCode() < 300
        ) {
            $autoClassification = $this->getAutoClassification($request);

            if ($autoClassification && $request->has('dispute_reason')) {
                $this->createAutoComplaint($request, $autoClassification);
            }
        }

        return $response;
    }

    private function getAutoClassification(Request $request): ?string
    {
        foreach ($this->triggerRoutes as $pattern => $classification) {
            if ($request->is($pattern)) {
                return $classification;
            }
        }

        return null;
    }

    private function createAutoComplaint(
        Request $request,
        string $defaultClassification
    ): void {

        try {
            $user = auth()->user();
            $reason = $request->dispute_reason ?? $request->reason ?? 'Auto-generated complaint';

            // ✅ Classify
            $classified = app(ComplaintClassificationService::class)
                ->classify($reason, 'customer_app');

            Complaint::create([
                'case_id' => Complaint::generateCaseId(),
                'source' => 'customer_app',
                'reporter_type' => $this->getEntityType($user),
                'reporter_id' => $user->id,
                'reporter_ref' => $this->getEntityRef($user),
                'related_entity_id' => $request->route('order')
                                      ?? $request->route('payment')
                                      ?? null,
                'related_entity_type' => $this->getRelatedEntityType($request),
                'classification' => $classified['classification'],
                'is_auto_classified' => true,
                'dispute_reason' => $reason,
                'severity' => $classified['severity'],
                'sla_hours' => $classified['sla_hours'],
                'sla_deadline' => $classified['sla_deadline'],
                'status' => 'unassigned',
                'classification_meta' => $classified['classification_meta'],
            ]);

        } catch (\Exception $e) {
            Log::error('Auto complaint creation failed: '.$e->getMessage());
        }
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

    private function getRelatedEntityType(Request $request): ?string
    {
        if ($request->route('order')) {
            return 'order';
        }
        if ($request->route('payment')) {
            return 'payment';
        }

        return null;
    }
}
