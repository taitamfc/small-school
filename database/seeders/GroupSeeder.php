<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;


class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $group = new Group();
        $group->name = 'Quản trị viên';
        $group->save();

        $group = new Group();
        $group->name = 'Giáo viên';
        $group->save();

        $group = new Group();
        $group->name = 'Sinh viên';
        $group->save();
    }
}
