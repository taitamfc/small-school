<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'full_name',
        'avatar',
        'group_id',
        'email',
        'password',
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
    public function scopeSearch($query)
    {
        if ($key = request()->key) {
            $query = $query->where('user_name', 'like', '%' . $key . '%')
            ->orwhere('email', 'like', '%' . $key . '%')
            ->orwhere('full_name', 'like', '%' . $key . '%');
        }
        return $query;
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function groups()
    {
        return $this->belongsTo(Group::class,'group_id','id');
    }
}
