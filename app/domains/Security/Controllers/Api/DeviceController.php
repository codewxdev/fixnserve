<?php

namespace App\Domains\Security\Controllers\Api;

use App\Domains\Security\Models\Device;
use App\Domains\Security\Models\DevicePolicy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    // 1. Get current device policies
    public function getPolicies()
    {
        $policy = DevicePolicy::first();

        return response()->json($policy);
    }

    // 2. Update policies
    public function updatePolicies(Request $request)
    {
        $data = $request->validate([
            'max_trusted_devices' => 'integer|min:1',
            'trust_expiration_days' => 'nullable|integer|min:1',
            'require_otp_new_device' => 'boolean',
            'block_rooted_devices' => 'boolean',
        ]);

        $policy = DevicePolicy::first();
        $policy->update($data);

        return response()->json(['message' => 'Policies updated', 'policy' => $policy]);
    }

    // 3. Device stats / insights
    public function insights()
    {
        return response()->json([
            'total_recognized' => Device::count(),
            'untrusted' => Device::where('trust_status', 'unverified')->count(),
            'banned' => Device::where('trust_status', 'banned')->count(),
        ]);
    }

    // 4. List devices with search/pagination
    public function index(Request $request)
    {
        $query = Device::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', fn ($q) => $q->where('email', 'like', "%$search%"))
                ->orWhere('fingerprint', 'like', "%$search%")
                ->orWhere('last_ip', 'like', "%$search%");
        }

        $devices = $query->with('user')->paginate($request->get('per_page', 10));

        return response()->json($devices);
    }

    // 5. Trust a device
    public function trust(Device $device)
    {
        $device->update(['trust_status' => 'trusted']);

        return response()->json(['message' => 'Device trusted']);
    }

    // 6. Revoke a trusted device
    public function revoke(Device $device)
    {
        $device->update(['trust_status' => 'unverified']);

        return response()->json(['message' => 'Device trust revoked']);
    }

    // 7. Ban a device
    public function ban(Device $device)
    {
        $device->update(['trust_status' => 'banned']);

        return response()->json(['message' => 'Device banned']);
    }

    // 8. Unban a device
    public function unban(Device $device)
    {
        $device->update(['trust_status' => 'unverified']);

        return response()->json(['message' => 'Device unbanned']);
    }
}
