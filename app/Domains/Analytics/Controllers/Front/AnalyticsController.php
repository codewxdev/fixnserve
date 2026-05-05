<?php

namespace App\Domains\Analytics\Controllers\Front;

use App\Http\Controllers\Controller;

class AnalyticsController extends Controller
{
    public function executive() { return view('Admin.Analytics.Executive.index'); }
    public function financial() { return view('Admin.Analytics.Financial.index'); }
    public function operational() { return view('Admin.Analytics.Operational.index'); }
    public function builder() { return view('Admin.Analytics.Builder.index'); }
    public function scheduled() { return view('Admin.Analytics.Scheduled.index'); }
}