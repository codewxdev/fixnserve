<?php

namespace App\Domains\RBAC\Controllers\Front;

use App\Http\Controllers\Controller;


class PermissionController extends Controller
{
    public function index()
    {
        return view('Admin.rbac.permissions.index');
    }
}