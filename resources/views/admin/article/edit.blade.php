@extends('admin.common.main')
@section('css')
    <!--引入CSS-->
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 用户中心
        <span class="c-gray en">&gt;</span> 修改文章
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新">
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
    <article class="page-container">
        @include('admin.common.validate')
        <form  action="{{route('admin.article.update',$article)}}" ref="frm" class="form form-horizontal">
            @method('PUT')
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>文章标题：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="title" v-model="info.title">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>文章摘要：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="desn" v-model="info.desn">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>文章封面：</label>
                <div class="formControls col-xs-4 col-sm-5">
                    {{--<input type="file" class="input-text" name="pic">--}}
                    {{--表单提交时的封面地址--}}
                    <input type="hidden" name="pic" id="pic" v-model="info.pic">
                    <div id="picker">选择文件</div>
                </div>
                <div class="formControls col-xs-4 col-sm-4">
                    <img :src="info.pic" id="img" style="width:100px;">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>文章内容：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="body" id="body" cols="30" rows="10"></textarea>
                </div>
            </div>


            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="button" @click="dopost" value="添加">
                </div>
            </div>
        </form>
    </article>
@endsection

@section('js')
    <!-- 配置文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>
    <!--引入JS-->
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <!-- 实例化编辑器 -->
    <script>

        //vue管理
        new Vue ({
            el:'.page-container',
            data:{
                info:{!! $article !!}
            },
            mounted(){
                //富文本编辑器
                this.editor = UE.getEditor('body',{
                    initialFrameHeight:200
                });
                //渲染
                this.editor.addListener("ready",()=>{
                    this.editor.setContent(this.info.body)
                });
                this.uploader = WebUploader.create({
                    // 选完文件后，是否自动上传。
                    auto: true,
                    // swf文件路径
                    // swf: BASE_URL + '/js/Uploader.swf',
                    swf: '/webuploader/Uploader.swf',
                    // 文件接收服务端。
                    server: '{{route('admin.article.upfile')}}',
                    //文件追加参数
                    formData:{
                        _token:'{{csrf_token()}}'
                    },
                    // 选择文件的按钮。可选。
                    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                    pick: '#picker',
                    // pick:{
                    //     id:'#picker',
                    //     multiple:false
                    // },
                    // 压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                    resize: true
                });
                this.uploader.on( 'uploadSuccess', ( file,ret )=> {
                    // $( '#'+file.id ).addClass('upload-state-done');
                    //lujing
                    let src = ret.url;
                    this.info.pic = src;


                });
            },
            methods:{
                async dopost(){
                    this.info = this.editor.setContent();
                    // console.log(this.$refs.frm);
                    var frmData = JSON.stringify(this.info);
                    // console.log(frmData);
                    let ret = await fetch(this.$refs.frm.action,{
                        method:'put',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}',
                            'Content-Type':'application/json'
                        },
                        body:frmData
                    });
                    let json = await ret.json();
                    location.href = json.url;
                }
            }
        })
            //.$mount('.page-container');

        {{--var uploader = WebUploader.create({--}}
            {{--// 选完文件后，是否自动上传。--}}
            {{--auto: true,--}}
            {{--// swf文件路径--}}
            {{--// swf: BASE_URL + '/js/Uploader.swf',--}}
            {{--swf: '/webuploader/Uploader.swf',--}}
            {{--// 文件接收服务端。--}}
            {{--server: '{{route('admin.article.upfile')}}',--}}
            {{--//文件追加参数--}}
            {{--formData:{--}}
                {{--_token:'{{csrf_token()}}'--}}
            {{--},--}}
            {{--// 选择文件的按钮。可选。--}}
            {{--// 内部根据当前运行是创建，可能是input元素，也可能是flash.--}}
            {{--pick: '#picker',--}}
            {{--// pick:{--}}
            {{--//     id:'#picker',--}}
            {{--//     multiple:false--}}
            {{--// },--}}
            {{--// 压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！--}}
            {{--resize: true--}}
        {{--});--}}
        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        // uploader.on( 'uploadSuccess', function( file,ret ) {
        //     // $( '#'+file.id ).addClass('upload-state-done');
        //     //lujing
        //     let src = ret.url;
        //     //给表单添加value值
        //     $('#pic').val(src);
        //     //给图片添加src
        //     $('#img').attr('src',src);
        //
        // });
    </script>
@endsection
