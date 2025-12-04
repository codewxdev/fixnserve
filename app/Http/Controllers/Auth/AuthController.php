<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        
        $user = auth()->user();
        // Get user roles and permissions
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions()->pluck('name');
        // Check if user is Super Admin
        $isSuperAdmin = $user->hasRole('Super Admin');
        // $isAdmin = $user->hasRole('Admin');

        // Create custom claims based on roles
        $customClaims = [
            'roles' => $roles,
            'permissions' => $permissions,
            'is_super_admin' => $isSuperAdmin,
            'user_id' => $user->id,
        ];

        // Generate token with custom claims
        $tokenWithClaims = JWTAuth::claims($customClaims)->fromUser($user);

        // Return response based on role
        $response = [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $roles,
                'is_super_admin' => $isSuperAdmin,
            ],
            'token' => $tokenWithClaims,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ];

        // Add extra data for Super Admin
        if ($isSuperAdmin) {
            $response['admin_access'] = true;
            $response['access_level'] = 'super_admin';

        }
 
        return response()->json(['status'=>true, $response]);

    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Logged out']);
    }

    public function refresh()
    {
        return response()->json(['token' => auth()->refresh()]);
    }
}
