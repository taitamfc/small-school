<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   
        public function run(): void
        {
            $teachers = [
                'tam','khang'
            ];
            foreach( $teachers as $teacher ){
                DB::table('teachers')->insert([
                    'name'      => $teacher,
                    'email'     => $teacher.'@gmail.com',
                    'password'  => bcrypt('admin'),
                    'level'     => 1,
                    'status'    => 'hoat_dong',
                ]);
            }
        }
    }
   

