<?php
namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentExport implements FromCollection
{
    public function collection()
    {
        return Student::select(['name', 'phone', 'email', 'status', 'room_name', 'birthday'])->get();
    }
}

