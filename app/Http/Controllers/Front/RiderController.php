<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRiderRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Commands\AssignRole;

class RiderController extends Controller
{
      public function index()
    {
        // 1. Fetch Categories (Kept as per your previous code, though maybe less relevant for riders)
        $categories = \App\Models\MartCategory::where('status', 1)->get();

        // 2. Fetch Riders (Users) and Map to the Table Structure
        // We filter by a role or just fetch all users depending on your logic. 
        // Here I fetch all, assuming this table is for riders.
        $riders = User::role('Rider')->get()->map(function ($user) {
            return [
                'id'       => $user->id,
                'name'     => $user->name,
                'owner'    => $user->name, // Rider is the owner
                'contact'  => $user->email,
                'phone'    => $user->phone ?? 'NaN',
                'city'     => $user->city ?? 'NaN',
                'category' => 'Rider', // Static category
                'status'   => ucfirst($user->status), // active, ban, etc.
                'logo'     => strtoupper(substr($user->name, 0, 1)),
                'color'    => 'indigo',
                
                // Existing fields kept as NaN
                'stats'    => [
                    'orders'   => 'NaN',
                    'products' => 'NaN',
                    'revenue'  => 'NaN'
                ],
                'wallet'   => [
                    'balance' => 'NaN'
                ]
            ];
        });

        // Pass 'vendors' variable because the View expects it
        return view('Admin.riders.index', [
            'categories' => $categories, 
            'riders'    => $riders 
        ]);
    }

    public function store(StoreRiderRequest $request)
    {
        // "Skinny Controller" - Data is already validated by StoreRiderRequest
        
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'city'     => $request->city,
            'address'  => $request->address,
            'status'   => 'active', // Default from schema
            'mode'     => 1,        // Default from schema
            'uuid'     => \Illuminate\Support\Str::uuid(),
        ]);

        $user->AssignRole('Rider');
        
        return response()->json([
            'success' => true,
            'message' => 'Rider Onboarded Successfully',
            'data'    => $user
        ], 200);
    }
}
