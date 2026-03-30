<?php

namespace App\Domains\KYC\Controllers\Front;

use App\Http\Controllers\Controller;

class KycController extends Controller {

      public function index(){
          return view('Admin.kyc.document_managment.index');
      }

     public function AiVerificationPipeline(){
         return view('Admin.kyc.ai_verification_pipeline.index');
     }    
     
     public function OrchestrationEngine(){
        return view('Admin.kyc.kyc_orchestration_engin.index');
     }
     
     public function EntitySpecificControls(){
        return view('Admin.kyc.entity-specific_controls.index');
     }

     public function ComplianceGovernance(){
        return view('Admin.kyc.compliance_governance.index');
     }
}