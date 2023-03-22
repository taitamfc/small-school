<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'group_id' => 1
            ],
            [
                'name' => 'Student Care 1',
                'group_id' => 3
            ],
            [
                'name' => 'Student Care 2',
                'group_id' => 3
            ],
            [
                'name' => 'Saler 1',
                'group_id' => 4
            ],
            [
                'name' => 'Saler 2',
                'group_id' => 4
            ]
        ];
        foreach( $users as $u_data ){
            $user = new User();
            $user->full_name    = $u_data['name'];
            $user->user_name    = Str::slug($u_data['name'],'_');
            $user->email        = Str::slug($u_data['name'],'_').'@gmail.com';
            $user->password     = bcrypt('admin');
            $user->group_id     = $u_data['group_id'];
            $user->save();
        }
        
    }
}
