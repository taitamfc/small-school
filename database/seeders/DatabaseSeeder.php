<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GroupSeeder::class,
            UserSeeder::class,
            RoleSeeder::class,
            GroupRoleSeeder::class,
            RoomSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            TaskSeeder::class,
            CourseSeeder::class,
        ]);
    }
}
