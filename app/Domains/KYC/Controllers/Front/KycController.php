<?php

namespace App\Domains\KYC\Controllers\Front;

use App\Http\Controllers\Controller;

class KycController extends Controller {

      public function index(){
          return view('Admin.KYC.Documents.index');
      }

      public function verification(){
          return view('Admin.KYC.Pipeline.index');
      }

   //   public function AiVerificationPipeline(){
   //       return view('admin.kyc.ai_verification_pipeline.index');
   //   }    
     
   //   public function OrchestrationEngine(){
   //      return view('admin.kyc.kyc_orchestration_engin.index');
   //   }
     
   //   public function EntitySpecificControls(){
   //      return view('admin.kyc.entity-specific_controls.index');
   //   }

     public function ComplianceGovernance(){
        return view('Admin.KYC.Compliance.index');
     }
}