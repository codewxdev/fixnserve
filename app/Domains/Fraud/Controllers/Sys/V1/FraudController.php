<?php

namespace App\Domains\Fraud\Controllers\Sys\V1;

use App\Domains\Fraud\Models\IpBlock;
use App\Domains\Fraud\Models\PaymentAbuseDetection;
use App\Domains\Fraud\Services\PaymentAbuseService;
use App\Domains\Fraud\Services\RiskScoringService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FraudController extends BaseApiController
{
    public function __construct(
        protected RiskScoringService $riskService,
        protected PaymentAbuseService $abuseService
    ) {}

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

    //  POST Submit New Event
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
    // 5. PURGE ALL BOT SESSIONS

    public function purgeBotSessions()
    {
        $count = DB::table('user_sessions')
            ->where('risk_score', '>=', 90)
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now()]);

        return $this->success([
            'purged_count' => $count,
            'message' => "{$count} bot sessions terminated",
        ], 'bot_sessions_purged');
    }

    // 10. GET IP BLOCKS

    public function getIpBlocks(Request $request)
    {
        $request->validate([
            'type' => 'nullable|in:vpn,proxy,tor,datacenter,manual,bot',
        ]);

        $blocks = IpBlock::with('blockedBy:id,name')
            ->active()
            ->when($request->type, fn ($q) => $q->byType($request->type))
            ->latest()
            ->paginate(20);

        return $this->success($blocks, 'ip_blocks_fetched');
    }

    // 11. BLOCK IP

    public function blockIp(Request $request)
    {
        $validated = $request->validate([
            'ip_address' => 'required|ip',
            'type' => 'required|in:vpn,proxy,tor,datacenter,manual,bot',
            'reason' => 'nullable|string|max:500',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $block = IpBlock::updateOrCreate(
            ['ip_address' => $validated['ip_address']],
            [
                'type' => $validated['type'],
                'reason' => $validated['reason'] ?? 'Manual block',
                'blocked_by' => auth()->id(),
                'expires_at' => $validated['expires_at'] ?? null,
                'is_active' => true,
                'block_count' => DB::raw('block_count + 1'),
            ]
        );

        return $this->success($block, 'ip_blocked', 201);
    }

    // 12. UNBLOCK IP

    public function unblockIp(string $ip)
    {
        $block = IpBlock::where('ip_address', $ip)->first();

        if (! $block) {
            return $this->error('ip_not_found', 404);
        }

        $block->update(['is_active' => false]);

        return $this->success(null, 'ip_unblocked');
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
}
