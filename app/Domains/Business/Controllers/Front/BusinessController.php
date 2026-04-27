<?php


namespace App\Domains\Business\Controllers\Front;

use App\Http\Controllers\Controller;

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
}