@extends('admin.common.main')

@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源属性管理 <span
                class="c-gray en">&gt;</span> 房源属性列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新">
            <i class="Hui-iconfont">&#xe68f;</i></a></nav>
    @include('admin.common.msg')
    <div class="page-container">
        <form method="get" class="text-c"> 搜索节点
            <input type="text" class="input-text" style="width:250px" placeholder="节点"  value="{{ request()->get('name') }}" name="name" autocapitalize="off">
            <button type="submit" class="btn btn-success radius">
                <i class="Hui-iconfont">&#xe665;</i> 搜节点
            </button>

        </form>

        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a href="{{route('admin.fangattr.create')}}" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加</a>
        </span></div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">房源属性名称</th>
                    <th width="100">图标</th>
                    <th width="100">字段</th>
                    <th width="130">加入时间</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $node)
                    <tr class="text-c">
                        <td>{{$node['id']}}</td>
                        <td class="text-l">
                            {{$node['html']}}
                            {{$node['name']}}
                        </td>
                        <td><img src="{{$node['icon']}}" style="width: 50px;"></td>

                        <td>{{$node['filed_name']}}</td>
                        <td>{{$node['created_at']}}</td>
                        <td class="td-manage">
                            <a href="{{route('admin.fangattr.edit',$node['id'])}}" class="label label-secondary radius">修改</a>
                            <a href="{{route('admin.fangattr.destroy',$node['id'])}}" class="label label-disabled  radius">删除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
    <script>
    </script>
@endsection