<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfessionalService {

       public function registerProfessional(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. User/Provider Create karein
            $provider = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('javed123@'), // Default password or logic
                 
            ]);

            $provider->assignRole('Professional');

            return $provider;
        });
    }
}