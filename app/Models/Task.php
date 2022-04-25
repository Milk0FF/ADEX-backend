<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'customer_id',
        'task_status_id',
    ];
    public function executor()
    {
        return $this->belongsTo(User::class, 'executor_id');
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'task_status_id');
    }
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
    public function categoryWorks()
    {
        return $this->belongsToMany(CategoryWork::class);
    }
}
