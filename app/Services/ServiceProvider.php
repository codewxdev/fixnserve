<?php

namespace App\Services;

use App\Models\User; // Ya Provider Model
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ServiceProvider
{
    public function registerProvider(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. User/Provider Create karein
            $provider = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('javed123@'), // Default password or logic
                 
            ]);

            $provider->assignRole('Provider');

            return $provider;
        });
    }
}