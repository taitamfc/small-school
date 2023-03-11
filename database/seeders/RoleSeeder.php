<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = ['User', 'Student', 'Teacher','Event'];
        $nameparent = ['Quản Trị Viên', 'Giáo Viên', 'Sinh Viên', 'Lịch Trình',];
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
        
        }
    }
}
