<?php
namespace App\Exports;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return User::all();
    }
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone'
        ];
    }
}