<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // return view('students.dashboard');
        return view('students.events.calendar');
    }

    public function dataTable(){
        
    }
}
