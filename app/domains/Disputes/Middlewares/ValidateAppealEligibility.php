<?php

namespace App\Domains\Disputes\Middlewares;

use App\Domains\Disputes\Services\AppealService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateAppealEligibility
{
    public function __construct(
        protected AppealService $appealService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Only check on appeal submission
        if (! $request->isMethod('POST')) {
            return $next($request);
        }

        if (! auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();
        $entityType = $this->getEntityType($user);

        // ✅ Check eligibility
        $check = $this->appealService->canAppeal(
            appellantType: $entityType,
            appellantId: $user->id,
            appealType: $request->appeal_type ?? '',
            relatedId: $request->complaint_id
                        ?? $request->refund_request_id
                        ?? 0
        );

        if (! $check['can_appeal']) {
            return response()->json([
                'status' => 'error',
                'message' => $check['reason'],
                'reason' => 'appeal_not_eligible',
            ], 422);
        }

        // ✅ Pass remaining info to request
        $request->merge([
            'appellant_type' => $entityType,
            'appellant_id' => $user->id,
            'appeals_remaining' => $check['appeals_remaining'] ?? 0,
        ]);

        return $next($request);
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
