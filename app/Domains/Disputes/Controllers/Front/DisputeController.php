<?php

namespace App\Domains\Disputes\Controllers\Front;

use App\Http\Controllers\Controller;

class DisputeController extends Controller{

    public function index(){

         return view('Admin.dispute.complaint_intake_classification.index');
    } 

    public function EvidenceContext(){
        return view('Admin.dispute.evidence_context.index');
    }
}