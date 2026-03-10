<?php


namespace App\Domains\System\Controllers\Front;

class SystemController
{
    public function index()
    {
        return view('Admin.system.global_preferences.index');
    }

    public function featureControl()
    {
        return view('Admin.system.feature_control_&_release_control.index');  
    }

    public function localization()
    {
        return view('Admin.system.localization_&_internationalization.index'); 
    }

    public function geo()
    {
        return view('Admin.system.geo_&_map.index'); 
    }

    public function rateLimit()
    {
        return view('Admin.system.rate_limit_&_throttling.index'); 
    }   

    public function configurationVersioning()
    {
        return view('Admin.system.configuration_versioning_&_rollback.index'); 
    }

    public function configurationImpactAnalysis()
    {
        return view('Admin.system.configuration_access_analysis.index'); 
    }

    public function accessControl()
    {
        return view('Admin.system.access_control_&_governance.index'); 
    }


     
}