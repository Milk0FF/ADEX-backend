<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'user_info_id',
        'user_type_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function userInfo()
    {
        return $this->belongsTo(UserInfo::class);
    }
    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }
    public function aboutExecutorReviews()
    {
        return $this->hasMany(Review::class, 'executor_id');
    }
    public function aboutCustomerReviews()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }
    public function ownerReviews()
    {
        return $this->hasMany(Review::class, 'author_id');
    }
    public function executorTasks()
    {
        return $this->hasMany(Task::class, 'executor_id');
    }
    public function customerTasks()
    {
        return $this->hasMany(Task::class, 'customer_id');
    }
    public function executorChats()
    {
        return $this->hasMany(Chat::class, 'executor_id');
    }
    public function customerChats()
    {
        return $this->hasMany(Chat::class, 'customer_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class, 'author_id');
    }
    public function categoryWorks()
    {
        return $this->belongsToMany(CategoryWork::class);
    }
}
