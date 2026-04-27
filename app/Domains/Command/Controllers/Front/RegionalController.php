<?php

namespace App\Domains\Command\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegionalController extends Controller
{
    public function index(){
        return view('Admin.Command.regions.index');
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|string|in:active,suspended,maintenance' 
    ]);

    $country = \App\Models\Country::findOrFail($id);
    
     

    $country->update(['status' => $request->status]);

    return response()->json([
        'success' => true,
        'message' => 'Region status updated successfully.'
    ]);
}
}
