<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpouseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'salutation', 
        'first_name', 
        'last_name',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
