<?php

namespace App\Domains\Disputes\Services;

use App\Domains\Disputes\Models\CaseEvidence;
use App\Domains\Disputes\Models\EvidenceShare;
use App\Domains\Disputes\Models\EvidenceTimeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EvidenceService
{
    // ═══════════════════════════════════════
    // UPLOAD EVIDENCE
    // ═══════════════════════════════════════

    public function upload(array $data, Request $request): CaseEvidence
    {
        $checksum = null;
        $filePath = null;
        $fileUrl = null;

        // ✅ Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store("evidence/{$data['case_type']}/{$data['case_id']}");
            $fileUrl = Storage::url($filePath);
            $checksum = hash_file('sha256', $file->getRealPath());
        }

        $evidence = CaseEvidence::create([
            'evidence_id' => CaseEvidence::generateId(),
            'case_type' => $data['case_type'],
            'case_id' => $data['case_id'],
            'case_ref' => $data['case_ref'],
            'evidence_type' => $data['evidence_type'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'file_path' => $filePath,
            'file_url' => $fileUrl,
            'content' => $data['content'] ?? null,
            'checksum' => $checksum,
            'event_timestamp' => $data['event_timestamp'] ?? now(),
            'linked_order_id' => $data['linked_order_id'] ?? null,
            'linked_user_id' => $data['linked_user_id'] ?? null,
            'linked_wallet_tx_id' => $data['linked_wallet_tx_id'] ?? null,
            'uploaded_by' => auth()->id(),
        ]);

        // ✅ Add to timeline
        $this->addToTimeline($evidence);

        Log::info("📁 Evidence uploaded: {$evidence->evidence_id}");

        return $evidence;
    }

    // ═══════════════════════════════════════
    // BUILD TIMELINE
    // ═══════════════════════════════════════

    public function buildTimeline(string $caseType, int $caseId): array
    {
        // ✅ Get all evidence
        $evidences = CaseEvidence::forCase($caseType, $caseId)
            ->orderBy('event_timestamp')
            ->get();

        // ✅ Get related order events
        $orderEvents = $this->getOrderEvents($caseId, $caseType);

        // ✅ Get wallet transactions
        $walletEvents = $this->getWalletEvents($caseId, $caseType);

        // ✅ Merge and sort by time
        $timeline = collect();

        foreach ($evidences as $evidence) {
            $timeline->push([
                'time' => $evidence->event_timestamp,
                'type' => 'evidence',
                'sub_type' => $evidence->evidence_type,
                'title' => $evidence->title,
                'description' => $evidence->description,
                'evidence_id' => $evidence->evidence_id,
                'is_locked' => $evidence->is_locked,
            ]);
        }

        foreach ($orderEvents as $event) {
            $timeline->push($event);
        }

        foreach ($walletEvents as $event) {
            $timeline->push($event);
        }

        return $timeline->sortBy('time')->values()->toArray();
    }

    private function getOrderEvents(int $caseId, string $caseType): array
    {
        $complaint = DB::table('complaints')->find($caseId);
        if (! $complaint) {
            return [];
        }

        $orderId = $complaint->related_entity_id;
        if (! $orderId) {
            return [];
        }

        $order = DB::table('orders')->find($orderId);
        if (! $order) {
            return [];
        }

        return [
            [
                'time' => $order->created_at,
                'type' => 'order_event',
                'sub_type' => 'order_placed',
                'title' => "Order Placed: {$orderId}",
                'description' => "Amount: Rs. {$order->total_amount}",
            ],
            [
                'time' => $order->updated_at,
                'type' => 'order_event',
                'sub_type' => "order_{$order->status}",
                'title' => "Order Status: {$order->status}",
                'description' => "Order marked as {$order->status}",
            ],
        ];
    }

    private function getWalletEvents(int $caseId, string $caseType): array
    {
        $complaint = DB::table('complaints')->find($caseId);
        if (! $complaint) {
            return [];
        }

        $txs = DB::table('wallet_transactions')
            ->where('user_id', $complaint->reporter_id)
            ->where('created_at', '>=', now()->subDays(7))
            ->get();

        return $txs->map(function ($tx) {
            return [
                'time' => $tx->created_at,
                'type' => 'wallet_event',
                'sub_type' => $tx->type,
                'title' => 'Wallet: '.ucfirst($tx->type),
                'description' => "Amount: Rs. {$tx->amount}",
            ];
        })->toArray();
    }

    private function addToTimeline(CaseEvidence $evidence): void
    {
        EvidenceTimeline::create([
            'case_type' => $evidence->case_type,
            'case_id' => $evidence->case_id,
            'case_ref' => $evidence->case_ref,
            'evidence_id' => $evidence->id,
            'event_time' => $evidence->event_timestamp ?? now(),
            'event_type' => $evidence->evidence_type,
            'event_description' => $evidence->title,
            'actor_ref' => 'User:'.auth()->id(),
        ]);
    }

    // ✅ Lock evidence
    public function lockEvidence(CaseEvidence $evidence): CaseEvidence
    {
        if ($evidence->is_locked) {
            throw new \Exception('evidence_already_locked');
        }

        $evidence->update([
            'is_locked' => true,
            'locked_at' => now(),
            'locked_by' => auth()->id(),
        ]);

        Log::info("🔒 Evidence locked: {$evidence->evidence_id}");

        return $evidence->fresh();
    }

    // ✅ Flag tampering
    public function flagTampering(
        CaseEvidence $evidence,
        string $reason
    ): CaseEvidence {

        $evidence->update([
            'is_tampered' => true,
            'meta' => array_merge($evidence->meta ?? [], [
                'tamper_reason' => $reason,
                'flagged_by' => auth()->id(),
                'flagged_at' => now()->toDateTimeString(),
                'integrity_check' => $evidence->verifyIntegrity(),
            ]),
        ]);

        Log::warning("⚠️ Evidence tampered: {$evidence->evidence_id}");

        return $evidence->fresh();
    }

    // ✅ Share evidence
    public function shareEvidence(
        CaseEvidence $evidence,
        array $data
    ): EvidenceShare {

        $share = EvidenceShare::create([
            'evidence_id' => $evidence->id,
            'shared_by' => auth()->id(),
            'shared_with' => $data['shared_with'],
            'department' => $data['department'],
            'share_reason' => $data['reason'] ?? null,
            'can_download' => $data['can_download'] ?? false,
            'expires_at' => $data['expires_at'] ?? now()->addDays(7),
        ]);

        $evidence->update(['is_shared' => true]);

        return $share;
    }

    // ✅ Dashboard stats
    public function getDashboardStats(): array
    {
        return [
            'total_evidences' => CaseEvidence::count(),
            'locked' => CaseEvidence::locked()->count(),
            'tampered' => CaseEvidence::where('is_tampered', true)->count(),
            'shared' => CaseEvidence::where('is_shared', true)->count(),
            'by_type' => [
                'chat_transcript' => CaseEvidence::where('evidence_type', 'chat_transcript')->count(),
                'gps_trace' => CaseEvidence::where('evidence_type', 'gps_trace')->count(),
                'delivery_proof' => CaseEvidence::where('evidence_type', 'delivery_proof')->count(),
                'transaction_log' => CaseEvidence::where('evidence_type', 'transaction_log')->count(),
            ],
        ];
    }
}
