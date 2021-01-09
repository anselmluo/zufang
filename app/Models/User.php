<?php

namespace App\Models;

use App\Models\Traits\Btn;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //trait类，和继承效果一样
    use SoftDeletes,Btn;
    //软删除标识字段
    protected $dates = ['deleted_at'];
    //
    protected $guarded=[];
    protected $hidden = ['password'];

    //角色属于
    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }
}
