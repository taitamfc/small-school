<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $fillable = ['name', 'group_name'];
    function childrentroles(){
        return $this->hasMany(Role::class, 'group_key', 'id');
    }
    public function groups(){
        return $this->belongsToMany(Group::class,'group_roles','group_id','role_id');
    }
}
