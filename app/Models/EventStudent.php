<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventStudent extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'event_student';
    protected $fillable = 'student_id';
}
