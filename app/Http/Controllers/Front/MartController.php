<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MartController extends Controller
{
    public function index(){
        return view('Admin.mart.index');
    }
}
