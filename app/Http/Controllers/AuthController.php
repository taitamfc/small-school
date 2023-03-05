<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{   public function index(){
      $this->viewLoginUser();
    }



    public function checkLoginUser(){
        if (Auth::check()) {
            return view('admin.dasboard');
        } else {
            return view('admin.users.login');
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
        } else {
            return back()->withInput();
        }
    }



    public function logoutUser(){
        Auth::logout();
        return redirect()->route('login');
    }
    public function loginStudent(LoginRequest $request)
    {
       
    }

    public function loginTeacher(LoginRequest $request)
    {
      
    }
}
