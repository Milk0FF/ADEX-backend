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
        'views',
        'executor_id',
        'customer_id',
        'task_status_id',
    ];
}
