<?php

namespace App\Domains\Security\Controllers\Front;

use App\Http\Controllers\Controller;

class SecuirtyController extends Controller
{
    public function index()
    {
        return view('Admin.security.auth.index');
    }


    public function sessions()
    {
        return view('Admin.security.sessions.index');
    }

    public function tokens()
    {
        return view('Admin.security.tokens.index');
    }

    public function devices()
    {
        return view('Admin.security.devices.index');
    }

    public function network()
    {
        return view('Admin.security.network_security.index');
    }  
    
    public function privilegedAccess()
    {
        return view('Admin.security.privileged_access.index');
    }
}