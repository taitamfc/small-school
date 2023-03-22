<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateProfileTeacherRequest;
use App\Models\Teacher;


class ProfileController extends Controller
{
    public function index(){
        $teacher = Auth::guard('teachers')->user();
        return view('teachers.profile', compact('teacher'));
    }
    public function logout(){
        Auth::guard('teachers')->logout();
        return redirect()->route('teachers.login');
    }
    public function login(){
        return view('teachers.login');
    }
    public function postLogin(LoginRequest $request)
    {
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::guard('teachers')->attempt($arr)) {
            return redirect()->route('teachers.dashboard');
        } else if(Teacher::where('email', $arr['email'])->exists()) {
            $errorMessage = ['password' => 'Mật khẩu không đúng.'];
            return back()->withInput()->withErrors($errorMessage);
        } else {
            $errorMessage = ['email' => 'Tài khoản không tồn tại.'];
            return back()->withInput()->withErrors($errorMessage);
        }
    }
    public function postProfile(UpdateProfileTeacherRequest $request){
        try {
            $id = Auth::guard('teachers')->user()->id;
            $teacher = Teacher::find($id);
            $teacher->name = $request->name;
            $teacher->email = $request->email;
            if(isset($request->password) && !empty($request->password)){
                $teacher->password = bcrypt($request->password);
            }
            $images = str_replace('storage', 'public', $teacher->avatar);
            $fieldName = 'inputFile';
            if ($request->hasFile($fieldName)) {
                $fullFileNameOrigin = $request->file($fieldName)->getClientOriginalName();
                $fileNameOrigin = pathinfo($fullFileNameOrigin, PATHINFO_FILENAME);
                $extenshion = $request->file($fieldName)->getClientOriginalExtension();
                $fileName = $fileNameOrigin . '-' . rand() . '_' . time() . '.' . $extenshion;
                $path = 'storage/' . $request->file($fieldName)->storeAs('public/images/teachers', $fileName);
                $path = str_replace('public/', '', $path);
                $teacher->image = $path;
            }
            $teacher->save();
                if (isset($path) && isset($images)) {
                    Storage::delete($images);
                }
                return back()->with('success', 'Cập nhật thành công.');
            } catch (\Exception $e) {
                if(isset($path)){
                    $images = str_replace('storage', 'public', $path);
                    Storage::delete($images); }
                Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
                return back()->with('error', 'Cập nhật không thành công.');
            }
    }
}
