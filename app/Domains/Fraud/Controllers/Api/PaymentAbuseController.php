<?php

namespace App\Domains\Fraud\Controllers\Api;

use App\Domains\Fraud\Models\PaymentAbuseDetection;
use App\Domains\Fraud\Models\PaymentThreatPattern;
use App\Domains\Fraud\Models\PaymentVelocityLimit;
use App\Domains\Fraud\Services\PaymentAbuseService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;

class PaymentAbuseController extends BaseApiController
{
    public function __construct(
        protected PaymentAbuseService $abuseService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Helper: Not Found Checker (uses your notFound())
    |--------------------------------------------------------------------------
    */
    private function checkNotFound($data, $message)
    {
        if (
            ! $data ||
            (is_array($data) && empty($data)) ||
            ($data instanceof Collection && $data->isEmpty()) ||
            ($data instanceof AbstractPaginator && $data->isEmpty())
        ) {
            return $this->notFound($message);
        }

        return null;
    }

    // ✅ 1. Dashboard
    public function dashboard()
    {
        $data = $this->abuseService->getDashboardStats();

        if ($response = $this->checkNotFound($data, 'dashboard_data_not_found')) {
            return $response;
        }

        return $this->success($data, 'payment_abuse_dashboard_fetched');
    }

    // ✅ 2. Transaction Risk Feed
    public function transactionFeed(Request $request)
    {
        $request->validate([
            'severity' => 'nullable|in:low,medium,high,critical',
            'abuse_pattern' => 'nullable|string',
            'status' => 'nullable|in:detected,under_review,confirmed,false_positive,resolved',
        ]);

        $detections = PaymentAbuseDetection::query()
            ->when($request->severity, fn ($q) => $q->where('severity', $request->severity))
            ->when($request->abuse_pattern, fn ($q) => $q->where('abuse_pattern', $request->abuse_pattern))
            ->when($request->status, fn ($q) => $q->where('status', $request->status), fn ($q) => $q->active())
            ->latest()
            ->paginate(20);

        if ($response = $this->checkNotFound($detections, 'transaction_not_found')) {
            return $response;
        }

        return $this->success($detections, 'transaction_feed_fetched');
    }

    // ✅ 3. Get Active Threat Patterns
    public function threatPatterns()
    {
        $patterns = PaymentThreatPattern::active()->get();

        if ($response = $this->checkNotFound($patterns, 'threat_patterns_not_found')) {
            return $response;
        }

        return $this->success($patterns, 'threat_patterns_fetched');
    }

    // ✅ 4. Get Velocity Limits
    public function getVelocityLimits()
    {
        $limits = PaymentVelocityLimit::all();

        if ($response = $this->checkNotFound($limits, 'velocity_limits_not_found')) {
            return $response;
        }

        return $this->success($limits, 'velocity_limits_fetched');
    }

    // ✅ 5. Update Velocity Limits
    public function updateVelocityLimits(Request $request)
    {
        $request->validate([
            'limits' => 'required|array',
            'limits.*.id' => 'required|exists:payment_velocity_limits,id',
            'limits.*.max_count' => 'required|integer|min:1',
            'limits.*.max_amount' => 'nullable|numeric|min:0',
            'limits.*.is_active' => 'required|boolean',
        ]);

        foreach ($request->limits as $limit) {
            PaymentVelocityLimit::find($limit['id'])->update([
                'max_count' => $limit['max_count'],
                'max_amount' => $limit['max_amount'] ?? null,
                'is_active' => $limit['is_active'],
            ]);
        }

        $limits = PaymentVelocityLimit::all();

        if ($response = $this->checkNotFound($limits, 'velocity_limits_not_found')) {
            return $response;
        }

        return $this->success($limits, 'velocity_limits_updated');
    }

    // ✅ 6. Freeze Wallet
    public function freezeWallet($id)
    {
        $detection = PaymentAbuseDetection::find($id);

        if ($response = $this->checkNotFound($detection, 'detection_not_found')) {
            return $response;
        }

        $this->abuseService->freezeWallet($detection);

        $detection->update([
            'auto_action' => 'wallet_freeze',
            'status' => 'confirmed',
        ]);

        return $this->success($detection, 'wallet_frozen');
    }

    // ✅ 7. Delay Payout
    public function delayPayout($id)
    {
        $detection = PaymentAbuseDetection::find($id);

        if ($response = $this->checkNotFound($detection, 'detection_not_found')) {
            return $response;
        }

        $this->abuseService->delayPayout($detection);

        $detection->update([
            'auto_action' => 'payout_delay',
            'status' => 'confirmed',
        ]);

        return $this->success($detection, 'payout_delayed');
    }

    // ✅ 8. Manual Review Trigger
    public function manualReview($id)
    {
        $detection = PaymentAbuseDetection::find($id);

        if ($response = $this->checkNotFound($detection, 'detection_not_found')) {
            return $response;
        }

        $this->abuseService->triggerManualReview($detection);

        return $this->success($detection->fresh(), 'manual_review_triggered');
    }

    // ✅ 9. Suspend Dispatch
    public function suspendDispatch($id)
    {
        $detection = PaymentAbuseDetection::find($id);

        if ($response = $this->checkNotFound($detection, 'detection_not_found')) {
            return $response;
        }

        $this->abuseService->suspendDispatch($detection);

        $detection->update([
            'auto_action' => 'suspend_dispatch',
            'status' => 'confirmed',
        ]);

        return $this->success($detection, 'dispatch_suspended');
    }

    // ✅ 10. Mark False Positive
    public function markFalsePositive($id)
    {
        $detection = PaymentAbuseDetection::find($id);

        if ($response = $this->checkNotFound($detection, 'detection_not_found')) {
            return $response;
        }

        $detection->update(['status' => 'false_positive']);

        return $this->success($detection, 'marked_false_positive');
    }

    // ✅ 11. Resolve Detection
    public function resolve($id)
    {
        $detection = PaymentAbuseDetection::find($id);

        if ($response = $this->checkNotFound($detection, 'detection_not_found')) {
            return $response;
        }

        $detection->update(['status' => 'resolved']);

        return $this->success($detection, 'detection_resolved');
    }

    // ✅ 12. Export Abuse Logs
    public function exportLogs()
    {
        $logs = PaymentAbuseDetection::latest()->get();

        if ($response = $this->checkNotFound($logs, 'logs_not_found')) {
            return $response;
        }

        $filename = 'payment_abuse_log_'.now()->format('Y_m_d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Time', 'Entity', 'Type', 'Amount',
                'Abuse Pattern', 'Confidence', 'Severity',
                'Auto Action', 'Status',
            ]);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->entity_ref,
                    $log->transaction_type,
                    $log->amount,
                    $log->abuse_pattern,
                    $log->confidence_score.'%',
                    $log->severity,
                    $log->auto_action,
                    $log->status,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
