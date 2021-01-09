<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Node;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $auth = session('admin.auth');
        //读取菜单
        $menuData = (new Node())->treeData($auth);
        return view('admin.index.index',compact('menuData'));
    }

    public function welcome(){
        return view('admin.index.welcome');
    }

    public function logout(){
        //退出登录
        auth()->logout();
        return redirect(route('admin.login'))->with('success','退出成功，请重新登录！');
    }
}
