<?php

namespace App\Domains\Security\Console\Commands;

use App\Domains\Security\Models\PrivilegeRequest;
use Illuminate\Console\Command;

class CheckPasswordRotation extends Command
{
    public function handle()
    {
        $expired = PrivilegeRequest::where('status', 'approved')
            ->where('expires_at', '<', now())
            ->get();

        foreach ($expired as $privilege) {

            $privilege->user->removeRole($privilege->requested_role);

            $privilege->update([
                'status' => 'expired',
            ]);
        }
    }
}
