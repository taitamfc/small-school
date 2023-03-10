<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Group;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

       

        $groups = ['User','Group' , 'Teacher', 'Student','Event'];
        $nameparent = ['Quản Trị Viên','Chức vụ', 'Giáo Viên', 'Sinh Viên', 'Lịch Trình'];
        $this->importGroup();
        $this->importRole($groups,$nameparent);
        $this->importGroupRole();
        $this->call([
            UserTableSeeder::class,
        ]);
    }

    public function importGroup()
    {
        $group = new Group();
        $group->name = 'Quản trị viên';
        $group->save();

        $group = new Group();
        $group->name = 'Giáo viên';
        $group->save();

        $group = new Group();
        $group->name = 'Sinh viên';
        $group->save();
    }
    public function importGroupRole()
    {   
        $roles = Role::all();
        foreach($roles as $role) {
            if($role->group_key == 0)
            {
                continue;
            }
            DB::table('group_roles')->insert([
                'group_id' => 1,
                'role_id' => $role->id,
            ]);
        }
    }
    public function importRole($groups,$nameparent){
        foreach($groups as $key => $parentNameGroup){
            $parentGroup = Role::create([
                'group_name' => $nameparent[$key], 
                'name' => $parentNameGroup,
                'group_key' => 0,
            ]);
           Role::create([
                'group_name' => 'Xem Trang '.$nameparent[$key],
                'name' => $parentNameGroup.'_viewAny',
                'group_key' => $parentGroup->id,
            ]);
           Role::create([
                'group_name' => 'Xem Chi Tiết '.$nameparent[$key],
                'name' => $parentNameGroup.'_view',
                'group_key' => $parentGroup->id,
            ]);
           Role::create([
                'group_name' => 'Thêm '.$nameparent[$key],
                'name' => $parentNameGroup.'_create',
                'group_key' => $parentGroup->id,
            ]);
           Role::create([
                'group_name' => 'Chỉnh Sửa '.$nameparent[$key],
                'name' => $parentNameGroup.'_update',
                'group_key' => $parentGroup->id,
            ]);
           Role::create([
                'group_name' => 'Xóa '.$nameparent[$key],
                'name' => $parentNameGroup.'_delete',
                'group_key' => $parentGroup->id,
            ]);
            Role::create([
                'group_name' => 'Nhập excel '.$nameparent[$key],
                'name' => $parentNameGroup.'_import',
                'group_key' => $parentGroup->id,
            ]);
            Role::create([
                'group_name' => 'Xuất excel '.$nameparent[$key],
                'name' => $parentNameGroup.'_export',
                'group_key' => $parentGroup->id,
            ]);
        
        }

    }
}
