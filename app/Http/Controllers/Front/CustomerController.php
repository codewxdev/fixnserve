<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    
    public function index(){
        return view('Admin.customers.index');
    }

     public function order_history(){
        return view('Admin.customers.order_history');
    }

}
