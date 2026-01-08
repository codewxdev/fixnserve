<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    
    public function index(){

        $users = User::doesntHave('roles')->get();
        return view('Admin.customers.index',compact('users'));
    }

     public function order_history(){
        return view('Admin.customers.order_history');
    }

}
