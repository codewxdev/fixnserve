<?php

namespace App\Domains\Fraud\Controllers\Front;

use App\Http\Controllers\Controller;

class FraudController extends Controller
{
    public function scoring() { return view('Admin.Fraud.Scoring.index'); }
    public function accounts() { return view('Admin.Fraud.Accounts.index'); }
    public function transactions() { return view('Admin.Fraud.Transactions.index'); }
    public function enforcement() { return view('Admin.Fraud.Enforcement.index'); }
    public function overrides() { return view('Admin.Fraud.Overrides.index'); }
}