<?php


namespace App\Domains\RBAC\Controllers\Front;

use App\Http\Controllers\Controller;

class AuditGovernanceController extends Controller
{
    public function index()
    {
        return view('Admin.rbac.audit_governance.index');
    }
}