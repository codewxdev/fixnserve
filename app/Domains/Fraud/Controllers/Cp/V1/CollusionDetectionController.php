<?php

namespace App\Domains\Fraud\Controllers\Cp\V1;

use App\Domains\Fraud\Models\CollusionInvestigation;
use App\Domains\Fraud\Models\CollusionRing;
use App\Domains\Fraud\Models\InteractionGraph;
use App\Domains\Fraud\Services\CollusionDetectionService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class CollusionDetectionController extends BaseApiController
{
    public function __construct(
        protected CollusionDetectionService $collusionService
    ) {}

    // 1. Dashboard
    public function dashboard()
    {
        return $this->success(
            $this->collusionService->getDashboardStats(),
            'collusion_dashboard_fetched'
        );
    }

    // 2. Live Detected Rings
    public function liveRings(Request $request)
    {
        $request->validate([
            'ring_type' => 'nullable|string',
            'status' => 'nullable|in:detected,investigating,confirmed,false_positive,resolved',
        ]);

        $rings = CollusionRing::with('actors')
            ->when($request->ring_type, fn ($q) => $q->where('ring_type', $request->ring_type))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        return $this->success($rings, 'live_rings_fetched');
    }

    // 3. Ring Detail
    public function ringDetail(CollusionRing $ring)
    {
        return $this->success(
            $ring->load(['actors', 'investigation.openedBy', 'investigation.assignedTo']),
            'ring_detail_fetched'
        );
    }

    // 4. Interaction Graph
    public function interactionGraph(Request $request)
    {
        $suspicious = InteractionGraph::suspicious()
            ->latest()
            ->paginate(20);

        $stats = [
            'total_pairs' => InteractionGraph::count(),
            'suspicious_pairs' => InteractionGraph::suspicious()->count(),
            'shared_gps' => InteractionGraph::where('shared_gps', true)->count(),
            'no_chat' => InteractionGraph::where('no_chat_history', true)->count(),
        ];

        return $this->success([
            'stats' => $stats,
            'suspicious' => $suspicious,
        ], 'interaction_graph_fetched');
    }

    // 5. Shadow Ban
    public function shadowBan(Request $request, CollusionRing $ring)
    {
        $ring->update(['system_enforcement' => 'shadow_ban']);
        $this->collusionService->applyEnforcement($ring->load('actors'));

        return $this->success($ring, 'shadow_ban_applied');
    }

    // 6. Suppress Ranking
    public function suppressRanking(CollusionRing $ring)
    {
        $ring->update(['system_enforcement' => 'ranking_suppressed']);
        $this->collusionService->applyEnforcement($ring->load('actors'));

        return $this->success($ring, 'ranking_suppressed');
    }

    // 7. Open Investigation
    public function openInvestigation(Request $request, CollusionRing $ring)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $investigation = CollusionInvestigation::updateOrCreate(
            ['ring_id' => $ring->id],
            [
                'opened_by' => auth()->id(),
                'notes' => $request->notes,
                'assigned_to' => $request->assigned_to,
                'status' => 'open',
            ]
        );

        $ring->update(['status' => 'investigating']);

        return $this->success($investigation, 'investigation_opened', 201);
    }

    // 8. Quarantine Reviews
    public function quarantineReviews(CollusionRing $ring)
    {
        $ring->update(['system_enforcement' => 'reviews_quarantined']);
        $this->collusionService->applyEnforcement($ring->load('actors'));

        return $this->success($ring, 'reviews_quarantined');
    }

    //  10. Bulk Ban
    public function bulkBan(Request $request)
    {
        $request->validate([
            'ring_ids' => 'required|array',
            'ring_ids.*' => 'exists:collusion_rings,id',
        ]);

        foreach ($request->ring_ids as $ringId) {
            $ring = CollusionRing::find($ringId);
            $ring->update(['system_enforcement' => 'bulk_ban']);
            $this->collusionService->applyEnforcement($ring->load('actors'));
        }

        return $this->success([
            'banned_rings' => count($request->ring_ids),
        ], 'bulk_ban_applied');
    }

    //  11. Mark False Positive
    public function markFalsePositive(Request $request, CollusionRing $ring)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $ring->update([
            'status' => 'false_positive',
            'meta' => array_merge($ring->meta ?? [], [
                'fp_reason' => $request->reason,
                'marked_by' => auth()->id(),
                'marked_at' => now()->toDateTimeString(),
            ]),
        ]);

        // Lift enforcements
        foreach ($ring->actors as $actor) {
            Cache::forget("shadow_banned:{$actor->entity_type}:{$actor->entity_id}");
            Cache::forget("ranking_suppressed:{$actor->entity_type}:{$actor->entity_id}");
            Cache::forget("payout_delay:{$actor->entity_id}");
        }

        return $this->success($ring, 'marked_false_positive');
    }

    // 12. Resolve Ring
    public function resolve(CollusionRing $ring)
    {
        $ring->update(['status' => 'resolved', 'is_active' => false]);

        if ($ring->investigation) {
            $ring->investigation->update([
                'status' => 'closed',
                'closed_at' => now(),
            ]);
        }

        return $this->success($ring, 'ring_resolved');
    }

    // 13. Export Logs
    public function exportLogs()
    {
        $rings = CollusionRing::with('actors')->latest()->get();
        $filename = 'collusion_log_'.now()->format('Y_m_d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($rings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Ring ID', 'Type', 'Actors', 'Confidence',
                'Fraud Pattern', 'Enforcement', 'Status', 'Date',
            ]);
            foreach ($rings as $ring) {
                fputcsv($file, [
                    $ring->ring_id,
                    $ring->ring_type,
                    $ring->actors_count,
                    $ring->confidence_score.'%',
                    $ring->fraud_pattern_detail,
                    $ring->system_enforcement,
                    $ring->status,
                    $ring->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    //  9. Freeze Payouts
    public function freezePayouts(CollusionRing $ring)
    {
        $ring->update(['system_enforcement' => 'payouts_frozen']);
        $this->collusionService->applyEnforcement($ring->load('actors'));

        return $this->success($ring, 'payouts_frozen');
    }
}
