<?php

namespace App\Models;

class Fangattr extends Base
{
    //获取全部数据
    public function getList()
    {
        $data = self::get()->toArray();
        //调用父级层级递归函数
        return $this->treelevel($data);
    }
}
