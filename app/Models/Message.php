<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'author_id',
        'chat_id',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
