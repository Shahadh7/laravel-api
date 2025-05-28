<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSpouseDetailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // already protected by Sanctum
    }

    public function rules(): array
    {
        return [
            'salutation' => 'nullable|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
        ];
    }
}

