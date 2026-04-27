<?php

namespace App\Domains\Security\Controllers\Cp\V1;

use App\Domains\Security\Models\AuthPolicy;
use App\Domains\Security\Models\MFAPolicy;
use App\Domains\Security\Models\PasswordPolicy;
use App\Domains\Security\Models\User;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class AuthGovernanceController extends BaseApiController
{
    public function index()
    {
        return $this->success([
            'auth_policy' => AuthPolicy::current(),
            'mfa_policy' => MFAPolicy::current(),
            'password_policy' => PasswordPolicy::current(),
        ], 'security_policies_fetched');
    }

    public function updateLoginMethods(Request $request)
    {
        $data = $request->validate([
            'email_password' => 'required|boolean',
            'phone_otp' => 'required|boolean',
            'oauth' => 'required|boolean',
            'login_rules' => 'nullable|array',
        ]);

        AuthPolicy::current()->update([
            'login_email_password' => $data['email_password'],
            'login_phone_otp' => $data['phone_otp'],
            'login_oauth' => $data['oauth'],
            'login_rules' => $data['login_rules'] ?? null,
        ]);

        return $this->success([], 'login_methods_updated');
    }

    public function updateMFA(Request $request)
    {
        $data = $request->validate([
            'enforcement' => 'required|in:off,admins_only,all_users',
            'methods' => 'required|array',
            'methods.*' => 'in:totp,email,sms',
        ]);

        MFAPolicy::current()->update([
            'enforcement_policy' => $data['enforcement'],
            'allowed_methods' => $data['methods'],
        ]);

        return $this->success([], 'mfa_policy_updated');
    }

    public function updatePasswordRules(Request $request)
    {
        $data = $request->validate([
            'min_length' => 'required|integer|min:6|max:64',
            'uppercase' => 'boolean',
            'symbols' => 'boolean',
            'prevent_reuse' => 'boolean',
            'check_breached' => 'boolean',
            'rotation_after_90days' => 'boolean',
        ]);

        PasswordPolicy::current()->update([
            'min_length' => $data['min_length'],
            'require_uppercase' => $data['uppercase'] ?? false,
            'require_symbols' => $data['symbols'] ?? false,
            'prevent_reuse' => $data['prevent_reuse'] ?? false,
            'check_breached' => $data['check_breached'] ?? false,
            'force_rotation_days' => $data['rotation_after_90days'] ?? null,
        ]);

        return $this->success([], 'password_rules_updated');
    }

    public function forcePasswordReset()
    {
        User::query()->update([
            'force_password_reset' => true,
        ]);

        return $this->success([], 'password_reset_forced');
    }
}
