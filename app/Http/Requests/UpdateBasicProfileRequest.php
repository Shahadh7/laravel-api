<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBasicProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'salutation'    => 'required|string|in:Mr.,Ms.,Mrs.,Dr.',
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'email_address' => 'required|email|unique:profiles,email_address,' . $this->user()->id . ',user_id',
        ];
    }
}
