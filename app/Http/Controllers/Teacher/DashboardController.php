<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index(){
        $teacher_id = Auth::guard('teachers')->user()->id;

        $da_xac_nhan = Event::select('id')
        ->where('teacher_id',$teacher_id)
        ->where('status','da_xac_nhan')
        ->count();

        $da_thuc_hien = Event::select('id')
        ->where('teacher_id',$teacher_id)
        ->where('status','da_thuc_hien')
        ->count();

        $tong_sinh_vien = 0;
        $tong_thu_nhap  = 0;

        $params = [
            'da_xac_nhan' => number_format($da_xac_nhan),
            'da_thuc_hien' => number_format($da_thuc_hien),
            'tong_sinh_vien' => number_format($tong_sinh_vien),
            'tong_thu_nhap' => number_format($tong_thu_nhap)
        ];
        return view('teachers.dashboard',$params);
        return view('teachers.events.calendar');
    }
}
