<?php

namespace App\Domains\Security\Controllers\Api;

use App\Domains\Security\Models\GeoRule;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class GeoRuleController extends BaseApiController
{
    public function index()
    {
        $geoRules = GeoRule::all();

        return $this->success(['geoRules' => $geoRules]);
    }

    public function updateCountry(Request $request)
    {
        $data = $request->validate([
            'country_code' => 'required|string',
            'status' => 'required|in:allowed,blocked',
        ]);

        $geoRule = GeoRule::updateOrCreate(
            ['country_code' => $data['country_code']],
            ['status' => $data['status']]
        );

        return $this->success(['geoRule' => $geoRule], 'Geo rule updated successfully');
    }

    public function updateDefault(Request $request)
    {
        $request->validate([
            'policy' => 'required|in:allow_all,deny_all',
        ]);

        GeoRule::query()->update(['is_default' => false]);

        $geoRule = GeoRule::create([
            'country_code' => '*',
            'status' => $request->policy === 'deny_all' ? 'blocked' : 'allowed',
            'is_default' => true,
        ]);

        return $this->success(['geoRule' => $geoRule], 'Default geo rule updated successfully');
    }
}
