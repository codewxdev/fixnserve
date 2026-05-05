<?php

namespace App\Domains\Support\Controllers\Front;

use App\Http\Controllers\Controller;

class SupportController extends Controller
{
    public function tickets() { return view('Admin.Support.Tickets.index'); }
    public function sla() { return view('Admin.Support.SLA.index'); }
    public function workspace() { return view('Admin.Support.Workspace.index'); }
    public function incidents() { return view('Admin.Support.Incidents.index'); }
    public function knowledge() { return view('Admin.Support.Knowledge.index'); }
    public function assistant() { return view('Admin.Support.Assistant.index'); }
}