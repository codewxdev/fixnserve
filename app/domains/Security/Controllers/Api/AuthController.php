<?php

namespace App\Domains\Security\Controllers\Api;

use App\Domains\Security\Models\User;
use App\Domains\Security\Models\UserSession;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use PragmaRX\Google2FA\Google2FA;
use Twilio\Rest\Client;
use Tymon\JWTAuth\Facades\JWTAuth; // Or GdImageBackEnd if Imagick is not installed

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).+$/',
            ],
        ]);

        DB::transaction(function () use ($request, &$user, &$token) {

            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Wallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'currency' => 'PKR',
            ]);

            // JWT generate
            $token = JWTAuth::fromUser($user);

            // Token payload (jti)
            $payload = JWTAuth::setToken($token)->getPayload();

            // 🔥 SESSION STORE

            UserSession::create([
                'user_id' => $user->id,
                'jwt_id' => $payload->get('jti'),
                'token' => hash('sha256', $token),
                'device' => $request->header('User-Agent'),
                'ip_address' => $request->ip(),
                'location' => null,
                'risk_score' => 0,
                'last_activity_at' => now(),
            ]);
        });

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'user' => $user,
            'access_token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $login = $request->login;
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $fieldType => $login,
            'password' => $request->password,
        ];

        $jwtId = (string) Str::uuid();

        if (! $token = JWTAuth::claims(['jti' => $jwtId])->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = auth()->user();

        // For Admin / Super Admin – 2FA
        if ($user->hasRole(['Admin', 'Super Admin'])) {
            if ($user->is_2fa_enabled) {
                // Return 2FA required response; do NOT create session yet
                return response()->json([
                    'status' => '2fa_required',
                    'email' => $user->email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                ]);
            }

            // Admin without 2FA enabled
            return response()->json([
                'status' => 'enable_2fa',
                'message' => 'Admin account must enable 2FA.',
                'access_token' => $token,
            ]);
        }

        // Normal user – create session immediately
        $this->createSession($user, $token, $jwtId, $request);

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout(Request $request)
    {

        $token = $request->bearerToken();

        if (! $token) {
            return response()->json(['message' => 'Token not provided'], 400);
        }

        try {
            // Get JWT payload
            $payload = JWTAuth::setToken($token)->getPayload();
            $jti = $payload->get('jti');

            // Revoke the token in UserSession
            if ($jti) {
                UserSession::where('jwt_id', $jti)
                    ->whereNull('logout_at')
                    ->update([
                        'logout_at' => now(),
                        'is_revoked' => true,
                    ]);
            }

            // Update the latest login history
            // $user = auth()->user();
            // if ($user) {
            //     $lastLogin = LoginHistory::where('user_id', $user->id)
            //         ->where('token', $token)
            //         ->latest()
            //         ->first();

            //     if ($lastLogin) {
            //         $lastLogin->update(['logout_at' => now()]);
            //     }
            // }

            // Log out the user from auth
            auth()->logout();

            return response()->json(['message' => 'Logged out successfully']);

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['message' => 'Token has expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['message' => 'Invalid token'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Logout failed', 'error' => $e->getMessage()], 500);
        }
    }

    //javed
    // public function logout(Request $request)
    // {
    //     // 1. Token get karein
    //     $token = $request->bearerToken();

    //     if (! $token) {
    //         return response()->json(['message' => 'Token not provided'], 400);
    //     }

    //     // --- MAIN FIX IS HERE ---

    //     // 2. Token ka Hash banayen (Kyunki DB mein hash saved hai)
    //     // Hum JTI decode nahi karenge, kyunki agar token expired hua to wo crash ho jayega.
    //     $hashedToken = hash('sha256', $token);

    //     // 3. Database mein Session ko "Logged Out" mark karein
    //     UserSession::where('token', $hashedToken)
    //         ->whereNull('logout_at')
    //         ->update([
    //             'logout_at' => now(),
    //             'is_revoked' => true,
    //         ]);

    //     // 4. JWT Token ko Blacklist karein (Optional but Recommended)
    //     try {
    //         auth()->logout(); // Ye token ko invalid kar dega
    //     } catch (\Exception $e) {
    //         // Agar token pehly se expired hai to koi masla nahi, 
    //         // humne DB update kar diya hai, wo zaroori tha.
    //     }

    //     return response()->json(['message' => 'Logged out successfully']);
    // }
    
    public function refresh()
    {
        return response()->json(['token' => auth()->refresh()]);
    }

    public function enable2FA(Request $request)
    {
        $google2fa = new Google2FA;

        $secret = $google2fa->generateSecretKey();

        $user = $request->user();
        $user->google2fa_secret = $secret;
        $user->is_2fa_enabled = false; // will be set true after OTP verify
        $user->save();

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            'FixnServe',
            $user->email,
            $secret
        );

        return response()->json([
            'status' => 'setup_initiated',
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

        // Enable 2FA after first successful verification
        if (! $user->is_2fa_enabled) {
            $user->is_2fa_enabled = 1;
            $user->save();
        }

        $jwtId = (string) Str::uuid();
        $token = JWTAuth::claims(['jti' => $jwtId])->fromUser($user);

        // Create user session after successful 2FA
        $this->createSession($user, $token, $jwtId, $request);

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => $user,
        ]);
    }

    /**
     * Helper: Create User Session
     */
    protected function createSession(User $user, $token, $jwtId, Request $request)
    {
        $agent = new Agent;
        $agent->setUserAgent($request->userAgent());

        UserSession::create([
            'user_id' => $user->id,
            'jwt_id' => $jwtId,
            'token' => hash('sha256', $token),
            'device' => $agent->device() ?: 'Unknown',
            'ip_address' => $request->ip(),
            'location' => null,
            'risk_score' => 0,
            'last_activity_at' => now(),
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

    // public function loginHistory(Request $request)
    // {
    //     $user = auth()->user();
    //     $history = $user->loginHistories()->orderBy('login_at', 'desc')->get();

    //     return response()->json($history);
    // }

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
            'country_id' => 'nullable|integer|exists:countries,id', // Added country_id
            'phone' => 'nullable|string|regex:/^[0-9]+$/',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);
        if (! empty($validated['phone']) && ! empty($validated['country_id'])) {

            $country = Country::find($validated['country_id']);

            if ($country && strlen($validated['phone']) != $country->phone_length) {
                return response()->json([
                    'status' => false,
                    'message' => "Phone number must be {$country->phone_length} digits for selected country.",
                ], 422);
            }
        }
        if (isset($validated['phone'])) {

            if (is_null($user->phone)) {

                $user->pending_phone = $validated['phone'];

                $otp = rand(100000, 999999);
                $user->phone_otp = $otp;

                // sendOtpSMS($validated['phone'], $otp);

            } else {
                // Phone already exists → don't update
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
