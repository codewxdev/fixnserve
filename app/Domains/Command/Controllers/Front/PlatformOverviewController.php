<?php

namespace App\Domains\Command\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlatformOverviewController extends Controller
{
    public function index(){
        
        return view('Admin.command_center.platform_overview.index');
    }
}
