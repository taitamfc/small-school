<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
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
