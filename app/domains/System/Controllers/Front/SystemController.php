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
}