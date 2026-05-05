<?php

namespace App\Domains\Audit\Controllers\Front;

use App\Http\Controllers\Controller;

class AuditComplianceController extends Controller
{
    public function actions() { return view('Admin.Audit.Actions.index'); }
    public function financial() { return view('Admin.Audit.Financial.index'); }
    public function security() { return view('Admin.Audit.Security.index'); }
    public function access() { return view('Admin.Audit.Access.index'); }
    public function reporting() { return view('Admin.Audit.Reporting.index'); }
    public function retention() { return view('Admin.Audit.Retention.index'); }
    public function forensics() { return view('Admin.Audit.Forensics.index'); }
}