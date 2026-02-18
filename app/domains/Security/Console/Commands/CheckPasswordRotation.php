<?php

namespace App\Domains\Security\Console\Commands;

use App\Domains\Security\Models\PasswordPolicy;
use App\Domains\Security\Models\User;
use Illuminate\Console\Command;

class CheckPasswordRotation extends Command
{
    protected $signature = 'security:password-rotation';

    public function handle()
    {
        $policy = PasswordPolicy::current();

        if (! $policy->force_rotation_days) {
            return;
        }

        User::where('last_password_changed_at', '<',
            now()->subDays($policy->force_rotation_days)
        )->update([
            'force_password_reset' => true,
        ]);
    }
}
