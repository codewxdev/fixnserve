<?php

namespace App\Domains\Security\Controllers\Api;

use App\Domains\Audit\Services\SecurityAuditService;
use App\Domains\Security\Models\IpRule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IpRuleController extends Controller
{
    protected $securityAudit;

    public function __construct(SecurityAuditService $securityAudit)
    {
        $this->securityAudit = $securityAudit;
    }

    public function index()
    {
        $iprules = IpRule::latest()->get();

        return response()->json($iprules);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cidr' => 'required|string',
            'type' => 'required|in:allow,deny',
            'applies_to' => 'nullable|string',
            'comment' => 'nullable|string',
            'expires_at' => 'nullable|date',
        ]);

        return IpRule::create($data);
    }

    public function update(Request $request, $id)
    {
        $ipRule = IpRule::findOrFail($id);

        // 🔹 Capture BEFORE state
        $beforeState = $ipRule->toArray();

        $data = $request->validate([
            'cidr' => 'nullable|string',
            'type' => 'nullable|in:allow,deny',
            'applies_to' => 'nullable|string',
            'comment' => 'nullable|string',
            'expires_at' => 'nullable|date',
            'reason_code' => 'required|string|min:3', // mandatory for audit
        ]);

        $ipRule->update($data);

        // 🔹 Capture AFTER state
        $afterState = $ipRule->fresh()->toArray();

        // 🔐 SECURITY AUDIT
        $this->securityAudit->log(
            'ip_rule_updated',
            [
                'ip_rule_id' => $ipRule->id,
                'cidr' => $ipRule->cidr,
                'type' => $ipRule->type,
                'applies_to' => $ipRule->applies_to,
                'comment' => $ipRule->comment,
                'expires_at' => $ipRule->expires_at,
            ],
            auth()->user(),      // Actor
            $beforeState,
            $afterState,
            $data['reason_code']  // Reason code
        );

        return response()->json([
            'status' => true,
            'message' => 'IP rule updated successfully',
            'data' => $afterState,
        ]);
    }

    public function destroy($id)
    {
        $ipRule = IpRule::findOrFail($id);
        if (! $ipRule) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $ipRule->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
