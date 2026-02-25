<?php

namespace App\Domains\Security\Controllers\Api;

use App\Domains\Audit\Services\AdminAuditService;
use App\Domains\Security\Models\AuthPolicy;
use App\Domains\Security\Models\MFAPolicy;
use App\Domains\Security\Models\TokenPolicy;
use App\Domains\Security\Models\User;
use App\Domains\Security\Models\UserSession;
use App\Domains\Security\Rules\DynamicPasswordRule;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Wallet;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use Twilio\Rest\Client;
use Tymon\JWTAuth\Facades\JWTAuth;

// Or GdImageBackEnd if Imagick is not installed

class AuthController extends Controller
{
    protected $audit;

    public function __construct(AdminAuditService $audit)
    {
        $this->audit = $audit;
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'string', 'confirmed', new DynamicPasswordRule],
            'fingerprint' => 'required|string',
            'device_name' => 'required|string',
            'os_version' => 'nullable|string',
            'app_version' => 'nullable|string',
            'is_rooted' => 'nullable|boolean',

        ]);

        DB::transaction(function () use ($request, &$user, &$token) {

            $user = User::create([
                'name' => $request->first_name.' '.$request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Wallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'currency' => 'PKR',
            ]);
            $this->resolveDevice($user, $request);
            // JWT generate
            $token = JWTAuth::fromUser($user);

            // Token payload (jti)
            $payload = JWTAuth::setToken($token)->getPayload();
            $jwtId = $payload->get('jti') ?? (string) Str::uuid();

            // 🔥 SESSION STORE
            $this->createSession($user, $token, $jwtId, $request);
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
            'fingerprint' => 'required|string',
            'device_name' => 'required|string',
            'os_version' => 'nullable|string',
            'app_version' => 'nullable|string',
            'is_rooted' => 'nullable|boolean',
        ]);

        $login = $request->login;
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $fieldType => $login,
            'password' => $request->password,
        ];

        $jwtId = (string) Str::uuid();
        if (! $token = JWTAuth::claims([
            'jti' => $jwtId,
        ])->attempt($credentials)) {

            $this->audit->log([
                'action_type' => 'login_failed',
                'target_type' => 'User',
                'target_id' => null,
                'before_state' => null,
                'after_state' => [
                    'login' => $request->login,
                    'ip' => $request->ip(),
                ],
                'reason_code' => 'Invalid credentials',
            ]);

            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        // ✅ NOW user exists
        $user = auth()->user();
        // $device = Auth($user, $request);
        /* 🔐 Resolve scopes AFTER authentication */
        $scopes = $this->resolveScopes($user);
        /* 🔄 Re-issue token WITH role + scopes */
        $token = JWTAuth::claims([
            'jti' => $jwtId,
            'role' => $user->role,
            'scopes' => $scopes,
        ])->fromUser($user);

        /* =======================
         | AUTH GOVERNANCE CHECKS
         ======================= */

        $authPolicy = AuthPolicy::current();
        /**
         * 1️⃣ Account status
         */
        if ($user->status !== 'active') {
            return response()->json(['error' => 'Account inactive'], 403);
        }
        /**
         * 2️⃣ LOGIN RULES (JSON BASED – ROLE + TIME)
         */
        $rules = $authPolicy->login_rules ?? [];
        $role = $user->role;
        $now = now()->format('H:i');
        // Role specific rule
        if (isset($rules['roles'][$role])) {

            $roleRule = $rules['roles'][$role];

            // Role blocked
            if (($roleRule['allowed'] ?? true) === false) {
                return response()->json(['error' => 'Login not allowed for this role'], 403);
            }

            // Role time window
            if (isset($roleRule['time'])) {
                if (
                    $now < $roleRule['time']['from'] ||
                    $now > $roleRule['time']['to']
                ) {
                    return response()->json(['error' => 'Login not allowed at this time'], 403);
                }
            }

        }
        // Default rule
        elseif (isset($rules['default']['time'])) {

            if (
                $now < $rules['default']['time']['from'] ||
                $now > $rules['default']['time']['to']
            ) {
                return response()->json(['error' => 'Login not allowed at this time'], 403);
            }
        }
        /**
         * 3️⃣ Force password reset
         */
        if ($user->force_password_reset) {
            return response()->json([
                'status' => 'password_reset_required',
                'message' => 'Password reset required by security policy',
            ], 403);
        }
        /**
         * 4️⃣ MFA POLICY (CONFIG DRIVEN)
         */
        $mfaPolicy = MFAPolicy::current();
        $mfaRequired = false;

        if ($mfaPolicy->enforcement_policy === 'all_users') {
            $mfaRequired = true;
        }

        if (
            $mfaPolicy->enforcement_policy === 'admins_only' &&
            $user->hasRole(['Admin', 'Super Admin'])
        ) {
            $mfaRequired = true;
        }

        if ($mfaRequired) {

            if ($user->is_2fa_enabled) {
                return response()->json([
                    'status' => '2fa_required',
                    'email' => $user->email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                ]);
            }

            return response()->json([
                'status' => 'enable_2fa',
                'message' => 'Two-factor authentication is required.',
                'access_token' => $token,
            ]);
        }

        /**
         * 5️⃣ Create session (NORMAL USERS)
         */
        $this->createSession($user, $token, $jwtId, $request);
        // 🔐 AUDIT LOG — LOGIN SUCCESS
        $this->audit->log([
            'action_type' => 'login_success',
            'target_type' => 'User',
            'target_id' => $user->id,
            'before_state' => null,
            'after_state' => [
                'device' => $request->device_name,
                'ip' => $request->ip(),
            ],
            'reason_code' => 'User login successful',
        ]);
        $policy = TokenPolicy::current();

        $ttl = $policy->access_token_ttl_minutes;

        auth()->factory()->setTTL($ttl);

        return $this->respondWithToken($token);
    }

    protected function resolveDevice(User $user, Request $request)
    {
        $fingerprint = $request->fingerprint;

        $device = \App\Domains\Security\Models\Device::where('fingerprint', $fingerprint)->first();

        if ($device) {
            // Existing device → update last seen
            $device->update([
                'last_ip' => $request->ip(),
                'last_seen_at' => now(),
            ]);

            return $device;
        }

        // New device
        return \App\Domains\Security\Models\Device::create([
            'user_id' => $user->id,
            'device_name' => $request->device_name,
            'fingerprint' => $fingerprint,
            'os_version' => $request->os_version,
            'app_version' => $request->app_version,
            'last_ip' => $request->ip(),
            'trust_status' => 'unverified',
            'last_seen_at' => now(),
            'is_rooted' => $request->is_rooted ?? false,
        ]);
    }

    protected function resolveScopes($user): array
    {
        if ($user->hasRole('Super Admin')) {
            return ['admin:*'];
        }

        if ($user->hasRole('Admin')) {
            return ['manage:users', 'manage:settings'];
        }

        return ['read:basic'];
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
                        'revoked_at' => now(),

                    ]);
                // 🔐 AUDIT LOG — LOGOUT
                $this->audit->log([
                    'action_type' => 'logout',
                    'target_type' => 'User',
                    'target_id' => auth()->id(),
                    'before_state' => [
                        'jwt_id' => $jti,
                    ],
                    'after_state' => [
                        'revoked' => true,
                    ],
                    'reason_code' => 'User initiated logout',
                ]);
            }
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

    // javed
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

        if (! $google2fa->verifyKey($user->google2fa_secret, $request->otp)) {
            return response()->json(['error' => 'Invalid OTP'], 401);
        }

        if (! $user->is_2fa_enabled) {
            $user->is_2fa_enabled = true;
            $user->save();
        }

        $policy = TokenPolicy::current();

        // ✅ SET TTL BEFORE TOKEN GENERATION
        auth()->factory()->setTTL($policy->access_token_ttl_minutes);

        $jwtId = (string) Str::uuid();

        $token = JWTAuth::claims([
            'jti' => $jwtId,
            'role' => $user->getRoleNames()->first(), // ✅ FIX
            'roles' => $user->getRoleNames()->toArray(),
            'scopes' => $this->resolveScopes($user),
        ])->fromUser($user);
        // dd(JWTAuth::setToken($token)->getPayload());

        // DO NOT use login() here

        $this->createSession($user, $token, $jwtId, $request);
        $this->audit->log([
            'action_type' => '2fa_verified',
            'target_type' => 'User',
            'target_id' => $user->id,
            'reason_code' => 'MFA verification successful',
        ]);

        return response()->json([
            'status' => 'success',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $user,
        ]);
    }

    // public function verify2FA(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'otp' => 'required',
    //     ]);

    //     $policy = TokenPolicy::current();

    //     auth()->factory()->setTTL($policy->access_token_ttl_minutes);

    //     $user = User::where('email', $request->email)->first();
    //     if (! $user) {
    //         return response()->json(['error' => 'User not found'], 404);
    //     }

    //     $google2fa = new Google2FA;
    //     $valid = $google2fa->verifyKey($user->google2fa_secret, $request->otp);

    //     if (! $valid) {
    //         return response()->json(['error' => 'Invalid OTP'], 401);
    //     }

    //     // Enable 2FA after first successful verification
    //     if (! $user->is_2fa_enabled) {
    //         $user->is_2fa_enabled = 1;
    //         $user->save();
    //     }
    //     auth()->login($user);
    //     $jwtId = (string) Str::uuid();
    //     $scopes = $this->resolveScopes($user);

    //     $token = JWTAuth::claims([
    //         'jti' => $jwtId,
    //         'role' => $user->role,
    //         'scopes' => $scopes,
    //         'mfa_verified' => true,
    //     ])->fromUser($user);
    //     // $token = JWTAuth::claims(['jti' => $jwtId,])->fromUser($user);

    //     // Create user session after successful 2FA
    //     $this->createSession($user, $token, $jwtId, $request);

    //     return response()->json([
    //         'status' => 'success',
    //         'token' => $token,
    //         'user' => $user,
    //     ]);
    // }

    /**
     * Helper: Create User Session
     */
    protected function createSession(User $user, $token, $jwtId, Request $request)
    {
        $policy = TokenPolicy::current();

        $device = $this->resolveDevice($user, $request);
        // dd($device);
        // 🌍 Resolve Geo From IP
        $ip = $request->ip();
        if (app()->environment('local') && ($ip === '127.0.0.1' || $ip === '::1')) {
            $ip = '8.8.8.8'; // Google DNS (USA)

        }
        try {
            $geo = geoip($ip);

            $country = $geo->iso_code ?? null;
            $city = $geo->city ?? null;
            $latitude = $geo->lat ?? null;
            $longitude = $geo->lon ?? null;

            $location = $city && $country
                ? $city.', '.$country
                : $country;

        } catch (\Exception $e) {
            $country = null;
            $latitude = null;
            $longitude = null;
            $location = null;
        }

        UserSession::create([
            'user_id' => $user->id,
            'jwt_id' => $jwtId,
            'token' => hash('sha256', $token),
            'device' => $device->device_name,
            'device_id' => $device->id,
            'ip_address' => $ip,
            'country' => $country,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'location' => $location,
            'risk_score' => 0,
            'last_activity_at' => now(),
            'mfa_verified' => 1,
            'expires_at' => now()->addMinutes(
                $policy->access_token_ttl_minutes
            ),

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
            if ($user->image && \Storage::exists('public/profile_images/'.$user->image)) {
                \Storage::delete('public/profile_images/'.$user->image);
            }

            // Save new image
            $file = $request->file('image');
            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

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
                    ? asset('storage/profile_images/'.$user->image)
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

    public function rotateToken($jti)
    {
        $session = UserSession::where('jwt_id', $jti)->firstOrFail();
        // dd($session);
        // revoke old
        $session->update([
            'is_revoked' => true,
            'revoked_at' => now(),
        ]);

        // issue new token
        $newJti = Str::uuid();
        $user = auth()->user();

        $newToken = JWTAuth::claims([
            'jti' => $newJti,
            'role' => $user->role,
            'scopes' => $this->resolveScopes($user),
        ])->fromUser($user);

        $this->createSession($user, $newToken, $newJti, request());

        return response()->json([
            'message' => 'Token rotated',
            'access_token' => $newToken,
        ]);
    }

    public function revokeToken($jti)
    {
        $session = UserSession::where('jwt_id', $jti)->firstOrFail();

        $session->update([
            'is_revoked' => true,
            'revoked_at' => now(),
        ]);

        return response()->json([
            'message' => 'Token revoked successfully',
        ]);
    }
}
