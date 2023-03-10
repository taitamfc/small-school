<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DasboardController extends Controller
{
    public function index(){
        echo __METHOD__;
        return view('teachers.dasboard');
    }
}
