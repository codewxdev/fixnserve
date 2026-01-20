<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
     public function coupon(){
        return view('Admin.marketing.coupons');
     }

     public function campaign(){
        return view('Admin.marketing.campaigns');
     }

     public function loyalty(){
        return view('Admin.marketing.loyalty');
     }

     public function featured(){
        return view('Admin.marketing.featured');
     }
}
