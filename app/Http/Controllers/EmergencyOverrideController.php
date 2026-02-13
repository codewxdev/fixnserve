<?php

namespace App\Http\Controllers;

use App\Models\EmergencyOverride;
use App\Models\EmergencyOverrideLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class EmergencyOverrideController extends Controller
{
    /**
     * ACTIVATE emergency override
     * Admin only + MFA required
     */
    public function activate(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
            'duration_minutes' => 'nullable|integer|min:5|max:120',
        ]);

        // ✅ Admin check (important)
        if (! auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Admin only');
        }

        $duration = $request->duration_minutes ?? 30;

        // ✅ Create override
        $override = EmergencyOverride::create([
            'admin_id' => auth()->id(),
            'reason' => $request->reason,
            'expires_at' => now()->addMinutes($duration),
            'active' => true,
        ]);

        // ✅ Cache (Redis)
        Redis::set(
            'emergency_override:admin:'.auth()->id(),
            json_encode([
                'override_id' => $override->id,
                'expires_at' => $override->expires_at,
            ])
        );

        // ✅ Audit log
        EmergencyOverrideLog::create([
            'override_id' => $override->id,
            'admin_id' => auth()->id(),
            'action' => 'OVERRIDE_ACTIVATED',
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'Emergency override activated',
            'expires_at' => $override->expires_at,
        ]);
    }

    /**
     * TERMINATE emergency override
     */
    public function terminate()
    {
        if (! auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Admin only');
        }

        $override = EmergencyOverride::where('admin_id', auth()->id())
            ->where('active', true)->first();

        EmergencyOverrideLog::create([
            'override_id' => $override->id,
            'admin_id' => auth()->id(),
            'action' => 'OVERRIDE_TERMINATED',
            'created_at' => now(),
        ]);
        $override->update(['active' => false]);

        Redis::del('emergency_override:admin:'.auth()->id());

        return response()->json([
            'message' => 'Emergency override terminated',
        ]);
    }

    /**
     * VIEW override logs (Admin dashboard)
     */
    public function logs()
    {
        if (! auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Admin only');
        }

        return EmergencyOverrideLog::get();
    }

    // EmergencyOverrideController.php
    public function criticalAction(Request $request)
    {
        // Middleware ensures only emergency admin reaches here
        return response()->json([
            'message' => 'Critical action performed successfully!',
            'performed_by' => auth()->id(),
            'time' => now(),
        ]);
    }
}
