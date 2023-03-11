<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;


class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $group = new Room();
        $group->name = 'C1022';
        $group->save();

        $group = new Room();
        $group->name = 'C0223';
        $group->save();
    }
}
