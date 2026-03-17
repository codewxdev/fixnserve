<?php

namespace App\Domains\System\Controllers\Api;

use App\Domains\System\Models\DualApprovalRule;
use App\Http\Controllers\BaseApiController;

class DualApprovalRuleController extends BaseApiController
{
    // ✅ GET all rules
    public function index()
    {
        $rules = DualApprovalRule::all();

        return $this->success($rules, 'approval_rules_fetched');
    }

    // ✅ PATCH toggle rule ON/OFF
    public function toggle(DualApprovalRule $rule)
    {
        $rule->update([
            'requires_approval' => ! $rule->requires_approval,
        ]);

        return $this->success([
            'id' => $rule->id,
            'setting_key' => $rule->setting_key,
            'setting_label' => $rule->setting_label,
            'requires_approval' => $rule->requires_approval,
            'message' => $rule->requires_approval
                ? "✅ {$rule->setting_label} now requires dual approval"
                : "⚠️ {$rule->setting_label} dual approval disabled",
        ], 'approval_rule_toggled');
    }
}
