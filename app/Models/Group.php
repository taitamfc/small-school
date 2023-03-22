<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'groups';
    protected $fillable = ['name','description'];
    public function users()
    {
        return $this->hasMany(User::class,'group_id','id');
    }
    public function roles() {
        return $this->belongsToMany(Role::class,'group_roles','group_id','role_id');
    }
    public function scopeSearch($query)
    {
        if ($key = request()->key) {
            $query->where('name', 'like', '%' . $key . '%');
        }
        return $query;
    }
}
