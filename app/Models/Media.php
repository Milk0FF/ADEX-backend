<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'media_type_id',
    ];
    public function userInfo(){
        return $this->hasOne(UserInfo::class);
    }
    public function mediaType(){
        return $this->belongsTo(MediaType::class);
    }
}
