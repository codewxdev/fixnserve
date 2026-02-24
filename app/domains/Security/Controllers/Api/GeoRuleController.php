<?php

namespace App\Domains\Security\Controllers\Api;

use App\Domains\Security\Models\GeoRule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeoRuleController extends Controller
{
    public function index()
    {
        return GeoRule::all();
    }

    public function updateCountry(Request $request)
    {
        $data = $request->validate([
            'country_code' => 'required|string',
            'status' => 'required|in:allowed,blocked',
        ]);

        return GeoRule::updateOrCreate(
            ['country_code' => $data['country_code']],
            ['status' => $data['status']]
        );
    }

    public function updateDefault(Request $request)
    {
        $request->validate([
            'policy' => 'required|in:allow_all,deny_all',
        ]);

        GeoRule::query()->update(['is_default' => false]);

        return GeoRule::create([
            'country_code' => '*',
            'status' => $request->policy === 'deny_all' ? 'blocked' : 'allowed',
            'is_default' => true,
        ]);
    }
}
