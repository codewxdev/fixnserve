<?php
namespace App\Services;

use App\Models\User;
use App\Models\BusinessDoc; // Make sure Model exists for business_docs table
use App\Models\MartCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MartOnboardingService
{
    public function onboardVendor(array $data)
    {
        return DB::transaction(function () use ($data) {
            
            // 1. Create User (Login Access)
            $user = User::create([
                'name'     => $data['owner_name'],
                'email'    => $data['email'],
                'phone'    => $data['phone'], // Assuming user table has phone
                'password' => Hash::make($data['password']),
                'role'     => 'vendor', // Example Role
            ]);

            // 2. Fetch Category Name for 'business_type' column
            $categoryName = MartCategory::find($data['category_id'])->name;

            // 3. Create Business Doc Entry (As per your table schema)
            $business = BusinessDoc::create([
                'user_id'       => $user->id,
                'business_name' => $data['business_name'],
                'owner_name'    => $data['owner_name'],
                'business_type' => $categoryName, // Saving 'Grocery' etc in business_type
                'location'      => $data['location'],
                'email'         => $data['email'],
                'status'        => 'pending', // Default provided in DB
            ]);

            return $business;
        });
    }
}