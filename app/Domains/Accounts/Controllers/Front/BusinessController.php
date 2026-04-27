<?php

namespace App\Domains\Accounts\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Intelligence;

class BusinessController extends Controller
{
    public function index()
    {
         return view('Admin.Accounts.Registry.index');
    }

     
    public function lifecycle()
    {
         return view('Admin.Accounts.Lifecycle.index');
    }

    public function intelligence()
    {
        return view('Admin.Accounts.Intelligence.index');
    }
    
}