<?php

namespace App\Domains\Security\Controllers\Front;

use App\Http\Controllers\Controller;

class SecurityController extends Controller
{
    public function policies()
    {
        return view('Admin.Security.Authentication.index');
    }
    
    public function index()
    {
        return view('Admin.Security.Authentication.index');
    }


    public function sessions()
    {
        return view('Admin.Security.Sessions.index');
    }

    public function tokens()
    {
        return view('Admin.Security.Tokens.index');
    }

    public function devices()
    {
        return view('Admin.Security.Devices.index');
    }

    public function network()
    {
        return view('Admin.Security.Network.index');
    }  
    
    public function jit()
    {
        return view('Admin.Security.Privileged.index');
    }

     function getProfile()
    {
        
      return view('admin.profile.index');
        
    }
}