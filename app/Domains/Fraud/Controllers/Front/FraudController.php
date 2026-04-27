<?php

namespace App\Domains\Fraud\Controllers\Front;
use App\Http\Controllers\Controller;

class FraudController extends Controller {

     public function index(){
         return view('admin.fraud.risk_scoring_engine.index');
     }

     public function SessionIdentityRisk(){
         
         return view('admin.fraud.session_identity_risk.index');
     }

     public function PaymentWallet(){
         
         return view('admin.fraud.payment_wallet.index');
     }

     public function PromotionIncentiveAbuse(){
         return view('admin.fraud.promotion_incentive_abuse.index');
     }

     public function CollusionNetworks(){
         return view('admin.fraud.collusion_networks.index');
     }

     public function AutomatedEnforcementEngine(){
        return view('admin.fraud.automated_enforcement_engine.index');
     }

     public function ManualOverridesGovernance(){
         return view('admin.fraud.manual_overrides_governance.index');
     }
}