<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithStartRow;
class UsersImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = User::where('email', $row[3])->first();
        if (!$user) {
            return new User([
                'full_name' => $row[1],
                'user_name' => $row[2], 
                'email' => $row[3], 
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
