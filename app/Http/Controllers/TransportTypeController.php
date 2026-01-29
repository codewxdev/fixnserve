<?php

namespace App\Http\Controllers;

use App\Models\TransportType;
use Illuminate\Http\Request;

class TransportTypeController extends Controller
{
     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:transport_types,name',
        ]);

        $type = TransportType::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'data' => $type
        ], 201);
    }

}
