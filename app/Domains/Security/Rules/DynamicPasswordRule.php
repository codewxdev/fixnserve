<?php

namespace App\Domains\Security\Rules;

use App\Domains\Security\Models\PasswordPolicy;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DynamicPasswordRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $policy = PasswordPolicy::current();

        if (strlen($value) < $policy->min_length) {
            $fail("Password must be at least {$policy->min_length} characters long.");

            return;
        }

        if ($policy->require_uppercase && ! preg_match('/[A-Z]/', $value)) {
            $fail('Password must contain at least one uppercase letter.');

            return;
        }

        if ($policy->require_symbols && ! preg_match('/[@$!%*#?&]/', $value)) {
            $fail('Password must contain at least one symbol.');

            return;
        }

        if (! preg_match('/\d/', $value)) {
            $fail('Password must contain at least one number.');
        }
    }
}
