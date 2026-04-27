<?php


namespace App\Domains\System\Controllers\Front;

class SystemController
{
    public function index()
    {
        return view('admin.system.global_preferences.index');
    }

    public function featureControl()
    {
        return view('admin.system.feature_control_&_release_control.index');  
    }

    public function localization()
    {
        return view('admin.system.localization_&_internationalization.index'); 
    }

    public function geo()
    {
        return view('admin.system.geo_&_map.index'); 
    }

    public function rateLimit()
    {
        return view('admin.system.rate_limit_&_throttling.index'); 
    }   

    public function configurationVersioning()
    {
        return view('admin.system.configuration_versioning_&_rollback.index'); 
    }

    public function configurationImpactAnalysis()
    {
        return view('admin.system.configuration_access_analysis.index'); 
    }

    public function accessControl()
    {
        return view('admin.system.access_control_&_governance.index'); 
    }


     
}