<?php

namespace App\Domains\Accounts\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ConsultantService
{
    public function registerConsultant(array $data)
    {
        return DB::transaction(function () use ($data) {
            
            // 1. Create User
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('javed123@'), // Default Password
                 
            ]);

            // 2. Assign Role
            $user->assignRole('Consultant'); 

            return $user;
        });
    }
}