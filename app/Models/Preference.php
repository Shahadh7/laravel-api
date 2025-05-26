<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'hobbies', 
        'favorite_sports', 
        'preferred_music_genre', 
        'preferred_movie_tv_show',
    ];

    protected $casts = [
        'hobbies' => 'array',
        'favorite_sports' => 'array',
        'preferred_music_genre' => 'array',
        'preferred_movie_tv_show' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
