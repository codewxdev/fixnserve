<?php

namespace App\Domains\Config\Services;

use App\Domains\Config\Models\RateLimitConfiguration;
use App\Domains\Config\Models\TemporaryOverride;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitService
{
    // ✅ Get config from cache
    public function getConfig(): RateLimitConfiguration
    {
        return Cache::remember('rate_limit_config', 3600, function () {
            return RateLimitConfiguration::firstOrCreate(['id' => 1]);
        });
    }

    // ✅ Check if request should be throttled
    public function check(string $ip, ?int $userId = null): array
    {
        $config = $this->getConfig();

        // ✅ Emergency throttling - reduce all limits by 90%
        $multiplier = $config->emergency_throttling ? 0.1 : 1.0;

        // ✅ Check temporary overrides first
        $override = $this->getActiveOverride($ip, $userId);

        if ($override) {
            // Complete block
            if ($override->is_blocked) {
                return [
                    'allowed' => false,
                    'reason' => 'blocked',
                    'message' => 'You are temporarily blocked',
                    'retry_after' => $override->expires_at,
                ];
            }

            // Custom limit
            $allowed = $this->checkRateLimit(
                "override:{$override->type}:{$override->value}",
                $override->limit
            );

            return [
                'allowed' => $allowed,
                'limit' => $override->limit,
                'reason' => 'override_limit',
            ];
        }

        // ✅ Check per-IP limit
        $ipLimit = (int) ($config->per_ip_limit * $multiplier);
        if (! $this->checkRateLimit("ip:{$ip}", $ipLimit)) {
            return [
                'allowed' => false,
                'reason' => 'ip_limit_exceeded',
                'message' => 'Too many requests from this IP',
                'limit' => $ipLimit,
                'retry_after' => 60,
            ];
        }

        // ✅ Check per-user limit
        if ($userId) {
            $userLimit = (int) ($config->per_user_limit * $multiplier);
            if (! $this->checkRateLimit("user:{$userId}", $userLimit)) {
                return [
                    'allowed' => false,
                    'reason' => 'user_limit_exceeded',
                    'message' => 'Too many requests from this user',
                    'limit' => $userLimit,
                    'retry_after' => 60,
                ];
            }
        }

        // ✅ Check global API limit
        $apiLimit = (int) ($config->api_rate_limit * $multiplier);
        if (! $this->checkRateLimit('global_api', $apiLimit)) {
            return [
                'allowed' => false,
                'reason' => 'global_limit_exceeded',
                'message' => 'API rate limit exceeded',
                'limit' => $apiLimit,
                'retry_after' => 60,
            ];
        }

        return ['allowed' => true];
    }

    // ✅ Check channel limits (SMS, Push, Email)
    public function checkChannel(string $channel, ?int $userId = null): bool
    {
        $config = $this->getConfig();

        $limits = [
            'sms' => $config->sms_limit,
            'push' => $config->push_limit,
            'email' => $config->email_limit,
        ];

        $limit = $limits[$channel] ?? 60;
        $key = $userId ? "{$channel}:user:{$userId}" : "{$channel}:global";

        return $this->checkRateLimit($key, $limit);
    }

    // ✅ Core rate limit check using Laravel RateLimiter
    private function checkRateLimit(string $key, int $limit): bool
    {
        return ! RateLimiter::tooManyAttempts($key, $limit);
    }

    // ✅ Get active override for IP or user
    private function getActiveOverride(string $ip, ?int $userId): ?TemporaryOverride
    {
        $overrides = Cache::remember('rate_limit_overrides', 300, function () {
            return TemporaryOverride::where('expires_at', '>', now())->get();
        });

        // Check IP override
        $ipOverride = $overrides->where('type', 'ip')->where('value', $ip)->first();
        if ($ipOverride) {
            return $ipOverride;
        }

        // Check user override
        if ($userId) {
            $userOverride = $overrides->where('type', 'user')
                ->where('value', $userId)
                ->first();
            if ($userOverride) {
                return $userOverride;
            }
        }

        return null;
    }

    public function refreshConfig(): void
    {
        Cache::forget('rate_limit_config');
    }

    public function refreshOverrides(): void
    {
        Cache::forget('rate_limit_overrides');
    }
}
