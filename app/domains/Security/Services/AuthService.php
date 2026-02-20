<?php

namespace App\Domains\Security\Services;

use App\Domains\Security\Models\Device;
use App\Domains\Security\Models\DevicePolicy;
use App\Domains\Security\Models\User;
use Illuminate\Http\Request;
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
            'user' => $user,
        ];
    }

    public function handleDevice(User $user, Request $request)
    {
        $devicePolicy = DevicePolicy::first();
        $fingerprint = $request->fingerprint;

        if (! $fingerprint) {
            throw new \Exception('Device fingerprint missing');
        }

        $device = Device::where('user_id', $user->id)
            ->where('fingerprint', $fingerprint)
            ->first();

        // 🔹 New Device
        if (! $device) {

            if ($devicePolicy->block_rooted_devices && $request->is_rooted) {
                abort(403, 'Rooted device not allowed');
            }

            $device = Device::create([
                'user_id' => $user->id,
                'fingerprint' => $fingerprint,
                'device_name' => $request->device_name,
                'os_version' => $request->os_version,
                'app_version' => $request->app_version,
                'last_ip' => $request->ip(),
                'last_seen_at' => now(),
                'trust_status' => $devicePolicy->require_otp_new_device ? 'unverified' : 'trusted',
                'trusted_at' => $devicePolicy->require_otp_new_device ? null : now(),
            ]);

            if ($devicePolicy->require_otp_new_device) {
                abort(403, 'New device detected. Verification required.');
            }

        } else {

            // 🚫 Block banned device
            if ($device->trust_status === 'banned') {
                abort(403, 'Device banned');
            }

            $device->update([
                'last_seen_at' => now(),
                'last_ip' => $request->ip(),
            ]);
        }

        return $device;
    }
}
