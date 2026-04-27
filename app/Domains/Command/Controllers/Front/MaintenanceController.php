<?php

namespace App\Domains\Command\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(){
        return view('Admin.Command.Maintenance.index');
    }
}
