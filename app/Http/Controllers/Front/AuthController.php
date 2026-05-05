<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
   public function index(){
        return view('Auth.login');
    }

    public function forget(){
        return view('Auth.forgetPassword');
    }

    public function reset(){
        return view('Auth.resetPassword');
    }
}
