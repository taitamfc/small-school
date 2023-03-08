<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Imports\StudentImport;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search           = $request->key ?? '';
        $name             = $request->name ?? '';
        $orderby          = $request->orderby ?? '';
        $email            = $request->email ?? '';
        $phone            = $request->phone ?? '';
        $room_name        = $request->room_name ?? '';

        $query = Student::query(true);

        if (!empty($orderby)) {
            $query->orderBy('id', $orderby);
        }
        if (!empty($name)) {
            $query->orWhere('name', 'like', '%' . $name . '%');
        }
        if (!empty($email)) {
            $query->orWhere('email', 'like', '%' . $email . '%');
        }
        if (!empty($phone)) {
            $query->orWhere('phone', 'like', '%' . $phone . '%');
        }
        if (!empty($room_name)) {
            $query->orWhere('room_name', 'like', '%' . $room_name . '%');
        }
        if (!empty($search)) {
            $query->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('room_name', 'like', '%' . $search . '%');

            });
        }
        $students = $query->paginate(5);
        $params = [
            'students'        => $students,
        ];
        return view('admin.students.index',$params);
    }


    public function create()
    {   $students = Student::all();
        return view('admin.students.create',compact('students'));
    }


    public function store(StoreStudentRequest $request)
    {

        try {
            $student = new Student();
            $student->name = $request->name;
            $student->phone = $request->phone;
            $student->room_name = $request->room_name;
            $student->email = $request->email;
            $student->password = bcrypt($request->password);
            $student->birthday = $request->birthday;
            $student->status = $request->status;
            $fieldName = 'inputFile';
            if ($request->hasFile($fieldName)) {
                $fullFileNameOrigin = $request->file($fieldName)->getClientOriginalName();
                $fileNameOrigin = pathinfo($fullFileNameOrigin, PATHINFO_FILENAME);
                $extenshion = $request->file($fieldName)->getClientOriginalExtension();
                $fileName = $fileNameOrigin . '-' . rand() . '_' . time() . '.' . $extenshion;
                $path = 'storage/' . $request->file($fieldName)->storeAs('public/images/users', $fileName);
                $path = str_replace('public/', '', $path);
                $student->image = $path;
            }

            $student->save();
            return redirect()->route('student.index')->with('success', 'Thêm tài khoản thành công.');
        } catch (\Exception $e) {
            if(isset($path)){
                $images = str_replace('storage', 'public', $path);
                Storage::delete($images); }
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Thêm tài khoản không thành công!.');
        }
    }


    public function show($id)
    {

    }


    public function edit($id)
    {
        $student = Student::find($id);
        $params = [
            'student' => $student
        ];
        return view('admin.students.edit', $params);
    }

    public function update(UpdateStudentRequest $request, $id)
    {
        try {
            $student = Student::find($id);
            $student->name = $request->name;
            $student->phone = $request->phone;
            $student->room_name = $request->room_name;
            $student->email = $request->email;
            $student->birthday = $request->birthday;
            $fieldName = 'inputFile';
            if ($request->hasFile($fieldName)) {
                $fullFileNameOrigin = $request->file($fieldName)->getClientOriginalName();
                $fileNameOrigin = pathinfo($fullFileNameOrigin, PATHINFO_FILENAME);
                $extenshion = $request->file($fieldName)->getClientOriginalExtension();
                $fileName = $fileNameOrigin . '-' . rand() . '_' . time() . '.' . $extenshion;
                $path = 'storage/' . $request->file($fieldName)->storeAs('public/images/users', $fileName);
                $path = str_replace('public/', '', $path);
                $student->image = $path;
            }
            $student->save();
            return redirect()->route('student.index')->with('success', 'Cập nhật tài khoản thành công.');
        } catch (\Exception $e) {
            if(isset($path)){
                $images = str_replace('storage', 'public', $path);
                Storage::delete($images); }
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Cập nhật tài khoản không thành công!.');
        }
    }

        public function destroy( $id)
    {
        try {
            $student = Student::find($id);
            $image = $student->image;
            $student->delete();
            $images = str_replace('storage', 'public', $image);
            Storage::delete($images);

            return back()->with('success', 'Xóa tài khoản thành công!.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->with('error', 'Xóa tài khoản không thành công!.');
        }

    }

    public function export()
    {
        try {
            return Excel::download(new UsersExport, 'users.xlsx');
            return back()->with('success', 'Export thành công!.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->with('error', 'Export không thành công!.');
        }
    }

    public function import(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'import_student'   => 'required',
        ],[
            'import_student.required' => 'Vui lòng chọn file để import',
//            'import_student.mimes' => 'Vui lòng chọn file đúng định dạng xlsx'
        ]);

        if ($validator->fails()) {
            return redirect('students')
                ->withErrors($validator)
                ->withInput();
        }
        $import = Excel::import(new StudentImport, $request->file('import_student')->store('temp'));

        dd($import);
    }
}
