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
            DB::table('teachers')->insert([
           [ 
            'name' => 'khang',
            'email' => 'cukhang@gmail.com',
            'password' =>bcrypt('admin'),
            'level' => 1,
            'status' => 10,
            ],
            [ 
                'name' => 'toàn',
                'email' => 'cutoan@gmail.com',
                'password' =>bcrypt('admin'),
                'level' => 2,
                'status' => 8,
                ],

                [ 
                    'name' => 'đỏ',
                    'email' => 'cudo@gmail.com',
                    'password' =>bcrypt('admin'),
                    'level' => 3,
                    'status' => 9,
                    ],

                    [ 
                        'name' => 'cún',
                        'email' => 'cucun@gmail.com',
                        'password' =>bcrypt('admin'),
                        'level' => 5,
                        'status' => 15,
                        ],
                        [ 
                            'name' => 'chó',
                            'email' => 'cho@gmail.com',
                            'password' =>bcrypt('admin'),
                            'level' => 1,
                            'status' => 10,
                            ],
        ]);  
        }
    }
   

