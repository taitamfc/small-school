<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table('students')->insert([
            'name' => fake()->name(),
            'phone' => Str::random(10).'number',
            'room_name' => Str::random(10),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('123456'),
            'image' => '',
            'birthday' => date("Y-m-d"),
            'status' => 1,
        ]);
    }
}
