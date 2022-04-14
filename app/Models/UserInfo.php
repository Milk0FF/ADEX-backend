<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstname',
        'lastname',
        'about',
        'phone',
        'living_place',
        'birth_date',
        'register_date',
        'rating',
        'employment_type_id',
        'media_id',
    ];
}
