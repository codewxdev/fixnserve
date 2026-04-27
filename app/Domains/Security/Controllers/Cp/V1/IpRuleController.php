<?php

namespace App\Domains\Security\Controllers\Cp\V1;

use App\Domains\Audit\Services\SecurityAuditService;
use App\Domains\Security\Models\IpRule;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class IpRuleController extends BaseApiController
{
    protected $securityAudit;

    public function __construct(SecurityAuditService $securityAudit)
    {
        $this->securityAudit = $securityAudit;
    }

    public function index()
    {
        $iprules = IpRule::latest()->get();

        return $this->success(['iprules' => $iprules]);
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

        $ipRule = IpRule::create($data);

        return $this->success(['ipRule' => $ipRule], 'IP rule created successfully');
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

        return $this->success(['ipRule' => $ipRule], 'IP rule updated successfully');
    }

    public function destroy($id)
    {
        $ipRule = IpRule::findOrFail($id);
        if (! $ipRule) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $ipRule->delete();

        return $this->success(null, 'IP rule deleted successfully');
    }
}
