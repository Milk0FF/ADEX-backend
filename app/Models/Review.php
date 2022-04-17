<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment',
        'score_type_id',
        'task_id',
        'customer_id',
        'executor_id',
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
    public function scoreType()
    {
        return $this->belongsTo(ScoreType::class);
    }
}
