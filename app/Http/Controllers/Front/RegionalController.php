<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegionalController extends Controller
{
    public function index(){
        return view('Admin.regional_controle.index');
    }
}
