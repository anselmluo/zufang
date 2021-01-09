<?php

namespace App\Models;


class Node extends Base
{
    //修改器 route_name
    public function setRouteNameAttribute($value)
    {
        $this->attributes['route_name'] = empty($value) ? '' : $value;
    }
    //访问器 menu
    public function getMenuAttribute()
    {
        if($this->is_menu == '1'){
            return '<span class="label label-success radius">是</span>';
        }
        return '<span class="label label-denger radius">否</span>';
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
    public function getAllList(){
        $data = self::get()->toArray();
        return $this->treelevel($data);
    }
    /**获取层级数据
     * @param array $allow_node 拥有的权限id
     * @return array
     */
    public function treeData($allow_node)
    {
        $query = Node::where('is_menu','1');
        if($allow_node !==true){
            $query->wherein('id',array_keys($allow_node));
        }
        $menuData = $query->get()->toArray();
        return $this->subTree($menuData);
    }
}
