<?php

namespace App\Domains\Config\Controllers\Front;

use App\Http\Controllers\Controller;

class SystemConfigurationController extends Controller
{
    public function globalSettings()
    {
        return view('Admin.Config.Global.index');
    }

    public function featureFlags()
    {
        return view('Admin.Config.Flags.index');
    }

    public function environment()
    {
        return view('Admin.Config.Environment.index');
    }

    public function localization()
    {
        return view('Admin.Config.Localization.index');
    }

    public function geoConfig()
    {
        return view('Admin.Config.Geo.index');
    }

    public function rateLimits()
    {
        return view('Admin.Config.Limits.index');
    }

    public function versioning()
    {
        return view('Admin.Config.Versioning.index');
    }

    public function aiImpact()
    {
        return view('Admin.Config.Impact.index');
    }
}