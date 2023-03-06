<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
            'name' => Str::random(10),
            'phone' => Str::random(10),
            'room_name' => Str::random(10),
            'email' => Str::random(10),
            'password' => Hash::make('password'),
            'image' => Str::random(10),
            'birthday' => Str::random(10),
            'status' => Str::random(10),
        ]);
    }
}
