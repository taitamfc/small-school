<?php

namespace App\Imports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithStartRow;
class TeacherImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $teacher = Teacher::where('email', $row[3])->first();
        if (!$teacher) {
            return new Teacher([
                'name' => $row[1],
                'email' => $row[2], 
                'level' => $row[3], 
                'password' => Hash::make($row[4]),
                'created_at' => now()
            ]);
        }

        return null;
    }
    public function startRow(): int
    {
        return 2;
    }
}