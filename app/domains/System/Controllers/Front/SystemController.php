<?php


namespace App\Domains\System\Controllers\Front;

class SystemController
{
    public function index()
    {
        return view('Admin.system.global_preferences.index');
    }
}