<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'date_end',
        'customer_id',
        'executor_id',
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
    public function executorInfo()
    {
        return $this->belongsTo(UserInfo::class, 'executor_id');
    }
    public function customerInfo()
    {
        return $this->belongsTo(UserInfo::class, 'customer_id');
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
