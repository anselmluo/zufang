<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //获取搜素框
        $name = $request->get('name','');
        //when 如果参数1存在，则执行闭包 use 获取外部变量
        $roles = Role::when($name,function ($query) use ($name){
            $query->where('name','like',"%{$name}%");
        })->paginate($this->pagesiz);
        return view('admin.role.index',compact('roles','name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request,[
                'name'=>'required|unique:roles,name'
            ]);
        }catch(\Exception $e){
            return ['status'=>1000,'msg'=>'验证失败'];
        }

        Role::create($request->only('name'));
        return ['status'=>0,'msg'=>'添加成功'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $model = Role::find($id);
        return view('admin.role.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try{
            $this->validate($request,[
                //唯一字段中，以id的值以外的字段，栗子：排除id为1的name的字段值
                'name'=>'required|unique:roles,name'.$id.',id'
            ]);
        }catch(\Exception $e){
            return ['status'=>1000,'msg'=>'验证失败'];
        }

        Role::where('id',$id)->update($request->only('name'));
        //数组写法
//        Role::where([['id','=',$id]])->update($request->only('name'));

        return ['status'=>0,'msg'=>'修改成功'];
    }

    public function node(Role $role){
//        dump($role->nodes->toArray());
        //读取所有权限
        $nodeAll = (new Node())->getAllList();
        //读取当前角色权限
        $nodes = $role->nodes()->pluck('id')->toArray();

        return view('admin.role.node',compact('role','nodeAll','nodes'));

    }

    public function nodeSave(Request $request , Role $role){
//        dump($request->all());
        $role->nodes()->sync($request->get('node'));
        return redirect(route('admin.role.index'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
