<?php

namespace App\Domains\Disputes\Controllers\Front;

use App\Http\Controllers\Controller;

class DisputeController extends Controller{

    public function index(){

         return view('admin.dispute.complaint_intake_classification.index');
    } 

    public function EvidenceContext(){
        return view('admin.dispute.evidence_context.index');
    }
}