<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ImportUserRequest;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\UploadFileTrait;
use Yajra\DataTables\EloquentDataTable;
use DataTables;

class UserController extends Controller
{   
    use UploadFileTrait;
    public function index(Request $request)
    {   $this->authorize('viewAny', User::class);
        $group_id         = $request->group_id ?? '';
        $search           = $request->key ?? '';
        $full_name        = $request->full_name ?? '';
        $item_name        = $request->user_name ?? '';
        $orderby          = $request->orderby ?? '';
        $email            = $request->email ?? '';
        $groups = Group::all();
        $query = User::query(true);
        $query->orderBy('id', 'DESC');
        if (!empty($group_id)) {
            $query->where('group_id',  $request->group_id);
        };
        if (!empty($orderby)) {
            $query->orderBy('id', $orderby);
        }
        if (!empty($full_name)) {
            $query->where('full_name', 'like', '%' . $full_name . '%');
        }
        if (!empty($item_name)) {
            $query->where('user_name', 'like', '%' . $item_name . '%');
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
        $items = $query->paginate(5);
        $params = [
            'items'        => $items,
            'groups'     => $groups,
        ];
        return view('admin.users.index',$params);
    }

  
    public function create()
    {   
        $this->authorize('create', User::class);
        $groups = Group::all();
        $params = [
            'item'      => new User(),
            'groups'    => $groups,
        ];
        return view('admin.users.create',$params);
    }

 
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        $data = $request->except(['_token','_method']);
        if( isset($data['password']) ){
            $data['password'] = bcrypt($data['password']);
        }
        if($request->hasFile('image')){
            $image = $request->file('image');
            $pathInfor = $this->uploadFile($image, User::FOLDER);
            $data['image'] = User::DIR.'/'.$pathInfor;
        }
        try {
            User::create($data);
            return redirect()->route('users.index')->with('success', 'Thêm thành công.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Thêm không thành công!.');
        }
    }

 
    public function show($id)
    {

    }

  
    public function edit($id)
    {   
        $this->authorize('update', User::class);
        $groups = Group::all();
        $item = User::find($id);
        $params = [
            'groups' => $groups,
            'item' => $item
        ];
        return view('admin.users.edit', $params);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $this->authorize('update', User::class);
        $data = $request->except(['_token','_method']);
        if( isset($data['password']) && $data['password'] ){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }
        if( isset($data['recurrence_days']) ){
            $data['recurrence_days'] = implode(',',$data['recurrence_days']);
        }
        if($request->hasFile('image')){
            $image = $request->file('image');
            $pathInfor = $this->uploadFile($image, User::FOLDER);
            $data['image'] = User::DIR.'/'.$pathInfor;
        }
        try {
            User::find($id)->update($data);
            return redirect()->route('users.index')->with('success', 'Thêm thành công.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Thêm không thành công!.');
        }

    }

   
    public function destroy( $id)
    {   
        $this->authorize('delete', User::class);
        try {
            $item = User::find($id);
            $image = $item->avatar;
            $item->delete();
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
        $this->authorize('export', User::class);
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
        $this->authorize('import', User::class);
        try {
            Excel::import(new UsersImport, $request->file('importUser'));
            return redirect()->route('users.index')->with('success', 'Import thành công!.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return redirect()->route('users.index')->with('error', 'Import không thành công!(Hãy kiểm tra các trường trong file excel đã đủ các trường?[STT, Họ và tên, Tên đăng nhập, Email, Mật khẩu]).');
        }
      
    }

    public function viewImport(){
        $this->authorize('import', User::class);
        return view('admin.users.import');
    }

    public function dataTable(Request $request){
        $model  = User::query(true);
        return DataTables::eloquent($model)
        ->filter(function ($query) {
            if (request()->has('f_name')) {
                $query->where('full_name', 'like', "%" . request('f_name') . "%");
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
