<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends BaseController
{
    public function index()
    {
        //withTrashed 显示包括已软删除的所有用户
        $users = User::orderBy('id', 'aSC')->withTrashed()->paginate($this->pagesiz);
//        dd($users->toArray());
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
//        dd($request->toarray());
        $this->validate($request, [
            //唯一性验证
            'username' => 'required|unique:users',
            'password' => 'required|confirmed',
            //自定义验证规则
            'phone' => 'nullable|phone',
        ], [
            'phone' => '请输入正确手机号码'
        ]);
        $post = $request->except(['_token', 'password_confirmation']);
        $userModel = User::create($post);

        Mail::send('mail.useradd', compact('userModel'), function (Message $message) use ($userModel) {
//                给谁
            $message->to($userModel->email);
//                主题
            $message->subject('注册通知');
        });


        return redirect(route('admin.user.index'))->with('success', '添加账号成功');
    }

    public function del(int $id)
    {
        //删除->通过添加标识字段和修改模型文件use SoftDeletes改为软删除
        User::find($id)->delete();
        //强制删除-》配置软删除后的物理删除
//        User::find($id)->forceDelete();
        return ['status' => 0, 'msg' => '删除成功'];
    }

    public function restores(int $id)
    {
        User::onlyTrashed()->where('id', $id)->restores();

        return redirect(route('admin.user.index'))->with('success', '还原账户成功');
    }

    public function delall(Request $request)
    {
        $ids = $request->get('id');
        User::destroy($ids);
        return ['status' => 0, 'msg' => '批量删除成功'];
    }

    public function edit(int $id)
    {
        $model = User::find($id);
        return view('admin.user.edit', compact('model'));
    }

    public function update(Request $request, int $id)
    {
        $model = User::find($id);
        //原密码明文
        $spass = $request->get('spassword');
        //原密码密文
        $oldpass = $model->password;
        $booler = Hash::check($spass, $oldpass);
        if ($booler) {
            $data = $request->only([
                'truename',
                'password',
                'phone',
                'sex',
                'email',
            ]);
            if (!empty($data['password'])) {

                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }
            $model->update($data);
            return redirect(route('admin.user.index'))->with('success', '修改成功');
        }
        return redirect(route('admin.user.edit', $model))->withErrors(['error' => '原密码不正确']);

    }

    public function role(Request $request, User $user)
    {
//        post提交表单
        if($request->isMethod('post')){
            $post = $this->validate($request,[
                'role_id'=>'required',
            ],['role_id.required'=>'请选择']);
            $user->update($post);
            return redirect(route('admin.user.index'));
        }

            $roles = Role::all();
        return view('admin.user.role',compact('user','roles'));
    }
}
