<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithHeadings
{
    use Exportable;
    public function query()
    {
        return User::query()->select(['id', 'full_name', 'user_name', 'email']);
    }

    public function headings(): array
    {
        return [
            'STT',
            'Họ và tên',
            'Tên đăng nhập',
            'Email',
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->full_name,
            $user->user_name,
            $user->email,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => '@',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->setTitle('Users');
                $event->sheet->setAutoSize(true);
            },
        ];
    }
}
