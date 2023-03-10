<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Teacher;
use App\Http\Requests\ImportTeacherRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TeacherExport;
use App\Imports\TeacherImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Teacher::class);
        $name         = $request->name ?? '';
        $search       = $request->key ?? '';
        $email        = $request->email ?? '';
        $level        = $request->level ?? '';
        $query = Teacher::query(true);
    
        if (!empty($name)) {
            $query->where('name', 'like', '%' . $search .$name. '%');
        }
        if (!empty($search)) {
                $query->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('level', 'like', '%' . $search . '%');
            });
        }
        if (!empty($email)) {
            $query->where('email', 'like', '%' . $search .$email. '%');
           
        }
        if (!empty($level)) {
            $query->where('level', 'like', '%' . $search .$level. '%');
        }
       
        
        $teachers = $query->paginate(5);
        $params = [
            'teachers'        => $teachers,
        ];
        return view('admin.teachers.index',$params);
    
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Teacher::class);
        $teachers = Teacher::get();
        $param = [
            'teachers' => $teachers,
        ];
        return view('admin.teachers.create', $param);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request)
    {
        $this->authorize('create', Teacher::class);
       try {
        $teacher = new Teacher();
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->password = bcrypt($request->password);
        $teacher->level = $request->level;
        $teacher->status = $request->status;
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
        return redirect()->route('teachers.index')->with('success', 'Cập nhật thành công.');
       } catch (\Exception $e) { 
        if(isset($path)){
            $images = str_replace('storage', 'public', $path);
            Storage::delete($images); }
        Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
        return redirect()->route('teachers.create')->with('error', 'Thêm giáo viên thất bại.');
       }      
       return redirect()->route('teachers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update', Teacher::class);
        $teacher = Teacher::find($id);
        $param = [
            'teacher' => $teacher,
        ];
        return view('admin.teachers.edit', $param);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherRequest $request, string $id)
    {
        $this->authorize('update', Teacher::class);
        try {
        $teacher = Teacher::find($id);
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        if(isset($request->password) && !empty($request->password)){
            $teacher->password = bcrypt($request->password);
        }
        $teacher->level = $request->level;
        $teacher->status = $request->status;
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
            return redirect()->route('teachers.index')->with('success', 'Cập nhật thành công.');
        } catch (\Exception $e) {
            if(isset($path)){
                $images = str_replace('storage', 'public', $path);
                Storage::delete($images); }
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return redirect()->route('teachers.index')->with('error', 'Cập nhật không thành công.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Teacher::class);
        try {
            $teacher = Teacher::find($id);
            $teacher->delete();
                return redirect()->route('teachers.index')->with('success', 'Xoá thành công.');
            } catch (\Exception $e) {
                Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
                return redirect()->route('teachers.index')->with('error', 'Xoá thất bại.');
            }
        }

        public function export() 
        {   
            $this->authorize('export', Teacher::class);
            try {
                return Excel::download(new TeacherExport, 'teachers.xlsx');
                return back()->with('success', 'Export thành công!.');
            } catch (\Exception $e) {
                Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
                return back()->with('error', 'Export không thành công!.');
            }
            
        }
    
        public function import(ImportTeacherRequest $request) 
        {   
            $this->authorize('import', Teacher::class);
            try {
                Excel::import(new TeacherImport, $request->file('importTeacher'));
                return back()->with('success', 'Import thành công!.');
            } catch (\Exception $e) {
                Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
                return back()->with('error', 'Import không thành công!(Hãy kiểm tra các trường trong file excel đã đủ các trường?[STT, Tên,Email,Mật khẩu,level]).');
            }
          
        }

        public function viewImport(){
            $this->authorize('import', Teacher::class);
            return view('admin.teachers.import');
        }

        public function profile(){
            if(isset(Auth::guard('teachers')->user()->name)){
                $teacher = Auth::guard('teachers')->user();
                return view('admin.teachers.profile', compact('teacher'));
            }
        }
        public function updateProfile(UpdateProfileTeacherRequest $request, string $id){
            try {
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

