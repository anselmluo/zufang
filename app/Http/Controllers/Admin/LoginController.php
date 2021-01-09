<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //测试控制器的中间件，无实际意义
//    public function __construct()
//    {
//        $this->middleware(['ckadmin']);
//    }

    public function index()
    {
        //判断用户是否登录
        if (auth()->check()) {
            return redirect(route('admin.index'));
        }
        return view('admin.login.login');
    }

    public function login(Request $request)
    {
        $post = $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        //登录
        $booler = auth()->attempt($post);
        if ($booler) {
//            dd(auth()->user()->toArray());

            //是否超级管理员
            if (config('rbac.super') != $post['username']) {
                //获取权限
                $user = auth()->user();
                $role = $user->role;
                $nodeArr = $role->nodes()->pluck('route_name', 'id')->toArray();
                //权限保存session
                session(['admin.auth' => $nodeArr]);
            } else {
                session(['admin.auth' => true]);
            }

            return redirect(route('admin.index'));
        }
        //withErrors是闪存
        return redirect(route('admin.login'))->withErrors(['error' => '用户或密码错误！']);
    }
}
