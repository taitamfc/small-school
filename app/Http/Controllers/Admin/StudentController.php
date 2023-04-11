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
use App\Models\User;
use App\Models\Teacher;
use App\Models\Room;
use App\Models\Course;
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
        $query->orderBy('id', 'DESC');
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
        $items = $query->paginate(20);
        $params = [
            'items'        => $items,
        ];
        return view('admin.students.index',$params);
    }


    public function create()
    {   
        $this->authorize('create', Student::class);
        $item = new Student();
        $teachers = Teacher::all();
        $rooms = Room::all();
        $courses = Course::all();
        $student_carers = User::where('group_id',env('STUDENT_CARE_GI',3))->get();
        $salers = User::where('group_id',env('SALER_GI',4))->get();
        $params = [
            'item'              => $item,
            'teachers'          => $teachers,
            'rooms'          => $rooms,
            'salers'            => $salers,
            'courses'            => $courses,
            'student_carers'    => $student_carers,
        ];
        return view('admin.students.create',$params);
    }


    public function store(StoreStudentRequest $request)
    {
        $this->authorize('create', Student::class);
        $data = $request->except(['_token','_method']);
        if( isset($data['password']) ){
            $data['password'] = bcrypt($data['password']);
        }
        if($request->hasFile('image')){
            $image = $request->file('image');
            $pathInfor = $this->uploadFile($image, Student::FOLDER);
            $data['image'] = Student::DIR.'/'.$pathInfor;
        }
        try {
            Student::create($data);
            return redirect()->route('students.index')->with('success', 'Lưu thành công.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Lưu không thành công!.');
        }
    }


    public function show($id)
    {

    }


    public function edit($id)
    {
        $this->authorize('update', Student::class);
        $item = Student::find($id);
        // dd($item->events);
        $teachers = Teacher::all();
        $salers = Teacher::all();
        $rooms = Room::all();
        $courses = Course::all();
        $student_carers = User::where('group_id',env('STUDENT_CARE_GI',3))->get();
        $salers = User::where('group_id',env('SALER_GI',4))->get();
        $params = [
            'item'              => $item,
            'teachers'          => $teachers,
            'rooms'          => $rooms,
            'salers'            => $salers,
            'student_carers'    => $student_carers,
            'courses'    => $courses,
        ];
        return view('admin.students.edit', $params);
    }

    public function update(UpdateStudentRequest $request, $id)
    {
        $this->authorize('update', Student::class);
        $data = $request->except(['_token','_method']);
        if( isset($data['password']) ){
            $data['password'] = bcrypt($data['password']);
        }
        if($request->hasFile('image')){
            $image = $request->file('image');
            $pathInfor = $this->uploadFile($image, Student::FOLDER);
            $data['image'] = Student::DIR.'/'.$pathInfor;
        }
        try {
            Student::find($id)->update($data);
            return redirect()->route('students.index')->with('success', 'Lưu thành công.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Lưu không thành công!.');
        }
    }

    public function destroy( $id)
    {
        $this->authorize('delete', Student::class);
        try {
            $item = Student::find($id);
            $image = $item->image;
            $item->delete();
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
            $item = Auth::guard('students')->user();
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
            $item = Student::find($id);
            if($item){
                $image = $item->image;
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
            $query->where('id', '>', 0);
            if (request('f_name')) {
                $query->where('name', 'like', "%" . request('f_name') . "%");
            }
            if (request('f_phone')) {
                $query->where('phone', 'like', "%" . request('f_phone') . "%");
            }
            if (request('f_email')) {
                $query->where('email', 'like', "%" . request('f_email') . "%");
            }
            if (request('f_room_id')) {
                $query->where('room_id', request('f_room_id') );
            }
        })
        ->toJson();
    }
}
