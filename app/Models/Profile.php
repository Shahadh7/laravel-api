<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'salutation', 
        'first_name', 
        'last_name', 
        'email_address',
        'profile_image', 
        'home_address', 
        'country', 
        'postal_code', 
        'dob',
        'gender', 
        'marital_status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
