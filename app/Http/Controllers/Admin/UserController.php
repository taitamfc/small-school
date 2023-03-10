<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ImportUserRequest;
use App\Models\Group;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{   

    public function index(Request $request)
    {    
        $group_id         = $request->group_id ?? '';
        $search           = $request->key ?? '';
        $full_name        = $request->full_name ?? '';
        $user_name        = $request->user_name ?? '';
        $orderby          = $request->orderby ?? '';
        $email            = $request->email ?? '';
        $groups = Group::all();
        $query = User::query(true);
    
        if (!empty($group_id)) {
            $query->where('group_id',  $request->group_id);
        };
        if (!empty($orderby)) {
            $query->orderBy('id', $orderby);
        }
        if (!empty($full_name)) {
            $query->where('full_name', 'like', '%' . $full_name . '%');
        }
        if (!empty($user_name)) {
            $query->where('user_name', 'like', '%' . $user_name . '%');
        }
        if (!empty($email)) {
            $query->where('email', 'like', '%' . $email . '%');
        }
        if (!empty($search)) {
            $query->where(function($query) use ($search) {
                $query->where('user_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('full_name', 'like', '%' . $search . '%');
            });
        }
        $users = $query->paginate(5);
        $params = [
            'users'        => $users,
            'groups'     => $groups,
        ];
        return view('admin.users.index',$params);
    }

  
    public function create()
    {   $groups = Group::all();
        return view('admin.users.create',compact('groups'));
    }

 
    public function store(StoreUserRequest $request)
    {
     
        try {
        $user = new User();
        $user->user_name = $request->user_name;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->group_id = $request->group_id;
        $user->password = bcrypt($request->password);
        $fieldName = 'inputFile';
        if ($request->hasFile($fieldName)) {
            $fullFileNameOrigin = $request->file($fieldName)->getClientOriginalName();
            $fileNameOrigin = pathinfo($fullFileNameOrigin, PATHINFO_FILENAME);
            $extenshion = $request->file($fieldName)->getClientOriginalExtension();
            $fileName = $fileNameOrigin . '-' . rand() . '_' . time() . '.' . $extenshion;
            $path = 'storage/' . $request->file($fieldName)->storeAs('public/images/users', $fileName);
            $path = str_replace('public/', '', $path);
            $user->avatar = $path;
        }
            $user->save();
            return redirect()->route('users.index')->with('success', 'Thêm tài khoản thành công.');
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
    {   $groups = Group::all();
        $user = User::find($id);
        $params = [
            'groups' => $groups,
            'user' => $user
        ];
        return view('admin.users.edit', $params);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = User::find($id);
            $user->user_name = $request->user_name;
            $user->full_name = $request->full_name;
            $user->email = $request->email;
            $user->group_id = $request->group_id;
            if(isset($request->password) && !empty($request->password)){$user->password = bcrypt($request->password);}
            $fieldName = 'inputFile';
            if ($request->hasFile($fieldName)) {
                $fullFileNameOrigin = $request->file($fieldName)->getClientOriginalName();
                $fileNameOrigin = pathinfo($fullFileNameOrigin, PATHINFO_FILENAME);
                $extenshion = $request->file($fieldName)->getClientOriginalExtension();
                $fileName = $fileNameOrigin . '-' . rand() . '_' . time() . '.' . $extenshion;
                $path = 'storage/' . $request->file($fieldName)->storeAs('public/images/users', $fileName);
                $path = str_replace('public/', '', $path);
                $user->avatar = $path;
            }
                $user->save();
                return redirect()->route('users.index')->with('success', 'Cập nhật tài khoản thành công.');
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
            $user = User::find($id);
            $image = $user->avatar;
            $user->delete();
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

    public function import(ImportUserRequest $request) 
    {   
        try {
            Excel::import(new UsersImport, $request->file('importUser'));
            return redirect()->route('users.index')->with('success', 'Import thành công!.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return redirect()->route('users.index')->with('error', 'Import không thành công!(Hãy kiểm tra các trường trong file excel đã đủ các trường?[STT, Họ và tên, Tên đăng nhập, Email, Mật khẩu]).');
        }
      
    }

    public function viewImport(){
        return view('admin.users.import');
    }

}
