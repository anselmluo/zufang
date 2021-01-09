@extends('admin.common.main')
@section('css')
    <!--引入CSS-->
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">
@endsection
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源属性
        <span class="c-gray en">&gt;</span> 添加房源属性
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新">
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
    <article class="page-container">
        @include('admin.common.validate')
        {{--@submit Vue de onsubmit , 阻止默认行为prevent--}}
        <form action="{{route('admin.fangattr.store')}}" method="post" class="form form-horizontal">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否顶级：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select" name="pid">
					<option value="0">==顶级==</option>
                    @foreach($data as $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
				</select>
				</span></div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>属性名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>属性图标：</label>
                <div class="formControls col-xs-4 col-sm-5">

                    <div id="picker">选择图标</div>
                </div>
                <div  class="formControls col-xs-4 col-sm-4">
                    <input type="hidden"  name="icon" id="icon">
                    {{--图片上传--}}
                    <img src="" id="pic" style="width: 50px;">
                </div>

            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>字段名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="field_name" >
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="添加">
                </div>
            </div>
        </form>
    </article>
@endsection

@section('js')
    <!--引入JS-->
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>
    <script>
        //富文本编辑器
        var ue = UE.getEditor('body',{
            initialFrameHeight:200
        });

        var uploader = WebUploader.create({
            // 选完文件后，是否自动上传。
            auto: true,
            // swf文件路径
            // swf: BASE_URL + '/js/Uploader.swf',
            swf: '/webuploader/Uploader.swf',
            // 文件接收服务端。
            server: '{{route('admin.fangattr.upfile')}}',
            //文件追加参数
            formData:{
                _token:'{{csrf_token()}}'
            },
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            //pick: '#picker',
            pick:{
                id:'#picker',
                multiple:false
            },
            // 压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: true
        });
        /*//多图片上传
        uploader.on( 'uploadSuccess', function( file,ret ) {
            //图片提交时用#隔开
            let val =$('#pic').val();
            let tmp = val + '#' + ret.url;
            $('#pic').val(tmp);
            //图片展示
            let imglist = $('#inglist');
            imglist.append(`<img src = "${ret.url}" style="width:100px;"/> &nbsp;`);
        }*/
        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file,ret ) {
            // $( '#'+file.id ).addClass('upload-state-done');
            //lujing
            let src = ret.url;
            //给表单添加value值
            $('#icon').val(src);
            //给图片添加src
            $('#pic').attr('src',src);

        });
    </script>
@endsection
