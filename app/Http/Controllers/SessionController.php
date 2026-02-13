<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSession;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * 1️⃣ List Active Sessions
     * GET /api/sessions
     */
    public function index(Request $request)
    {
        $sessions = UserSession::with('user')
            ->whereNull('logout_at')
            ->when($request->user_id, fn ($q) => $q->where('user_id', $request->user_id))
            ->when($request->role, fn ($q) => $q->where('role', $request->role))
            ->when($request->region, fn ($q) => $q->where('region', $request->region))
            ->latest('last_activity')
            ->get();

        return response()->json($sessions);
    }

    /**
     * 2️⃣ View Session Details
     * GET /api/sessions/{id}
     */
    public function show($id)
    {
        $session = UserSession::with('user')->findOrFail($id);

        return response()->json($session);
    }

    /**
     * 3️⃣ Revoke Single Session
     * POST /api/sessions/{id}/revoke
     */
    public function revoke($id)
    {
        $session = UserSession::findOrFail($id);

        $this->revokeSession($session);

        return response()->json([
            'message' => 'Session revoked successfully',
        ]);
    }

    /**
     * 4️⃣ Revoke All Sessions for a User
     * POST /api/sessions/revoke-all
     */
    public function revokeAll(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        UserSession::where('user_id', $request->user_id)
            ->whereNull('logout_at')
            ->each(fn ($session) => $this->revokeSession($session));

        return response()->json([
            'message' => 'All user sessions revoked',
        ]);
    }

    /**
     * 5️⃣ Force Logout by Role
     * POST /api/sessions/revoke-role
     */
    public function revokeByRole(Request $request)
    {
        $request->validate([
            'role' => 'required|string',
        ]);

        UserSession::where('role', $request->role)
            ->whereNull('logout_at')
            ->each(fn ($session) => $this->revokeSession($session));

        return response()->json([
            'message' => "All {$request->role} sessions revoked",
        ]);
    }

    /**
     * 6️⃣ Force Logout by Region
     * POST /api/sessions/revoke-region
     */
    public function revokeByRegion(Request $request)
    {
        $request->validate([
            'region' => 'required|string',
        ]);

        UserSession::where('region', $request->region)
            ->whereNull('logout_at')
            ->each(fn ($session) => $this->revokeSession($session));

        return response()->json([
            'message' => "All sessions in {$request->region} revoked",
        ]);
    }

    /**
     * 7️⃣ Flag Session (Risk)
     * POST /api/sessions/{id}/flag
     */
    public function flag($id)
    {
        $session = UserSession::findOrFail($id);

        $session->update([
            'risk_score' => 'high',
        ]);

        return response()->json([
            'message' => 'Session flagged as high risk',
        ]);
    }

    /**
     * 🔒 Central Revoke Logic
     */
    private function revokeSession(UserSession $session)
    {
        $session->update([
            'is_revoked' => true,
            'logout_at' => now(),
        ]);

        // Optional: Add to blacklist (Redis / DB)
        cache()->put(
            "jwt_blacklist:{$session->jwt_id}",
            true,
            now()->addSeconds(config('jwt.ttl') * 60)
        );
    }
}
