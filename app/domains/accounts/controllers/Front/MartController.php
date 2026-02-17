<?php

namespace App\Domains\Accounts\Controllers\Front;

use App\Domains\Accounts\Requests\StoreMartRequest;
use App\Domains\Accounts\Services\MartOnboardingService;
use App\Domains\Catalog\Admin\Models\MartCategory;
use App\Http\Controllers\Controller;
use App\Domains\Security\Models\User;
use Illuminate\Http\Request;

class MartController extends Controller
{
    //    public function index()
    //     {
    //         // 1. Vendors ko fetch karein
    //         $users = User::role('Vendor')->get();

    //         // 2. Data ko Frontend ke format mein map karein
    //         $formattedVendors = $users->map(function ($user) {

    //             // Random color generator for UI aesthetics based on ID
    //             $colors = ['indigo', 'emerald', 'blue', 'pink', 'purple', 'orange', 'teal'];
    //             $color = $colors[$user->id % count($colors)];

    //             return [
    //                 'id' => $user->id,
    //                 'name' => $user->name ?? 'NaN',
    //                 // Since it's a user table, Owner and Name are likely the same for now
    //                 'owner' => $user->name ?? 'NaN', 
    //                 // Category user table mein nahi hai -> NaN
    //                 'category' => 'NaN', 
    //                 // Capitalize status (active/deactive)
    //                 'status' => $user->status ? ucfirst($user->status) : 'NaN', 
    //                 'rating' => 'NaN',
    //                 'reviews' => 'NaN',
    //                 // Logo ke liye first letter utha rahe hain
    //                 'logo' => $user->name ? strtoupper(substr($user->name, 0, 1)) : '?', 
    //                 'color' => $color,
    //                 'joined' => $user->created_at ? $user->created_at->format('d M, Y') : 'NaN',
    //                 'contact' => $user->email ?? 'NaN',
    //                 'phone' => $user->phone ?? 'NaN',
    //                 'address' => $user->address ?? 'NaN',
    //                 'commission' => 'NaN', 

    //                 // Nested Objects (Jo DB mein abhi exist nahi krte)
    //                 'stats' => [
    //                     'orders' => 'NaN',
    //                     'revenue' => 'NaN',
    //                     'products' => 'NaN'
    //                 ],
    //                 'wallet' => [
    //                     'balance' => 'NaN',
    //                     'pending' => 'NaN',
    //                     'last_payout' => 'NaN'
    //                 ],
    //                 // Arrays for lists
    //                 'inventory' => [], 
    //                 'recent_orders' => []
    //             ];
    //         });

    //         // 3. View ko pass karein
    //         return view('Admin.mart.index', [
    //             'vendors' => $formattedVendors
    //         ]);
    //     }


    // app/Http/Controllers/MartController.php

    public function index()
    {
        // 1. Categories fetch karein (Dropdown ke liye)
        $categories = MartCategory::where('status', 1)->get();

        // 2. Vendors fetch karein (Table listing ke liye)
        // Hum business_docs table se data le rahe hain
        $vendors = \App\Models\BusinessDoc::all()->map(function ($doc) {
            return [
                'id' => $doc->id,
                'name' => $doc->business_name,
                'owner' => $doc->owner_name,
                'contact' => $doc->email,
                'city' => $doc->location,
                'category' => $doc->business_type,
                'status' => ucfirst($doc->status), // Pending, Approved, etc.
                'logo' => substr($doc->business_name, 0, 1), // Pehla harf logo ke liye
                'color' => 'indigo', // Default color
                'joined' => $doc->created_at->format('d M, Y'),
                'rating' => '0.0', // Default
                'stats' => [
                    'orders' => 0,
                    'products' => 0,
                    'revenue' => 0
                ],
                'wallet' => [
                    'balance' => 0,
                    'pending' => 0,
                    'last_payout' => 0
                ]
            ];
        });
    

        return view('Admin.mart.index', compact('categories', 'vendors'));
    }


    public function store(StoreMartRequest $request, MartOnboardingService $service)
    {

        // 1. Validated Data service ko pass karein
        $service->onboardVendor($request->validated());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Vendor Onboarded Successfully',

            ]);
        }

        return back()->with('success', 'Vendor added!');
    }
}
