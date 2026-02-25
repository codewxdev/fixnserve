<?php

namespace App\Domains\Command\Controllers\Api;

use App\Domains\Audit\Services\AdminAuditService;
use App\Domains\Command\Models\EmergencyOverride;
use App\Domains\Command\Models\EmergencyOverrideLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class EmergencyOverrideController extends Controller
{
    protected $audit;

    public function __construct(AdminAuditService $audit)
    {
        $this->audit = $audit;
    }

    /**
     * ACTIVATE emergency override
     */
    public function activate(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
            'duration_minutes' => 'nullable|integer|min:5|max:120',
        ]);

        if (! auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Super Admin only');
        }

        $duration = $request->duration_minutes ?? 30;

        // Create override
        $override = EmergencyOverride::create([
            'admin_id' => auth()->id(),
            'reason' => $request->reason,
            'expires_at' => now()->addMinutes($duration),
            'active' => true,
        ]);

        // Redis cache with auto-expiry
        Redis::setex(
            'emergency_override:admin:'.auth()->id(),
            $duration * 60,
            json_encode([
                'override_id' => $override->id,
                'expires_at' => $override->expires_at,
            ])
        );

        // Override log
        EmergencyOverrideLog::create([
            'override_id' => $override->id,
            'admin_id' => auth()->id(),
            'action' => 'OVERRIDE_ACTIVATED',
            'created_at' => now(),
        ]);

        // 🔐 Enterprise Audit Log
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
            'reason_code' => $request->reason,
        ]);

        // High-risk duration detection
        if ($duration > 60) {
            $this->audit->log([
                'action_type' => 'high_risk_override_duration',
                'target_type' => 'EmergencyOverride',
                'target_id' => $override->id,
                'reason_code' => 'Override duration exceeds 60 minutes',
            ]);
        }

        return response()->json([
            'message' => 'Emergency override activated',
            'expires_at' => $override->expires_at,
        ]);
    }

    /**
     * TERMINATE emergency override
     */
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

        // Update DB
        $override->update(['active' => false]);

        // Remove Redis key
        Redis::del('emergency_override:admin:'.auth()->id());

        // Override log
        EmergencyOverrideLog::create([
            'override_id' => $override->id,
            'admin_id' => auth()->id(),
            'action' => 'OVERRIDE_TERMINATED',
            'created_at' => now(),
        ]);

        // 🔐 Enterprise Audit Log
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

        return response()->json([
            'message' => 'Emergency override terminated',
        ]);
    }

    /**
     * VIEW override logs
     */
    public function logs()
    {
        if (! auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Super Admin only');
        }

        return EmergencyOverrideLog::latest()->get();
    }

    /**
     * CRITICAL ACTION (Emergency Only)
     */
    public function criticalAction(Request $request)
    {
        if (! auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Super Admin only');
        }

        // 🔐 Audit critical action
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

        return response()->json([
            'message' => 'Critical action performed successfully!',
            'performed_by' => auth()->id(),
            'time' => now(),
        ]);
    }
}
