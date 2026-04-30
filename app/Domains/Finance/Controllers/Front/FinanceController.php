<?php

namespace App\Domains\Finance\Controllers\Front;

use App\Http\Controllers\Controller;

class FinanceController extends Controller
{
    public function ledger()
    {
        return view('Admin.Finance.Ledger.index');
    }

    public function wallets()
    {
        return view('Admin.Finance.Wallets.index');
    }

    public function commissions()
    {
        return view('Admin.Finance.Commissions.index');
    }

    public function payouts()
    {
        return view('Admin.Finance.Payouts.index');
    }

    public function refunds()
    {
        return view('Admin.Finance.Refunds.index');
    }
}