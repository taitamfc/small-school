<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    public $statuses = [
        'hoat_dong' => 'Hoạt động',
        'khong_hoat_dong' => 'Không hoạt động',
    ];
    protected $fillable = [
        'name','description','content','image','price'
    ];
}
