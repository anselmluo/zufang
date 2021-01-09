<?php

namespace App\Models;


class Article extends Base
{
    //追加字段,数据库实际没有该字段,需要集合访问器
    protected $appends = ['action'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
    //访问器
    public function getActionAttribute()
    {
        return $this->editBtn('admin.articel.edit').$this->deleteBtn('admin.articel.destroy');
    }
}
