<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CodashboardController extends Controller
{
    public function index(){
        return view('Admin.COdashboard.index');
    }
}
