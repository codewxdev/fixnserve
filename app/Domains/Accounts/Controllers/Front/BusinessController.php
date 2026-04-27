<?php

namespace App\Domains\Accounts\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        // Return your Business Directory view
        return view('cp.businesses.index');
    }

    public function store(Request $request)
    {
        // Handle new business creation
    }

    public function update(Request $request, $id)
    {
        // Handle business updates
    }

    public function destroy($id)
    {
        // Handle business deletion
    }
}