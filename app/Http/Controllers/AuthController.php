<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;

class AuthController extends Controller
{   
    public function index(){
    return $this->checkLoginUser();
    }
    public function checkLoginUser(){
        if (Auth::check()) {
            return view('admin.dasboard');
        } else {
            return view('admin.users.login');
        }
    }
    public function checkLoginTeacher(){
        if (Auth::guard('teachers')->check()) {
            return view('admin.dasboard');
        } else {
            return view('admin.teachers.login');
        }
    }
    public function checkLoginStudent(){
        if (Auth::guard('students')->check()) {
            return view('admin.dasboard');
        } else {
            return view('admin.students.login');
        }
    }

    public function loginUser(LoginRequest $request)
    {
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($arr)) {
            return redirect()->route('users.index');
        } else if(User::where('email', $arr['email'])->exists()) {
            $errorMessage = ['password' => 'Mật khẩu không đúng.'];
            return back()->withInput()->withErrors($errorMessage);
        } else {
            $errorMessage = ['email' => 'Tài khoản không tồn tại.'];
            return back()->withInput()->withErrors($errorMessage);
        }
    }
   
    public function loginTeacher(LoginRequest $request)
    {
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::guard('teachers')->attempt($arr)) {
            return redirect()->route('teachers.calendar.index');
        } else if(Teacher::where('email', $arr['email'])->exists()) {
            $errorMessage = ['password' => 'Mật khẩu không đúng.'];
            return back()->withInput()->withErrors($errorMessage);
        } else {
            $errorMessage = ['email' => 'Tài khoản không tồn tại.'];
            return back()->withInput()->withErrors($errorMessage);
        }
    }
    public function loginStudent(LoginRequest $request)
    {
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::guard('students')->attempt($arr)) {
            return redirect()->route('student.calendar');
        } else if(Student::where('email', $arr['email'])->exists()) {
            $errorMessage = ['password' => 'Mật khẩu không đúng.'];
            return back()->withInput()->withErrors($errorMessage);
        } else {
            $errorMessage = ['email' => 'Tài khoản không tồn tại.'];
            return back()->withInput()->withErrors($errorMessage);
        }
    }
    public function logoutUser(){
        Auth::logout();
        return redirect()->route('users.login');
    }
    public function logoutTeacher(){

        Auth::guard('teachers')->logout();

        return redirect()->route('teachers.login');
    }
    public function logoutStudent(){

        Auth::guard('students')->logout();

        return redirect()->route('students.login');
    }
    

    
}
