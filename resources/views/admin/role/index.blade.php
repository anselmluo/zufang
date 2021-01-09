@extends('admin.common.main')

@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 用户中心 <span
                class="c-gray en">&gt;</span> 权限列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新">
            <i class="Hui-iconfont">&#xe68f;</i></a></nav>
    @include('admin.common.msg')
    <div class="page-container">
        <form method="get" class="text-c"> 搜索角色名
            <input type="text" class="input-text" style="width:250px" placeholder="角色"  value="{{ request()->get('name') }}" name="name" autocapitalize="off">
            <button type="submit" class="btn btn-success radius">
                <i class="Hui-iconfont">&#xe665;</i> 搜角色
            </button>

        </form>

        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a href="{{route('admin.role.create')}}" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加角色</a>
        </span></div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">角色名称</th>
                    <th width="100">查看权限</th>
                    <th width="130">加入时间</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr class="text-c">
                        <td>{{$role->id}}</td>
                        <td>{{$role['name']}}</td>
                        <td>
                            <a class="label label-success radius" href="{{route('admin.role.node',$role)}}">权限</a>
                        </td>
                        <td>{{$role['created_at']}}</td>
                        <td class="td-manage">
                            <a href="{{route('admin.role.edit',$role)}}" class="label label-secondary radius">修改</a>
                            <a href="{{route('admin.role.destroy',$role->id)}}"
                               class="label label-disabled  radius">删除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$roles->links()}}
        </div>
    </div>
@endsection
@section('js')
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
                btn: ['确认', '取消'] //按钮
            }, () => {
                //选中的id
                let ids = $('input[name="id[]"]:checked');
                //要铲除的
                let id = [];
                //循环
                $.each(ids, (key, val) => {
                    //dom转jqury对象 $(dom对象)
                    // id.push($(val).val());
                    id.push(val.value);
                });
                if (id.length > 0) {
                    //发起ajax
                    $.ajax({
                        url: "{{route('admin.user.delall')}}",
                        data: {id, _token},
                        type: 'DELETE',
                    }).then(ret => {
                        if (ret.status == 0) {
                            layer.msg(ret.msg, {time: 2000, icon: 1}, () => {
                                location.reload();
                            })
                        }
                    })
                }
            }, function () {
                // layer.msg('也可以这样', {
                //     time: 20000, //20s后自动关闭
                //     btn: ['明白了', '知道了']
                // });
            });


        }
    </script>
@endsection