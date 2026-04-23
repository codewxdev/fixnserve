<?php

namespace App\Domains\Command\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemHealthController extends Controller
{
    public function index(){
        return view('Admin.command_center.system_health.index');
    }
}
