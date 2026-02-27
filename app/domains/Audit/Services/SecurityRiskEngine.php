<?php

namespace App\Domains\Audit\Services;

class SecurityRiskEngine
{
    public function evaluate(string $eventType, $user = null): int
    {
        $risk = 0;

        switch ($eventType) {
            case 'failed_login':
                $risk += 20;
                break;

            case 'mfa_failed':
                $risk += 30;
                break;

            case 'device_blocked':
                $risk += 40;
                break;

            case 'ip_policy_changed':
                $risk += 50;
                break;

            case 'token_rotated':
                $risk += 10;
                break;
        }

        // Privileged misuse detection
        if ($user && $user->hasRole('Super Admin')) {
            $risk += 10;
        }

        return $risk;
    }

    public function isAnomaly(int $risk): bool
    {
        return $risk >= 40;
    }
}
