<?php

namespace App\Domains\Disputes\Middlewares;

use App\Domains\Disputes\Services\SlaEscalationService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StartSlaTracking
{
    public function __construct(
        protected SlaEscalationService $slaService
    ) {}

    protected array $trackRoutes = [
        'api/complaints' => ['type' => 'complaint', 'level' => 'standard'],
        'api/appeals' => ['type' => 'appeal',    'level' => 'priority'],
        'api/refunds' => ['type' => 'refund',    'level' => 'standard'],
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // ✅ Start tracking on successful POST
        if (
            $request->isMethod('POST') &&
            $response->getStatusCode() === 201
        ) {
            $config = $this->getTrackConfig($request);

            if ($config) {
                $responseData = json_decode(
                    $response->getContent(), true
                );

                $id = $responseData['data']['id'] ?? null;
                $caseRef = $responseData['data']['case_id']
                        ?? $responseData['data']['appeal_id']
                        ?? $responseData['data']['refund_id']
                        ?? null;

                if ($id && $caseRef) {
                    $this->slaService->createTracking(
                        trackableType: $config['type'],
                        trackableId: $id,
                        caseRef: $caseRef,
                        slaLevel: $this->determineSlaLevel($request, $responseData),
                    );
                }
            }
        }

        // ✅ Mark resolved on status update
        if (
            in_array($request->method(), ['PATCH', 'PUT']) &&
            in_array($request->resolved_status ?? '', ['resolved', 'closed', 'completed'])
        ) {
            $config = $this->getTrackConfig($request);
            if ($config) {
                $id = $request->route('complaint')
                  ?? $request->route('appeal')
                  ?? $request->route('refund');

                if ($id) {
                    $this->slaService->markResolved(
                        $config['type'],
                        is_object($id) ? $id->id : $id
                    );
                }
            }
        }

        return $response;
    }

    private function getTrackConfig(Request $request): ?array
    {
        foreach ($this->trackRoutes as $pattern => $config) {
            if ($request->is($pattern)) {
                return $config;
            }
        }

        return null;
    }

    private function determineSlaLevel(
        Request $request,
        array $responseData
    ): string {

        // Legal if fraud allegation
        $classification = $responseData['data']['classification'] ?? '';
        if ($classification === 'fraud_allegations') {
            return 'legal';
        }

        // Priority if appeal
        if (isset($responseData['data']['appeal_id'])) {
            return 'priority';
        }

        // Standard default
        return 'standard';
    }
}
