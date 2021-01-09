@extends('admin.common.main')

@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 文章管理 <span
                class="c-gray en">&gt;</span> w文章列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新">
            <i class="Hui-iconfont">&#xe68f;</i></a></nav>
    @include('admin.common.msg')
    <div class="page-container">
        <form method="get" class="text-c" onsubmit="return dopost()">
            日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin"
                   class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax"
                   class="input-text Wdate" style="width:120px;">
            文章标题
            <input type="text" class="input-text" style="width:250px" placeholder="文章标题" id="title" autocapitalize="off">
            <button type="submit" class="btn btn-success radius">
                <i class="Hui-iconfont">&#xe665;</i> 搜文章
            </button>

        </form>

        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a href="{{route('admin.article.create')}}" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加文章</a>
        </span></div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">文章标题</th>
                    <th width="130">加入时间</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        //列表显示
        var dataTable = $('.table-sort').dataTable({
            "columnDefs": [
                { "orderable": false, "targets": 3 }
            ],
            serverSide: true,
            ajax: {
                url: '{{route('admin.article.index')}}',
                type: 'GET',
                //动态获取表单数据用function
                data:function (ret) {
                    ret.datemin = $('#datemin').val();
                    ret.datemax = $('#datemax').val();
                    ret.title = $.trim($('#title').val());
                }
            },
            columns:[
                // {'data':'字段1',"defaultContent":"默认值",'className':'类名'}.
                // {'data':'字段n',"defaultContent":"默认值",'className':'类名'}
                {'data':'id','className':'text-c'},
                {'data':'title'},
                {'data':'created_at'},
                {'data':'action',"defaultContent":"默认值"}
            ],
            createdRow:function(row,data,dataIndex){
                var id = data.id
                //行的最后一列
                var td = $(row).find('td:last-child');
                var html = `
        <a href="/admin/article/${id}/edit" class="label label-secondary radius">修改</a>
        <a href="/admin/article/${id}" onclick="return delArticle(event this)" class="label label-denger radius">删除</a>
    `;
                td.html(html);
            }
        });
        //表单提交
        function dopost() {
            dataTable.api().ajax.reload();
            //取消表单默认行为
            return false;
        }

        //删除
        function delArticle2(obj) {
            //url地址
            let url = $(obj).attr('href');
            //todo 询问是否删除
            fetch(url,{
                method:'DELETE',
                headers:{
                    'X-CSRF-TOKEN':'{{csrf_token()}}'
                }
            }).then(res=>{
                return json();
            }).then(data=>{
                console.log(data)
            })
            return false;
        }
        //async await promise 异步便同步
        async function delArticle(evt,obj) {
            evt.preventDefault();
            //url地址
            let url = $(obj).attr('href');
            //todo 询问是否删除
            let ret = await fetch(url,{
                method:'DELETE',
                headers:{
                    'X-CSRF-TOKEN':'{{csrf_token()}}'
                }
            })
            let json  = await ret.json();
            console.log(json);
            return false;
        }
    </script>
@endsection