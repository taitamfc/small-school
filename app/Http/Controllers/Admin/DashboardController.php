<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Student;
use App\Models\Task;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index(){
        $general_teacher = Teacher::count();
        $general_student = Student::count();
        $general_task = Task::where('status', 'cho_xac_nhan')->count();
        $general_event = Event::where('status', 'da_thuc_hien')->count();
        $params = [
        'general_teacher' =>  $general_teacher,
        'general_student' =>  $general_student,
        'general_task' =>  $general_task,
        'general_event' =>  $general_event,
        ];
        return view('admin.dashboard',$params);
    }
    
}
