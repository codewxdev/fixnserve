<?php

namespace App\Domains\Disputes\Controllers\Front;

use App\Http\Controllers\Controller;

class DisputeController extends Controller
{
    public function types() { return view('Admin.Disputes.Types.index'); }
    public function workflow() { return view('Admin.Disputes.Workflow.index'); }
    public function evidence() { return view('Admin.Disputes.Evidence.index'); }
    public function triage() { return view('Admin.Disputes.Triage.index'); }
    public function escalations() { return view('Admin.Disputes.Escalations.index'); }
}