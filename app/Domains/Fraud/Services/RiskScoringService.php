<?php

namespace App\Domains\Fraud\Services;

use App\Domains\Fraud\Models\RiskEnforcement;
use App\Domains\Fraud\Models\RiskEvent;
use App\Domains\Fraud\Models\RiskScore;
use App\Domains\Fraud\Models\RiskSignalWeight;
use Illuminate\Support\Facades\Cache;

class RiskScoringService
{
    // ✅ Main method - Process event & recalculate score
    public function processEvent(
        string $entityType,
        int $entityId,
        string $eventType,
        array $eventData = []
    ): RiskScore {

        // Get current score
        $riskScore = RiskScore::firstOrCreate(
            ['entity_type' => $entityType, 'entity_id' => $entityId],
            ['score' => 0, 'tier' => 'low']
        );

        $scoreBefore = $riskScore->score;

        // Calculate new score
        $result = $this->calculateScore($entityType, $entityId);
        $newScore = $result['score'];
        $newTier = RiskScore::getTier($newScore);

        // Update risk score
        $riskScore->update([
            'score' => $newScore,
            'tier' => $newTier,
            'reason_codes' => $result['reason_codes'],
            'signal_breakdown' => $result['signal_breakdown'],
            'last_event_at' => now(),
        ]);

        // Log event
        RiskEvent::create([
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'event_type' => $eventType,
            'event_data' => $eventData,
            'score_before' => $scoreBefore,
            'score_after' => $newScore,
            'score_delta' => $newScore - $scoreBefore,
        ]);

        // Auto enforcement
        $this->autoEnforce($riskScore);

        return $riskScore;
    }

    // ✅ Calculate score based on signals
    public function calculateScore(
        string $entityType,
        int $entityId
    ): array {

        $weights = $this->getSignalWeights();
        $totalScore = 0;
        $reasonCodes = [];
        $breakdown = [];

        foreach ($weights as $signal) {
            $signalScore = $this->evaluateSignal(
                $signal->signal_key,
                $entityType,
                $entityId
            );

            if ($signalScore > 0) {
                $weighted = ($signalScore * $signal->weight) / 100;
                $totalScore += $weighted;
                $reasonCodes[] = $signal->signal_key;

                $breakdown[$signal->signal_key] = [
                    'raw_score' => $signalScore,
                    'weight' => $signal->weight,
                    'weighted' => round($weighted, 2),
                    'impact' => $signal->impact,
                ];
            }
        }

        return [
            'score' => min(100, (int) round($totalScore)),
            'reason_codes' => $reasonCodes,
            'signal_breakdown' => $breakdown,
        ];
    }

    // ✅ Evaluate each signal
    private function evaluateSignal(
        string $signalKey,
        string $entityType,
        int $entityId
    ): int {

        return match ($signalKey) {

            // Device reuse check
            'device_reuse' => $this->checkDeviceReuse($entityId),

            // Payment failures
            'payment_failures' => $this->checkPaymentFailures(
                $entityType, $entityId
            ),

            // Velocity patterns
            'velocity_patterns' => $this->checkVelocityPatterns(
                $entityType, $entityId
            ),

            // Geo inconsistencies
            'geo_inconsistencies' => $this->checkGeoInconsistencies(
                $entityType, $entityId
            ),

            // Dispute frequency
            'dispute_frequency' => $this->checkDisputeFrequency(
                $entityType, $entityId
            ),

            default => 0,
        };
    }

    // ✅ Check device reuse (same device multiple accounts)
    private function checkDeviceReuse(int $entityId): int
    {
        // Count how many accounts use same device
        $reuses = RiskEvent::where('entity_id', $entityId)
            ->where('event_type', 'device_reuse')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        return match (true) {
            $reuses >= 5 => 100, // 5+ times = max risk
            $reuses >= 3 => 70,
            $reuses >= 1 => 40,
            default => 0,
        };
    }

    // ✅ Check payment failures
    private function checkPaymentFailures(
        string $entityType,
        int $entityId
    ): int {

        $failures = RiskEvent::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('event_type', 'payment_failed')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        return match (true) {
            $failures >= 10 => 100,
            $failures >= 5 => 70,
            $failures >= 2 => 40,
            default => 0,
        };
    }

    // ✅ Check velocity patterns
    private function checkVelocityPatterns(
        string $entityType,
        int $entityId
    ): int {

        // Too many actions in short time
        $actions = RiskEvent::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('created_at', '>=', now()->subHours(1))
            ->count();

        return match (true) {
            $actions >= 50 => 100,
            $actions >= 20 => 60,
            $actions >= 10 => 30,
            default => 0,
        };
    }

    // ✅ Check geo inconsistencies
    private function checkGeoInconsistencies(
        string $entityType,
        int $entityId
    ): int {

        $geoEvents = RiskEvent::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('event_type', 'geo_mismatch')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        return match (true) {
            $geoEvents >= 5 => 80,
            $geoEvents >= 2 => 50,
            $geoEvents >= 1 => 20,
            default => 0,
        };
    }

    // ✅ Check dispute frequency
    private function checkDisputeFrequency(
        string $entityType,
        int $entityId
    ): int {

        $disputes = RiskEvent::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('event_type', 'dispute_raised')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        return match (true) {
            $disputes >= 5 => 90,
            $disputes >= 3 => 60,
            $disputes >= 1 => 30,
            default => 0,
        };
    }

    // ✅ Auto enforce based on tier
    private function autoEnforce(RiskScore $riskScore): void
    {
        $action = match ($riskScore->tier) {
            'critical' => 'account_suspend',
            'high' => 'restrict_features',
            'medium' => 'monitoring',
            default => null,
        };

        if (! $action) {
            return;
        }

        // Check if enforcement already active
        $existing = RiskEnforcement::where('entity_type', $riskScore->entity_type)
            ->where('entity_id', $riskScore->entity_id)
            ->where('is_active', true)
            ->first();

        if ($existing && $existing->action === $action) {
            return;
        }

        // Deactivate old enforcement
        if ($existing) {
            $existing->update(['is_active' => false]);
        }

        // Create new enforcement
        RiskEnforcement::create([
            'entity_type' => $riskScore->entity_type,
            'entity_id' => $riskScore->entity_id,
            'action' => $action,
            'trigger' => 'auto',
            'risk_score' => $riskScore->score,
            'reason' => "Auto enforcement: tier {$riskScore->tier}",
        ]);
    }

    // ✅ Get signal weights from cache
    public function getSignalWeights()
    {
        return Cache::remember('risk_signal_weights', 3600, function () {
            return RiskSignalWeight::where('is_active', true)->get();
        });
    }

    public function refreshWeights(): void
    {
        Cache::forget('risk_signal_weights');
    }
}
