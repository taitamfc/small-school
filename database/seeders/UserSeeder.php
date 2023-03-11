<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->full_name = 'admin';
        $user->user_name = 'admin';
        $user->email = 'admin@gmail.com' ;
        $user->password = bcrypt('admin');
        $user->group_id = 1;
        $user->save();
    }
}
