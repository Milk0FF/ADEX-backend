<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable = [
        'comment',
        'score_type_id',
        'task_id',
        'author_id',
        'customer_id',
        'executor_id',
        'is_disable',
    ];
    public function executor()
    {
        return $this->belongsTo(User::class, 'executor_id');
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function executorInfo()
    {
        return $this->belongsTo(UserInfo::class, 'executor_id');
    }
    public function customerInfo()
    {
        return $this->belongsTo(UserInfo::class, 'customer_id');
    }
    public function authorInfo()
    {
        return $this->belongsTo(UserInfo::class, 'author_id');
    }
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    public function scoreType()
    {
        return $this->belongsTo(ScoreType::class);
    }
}
