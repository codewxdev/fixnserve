<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CooperateController extends Controller
{
    
    public function index(){
        return view('Admin.cooperation.index');
    }
}
