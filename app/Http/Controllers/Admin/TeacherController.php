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
        $phone        = $request->phone ?? '';
        $query = Teacher::query(true);
        $query->orderBy('id','DESC');
    
        if (!empty($name)) {
            $query->where('name', 'like', '%' . $search .$name. '%');
        }
        if (!empty($search)) {
                $query->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        if (!empty($email)) {
            $query->where('email', 'like', '%' . $email. '%');
           
        }
        if (!empty($phone)) {
            $query->where('phone', 'like', '%' . $phone. '%');
        }
       
        
        $items = $query->paginate(20);
        $params = [
            'items'        => $items,
        ];
        return view('admin.teachers.index',$params);
    
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Teacher::class);
        $item = new Teacher();
        $param = [
            'item' => $item,
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
        $item = new Teacher();
        $item->name = $request->name;
        $item->email = $request->email;
        $item->password = bcrypt($request->password);
        $item->level = $request->level;
        $item->status = $request->status;
        $fieldName = 'inputFile';
        if ($request->hasFile($fieldName)) {
            $fullFileNameOrigin = $request->file($fieldName)->getClientOriginalName();
            $fileNameOrigin = pathinfo($fullFileNameOrigin, PATHINFO_FILENAME);
            $extenshion = $request->file($fieldName)->getClientOriginalExtension();
            $fileName = $fileNameOrigin . '-' . rand() . '_' . time() . '.' . $extenshion;
            $path = 'storage/' . $request->file($fieldName)->storeAs('public/images/teachers', $fileName);
            $path = str_replace('public/', '', $path);
            $item->image = $path;
        }
        $item->save();
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
        $item = Teacher::find($id);
        $param = [
            'item' => $item,
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
        $item = Teacher::find($id);
        $item->name = $request->name;
        $item->email = $request->email;
        if(isset($request->password) && !empty($request->password)){
            $item->password = bcrypt($request->password);
        }
        $item->level = $request->level;
        $item->status = $request->status;
        $fieldName = 'inputFile';
        if ($request->hasFile($fieldName)) {
            $fullFileNameOrigin = $request->file($fieldName)->getClientOriginalName();
            $fileNameOrigin = pathinfo($fullFileNameOrigin, PATHINFO_FILENAME);
            $extenshion = $request->file($fieldName)->getClientOriginalExtension();
            $fileName = $fileNameOrigin . '-' . rand() . '_' . time() . '.' . $extenshion;
            $path = 'storage/' . $request->file($fieldName)->storeAs('public/images/teachers', $fileName);
            $path = str_replace('public/', '', $path);
            $item->image = $path;
        }
        $item->save();
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
            $item = Teacher::find($id);
            $item->delete();
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
                $item = Auth::guard('teachers')->user();
                return view('admin.teachers.profile', compact('teacher'));
            }
        }
        public function updateProfile(UpdateProfileTeacherRequest $request, string $id){
            try {
                $item = Teacher::find($id);
                $item->name = $request->name;
                $item->email = $request->email;
                if(isset($request->password) && !empty($request->password)){
                    $item->password = bcrypt($request->password);
                }
                $images = str_replace('storage', 'public', $item->avatar);
                $fieldName = 'inputFile';
                if ($request->hasFile($fieldName)) {
                    $fullFileNameOrigin = $request->file($fieldName)->getClientOriginalName();
                    $fileNameOrigin = pathinfo($fullFileNameOrigin, PATHINFO_FILENAME);
                    $extenshion = $request->file($fieldName)->getClientOriginalExtension();
                    $fileName = $fileNameOrigin . '-' . rand() . '_' . time() . '.' . $extenshion;
                    $path = 'storage/' . $request->file($fieldName)->storeAs('public/images/teachers', $fileName);
                    $path = str_replace('public/', '', $path);
                    $item->image = $path;
                }
                $item->save();
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

