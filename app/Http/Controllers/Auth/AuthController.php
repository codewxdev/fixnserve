<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;
use Twilio\Rest\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
use BaconQrCode\Renderer\Image\GdImageBackend; // Or GdImageBackEnd if Imagick is not installed
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;


use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'user' => $user,
            'access_token' => $token,
        ], 201);
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

        if ($user->hasRole(['Admin', 'Super Admin'])) {

            if ($user->is_2fa_enabled) {
                return response()->json([
                    'status' => '2fa_required',
                    'email' => $user->email,
                    'access_token' => $token,
                    'message' => 'Admin 2FA verification required.',
                ]);
            }

            // If admin 2FA is NOT enabled → force enable
            return response()->json([
                'status' => 'enable_2fa',
                'message' => 'Admin account must enable 2FA.',
                'access_token' => $token,
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

    // Add the necessary use statements at the top of your controller file
    // Added for optional debugging

    public function enable2FA(Request $request)
    {
        // dd($request->all());
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
            'status'=>'setup_initiated',
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
            'gender' => 'nullable|string',
            'current_address' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);

        if (isset($validated['phone'])) {

            if (is_null($user->phone)) {
                // Pehli dafa phone add ho raha hai → OTP bhejo
                $user->pending_phone = $validated['phone'];

                // Random OTP generate
                $otp = rand(100000, 999999);

                $user->phone_otp = $otp;
                // sendOtpSMS($validated['phone'], $otp);

                // Yahan SMS gateway (Twilio / local API) call karna hota hai
                // SMS::send($validated['phone'], "Your OTP: $otp");

            } else {
                // Phone already exists → update NAHI hoga
                unset($validated['phone']);
            }
        }

        if ($request->hasFile('image')) {

            // Delete old image if exists
            if ($user->image && \Storage::exists('public/profile_images/' . $user->image)) {
                \Storage::delete('public/profile_images/' . $user->image);
            }

            // Save new image
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/profile_images/', $filename);

            $user->image = $filename;
        }

        foreach ($validated as $key => $value) {
            if (! is_null($value) && $key !== 'image') {   // Only update if value provided
                $user->{$key} = $value;
            }
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully!',
            'data' => [
                'user' => $user,
                'profile_image_url' => $user->image
                    ? asset('storage/profile_images/' . $user->image)
                    : null,
            ],
        ]);
    }

    public function verifyPhoneOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $user = auth()->user();

        if ($user->phone_otp != $request->otp) {
            return response()->json([
                'message' => 'Invalid OTP',
            ], 422);
        }

        // Successful verification
        $user->phone = $user->pending_phone;
        $user->pending_phone = null;
        $user->phone_otp = null;
        $user->phone_verified_at = now();
        $user->save();

        return response()->json([
            'message' => 'Phone verified successfully!',
            'data' => $user,
        ]);
    }

    public function sendOtpSMS($phone, $otp)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $twilio = new Client($sid, $token);

        $twilio->messages->create($phone, [
            'from' => env('TWILIO_NUMBER'),
            'body' => "Your verification code is: $otp",
        ]);
    }
}
