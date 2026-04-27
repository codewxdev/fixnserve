<?php

namespace App\Domains\Security\Controllers\Front;

use App\Http\Controllers\Controller;

class SecurityController extends Controller
{
    /**
     * Sub-Module 2.1: Authentication Governance
     */
    public function policies()
    {
        return view('Admin.Security.Authentication.index');
    }
    
    /**
     * Sub-Module 2.2: Session Management
     */
    public function sessions()
    {
        return view('Admin.Security.Sessions.index');
    }

    /**
     * Sub-Module 2.3: Token & API Management
     */
    public function tokens()
    {
        return view('Admin.Security.Tokens.index');
    }

    /**
     * Sub-Module 2.4: Device Trust & Fingerprinting
     */
    public function devices()
    {
        return view('Admin.Security.Devices.index');
    }

    /**
     * Sub-Module 2.5: Network Defense Layer
     */
    public function network()
    {
        return view('Admin.Security.Network.index');
    }  
    
    /**
     * Sub-Module 2.6: Privileged Access Governance (JIT)
     */
    public function jit()
    {
        return view('Admin.Security.Privileged.index');
    }
}