<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;


class GroupRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
}
