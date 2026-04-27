<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
     public function coupon(){
        return view('admin.marketing.coupons');
     }

     public function campaign(){
        return view('admin.marketing.campaigns');
     }

     public function loyalty(){
        return view('admin.marketing.loyalty');
     }

     public function featured(){
        return view('admin.marketing.featured');
     }
}
