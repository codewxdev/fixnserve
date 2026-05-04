<?php

namespace App\Domains\Payments\Controllers\Front;

use App\Http\Controllers\Controller;

class PaymentInfrastructureController extends Controller
{
    public function connect() { return view('Admin.Payments.Connect.index'); }
    public function monitoring() { return view('Admin.Payments.Monitoring.index'); }
    public function webhooks() { return view('Admin.Payments.Webhooks.index'); }
    public function keys() { return view('Admin.Payments.Keys.index'); }
    public function fallbacks() { return view('Admin.Payments.Fallbacks.index'); }
    public function instant() { return view('Admin.Payments.Instant.index'); }
}