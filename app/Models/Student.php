<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Student extends Authenticatable
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = ['name', 'phone', 'email', 'status', 'birthday', 'image', 'room_name', 'password'];

    const DIR = 'storage';
    const FOLDER = 'student';

    public $statuses = [
        'hoat_dong' => 'Hoat động',
        'khong_hoat_dong' => 'Không hoạt động',
    ];

    public static function except(string $string)
    {
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
