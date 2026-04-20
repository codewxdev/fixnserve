<?php

namespace App\Domains\Fraud\Controllers\Front;
use App\Http\Controllers\Controller;

class FraudController extends Controller {

     public function index(){
         return view('Admin.fraud.risk_scoring_engine.index');
     }

     public function SessionIdentityRisk(){
         
         return view('Admin.fraud.session_identity_risk.index');
     }

     public function PaymentWallet(){
         
         return view('Admin.fraud.payment_wallet.index');
     }

     public function PromotionIncentiveAbuse(){
         return view('Admin.fraud.promotion_incentive_abuse.index');
     }

     public function CollusionNetworks(){
         return view('Admin.fraud.collusion_networks.index');
     }

     public function AutomatedEnforcementEngine(){
        return view('Admin.fraud.automated_enforcement_engine.index');
     }

     public function ManualOverridesGovernance(){
         return view('Admin.fraud.manual_overrides_governance.index');
     }
}