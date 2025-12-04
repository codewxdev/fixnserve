<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->first_name + $request->last_name,
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
        $agent = $request->header('User-Agent');
        $device = 'Unknown';
        $platform = 'Unknown';
        $browser = 'Unknown';

        if ($agent) {
            $agentParser = new \Jenssegers\Agent\Agent;
            $agentParser->setUserAgent($agent);
            $device = $agentParser->device();
            $platform = $agentParser->platform();
            $browser = $agentParser->browser();
        }

        // Save login history
        LoginHistory::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $agent,
            'device' => $device,
            'platform' => $platform,
            'browser' => $browser,
            'token' => $token,
            'login_at' => now(),
        ]);

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

    public function logout(Request $request)
    {
        $user = auth()->user();
        $token = $request->bearerToken();

        // Update logout_at
        LoginHistory::where('user_id', $user->id)
            ->where('token', $token)
            ->latest()
            ->update(['logout_at' => now()]);
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

    public function loginHistory(Request $request)
    {
        $user = auth()->user();
        $history = $user->loginHistories()->orderBy('login_at', 'desc')->get();

        return response()->json($history);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'current_address' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user,
        ]);
    }
}
