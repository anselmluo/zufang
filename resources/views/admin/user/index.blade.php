<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css"/>
    <title>用户管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户中心 <span
            class="c-gray en">&gt;</span> 用户列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i></a></nav>
@include('admin.common.msg')
<div class="page-container">
    <div class="text-c"> 日期范围：
        <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin"
               class="input-text Wdate" style="width:120px;">
        -
        <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax"
               class="input-text Wdate" style="width:120px;">
        <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
        <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户
        </button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a href="javascript:;" onclick="datadel()"
               class="btn btn-danger radius">
                <i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a href="{{route('admin.user.create')}}" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加用户</a>
        </span></div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="20">ID</th>
                <th width="80">姓名</th>
                <th width="50">角色</th>
                <th width="100">用户名</th>
                <th width="40">性别</th>
                <th width="90">手机</th>
                <th width="150">邮箱</th>
                <th width="130">加入时间</th>
                <th width="70">状态</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="text-c">

                    <td>
                        @if(auth()->id() != $user->id)
                            @if($user->deleted_at == null)
                                <input type="checkbox" value="{{$user->id}}" name="id[]">
                            @endif
                        @endif
                    </td>
                    <td>{{$user->id}}</td>
                    <td>{{$user['truename']}}</td>
                    <td>{{$user->role->name}}</td>
                    <td>{{$user['username']}}</td>
                    <td>{{$user['sex']}}</td>
                    <td>{{$user['phone']}}</td>
                    <td>{{$user['email']}}</td>
                    <td>{{$user['created_at']}}</td>
                    <td class="td-status"><span class="label label-success radius">已启用</span></td>
                    <td class="td-manage">
                        {!! $user->editBtn('admin.user.edit') !!}
{{--                        <a href="{{route('admin.user.edit',$user)}}" class="label label-secondary radius">修改</a>--}}
                        <a href="{{route('admin.user.role',$user)}}" class="label label-secondary radius">权限</a>
                        @if(auth()->id() != $user->id)
                            @if($user->deleted_at != null)
                                <a href="{{route('admin.user.restores',$user['id'])}}"
                                   class="label label-disabled  radius">还原</a>
                            @else
                                {!! $user->editBtn('admin.user.del') !!}
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$users->links()}}
    </div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>

<style>
    /*分页*/
    .pagination {
    }

    .pagination li {
        display: inline-block;
        margin-right: -1px;
        padding: 5px;
        border: 1px solid #e2e2e2;
        min-width: 20px;
        text-align: center;
    }

    .pagination li.active {
        background: #009688;
        color: #fff;
        border: 1px solid #009688;
    }

    .pagination li a {
        display: block;
        text-align: center;
    }
</style>

<script>

    const _token = "{{csrf_token()}}";
    //给删除按钮添加事件
    $('.delbtn').click(function (evt) {

        let url = $(this).attr('href');
        // alert(_token)
        $.ajax({
            url,
            data: {_token},
            type: 'DELETE',
            dataType: 'json'
        }).then(({status, msg}) => {
            if (status == 0) {
                //shanchu
                $(this).parents('tr').remove();
                //提示插件
                layer.msg(msg, {time: 2000, icon: 1})
            }
        });

        return false;
    });

    function datadel() {
        layer.confirm('确定要删除选中用户吗？', {
            btn: ['确认','取消'] //按钮
        }, ()=>{
            //选中的id
            let ids = $('input[name="id[]"]:checked');
            //要铲除的
            let id = [];
            //循环
            $.each(ids,(key,val)=>{
                //dom转jqury对象 $(dom对象)
                // id.push($(val).val());
                id.push(val.value);
            });
            if(id.length > 0){
                //发起ajax
                $.ajax({
                    url:"{{route('admin.user.delall')}}",
                    data:{id,_token},
                    type: 'DELETE',
                }).then(ret=>{
                    if(ret.status == 0){
                        layer.msg(ret.msg,{time:2000,icon:1},()=>{
                            location.reload();
                        })
                    }
                })
            }
        }, function(){
            // layer.msg('也可以这样', {
            //     time: 20000, //20s后自动关闭
            //     btn: ['明白了', '知道了']
            // });
        });


    }
</script>
</body>
</html>