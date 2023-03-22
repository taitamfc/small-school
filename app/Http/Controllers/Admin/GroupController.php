<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Group;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GroupController extends Controller
{
   
    public function index()
    {   
        $this->authorize('viewAny', Group::class);
        $groups = Group::search()->latest()->paginate(5);
        return view('admin.groups.index', compact('groups'));
    }

  
    public function create()
    {   
        $this->authorize('create', Group::class);
        $parent_roles = Role::where('group_key', 0)->get();
        return view('admin.groups.create',compact('parent_roles'));
    }

  
    public function store(StoreGroupRequest $request)
    {   
        $this->authorize('create', Group::class);
        try {
            $role = Group::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            $role->roles()->attach($request->roles_id);
            return redirect()->route('groups.index')->with('success', 'Thêm chức vụ thành công.');
        } catch (\Exception$e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Thêm chức vụ không thành công.');;
        }

    }

  
    public function show(string $id)
    {
    }

   
    public function edit(string $id)
    {
        try {
            $this->authorize('update', Group::class);
            $group = Group::find($id);
            $roles_checked = $group->roles;
            $parent_roles = Role::where('group_key', 0)->get();

            $params = [
                'group' => $group,
                'roles_checked' => $roles_checked,
                'parent_roles' => $parent_roles,
            ];
            return view('admin.groups.edit', $params);
        } catch (\Exception$e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput();
        }
    }

   
    public function update(UpdateGroupRequest $request,$id)
    {
        $this->authorize('update', Group::class);
        try {
            $group = Group::find($id);
            $group->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            $group->roles()->sync($request->roles_id);
            return redirect()->route('groups.index')->with('success', 'Chỉnh sửa chức vụ thành công.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Chỉnh sửa chức vụ không thành công.');
        }
    }

    public function destroy(string $id)
    {   
        $this->authorize('delete', Group::class);
        try {
            $group = Group::find($id);
            DB::table('group_roles')->where('group_id', '=', $group->id)->delete();
            $group->delete();
            return redirect()->route('groups.index')->with('success', 'Xóa chức vụ thành công.');;
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Xóa chức vụ không thành công.');;
        }
    }
}
