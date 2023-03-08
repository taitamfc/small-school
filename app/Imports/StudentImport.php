<?php

namespace App\Imports;

use App\Models\Student;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements ToModel, WithHeadingRow, WithValidation
{
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return Carbon::createFromFormat($format, $value);
        }
    }
     public function model(array $row)
     {
         return new Student([
             'name'  => $row['name'],
             'email' => $row['email'],
             'birthday'    => $this->transformDate((int)$row['birthday']),
             'phone'    => $row['phone'],
             'status'    => $row['status'],
             'room_name'    => $row['room_name'],
             'password' => bcrypt(123456),
             'image' => '/asset/plugins/img/avatar4.png'
         ]);
     }

     public function rules(): array
     {
         return [
             '*.name' => [
                 'required',
             ],
             '*.email' => [
                 'required',
                'unique:students,email'
             ],
             '*.birthday' => [
                 'required'
             ],
             '*.phone' => [
                 'required',
                 'unique:students,phone'
             ],
             '*.status' => [
                 'required'
             ],
         ];
     }

     public function headingRow(): int
     {
         return 2;
     }


 }
