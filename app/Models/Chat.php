<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'executor_id',
        'task_id',
    ];

    public function executor()
    {
        return $this->belongsTo(User::class, 'executor_id');
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
