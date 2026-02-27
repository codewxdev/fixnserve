<?php

namespace App\Domains\Security\Controllers\Api;

use App\Domains\Audit\Services\SecurityAuditService;
use App\Domains\Security\Models\Device;
use App\Domains\Security\Models\DevicePolicy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    protected $securityAudit;

    public function __construct(SecurityAuditService $securityAudit)
    {
        $this->securityAudit = $securityAudit;
    }

    // 1. Get current device policies
    public function getPolicies()
    {
        $policy = DevicePolicy::first();

        return response()->json($policy);
    }

    public function storeOrUpdatePolicy(Request $request)
    {
        $data = $request->validate([
            'max_trusted_devices' => 'required|integer|min:1',
            'trust_expiration_days' => 'nullable|integer|min:1',
            'require_otp_new_device' => 'required|boolean',
            'block_rooted_devices' => 'required|boolean',
        ]);
        // dD($data);
        $policy = DevicePolicy::first();
        if ($policy) {
            $policy->update($data);
        } else {
            $policy = DevicePolicy::create($data);
        }

        return response()->json([
            'status' => true,
            'message' => 'Device policy saved successfully',
            'policy' => $policy,
        ]);
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
    public function ban(Request $request, Device $device)
    {
        $request->validate([
            'reason_code' => 'required|string',
        ]);

        $actor = auth()->user();

        $beforeState = [
            'trust_status' => $device->trust_status,
        ];

        $device->update([
            'trust_status' => 'banned',
        ]);

        $afterState = [
            'trust_status' => 'banned',
        ];

        // 🔐 SECURITY AUDIT
        $this->securityAudit->log(
            'device_banned',
            [
                'device_id' => $device->id,
                'user_id' => $device->user_id,
                'fingerprint' => $device->fingerprint,
                'ip_address' => request()->ip(),
            ],
            $actor,
            $beforeState,
            $afterState,
            $request->reason_code
        );

        return response()->json(['message' => 'Device banned']);
    }

    // 8. Unban a device
    public function unban(Request $request, Device $device)
    {
        $request->validate([
            'reason_code' => 'required|string',
        ]);

        $actor = auth()->user();

        $beforeState = [
            'trust_status' => $device->trust_status,
        ];

        $device->update([
            'trust_status' => 'unverified',
        ]);

        $afterState = [
            'trust_status' => 'unverified',
        ];

        // 🔐 SECURITY AUDIT
        $this->securityAudit->log(
            'device_unbanned',
            [
                'device_id' => $device->id,
                'user_id' => $device->user_id,
                'fingerprint' => $device->fingerprint,
                'ip_address' => request()->ip(),
            ],
            $actor,
            $beforeState,
            $afterState,
            $request->reason_code
        );

        return response()->json(['message' => 'Device unbanned']);
    }
}
