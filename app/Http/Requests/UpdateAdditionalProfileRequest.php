<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdditionalProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'home_address' => 'nullable|string|required',
            'country' => 'nullable|string|required',
            'postal_code' => 'nullable|string|required',
            'dob' => 'required|date|before:-17 years',
            'gender' => 'required|in:Male,Female',
            'marital_status' => 'required|in:Single,Married',
        ];
    }
}
