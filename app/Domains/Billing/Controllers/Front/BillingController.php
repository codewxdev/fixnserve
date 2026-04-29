<?php

namespace App\Domains\Billing\Controllers\Front;

use App\Http\Controllers\Controller;

class BillingController extends Controller
{
    public function plans()
    {
        return view('Admin.Billing.Plans.index');
    }

    public function entitlements()
    {
        return view('Admin.Billing.Entitlements.index');
    }

    public function lifecycle()
    {
        return view('Admin.Billing.Lifecycle.index');
    }

    public function enforcement()
    {
        return view('Admin.Billing.Enforcement.index');
    }

    public function overrides()
    {
        return view('Admin.Billing.Overrides.index');
    }
}