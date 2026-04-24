<?php

namespace App\Domains\Command\Controllers\Cp\V1;

use App\Domains\Command\Models\KillSwitch;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class KillSwitchController extends BaseApiController
{
    /**
     * Request a kill switch (Admin 1)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'scope' => 'required|in:payments,orders,subscriptions,payouts,notifications',
            'type' => 'required|in:soft,hard',
            'reason' => 'required|string|min:10',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $kill = KillSwitch::create([
            'scope' => $validated['scope'],
            'type' => $validated['type'],
            'reason' => $validated['reason'],
            'expires_at' => $validated['expires_at'] ?? null,
            'created_by' => auth()->id(),
        ]);

        return $this->success(
            $kill,
            'kill_switch_request_created'
        );
    }

    /**
     * Cancel kill switch manually
     */
    public function cancel($id)
    {
        $kill = KillSwitch::findOrFail($id);

        if ($kill->status != 'active') {
            return $this->error(
                'invalid_kill_switch_state',
                422
            );
        }

        $kill->update(['status' => 'cancelled']);

        Redis::del("kill_switch:{$kill->scope}");

        return $this->success(
            null,
            'kill_switch_cancelled'
        );
    }

    /**
     * List for admin dashboard
     */
    public function index()
    {
        $kills = KillSwitch::paginate(10);

        return $this->success(
            $kills,
            'kill_switches_fetched'
        );
    }
}
