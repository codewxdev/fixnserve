<?php

namespace App\Domains\System\Console\Commands;

use App\Domains\Security\Models\User;
use App\Domains\System\Models\TimeBoundPrivilege;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RevokeExpiredPrivileges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:revoke-expired-privileges';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    // app/Console/Commands/RevokeExpiredPrivileges.php
    public function handle(): void
    {
        $expired = TimeBoundPrivilege::where('is_active', true)
            ->where('expires_at', '<', now())
            ->get();

        foreach ($expired as $privilege) {
            $user = User::find($privilege->target_admin_id);
            $role = Role::find($privilege->role_id);

            if ($user && $role) {
                $user->removeRole($role); // ✅ Remove Spatie role
            }

            $privilege->update(['is_active' => false]);

            Log::info("⏰ Privilege expired: User {$privilege->target_admin_id} lost role {$role?->name}");
        }

        $this->info("✅ Expired privileges revoked: {$expired->count()}");
    }
}
