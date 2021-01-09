<?php

namespace App\Models;


class Role extends Base
{
    //角色与权限 多对多
    public function nodes(){
        //参数1 关联模型，参数2 中间表名（没有前缀，参数3 当前模型外键id，参数4 关联模型外键id
        return $this->belongsToMany(Node::class,'role_node','role_id','node_id');
    }
}
