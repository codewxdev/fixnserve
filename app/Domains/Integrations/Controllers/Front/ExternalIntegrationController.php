<?php

namespace App\Domains\Integrations\Controllers\Front;

use App\Http\Controllers\Controller;

class ExternalIntegrationController extends Controller
{
    public function registry() { return view('Admin.Integrations.Registry.index'); }
    public function credentials() { return view('Admin.Integrations.Credentials.index'); }
    public function health() { return view('Admin.Integrations.Health.index'); }
    public function webhooks() { return view('Admin.Integrations.Webhooks.index'); }
    public function vendors() { return view('Admin.Integrations.Vendors.index'); }
}