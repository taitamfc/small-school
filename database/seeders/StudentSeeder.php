<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $c1022 = [
            'Huyền','Nho','Phong','Ngọc','Phong Tâm'
        ];
        $c0223 = [
            'Cường','Phi','Hiếu','Long','Khương'
        ];
        foreach( $c1022 as $student ){
            DB::table('students')->insert([
                'name' => $student,
                'phone' => 123456,
                'room_name' => 'c1022',
                'email' => Str::slug($student).'@gmail.com',
                'password' => bcrypt('admin'),
                'image' => 'no-image.png',
                'birthday' => date("Y-m-d"),
                'status' => 'hoat_dong',
            ]);
        }
        
    }
}
