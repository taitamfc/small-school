<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{   
    public function index(){
        return $this->checkLoginUser();
    }
    public function checkLoginUser(){
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        } else {
            return view('admin.users.login');
        }
    }
    public function checkLoginTeacher(){
        if (Auth::guard('teachers')->check()) {
            return redirect()->route('teachers.dashboard');
        } else {
            return redirect()->route('teachers.login');
        }
    }
    public function checkLoginStudent(){
        if (Auth::guard('students')->check()) {
            return redirect()->route('students.dashboard');
        } else {
            return redirect()->route('students.login');
        }
    }
    public function loginUser(LoginRequest $request)
    {
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($arr)) {
            return redirect()->route('admin.dashboard');
        } else if(User::where('email', $arr['email'])->exists()) {
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
}
