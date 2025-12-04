<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;
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

        if ($user->is_2fa_enabled) {
            return response()->json([
                'status' => '2fa_required',
                'email' => $user->email,
            ]);
        }

        return $this->respondWithToken($token);

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

    public function enable2FA(Request $request)
    {
        $google2fa = new Google2FA;

        $secret = $google2fa->generateSecretKey();

        // Save to DB
        $user = $request->user();
        $user->google2fa_secret = $secret;
        $user->is_2fa_enabled = false; // OTP verify hone ke baad 1
        $user->save(); // important!

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            'FixnServe',
            $request->user()->email,
            $secret
        );

        return response()->json([
            'secret' => $secret,
            'qrcode_url' => $qrCodeUrl,
        ]);
    }

    public function verify2FA(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $google2fa = new Google2FA;

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->otp);

        if (! $valid) {
            return response()->json(['error' => 'Invalid OTP'], 401);
        }

        // ✅ OTP valid → enable 2FA for future logins
        if (! $user->is_2fa_enabled) {
            $user->is_2fa_enabled = 1;
            $user->save();
        }

        // OTP valid → JWT generate
        $token = auth()->login($user);

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => $user,
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
}
