<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaintainanceController extends Controller
{
    public function index(){
        return view('Admin.command_center.maintainance_emergency.index');
    }
}
