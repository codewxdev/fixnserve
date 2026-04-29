<?php

namespace App\Domains\Config\Controllers\Api;

use App\Domains\Config\Models\RateLimitConfiguration;
use App\Domains\Config\Models\TemporaryOverride;
use App\Domains\Config\Services\RateLimitService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class RateLimitController extends BaseApiController
{
    protected RateLimitService $rateLimitService;

    public function __construct(RateLimitService $rateLimitService)
    {
        $this->rateLimitService = $rateLimitService;
    }

    // ✅ GET all limits
    public function getConfig()
    {
        $config = RateLimitConfiguration::first();
        $overrides = TemporaryOverride::where('expires_at', '>', now())->get();

        return $this->success([
            'config' => $config,
            'overrides' => $overrides,
        ], 'rate_limits_fetched');
    }

    // ✅ SAVE all limits
    public function saveLimits(Request $request)
    {
        $validated = $request->validate([
            // Global
            'api_rate_limit' => 'required|integer|min:1',
            'burst_limit' => 'required|integer|min:1',
            // Entity
            'per_user_limit' => 'required|integer|min:1',
            'per_ip_limit' => 'required|integer|min:1',
            // Channel
            'sms_limit' => 'required|integer|min:1',
            'push_limit' => 'required|integer|min:1',
            'email_limit' => 'required|integer|min:1',
        ]);

        $config = RateLimitConfiguration::updateOrCreate(
            ['id' => 1],
            $validated
        );

        // ✅ Refresh cache so middleware picks new limits instantly
        $this->rateLimitService->refreshConfig();

        return $this->success($config, 'rate_limits_saved');
    }

    // ✅ EMERGENCY throttling toggle
    public function emergencyThrottling()
    {
        $config = RateLimitConfiguration::firstOrCreate(['id' => 1]);
        $config->update(['emergency_throttling' => ! $config->emergency_throttling]);

        $this->rateLimitService->refreshConfig();

        return $this->success([
            'emergency_throttling' => $config->emergency_throttling,
            'message' => $config->emergency_throttling
                ? '🚨 Emergency Throttling ENABLED'
                : '✅ Emergency Throttling DISABLED',
        ], 'emergency_throttling_toggled');
    }

    // ✅ ADD temporary override
    public function addOverride(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:ip,user,api_key',
            'value' => 'required|string',
            'limit' => 'required_if:is_blocked,false|integer|min:1',
            'reason' => 'nullable|string|max:255',
            'expires_at' => 'required|date|after:now',
            'is_blocked' => 'boolean',
        ]);

        // ✅ Check if override already exists
        $override = TemporaryOverride::updateOrCreate(
            [
                'type' => $validated['type'],
                'value' => $validated['value'],
            ],
            $validated
        );

        $this->rateLimitService->refreshOverrides();

        return $this->success($override, 'override_added', 201);
    }

    // ✅ DELETE override
    public function deleteOverride(TemporaryOverride $override)
    {
        $override->delete();
        $this->rateLimitService->refreshOverrides();

        return $this->success(null, 'override_deleted');
    }

    // ✅ GET active overrides
    public function getOverrides()
    {
        $overrides = TemporaryOverride::where('expires_at', '>', now())->get();

        return $this->success($overrides, 'overrides_fetched');
    }
}
