<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DasboardController extends Controller
{
    public function index(){
        if ( Auth::guard('teachers')->check() ) {
            return $this->teacher_dasboard();
        }elseif( Auth::guard('students')->check() ){
            return $this->student_index();
        }elseif( Auth::check() ){
            return $this->user_dasboard();
        }
    }
    public function user_dasboard(){
        return view('admin.dasboard');
    }
    public function teacher_dasboard(){
        return view('teachers.dasboard');
    }
    public function student_index(){
        return view('students.dasboard');
    }
}
