<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MartController extends Controller
{
   public function index()
    {
        // 1. Vendors ko fetch karein
        $users = User::role('Vendor')->get();

        // 2. Data ko Frontend ke format mein map karein
        $formattedVendors = $users->map(function ($user) {
            
            // Random color generator for UI aesthetics based on ID
            $colors = ['indigo', 'emerald', 'blue', 'pink', 'purple', 'orange', 'teal'];
            $color = $colors[$user->id % count($colors)];

            return [
                'id' => $user->id,
                'name' => $user->name ?? 'NaN',
                // Since it's a user table, Owner and Name are likely the same for now
                'owner' => $user->name ?? 'NaN', 
                // Category user table mein nahi hai -> NaN
                'category' => 'NaN', 
                // Capitalize status (active/deactive)
                'status' => $user->status ? ucfirst($user->status) : 'NaN', 
                'rating' => 'NaN',
                'reviews' => 'NaN',
                // Logo ke liye first letter utha rahe hain
                'logo' => $user->name ? strtoupper(substr($user->name, 0, 1)) : '?', 
                'color' => $color,
                'joined' => $user->created_at ? $user->created_at->format('d M, Y') : 'NaN',
                'contact' => $user->email ?? 'NaN',
                'phone' => $user->phone ?? 'NaN',
                'address' => $user->address ?? 'NaN',
                'commission' => 'NaN', 
                
                // Nested Objects (Jo DB mein abhi exist nahi krte)
                'stats' => [
                    'orders' => 'NaN',
                    'revenue' => 'NaN',
                    'products' => 'NaN'
                ],
                'wallet' => [
                    'balance' => 'NaN',
                    'pending' => 'NaN',
                    'last_payout' => 'NaN'
                ],
                // Arrays for lists
                'inventory' => [], 
                'recent_orders' => []
            ];
        });

        // 3. View ko pass karein
        return view('Admin.mart.index', [
            'vendors' => $formattedVendors
        ]);
    }


}
