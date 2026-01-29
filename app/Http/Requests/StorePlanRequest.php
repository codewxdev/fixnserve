<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'app_id'            => 'required|exists:apps,id',
            'name'              => 'required|string|max:255',
            'tier'              => 'required|string|max:255',
            'price'             => 'required|numeric|min:0',
            'billing_cycle'     => 'required|in:monthly,yearly',
            'features'          => 'nullable|array',
            // Features validation fixed
            'features.*.key'    => 'required_with:features|string|max:255',
            'features.*.value'  => 'required_with:features|string|max:255',
        ];
    }
}
