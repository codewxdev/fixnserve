<?php

namespace App\Domains\Security\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return ['status' => false, 'message' => 'Invalid Credentials'];
        }

        // mobile API needs token
        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'status' => true,
            'token' => $token,
            'user'  => $user
        ];
    }
}
