<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileStudentRequest;

use App\Models\Student;


class ProfileController extends Controller
{
    public function index(){
        $student = Auth::guard('students')->user();
        return view('students.profile', compact('student'));
    }
    public function logout(){
        Auth::guard('students')->logout();
        return redirect()->route('students.login');
    }
    public function login(){
        return view('students.login');
    }
    public function postLogin(LoginRequest $request)
    {
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::guard('students')->attempt($arr)) {
            return redirect()->route('students.dashboard');
        } else if(Student::where('email', $arr['email'])->exists()) {
            $errorMessage = ['password' => 'Mật khẩu không đúng.'];
            return back()->withInput()->withErrors($errorMessage);
        } else {
            $errorMessage = ['email' => 'Tài khoản không tồn tại.'];
            return back()->withInput()->withErrors($errorMessage);
        }
    }
    public function updateProfile(UpdateProfileStudentRequest $request){
        try {
            $id = Auth::guard('students')->user()->id;
            $image = $request->file('image');
            $teacher = Student::find($id);
            $teacher->name = $request->name;
            $teacher->email = $request->email;
            $teacher->phone = $request->phone;
            $teacher->birthday = $request->birthday;
            if(isset($request->password) && !empty($request->password)){
                $teacher->password = bcrypt($request->password);
            }
            if($request->hasFile('image')){
                $pathInfor = $this->uploadFile($image, Student::FOLDER);
                $teacher->image = Student::DIR.'/'.$pathInfor;
            }
            $student = Student::find($id);
            if($student){
                $image = $student->image;
                $checkImage = Student::FOLDER.'/'.pathinfo($image)['basename'];
                if($checkImage && $image != null){
                    $this->deleteFile($checkImage);
                }
            }
            $teacher->save();
                return back()->with('success', 'Cập nhật thành công.');
            } catch (\Exception $e) {
                if(!file_exists($pathInfor)){
                    $this->deleteFile($pathInfor);
                 }
                Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
                return back()->with('error', 'Cập nhật không thành công.');
            }
    }
}
