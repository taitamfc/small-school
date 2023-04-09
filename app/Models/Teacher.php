<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Teacher extends Authenticatable
{
    use HasFactory;
    protected $table = 'teachers';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'birthday',
        'password',
        'cmnd',
        'ho_khau',
        'address',
        'level',
        'bank_user_name',
        'bank_number',
        'bank_branch_name',
        'recurrence_days',
        'image',
        'status'
    ];

    const DIR = 'storage';
    const FOLDER = 'teacher';

    public $statuses = [
        'hoat_dong' => 'Hoạt động',
        'khong_hoat_dong' => 'Không hoạt động',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
