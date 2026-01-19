<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMartRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            // Business Docs Table fields
            'business_name' => 'required|string|max:255',
            'owner_name'    => 'required|string|max:255',
            'location'      => 'required|string|max:255', // Maps to 'location' column
            'category_id'   => 'required|exists:mart_categories,id', // Dropdown check
            
            // Users Table fields
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|string|max:20',
            'password'      => 'required|string|min:8',
        ];
    }
}