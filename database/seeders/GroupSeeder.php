<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;
use Illuminate\Support\Facades\DB;



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
        $group->name = 'Quản lý';
        $group->save();

        $group = new Group();
        $group->name = 'Chăm sóc học viên';
        $group->save();

        $group = new Group();
        $group->name = 'Bán hàng';
        $group->save();
    }
}
