<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\StudentExport;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Requests\UpdateProfileStudentRequest;
use App\Imports\StudentImport;
use App\Traits\UploadFileTrait;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use DataTables;

class StudentController extends Controller
{
    use UploadFileTrait;
    public function __construct()
    {
        $this->model = new Student();
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Student::class);
        $search           = $request->key ?? '';
        $name             = $request->name ?? '';
        $orderby          = $request->orderby ?? '';
        $email            = $request->email ?? '';
        $phone            = $request->phone ?? '';
        $room_name        = $request->room_name ?? '';
        $birthday        = $request->birthday ?? '';

        $query = Student::query(true);

        if (!empty($orderby)) {
            $query->orderBy('id', $orderby);
        }
        if (!empty($name)) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if (!empty($birthday)) {
            $query->where('birthday', 'like', '%' . $birthday . '%');
        }
        if (!empty($email)) {
            $query->where('email', 'like', '%' . $email . '%');
        }
        if (!empty($phone)) {
            $query->where('phone', 'like', '%' . $phone . '%');
        }
        if (!empty($room_name)) {
            $query->where('room_name', 'like', '%' . $room_name . '%');
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
    {   
        $this->authorize('create', Student::class);
        $students = Student::all();
        return view('admin.students.create',compact('students'));
    }


    public function store(StoreStudentRequest $request)
    {
            $this->authorize('create', Student::class);
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
        $this->authorize('update', Student::class);
        $student = Student::find($id);
        $params = [
            'student' => $student
        ];
        return view('admin.students.edit', $params);
    }

    public function update(UpdateStudentRequest $request, $id)
    {
        $this->authorize('update', Student::class);
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
        $this->authorize('delete', Student::class);
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
        $this->authorize('export', Student::class);
        try {
            return Excel::download(new StudentExport, 'student.xlsx');
            Session::flash('success','Xuất tài liệu thành công');
            return back();
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->with('error', 'Xuất tài liệu không thành công!.');
        }
    }

    public function import(Request $request)
    {
        $this->authorize('import', Student::class);
        $validator = Validator::make($request->all(), [
            'import_student'   => 'required',
        ],[
            'import_student.required' => 'Vui lòng chọn tài liệu để nhập',
//            'import_student.mimes' => 'Vui lòng chọn file đúng định dạng xlsx'
        ]);

        if ($validator->fails()) {
            return redirect('students')
                ->withErrors($validator)
                ->withInput();
        }
        try {
            Excel::import(new StudentImport, $request->file('import_student')->store('temp'));
            Session::flash('success','Nhập tài liệu thành công');
            return redirect()->route('student.index');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            if($failures){
                return redirect()->route('student.index')->with(['failures' => $failures]);
            }
        }

    }
    public function profile(){
        if(isset(Auth::guard('students')->user()->name)){
            $student = Auth::guard('students')->user();
            return view('admin.students.profile', compact('student'));
        }
    }
    public function updateProfile(UpdateProfileStudentRequest $request, string $id){
        try {
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
    public function viewImport(){
        $this->authorize('import', Student::class);
        return view('admin.students.import');
    }
    public function dataTable(Request $request){
        $model  = Student::query(true);
        return DataTables::eloquent($model)
        ->filter(function ($query) {
            if (request()->has('f_name')) {
                $query->where('name', 'like', "%" . request('f_name') . "%");
            }
            if (request()->has('f_phone')) {
                $query->where('phone', 'like', "%" . request('f_phone') . "%");
            }
            if (request()->has('f_email')) {
                $query->where('email', 'like', "%" . request('f_email') . "%");
            }
            if (request()->has('f_room_id')) {
                
            }
        })
        ->toJson();
    }
}
