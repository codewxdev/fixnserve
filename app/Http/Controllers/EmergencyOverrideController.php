<?php

namespace App\Http\Controllers;

use App\Models\EmergencyOverride;
use App\Models\EmergencyOverrideLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class EmergencyOverrideController extends Controller
{
    public function logs()
    {
        return EmergencyOverrideLog::get();
    }

    public function activate(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
        ]);

        // STEP 4.1 — MFA CHECK
        if (! auth()->user()->mfa_verified) {
            return response()->json(['message' => 'MFA required'], 403);
        }

        // STEP 4.2 — CREATE OVERRIDE
        $override = EmergencyOverride::create([
            'admin_id' => auth()->id(),
            'reason' => $request->reason,
            'expires_at' => now()->addMinutes(30),
            'mfa_verified_at' => now(),
        ]);

        // STEP 4.3 — PUSH TO REDIS
        Redis::set(
            'emergency_override:admin:'.auth()->id(),
            json_encode([
                'override_id' => $override->id,
                'expires_at' => $override->expires_at,
            ])
        );

        return response()->json([
            'message' => 'Emergency override activated',
            'expires_at' => $override->expires_at,
        ]);
    }

    public function terminate()
    {
        EmergencyOverride::where('admin_id', auth()->id())
            ->where('active', true)
            ->update(['active' => false]);

        Redis::del('emergency_override:admin:'.auth()->id());

        return response()->json([
            'message' => 'Emergency override terminated',
        ]);
    }
}
