<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Student extends Authenticatable
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = [
        'name', 
        'phone', 
        'email', 
        'birthday', 
        'course_content',
        'course_id',
        'room_id',
        'status', 
        'fee', 
        'debt', 
        'saler_id',
        'student_care_id',
        'teacher_id',
        'start_date',
        'end_date',
        'exercise_date',
        'link_folder',
        'link_calendar',
        'note',
        'image', 
        'room_name', 
        'password'
    ];

    const DIR = 'storage';
    const FOLDER = 'student';

    public $statuses = [
        'hoat_dong' => 'Hoạt động',
        'dang_hoc' => 'Đang học',
        'ket_thuc' => 'Kết thúc',
        'bao_luu' => 'Bảo lưu',
    ];

    public $courses = [
        'video' => 'Video',
        'zoom'  => 'Zoom',
    ];
    public $rooms = [
        'video' => 'Video',
        'zoom'  => 'Zoom',
    ];

    // public static function except(string $string)
    // {
    // }

    // public function events()
    // {
    //     return $this->hasMany(Event::class);
    // }
}
