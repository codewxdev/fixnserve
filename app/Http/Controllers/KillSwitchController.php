<?php

namespace App\Http\Controllers;

use App\Models\KillSwitch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class KillSwitchController extends Controller
{
    /**
     * Request a kill switch (Admin 1)
     */
    public function store(Request $request)
    {
        $request->validate([
            'scope' => 'required|in:payments,orders,subscriptions,payouts,notifications',
            'type' => 'required|in:soft,hard',
            'reason' => 'required|string|min:10',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $kill = KillSwitch::create([
            'scope' => $request->scope,
            'type' => $request->type,
            'reason' => $request->reason,
            'expires_at' => $request->expires_at,
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Kill switch request created',
            'data' => $kill,
        ], 201);
    }

    /**
     * Cancel kill switch manually
     */
    public function cancel($id)
    {
        $kill = KillSwitch::find($id);

        if ($kill->status != 'active') {
            return response()->json(['message' => 'Invalid state'], 422);
        }

        $kill->update(['status' => 'cancelled']);

        Redis::del("kill_switch:{$kill->scope}");

        return response()->json([
            'message' => 'Kill switch cancelled',
        ]);
    }

    /**
     * List for admin dashboard
     */
    public function index()
    {
        return KillSwitch::get();

    }
}
