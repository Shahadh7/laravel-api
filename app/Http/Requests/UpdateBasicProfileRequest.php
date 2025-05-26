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
            'salutation' => 'required|string|required|in:Mr,Ms,Mrs,Dr',
            'first_name' => 'required|string|required',
            'last_name' => 'required|string|required',
            'email_address' => 'required|email|required|unique:profiles,email_address,' . $this->user()->id,
        ];
    }
}
