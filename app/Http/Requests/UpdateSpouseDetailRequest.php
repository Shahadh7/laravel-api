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
            'salutation' => 'string',
            'first_name' => 'string',
            'last_name' => 'string',
        ];
    }
}

