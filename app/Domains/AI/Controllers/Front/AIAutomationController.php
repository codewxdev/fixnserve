<?php

namespace App\Domains\AI\Controllers\Front;

use App\Http\Controllers\Controller;

class AIAutomationController extends Controller
{
    public function orchestrator() { return view('Admin.AI.Orchestrator.index'); }
    public function intelligence() { return view('Admin.AI.Intelligence.index'); }
    public function fraud() { return view('Admin.AI.Fraud.index'); }
    public function operations() { return view('Admin.AI.Operations.index'); }
    public function engine() { return view('Admin.AI.Engine.index'); }
    public function hitl() { return view('Admin.AI.HITL.index'); }
    public function governance() { return view('Admin.AI.Governance.index'); }
}