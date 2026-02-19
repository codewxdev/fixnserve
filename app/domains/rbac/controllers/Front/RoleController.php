<?php


namespace App\Domains\RBAC\Controllers\Front;

use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        return view('Admin.rbac.roles.index');
    }
}
