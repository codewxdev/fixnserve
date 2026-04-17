<?php


namespace App\Domains\RBAC\Controllers\Front;

use App\Http\Controllers\Controller;


class AccessMetrixController extends Controller
{
    public function index()
    {
        return view('Admin.rbac.access_matrix.index');
    }
}