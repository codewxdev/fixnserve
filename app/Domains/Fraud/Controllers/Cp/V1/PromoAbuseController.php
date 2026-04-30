<?php

namespace App\Domains\Fraud\Controllers\Cp\V1;

use App\Domains\Fraud\Models\PromoAbuseDetection;
use App\Domains\Fraud\Models\PromoAbuseRule;
use App\Domains\Fraud\Models\ReferralGraph;
use App\Domains\Fraud\Services\PromoAbuseService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PromoAbuseController extends BaseApiController
{
    public function __construct(
        protected PromoAbuseService $promoService
    ) {}

    // 1. Dashboard
    public function dashboard()
    {
        return $this->success(
            $this->promoService->getDashboardStats(),
            'promo_abuse_dashboard_fetched'
        );
    }

    // 2. Live Incentive Abuse Monitor
    public function liveMonitor(Request $request)
    {
        $request->validate([
            'abuse_pattern' => 'nullable|string',
            'status' => 'nullable|in:detected,actioned,false_positive,resolved',
            'filter' => 'nullable|in:all,blocked',
        ]);

        $detections = PromoAbuseDetection::query()
            ->when($request->abuse_pattern, fn ($q) => $q->where('abuse_pattern', $request->abuse_pattern))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->filter === 'blocked', fn ($q) => $q->active())
            ->latest()
            ->paginate(20);

        return $this->success($detections, 'live_monitor_fetched');
    }

    // 3. Referral Graph Analysis
    public function referralGraph(Request $request)
    {
        $suspicious = ReferralGraph::suspicious()
            ->with(['referrer:id,name,email', 'referee:id,name,email'])
            ->latest()
            ->paginate(20);

        $stats = [
            'total_referrals' => ReferralGraph::count(),
            'suspicious' => ReferralGraph::suspicious()->count(),
            'invalidated' => ReferralGraph::where('status', 'invalidated')->count(),
            'same_device_pairs' => ReferralGraph::where('same_device', true)->count(),
            'same_ip_pairs' => ReferralGraph::where('same_ip', true)->count(),
        ];

        return $this->success([
            'stats' => $stats,
            'suspicious' => $suspicious,
        ], 'referral_graph_fetched');
    }

    // 4. Get Promo Rules
    public function getPromoRules()
    {
        $rules = PromoAbuseRule::active()->get();

        return $this->success($rules, 'promo_rules_fetched');
    }

    // 5. Configure Promo Rules
    public function configurePromoRules(Request $request)
    {
        $request->validate([
            'rules' => 'required|array',
            'rules.*.id' => 'required|exists:promo_abuse_rules,id',
            'rules.*.action' => 'required|in:block,invalidate,reject',
            'rules.*.is_active' => 'required|boolean',
            'rules.*.config' => 'nullable|array',
        ]);

        foreach ($request->rules as $rule) {
            PromoAbuseRule::find($rule['id'])->update([
                'action' => $rule['action'],
                'is_active' => $rule['is_active'],
                'config' => $rule['config'] ?? null,
            ]);
        }

        return $this->success(
            PromoAbuseRule::all(),
            'promo_rules_updated'
        );
    }

    // 6. Invalidate Promo
    public function invalidatePromo(PromoAbuseDetection $detection)
    {
        $this->promoService->applySystemAction($detection, $detection->promo_amount);

        return $this->success($detection->fresh(), 'promo_invalidated');
    }

    //  7. Reward Clawback
    public function rewardClawback(Request $request, PromoAbuseDetection $detection)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $detection->update(['system_action' => 'reward_clawback']);
        $this->promoService->applySystemAction($detection, $request->amount);

        return $this->success($detection->fresh(), 'reward_clawback_applied');
    }

    //  8. Account Restriction
    public function restrictAccount(PromoAbuseDetection $detection)
    {
        $detection->update(['system_action' => 'account_restricted']);
        $this->promoService->applySystemAction($detection, 0);

        return $this->success($detection->fresh(), 'account_restricted');
    }

    // 9. Mark False Positive
    public function markFalsePositive(Request $request, PromoAbuseDetection $detection)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $detection->update([
            'status' => 'false_positive',
            'meta' => array_merge($detection->meta ?? [], [
                'fp_reason' => $request->reason,
                'marked_by' => auth()->id(),
                'marked_at' => now()->toDateTimeString(),
            ]),
        ]);

        return $this->success($detection, 'marked_false_positive');
    }

    // 10. Resolve Detection
    public function resolve(PromoAbuseDetection $detection)
    {
        $detection->update(['status' => 'resolved']);

        return $this->success($detection, 'detection_resolved');
    }

    // 11. Export Abuse Logs
    public function exportLogs()
    {
        $logs = PromoAbuseDetection::latest()->get();
        $filename = 'promo_abuse_log_'.now()->format('Y_m_d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Time', 'Entity', 'Promo Code',
                'Abuse Pattern', 'Confidence',
                'System Action', 'Amount', 'Status',
            ]);
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->entity_ref,
                    $log->promo_code,
                    $log->abuse_pattern,
                    $log->confidence_score.'%',
                    $log->system_action,
                    $log->promo_amount,
                    $log->status,
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
