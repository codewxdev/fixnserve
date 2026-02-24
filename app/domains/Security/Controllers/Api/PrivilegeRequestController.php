<?php

namespace App\Domains\Security\Controllers\Api;

use App\Domains\Security\Models\PrivilegeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrivilegeRequestController extends Controller
{
    public function requestElevation(Request $request)
    {
        $data = $request->validate([
            'requested_role' => 'required|string',
            'justification' => 'required|string',
            'duration_minutes' => 'required|integer|min:5|max:120',
        ]);

        return PrivilegeRequest::create([
            'user_id' => auth()->id(),
            'requested_role' => $data['requested_role'],
            'justification' => $data['justification'],
            'expires_at' => now()->addMinutes($data['duration_minutes']),
        ]);
    }

    public function approve($id)
    {
        $request = PrivilegeRequest::findOrFail($id);

        if ($request->status !== 'pending') {
            abort(400, 'Already processed');
        }

        $request->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // 🔥 Assign Temporary Role
        $user = $request->user;
        $user->assignRole($request->requested_role);

        return response()->json(['message' => 'Privilege approved']);
    }

    public function deny($id)
    {
        $request = PrivilegeRequest::findOrFail($id);

        $request->update([
            'status' => 'denied',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return response()->json(['message' => 'Privilege denied']);
    }

    public function extend(Request $request, $id)
    {
        $privilege = PrivilegeRequest::findOrFail($id);

        $privilege->update([
            'expires_at' => $privilege->expires_at
                ->addMinutes($request->extra_minutes),
        ]);

        return response()->json(['message' => 'Extended']);
    }

    public function terminate($id)
    {
        $privilege = PrivilegeRequest::findOrFail($id);

        $privilege->user->removeRole($privilege->requested_role);

        $privilege->update([
            'status' => 'terminated',
        ]);

        return response()->json(['message' => 'Privilege terminated']);
    }
}
