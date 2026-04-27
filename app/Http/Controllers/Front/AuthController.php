<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
   public function index(){
        return view('auth.login');
    }

    public function forget(){
        return view('auth.forgetPassword');
    }

    public function reset(){
        return view('auth.resetPassword');
    }
}
