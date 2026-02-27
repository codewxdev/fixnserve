<?php

namespace App\Domains\Audit\Services;

use App\Domains\Audit\Models\SecurityAuditLog;
use Illuminate\Support\Facades\Log;

class SecurityAuditService
{
    protected $riskEngine;

    public function __construct(SecurityRiskEngine $riskEngine)
    {
        $this->riskEngine = $riskEngine;
    }

    public function log(string $eventType, array $data = [], $user = null)
    {
        $risk = $this->riskEngine->evaluate($eventType, $user);
        $isAnomaly = $this->riskEngine->isAnomaly($risk);

        $log = SecurityAuditLog::create([
            'user_id' => $user?->id,
            'event_type' => $eventType,
            'risk_score' => $risk,
            'is_anomaly' => $isAnomaly,
            'event_data' => $data,
            'ip_address' => request()->ip(),
            'device' => request()->userAgent(),
            'occurred_at' => now(),
        ]);

        // Alert if required
        if ($isAnomaly) {
            $this->triggerAlert($log);
        }
    }

    protected function triggerAlert($log)
    {
        // Email / Slack / Admin notification
        Log::warning('SECURITY ANOMALY DETECTED', [
            'event' => $log->event_type,
            'risk_score' => $log->risk_score,
            'user_id' => $log->user_id,
        ]);
    }
}
