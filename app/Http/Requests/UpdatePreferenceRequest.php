<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePreferenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hobbies' => 'nullable|array',
            'favorite_sports' => 'nullable|array',
            'preferred_music_genre' => 'nullable|array',
            'preferred_movie_tv_show' => 'nullable|array',
        ];
    }
}

