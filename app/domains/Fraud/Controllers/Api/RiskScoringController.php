<?php

namespace App\Domains\Fraud\Controllers\Api;

use App\Domains\Fraud\Models\RiskEnforcement;
use App\Domains\Fraud\Models\RiskEvent;
use App\Domains\Fraud\Models\RiskScore;
use App\Domains\Fraud\Models\RiskSignalWeight;
use App\Domains\Fraud\Services\RiskScoringService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class RiskScoringController extends BaseApiController
{
    public function __construct(
        protected RiskScoringService $riskService
    ) {}

    // ✅ 1. GET Dashboard Stats
    public function dashboard()
    {
        $stats = [
            'low' => [
                'count' => RiskScore::byTier('low')->count(),
                'label' => 'LOW RISK (0-30)',
                'percentage' => $this->getPercentage('low'),
                'message' => '% of network',
            ],
            'medium' => [
                'count' => RiskScore::byTier('medium')->count(),
                'label' => 'MEDIUM RISK (31-65)',
                'message' => 'Monitoring active',
            ],
            'high' => [
                'count' => RiskScore::byTier('high')->count(),
                'label' => 'HIGH RISK (66-89)',
                'message' => 'Restricted features',
            ],
            'critical' => [
                'count' => RiskScore::byTier('critical')->count(),
                'label' => 'CRITICAL (90-100)',
                'message' => 'Pending suspension',
            ],
        ];

        $signals = RiskSignalWeight::all()->map(function ($signal) {
            return [
                'key' => $signal->signal_key,
                'label' => $signal->signal_label,
                'weight' => $signal->weight,
                'impact' => $signal->impact,
            ];
        });

        return $this->success([
            'stats' => $stats,
            'total_entities' => RiskScore::count(),
            'critical_count' => RiskScore::critical()->count(),
            'signal_weights' => $signals,
        ], 'dashboard_fetched');
    }

    // ✅ 2. GET Live Risk Feed
    public function liveRiskFeed(Request $request)
    {
        $request->validate([
            'tier' => 'nullable|in:low,medium,high,critical',
            'entity_type' => 'nullable|string',
            'search' => 'nullable|string',
        ]);

        $query = RiskScore::query()->latest('last_event_at');

        if ($request->tier) {
            $query->where('tier', $request->tier);
        }

        if ($request->entity_type) {
            $query->where('entity_type', $request->entity_type);
        }

        $entities = $query->paginate(20)->through(function ($risk) {
            // Get active enforcement
            $enforcement = RiskEnforcement::where('entity_type', $risk->entity_type)
                ->where('entity_id', $risk->entity_id)
                ->where('is_active', true)
                ->first();

            return [
                'entity_type' => $risk->entity_type,
                'entity_id' => $risk->entity_id,
                'score' => $risk->score,
                'tier' => $risk->tier,
                'reason_codes' => $risk->reason_codes,
                'enforcement' => $enforcement?->action,
                'last_event_at' => $risk->last_event_at
                    ?->diffForHumans(),
            ];
        });

        return $this->success($entities, 'live_feed_fetched');
    }

    // ✅ 3. GET Single Entity Risk Detail
    public function entityDetail(
        string $entityType,
        int $entityId
    ) {
        $riskScore = RiskScore::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->firstOrFail();

        $recentEvents = RiskEvent::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->latest()
            ->take(10)
            ->get();

        $enforcements = RiskEnforcement::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('is_active', true)
            ->get();

        return $this->success([
            'risk_score' => $riskScore,
            'recent_events' => $recentEvents,
            'enforcements' => $enforcements,
        ], 'entity_risk_detail_fetched');
    }

    // ✅ 4. POST Manual Rescore
    public function manualRescore(
        Request $request,
        string $entityType,
        int $entityId
    ) {
        $riskScore = $this->riskService->processEvent(
            entityType: $entityType,
            entityId: $entityId,
            eventType: 'manual_rescore',
            eventData: ['requested_by' => auth()->id()]
        );

        return $this->success($riskScore, 'entity_rescored');
    }

    // ✅ 5. GET Signal Weights
    public function getSignalWeights()
    {
        $weights = RiskSignalWeight::all();

        return $this->success($weights, 'signal_weights_fetched');
    }

    // ✅ 6. PUT Update Signal Weights
    public function updateSignalWeights(Request $request)
    {
        $request->validate([
            'weights' => 'required|array',
            'weights.*.id' => 'required|exists:risk_signal_weights,id',
            'weights.*.weight' => 'required|integer|min:0|max:100',
            'weights.*.impact' => 'required|in:low,medium,high',
            'weights.*.is_active' => 'required|boolean',
        ]);

        foreach ($request->weights as $w) {
            RiskSignalWeight::find($w['id'])->update([
                'weight' => $w['weight'],
                'impact' => $w['impact'],
                'is_active' => $w['is_active'],
            ]);
        }

        // Refresh cache
        $this->riskService->refreshWeights();

        return $this->success(
            RiskSignalWeight::all(),
            'signal_weights_updated'
        );
    }

    // ✅ 7. POST Submit New Event
    public function submitEvent(Request $request)
    {
        $validated = $request->validate([
            'entity_type' => 'required|in:customer,rider,vendor,provider',
            'entity_id' => 'required|integer',
            'event_type' => 'required|string',
            'event_data' => 'nullable|array',
        ]);

        $riskScore = $this->riskService->processEvent(
            entityType: $validated['entity_type'],
            entityId: $validated['entity_id'],
            eventType: $validated['event_type'],
            eventData: $validated['event_data'] ?? []
        );

        return $this->success([
            'score' => $riskScore->score,
            'tier' => $riskScore->tier,
            'reason_codes' => $riskScore->reason_codes,
        ], 'event_processed', 201);
    }

    // ✅ 8. GET Entity History
    public function entityHistory(
        string $entityType,
        int $entityId
    ) {
        $history = RiskEvent::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->latest()
            ->paginate(20);

        return $this->success($history, 'entity_history_fetched');
    }

    // ✅ 9. POST Manual Enforcement
    public function manualEnforce(
        Request $request,
        string $entityType,
        int $entityId
    ) {
        $validated = $request->validate([
            'action' => 'required|in:monitoring,restrict_features,wallet_freeze,account_suspend,flag_review',
            'reason' => 'required|string|max:500',
            'expires_at' => 'nullable|date|after:now',
        ]);

        // Deactivate existing
        RiskEnforcement::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        $enforcement = RiskEnforcement::create([
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'action' => $validated['action'],
            'trigger' => 'manual',
            'risk_score' => RiskScore::where('entity_type', $entityType)
                ->where('entity_id', $entityId)
                ->value('score') ?? 0,
            'reason' => $validated['reason'],
            'enforced_by' => auth()->id(),
            'expires_at' => $validated['expires_at'] ?? null,
            'is_active' => true,
        ]);

        return $this->success($enforcement, 'enforcement_applied', 201);
    }

    // ✅ 10. GET Critical Entities
    public function criticalEntities()
    {
        $critical = RiskScore::critical()
            ->with([])
            ->latest('score')
            ->get()
            ->map(function ($risk) {
                $enforcement = RiskEnforcement::where('entity_type', $risk->entity_type)
                    ->where('entity_id', $risk->entity_id)
                    ->where('is_active', true)
                    ->first();

                return [
                    'entity_type' => $risk->entity_type,
                    'entity_id' => $risk->entity_id,
                    'score' => $risk->score,
                    'reason_codes' => $risk->reason_codes,
                    'enforcement' => $enforcement?->action,
                    'last_event' => $risk->last_event_at?->diffForHumans(),
                ];
            });

        return $this->success([
            'count' => $critical->count(),
            'entities' => $critical,
        ], 'critical_entities_fetched');
    }

    // ✅ Helper
    private function getPercentage(string $tier): float
    {
        $total = RiskScore::count();
        if ($total === 0) {
            return 0;
        }

        $count = RiskScore::byTier($tier)->count();

        return round(($count / $total) * 100, 1);
    }
}
