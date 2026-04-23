<?php

namespace App\Domains\System\Controllers\Api;

use App\Domains\Security\Models\User;
use App\Domains\System\Models\TimeBoundPrivilege;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class TimeBoundPrivilegeController extends BaseApiController
{
    // ✅ GET all active grants
    public function index()
    {
        $grants = TimeBoundPrivilege::with([
            'targetAdmin:id,name,email',
            'grantedBy:id,name,email',
            'role:id,name',
        ])
            ->active()
            ->get()
            ->map(function ($grant) {
                return [
                    'id' => $grant->id,
                    'target_admin' => $grant->targetAdmin,
                    'granted_by' => $grant->grantedBy,
                    'role' => $grant->role,
                    'expires_at' => $grant->expires_at,
                    'expires_in_seconds' => $grant->remainingSeconds(),
                    'is_active' => $grant->is_active,
                ];
            });

        return $this->success($grants, 'active_grants_fetched');
    }

    // ✅ POST grant privilege
    public function store(Request $request)
    {
        $validated = $request->validate([
            'target_admin_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
            'duration' => 'required|in:30_minutes,1_hour,3_hours,6_hours,12_hours,24_hours',
        ]);

        // ✅ Duration map
        $durations = [
            '30_minutes' => 30,
            '1_hour' => 60,
            '3_hours' => 180,
            '6_hours' => 360,
            '12_hours' => 720,
            '24_hours' => 1440,
        ];

        $targetUser = User::findOrFail($validated['target_admin_id']);
        $role = Role::findOrFail($validated['role_id']);

        // ✅ Cannot grant to yourself
        if ($validated['target_admin_id'] === auth()->id()) {
            return $this->error('cannot_grant_to_yourself', 403);
        }

        // ✅ Revoke existing active privilege
        $existing = TimeBoundPrivilege::where('target_admin_id', $validated['target_admin_id'])
            ->active()
            ->first();

        if ($existing) {
            $targetUser->removeRole(Role::find($existing->role_id));
            $existing->update([
                'is_active' => false,
                'revoked_at' => now(),
                'revoked_by_id' => auth()->id(),
            ]);
        }

        // ✅ Assign Spatie role
        $targetUser->assignRole($role);

        // ✅ Store grant record
        $grant = TimeBoundPrivilege::create([
            'target_admin_id' => $validated['target_admin_id'],
            'granted_by_id' => auth()->id(),
            'role_id' => $validated['role_id'],
            'expires_at' => now()->addMinutes($durations[$validated['duration']]),
            'is_active' => true,
        ]);

        return $this->success(
            $grant->load([
                'targetAdmin:id,name,email',
                'grantedBy:id,name,email',
                'role:id,name',
            ]),
            'privilege_granted',
            201
        );
    }

    // ✅ DELETE revoke privilege
    public function revoke(TimeBoundPrivilege $privilege)
    {
        if (! $privilege->is_active) {
            return $this->error('privilege_already_revoked', 422);
        }

        $targetUser = User::findOrFail($privilege->target_admin_id);
        $role = Role::findOrFail($privilege->role_id);

        // ✅ Remove Spatie role
        $targetUser->removeRole($role);

        // ✅ Update record
        $privilege->update([
            'is_active' => false,
            'revoked_at' => now(),
            'revoked_by_id' => auth()->id(),
        ]);

        return $this->success($privilege, 'privilege_revoked');
    }

    // ✅ GET history (all grants including expired)
    public function history()
    {
        $history = TimeBoundPrivilege::with([
            'targetAdmin:id,name,email',
            'grantedBy:id,name,email',
            'revokedBy:id,name,email',
            'role:id,name',
        ])
            ->latest()
            ->get()
            ->map(function ($grant) {
                return [
                    'id' => $grant->id,
                    'target_admin' => $grant->targetAdmin,
                    'granted_by' => $grant->grantedBy,
                    'revoked_by' => $grant->revokedBy,
                    'role' => $grant->role,
                    'expires_at' => $grant->expires_at,
                    'revoked_at' => $grant->revoked_at,
                    'is_active' => $grant->is_active,
                    'status' => $this->getStatus($grant),
                ];
            });

        return $this->success($history, 'grant_history_fetched');
    }

    // ✅ Helper - get status label
    private function getStatus(TimeBoundPrivilege $grant): string
    {
        if (! $grant->is_active && $grant->revoked_at) {
            return 'revoked';
        }
        if ($grant->isExpired()) {
            return 'expired';
        }
        if ($grant->is_active) {
            return 'active';
        }

        return 'inactive';
    }
}
