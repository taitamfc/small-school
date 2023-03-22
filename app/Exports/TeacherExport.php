<?php
namespace App\Exports;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class TeacherExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return Teacher::select('id','name','email','level')->get();
    }
    public function headings(): array
    {
        return [
            'STT',
            'Name',
            'Email',
            'Cấp độ'
        ];
    }
}