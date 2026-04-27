<?php

namespace App\Domains\Command\Controllers\Cp\V1;

use App\Domains\Audit\Services\AdminAuditService;
use App\Domains\Command\Models\EmergencyOverride;
use App\Domains\Command\Models\EmergencyOverrideLog;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class EmergencyOverrideController extends BaseApiController
{
    protected $audit;

    public function __construct(AdminAuditService $audit)
    {
        $this->audit = $audit;
    }

    public function activate(Request $request)
    {
        $validated = $request->validate([
            'reason' => 'required|string|min:10',
            'duration_minutes' => 'nullable|integer|min:5|max:120',
        ]);

        if (! auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Super Admin only');
        }

        $duration = $validated['duration_minutes'] ?? 30;

        $override = EmergencyOverride::create([
            'admin_id' => auth()->id(),
            'reason' => $validated['reason'],
            'expires_at' => now()->addMinutes($duration),
            'active' => true,
        ]);

        Redis::setex(
            'emergency_override:admin:'.auth()->id(),
            $duration * 60,
            json_encode([
                'override_id' => $override->id,
                'expires_at' => $override->expires_at,
            ])
        );

        EmergencyOverrideLog::create([
            'override_id' => $override->id,
            'admin_id' => auth()->id(),
            'action' => 'OVERRIDE_ACTIVATED',
            'created_at' => now(),
        ]);

        $this->audit->log([
            'action_type' => 'emergency_override_activated',
            'target_type' => 'EmergencyOverride',
            'target_id' => $override->id,
            'before_state' => null,
            'after_state' => [
                'admin_id' => auth()->id(),
                'expires_at' => $override->expires_at,
                'duration_minutes' => $duration,
                'ip' => $request->ip(),
            ],
            'reason_code' => $validated['reason'],
        ]);

        if ($duration > 60) {
            $this->audit->log([
                'action_type' => 'high_risk_override_duration',
                'target_type' => 'EmergencyOverride',
                'target_id' => $override->id,
                'reason_code' => 'Override duration exceeds 60 minutes',
            ]);
        }

        return $this->success(
            ['expires_at' => $override->expires_at],
            'emergency_override_activated'
        );
    }

    public function terminate(Request $request)
    {
        if (! auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Super Admin only');
        }

        $override = EmergencyOverride::where('admin_id', auth()->id())
            ->where('active', true)
            ->first();

        if (! $override) {
            abort(404, 'No active override found.');
        }

        $oldState = $override->toArray();

        $override->update(['active' => false]);

        Redis::del('emergency_override:admin:'.auth()->id());

        EmergencyOverrideLog::create([
            'override_id' => $override->id,
            'admin_id' => auth()->id(),
            'action' => 'OVERRIDE_TERMINATED',
            'created_at' => now(),
        ]);

        $this->audit->log([
            'action_type' => 'emergency_override_terminated',
            'target_type' => 'EmergencyOverride',
            'target_id' => $override->id,
            'before_state' => $oldState,
            'after_state' => [
                'active' => false,
                'terminated_at' => now(),
            ],
            'reason_code' => 'Manual termination by Super Admin',
        ]);

        return $this->success(null, 'emergency_override_terminated');
    }

    public function logs()
    {
        if (! auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Super Admin only');
        }

        $logs = EmergencyOverrideLog::latest()->get();

        return $this->success($logs, 'override_logs_fetched');
    }

    public function criticalAction(Request $request)
    {
        if (! auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Super Admin only');
        }

        $this->audit->log([
            'action_type' => 'emergency_critical_action_executed',
            'target_type' => 'System',
            'target_id' => null,
            'before_state' => null,
            'after_state' => [
                'performed_by' => auth()->id(),
                'timestamp' => now(),
                'ip' => $request->ip(),
            ],
            'reason_code' => 'Critical action executed under emergency override',
        ]);

        return $this->success(
            [
                'performed_by' => auth()->id(),
                'time' => now(),
            ],
            'critical_action_executed'
        );
    }
}
