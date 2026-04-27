<?php

namespace App\Domains\Billing\Controllers\Front;

use App\Http\Controllers\Controller;

class PlanController extends Controller
{
     public function index()
    {
         return view('Admin.Billing.Plans.index');

    }
}