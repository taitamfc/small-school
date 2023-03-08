<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Teacher;
use App\Http\Requests\ImportTeacherRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TeacherExport;
use App\Imports\TeacherImport;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
       
       try {
        $teachers = new Teacher();
        $teachers->name = $request->name;
        $teachers->email = $request->email;
        $teachers->password = bcrypt($request->password);
        $teachers->level = $request->level;
        $teachers->status = $request->status;
        $teachers->save();
        return redirect()->route('teachers.create')->with('success', 'Thêm giáo viên thành công.');
       } catch (\Exception $e) { 
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
        try {
        $teachers = Teacher::find($id);
        $teachers->name = $request->name;
        $teachers->email = $request->email;
        if(isset($request->password) && !empty($request->password)){
            $teachers->password = bcrypt($request->password);
        }
        $teachers->level = $request->level;
        $teachers->status = $request->status;
        $teachers->save();
            return redirect()->route('teachers.index')->with('success', 'Cập nhật thành công.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return redirect()->route('teachers.index')->with('error', 'Cập nhật không thành công.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
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
            try {
                Excel::import(new TeacherImport, $request->file('importTeacher'));
                return back()->with('success', 'Import thành công!.');
            } catch (\Exception $e) {
                Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
                return back()->with('error', 'Import không thành công!(Hãy kiểm tra các trường trong file excel đã đủ các trường?[STT, Tên,Email,Mật khẩu,level]).');
            }
          
        }
    }

