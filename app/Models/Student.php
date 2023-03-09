<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = ['name', 'phone', 'email', 'status', 'birthday', 'image', 'room_name', 'password'];

    const DIR = 'storage';
    const FOLDER = 'student';

    public static function except(string $string)
    {
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
