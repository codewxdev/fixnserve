<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerService{

    public function registerCustomer(array $data) : User {
 
        return DB::transaction(function () use ($data) {
            
            // 1. User Create karein
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'gender'=>$data['gender'],
                'dob' => $data['dob'] ?? null,
                'password'=> Hash::make('javed123@'),
     
            ]);

            // 2. Wallet Create karein (Abhi jo humne relation discuss kiya tha)
            // Kyunke User model mein 'wallet()' relation hai, hum ye use kar sakte hain:
            $user->wallet()->create([
                'balance' => 0,
                // currency wagera agar chahiye
            ]);

            // 3. Email Notification (Optional)
            // Mail::to($user)->send(new WelcomeEmail($user));

            return $user;
        });
    }
}