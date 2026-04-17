<?php

namespace App\Domains\Security\Controllers\Api;

use App\Domains\Security\Models\TokenPolicy;
use App\Domains\Security\Models\UserSession;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class TokenPolicyController extends BaseApiController
{
    public function index()
    {
        $token = TokenPolicy::get();

        return $this->success([
            'token_policies' => $token,
        ], 'token_policies_fetched');
    }

    public function updateTokenPolicy(Request $request)
    {
        $validated = $request->validate([
            'access_token_ttl_minutes' => 'required|integer|min:5|max:1440',
            'refresh_token_ttl_days' => 'required|integer|min:1|max:90',
            'rotate_refresh_on_use' => 'required|boolean',
        ]);

        $policy = TokenPolicy::current();

        $policy->update([
            'access_token_ttl_minutes' => $validated['access_token_ttl_minutes'],
            'refresh_token_ttl_days' => $validated['refresh_token_ttl_days'],
            'rotate_refresh_on_use' => $validated['rotate_refresh_on_use'],
        ]);

        return $this->success([
            'access_token_ttl_minutes' => $policy->access_token_ttl_minutes,
            'refresh_token_ttl_days' => $policy->refresh_token_ttl_days,
            'rotate_refresh_on_use' => $policy->rotate_refresh_on_use,
        ], 'token_policy_updated');
    }

    public function listTokens()
    {
        $sessions = UserSession::where('is_revoked', false)->get();

        $tokens = $sessions->map(function ($session) {
            return [
                'id' => $session->jwt_id,
                'device' => $session->device,
                'created_at' => $session->created_at,
                'expires_at' => $session->expires_at,
                'last_used' => $session->last_activity_at,
                'is_expired' => $session->expires_at
                    ? now()->gt($session->expires_at)
                    : false,
                'is_revoked' => $session->is_revoked,
            ];
        });

        return $this->success([
            'tokens' => $tokens,
        ], 'active_tokens_fetched');
    }
}
