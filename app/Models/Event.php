<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public function events()
    {
        return $this->hasMany(Event::class, 'event_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function saveQuietly($options = [])
    {
        return static::withoutEvents(function () {
            return $this->save();
        });
    }
    public $table = 'events';

    protected $dates = [
        'end_time',
        'start_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const RECURRENCE_RADIO = [
        'none'    => 'None',
        'daily'   => 'Daily',
        'weekly'  => 'Weekly',
        'monthly' => 'Monthly',
    ];

    protected $fillable = [
        'name',
        'end_time',
        'event_id',
        'start_time',
        'recurrence',
        'created_at',
        'student_id',
        'teacher_id',
        'updated_at',
    ];



}
