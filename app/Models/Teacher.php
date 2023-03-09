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
        'level',
        'password',
    ];
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
