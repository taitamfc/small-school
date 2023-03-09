<?php

namespace App\Http\Controllers;

use App\Exports\StudentExport;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Imports\StudentImport;
use App\Traits\UploadFileTrait;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    use UploadFileTrait;
    public function __construct()
    {
        $this->model = new Student();
    }

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
            $image = $request->file('image');
            $dataRequest = [
                'name' => $request->get('name'),
                'phone' => $request->get('phone'),
                'room_name' => $request->get('room_name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'birthday' => $request->get('birthday'),
                'status' => $request->get('status'),
            ];
            if($request->hasFile('image')){
                $pathInfor = $this->uploadFile($image, Student::FOLDER);
                $dataRequest['image'] = Student::DIR.'/'.$pathInfor;
            }
        try {
            Student::create($dataRequest);
            return redirect()->route('student.index')->with('success', 'Thêm học sinh thành công.');
        } catch (\Exception $e) {
            if(!file_exists($pathInfor)){
               $this->deleteFile($pathInfor);
            }
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Thêm học sinh không thành công!.');
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
        $image = $request->file('image');
        $dataRequest = [
            'naame' => $request->get('name'),
            'phonea' => $request->get('phone'),
            'room_name' => $request->get('room_name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'birthday' => $request->get('birthday'),
            'status' => $request->get('status'),
        ];
        if($request->hasFile('image')){
            $pathInfor = $this->uploadFile($image, Student::FOLDER);
            $dataRequest['image'] = Student::DIR.'/'.$pathInfor;
        }
        try {
            $student = Student::find($id);
            if($student){
                $image = $student->image;
                $checkImage = Student::FOLDER.'/'.pathinfo($image)['basename'];
                if($checkImage && $image != null){
                    $this->deleteFile($checkImage);
                }
            }
            Student::findOrFail($id)->update($dataRequest);
            return redirect()->route('student.index')->with('success', 'Thêm học sinh thành công.');
        } catch (\Exception $e) {
            if(isset($pathInfor)){
                $this->deleteFile($pathInfor);
            }
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Thêm học sinh không thành công!.');
        }
    }

        public function destroy( $id)
    {
        try {
            $student = Student::find($id);
            $image = $student->image;
            $student->delete();
                $checkImage = Student::FOLDER.'/'.pathinfo($image)['basename'];
                if($checkImage && $image != null){
                    $this->deleteFile($checkImage);
                }
            return back()->with('success', 'Xóa học sinh thành công!.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->with('error', 'Xóa học sinh không thành công!.');
        }

    }

    public function export()
    {
        try {
            return Excel::download(new StudentExport, 'student.xlsx');
            Session::flash('success','Export thành công');
            return back();
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
        try {
            Excel::import(new StudentImport, $request->file('import_student')->store('temp'));
            Session::flash('success','Import thành công');
            return redirect()->route('student.index');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            if($failures){
                return redirect()->route('student.index')->with(['failures' => $failures]);
            }
        }

    }
}
