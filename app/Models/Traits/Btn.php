<?php
/**
 * Created by PhpStorm.
 * User: kerwin
 * Date: 2020/5/18
 * Time: 20:04
 */

//按钮
namespace App\Models\Traits;


trait Btn
{
//{{route('admin.user.edit',$user)}}
    public function editBtn(string $route)
    {
        if (auth()->user()->username != config('rbac.super') && !in_array($route,request()->auths)){
            return '';
        }

        return '<a href=".route($route,$this)." class="label label-secondary radius">修改</a>';
    }
    public function deleteBtn(string $route)
    {
        if (auth()->user()->username != config('rbac.super') && !in_array($route,request()->auths)){
            return '';
        }

        return '<a href=".route($route,$this)." class="label label-denger radius">删除</a>';
    }
}