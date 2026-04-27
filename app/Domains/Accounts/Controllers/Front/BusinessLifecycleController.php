<?php

namespace App\Domains\Accounts\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusinessLifecycleController extends Controller
{
    public function index()
    {
        // Return your Business Lifecycle view
        return view('cp.businesses.lifecycle');
    }

    public function suspend(Request $request, $id)
    {
        // Handle business suspension logic
    }
}