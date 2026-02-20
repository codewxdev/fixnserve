<?php

namespace App\Domains\Security\Controllers\Api;

use App\Domains\Security\Models\UserSession;
use App\Http\Controllers\Controller;
use App\Models\BlacklistedToken;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * 1️⃣ List Active Sessions
     * GET /api/sessions
     */
    public function index(Request $request)
    {
        $sessions = UserSession::with('user')->get();

            // ->whereNull('logout_at')
            // ->when($request->user_id, fn ($q) => $q->where('user_id', $request->user_id))
            // ->when($request->role, fn ($q) => $q->where('role', $request->role))
            // ->when($request->region, fn ($q) => $q->where('region', $request->region))
            // ->latest('last_activity_at')

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

        $user = UserSession::where('user_id', $request->user_id)
            ->whereNull('logout_at')->each(fn ($session) => $this->revokeSession($session));

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

        UserSession::with('user') // load related user
            ->whereNull('logout_at')
            ->get()
            ->each(function ($session) use ($request) {
                // Check role
                if ($session->user && $session->user->role === $request->role) {
                    // Skip Super Admin (optional)
                    if ($session->user->role !== 'Super Admin') {
                        $this->revokeSession($session);
                    }
                }
            });

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
    public function flag(Request $request, $id)
    {
        $request->validate([
            'risk_score' => 'required|integer|min:0|max:100',
        ]);

        $session = UserSession::findOrFail($id);

        $session->update([
            'risk_score' => $request->risk_score,
        ]);

        return response()->json([
            'message' => 'Session risk score updated',
            'risk_score' => $request->risk_score,
        ]);
    }

    /**
     * 🔒 Central Revoke Logic
     */
    private function revokeSession(UserSession $session)
    {
        // Super Admin session ko skip karna
        if ($session->user->roles === 'Super Admin') {
            return; // kuch bhi revoke nahi
        }

        // Get token expiry from JWT
        $expiresAt = $session->expires_at;

        // Store in DB blacklist
        BlacklistedToken::updateOrCreate(
            ['jwt_id' => $session->jwt_id],
            [
                'expires_at' => $expiresAt,
            ]
        );

        // Update session
        $session->update([
            'is_revoked' => true,
            'revoked_at' => now(),
            'logout_at' => now(),
        ]);
    }
}
