<?php

namespace App\Domains\Security\Controllers\Api;

use App\Domains\Security\Models\IpRule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IpRuleController extends Controller
{
    public function index()
    {
        return IpRule::latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cidr' => 'required|string',
            'type' => 'required|in:allow,deny',
            'applies_to' => 'nullable|string',
            'comment' => 'nullable|string',
            'expires_at' => 'nullable|date',
        ]);

        return IpRule::create($data);
    }

    public function update(Request $request, $id)
    {
        $ipRule = IpRule::findOrFail($id);

        $data = $request->validate([
            'cidr' => 'nullable|string',
            'type' => 'nullable|in:allow,deny',
            'applies_to' => 'nullable|string',
            'comment' => 'nullable|string',
            'expires_at' => 'nullable|date',
        ]);
        $ipRule = $ipRule->update($data);

        return response()->json($ipRule);
    }

    public function destroy($id)
    {
        $ipRule = IpRule::findOrFail($id);
        if (!$ipRule) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $ipRule->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
