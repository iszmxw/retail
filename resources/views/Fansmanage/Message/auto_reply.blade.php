<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8" />
    <title>零壹云管理平台 | 总分店管理系统</title>
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/js/jPlayer/jplayer.flat.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/css/simple-line-icons.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/css/font.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Fansmanage')}}/css/app.css" type="text/css" />
    <link href="{{asset('public/Fansmanage')}}/sweetalert/sweetalert.css" rel="stylesheet" />

    <!--[if lt IE 9]>
    <script src="{{asset('public/Fansmanage')}}/js/ie/html5shiv.js"></script>
    <script src="{{asset('public/Fansmanage')}}/js/ie/respond.min.js"></script>
    <script src="{{asset('public/Fansmanage')}}/js/ie/excanvas.js"></script>
    <![endif]-->
</head>
<body class="">
<section class="vbox">
    <header class="bg-white-only header header-md navbar navbar-fixed-top-xs">
        @include('Fansmanage/Public/Header')
    </header>
    <section>
        <section class="hbox stretch">

            <!-- .aside -->
            <aside class="bg-black dk aside hidden-print" id="nav">
                <section class="vbox">
                    <section class="w-f-md scrollable">
                        @include('Fansmanage/Public/Nav')
                    </section>
                </section>
            </aside>
            <!-- /.aside -->
            <section id="content">
                <section class="hbox stretch">
                    <!-- side content -->
                    <aside class="aside bg-dark" id="sidebar">
                        <section class="vbox animated fadeInUp">
                            <section class="scrollable hover">
                                <div class="list-group no-radius no-border no-bg m-t-n-xxs m-b-none auto">
                                    <a href="{{url('fansmanage/message/auto_reply')}}" class="list-group-item active">
                                        关键词自动回复
                                    </a>
                                    <a href="{{url('fansmanage/message/subscribe_reply')}}" class="list-group-item">
                                        关注后自动回复
                                    </a>
                                    <a href="{{url('fansmanage/message/default_reply')}}" class="list-group-item ">
                                        默认回复
                                    </a>
                                </div>
                            </section>
                        </section>
                    </aside>
                    <!-- / side content -->
                    <section>
                        <section class="vbox">
                            <section class="scrollable padder-lg">
                                <h2 class="font-thin m-b">关键词自动回复</h2>
                                <div class="row row-sm">
                                    <button class="btn btn-success" id="addKeyWord" onclick="return getAddForm();">新建关键字 &nbsp;&nbsp;<i class="fa fa-plus"></i></button>
                                    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="_token" id="auto_reply_add_url" value="{{ url('fansmanage/ajax/auto_reply_add') }}">
                                    <input type="hidden" name="_token" id="auto_reply_edit_text_url" value="{{ url('fansmanage/ajax/auto_reply_edit_text') }}">
                                    <input type="hidden" name="_token" id="auto_reply_edit_image_url" value="{{ url('fansmanage/ajax/auto_reply_edit_image') }}">
                                    <input type="hidden" name="_token" id="auto_reply_edit_article_url" value="{{ url('fansmanage/ajax/auto_reply_edit_article') }}">
                                    <input type="hidden" name="_token" id="auto_reply_edit_url" value="{{ url('fansmanage/ajax/auto_reply_edit') }}">
                                    <input type="hidden" name="_token" id="auto_reply_delete_url" value="{{ url('fansmanage/ajax/auto_reply_delete_confirm') }}">
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped b-t b-light">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>关键词</th>
                                            <th>适配类型</th>
                                            <th>添加时间</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($list as $key=>$val)
                                        <tr>
                                            <td>{{$val->id}}</td>
                                            <td>{{$val->keyword}}</td>
                                            <td>
                                                @if($val->type == '1')
                                                    <label class="label label-success">精确</label>
                                                @else
                                                    <label class="label label-info">模糊</label>
                                                @endif
                                            </td>
                                            <td>{{$val->created_at}}</td>
                                            <td>
                                                @if($val['reply_type']=='1')
                                                    <div>
                                                        <button class="btn btn-info btn-xs" id="editText" onclick="return getAutoEditTextForm('{{$val->id}}')"><i class="fa fa-edit"></i>&nbsp;&nbsp;编辑</button>
                                                        <label class="label label-primary">文本</label>&nbsp;&nbsp;
                                                         {{str_limit($val->reply_info,20,'...')}}&nbsp;&nbsp;
                                                    </div>
                                                @elseif($val['reply_type']=='3')
                                                    <div>
                                                        <button class="btn btn-info btn-xs" id="editArticle" onclick="return getAutoEditArticleForm('{{$val->id}}')"><i class="fa fa-edit"></i>&nbsp;&nbsp;编辑</button>
                                                        <label class="label label-primary">图文</label>&nbsp;&nbsp;
                                                        {{str_limit($val->reply_info,20,'...')}}&nbsp;&nbsp;

                                                    </div>
                                                @elseif($val['reply_type']=='2')
                                                    <div>
                                                        <button class="btn btn-info btn-xs" id="editPicture" onclick="return getAutoEditImageForm('{{$val->id}}')"><i class="fa fa-edit"></i>&nbsp;&nbsp;编辑</button>
                                                        <label class="label label-primary" >图片</label>&nbsp;&nbsp;
                                                        <img src="{{asset('uploads/wechat/'.$val['organization_id'].'/'.$val->reply_info)}}" alt="" class="r r-2x img-full" style="width:100px; height: 100px">&nbsp;&nbsp;

                                                    </div>
                                                @endif
                                                @if(!empty($val['reply_type']))<div class="line line-dashed b-b line-lg pull-in"></div>@endif
                                                <div>
                                                    @if($val['reply_type']<>'1')<button class="btn btn-info btn-sm" onclick="return getAutoEditTextForm('{{$val->id}}')"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;文本回复</button>@endif
                                                    @if($val['reply_type']<>'3')<button class="btn btn-info btn-sm" onclick="return getAutoEditArticleForm('{{$val->id}}')"><i class="icon icon-picture"></i>&nbsp;&nbsp;图文回复</button>@endif
                                                        @if($val['reply_type']<>'2')<button class="btn btn-info btn-sm" onclick="return getAutoEditImageForm('{{$val->id}}')"><i class="fa fa-tasks"></i>&nbsp;&nbsp;图片回复</button>@endif
                                                    <button class="btn btn-info btn-sm" onclick="return getAutoEditForm('{{$val->id}}')"><i class="fa fa-edit"></i>&nbsp;&nbsp;编辑关键字</button>
                                                    <button class="btn btn-danger btn-sm" id="deleteBtn" onclick="return getAutoDeleteForm('{{$val->id}}')"><i class="fa fa-times"></i>&nbsp;&nbsp;删除关键字</button>
                                                </div>

                                            </td>
                                        </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                                <footer class="panel-footer">
                                    <div class="row">
                                        <div class="col-sm-12 text-right text-center-xs">
                                            {{$list->links()}}
                                        </div>
                                    </div>
                                </footer>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<script src="{{asset('public/Fansmanage')}}/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{asset('public/Fansmanage')}}/js/bootstrap.js"></script>
<!-- App -->
<script src="{{asset('public/Fansmanage')}}/js/app.js"></script>
<script src="{{asset('public/Fansmanage')}}/js/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{asset('public/Fansmanage')}}/js/app.plugin.js"></script>
<script type="text/javascript" src="{{asset('public/Fansmanage')}}/js/jPlayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="{{asset('public/Fansmanage')}}/js/jPlayer/add-on/jplayer.playlist.min.js"></script>
<script type="text/javascript" src="{{asset('public/Fansmanage')}}/js/jPlayer/demo.js"></script>
<script type="text/javascript" src="{{asset('public/Fansmanage')}}/sweetalert/sweetalert.min.js"></script>


<script type="text/javascript">

    //弹出图片上传框
    function getAddForm(){
        var url = $('#auto_reply_add_url').val();
        var token = $('#_token').val();
        var data = {'_token':token};
        $.post(url,data,function(response){
            if(response.status=='-1'){
                swal({
                    title: "提示信息",
                    text: response.data,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                },function(){
                    window.location.reload();
                });
                return;
            }else{

                $('#myModal').html(response);
                $('#myModal').modal();
            }
        });
    }
    //弹出文本输入框
    function getAutoEditTextForm(id){
        var url = $('#auto_reply_edit_text_url').val();
        var token = $('#_token').val();
        if(id==''){
            swal({
                title: "提示信息",
                text: '数据传输错误',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
            },function(){
                window.location.reload();
            });
            return;
        }

        var data = {'id':id,'_token':token};
        $.post(url,data,function(response){
            if(response.status=='-1'){
                swal({
                    title: "提示信息",
                    text: response.data,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                },function(){
                    window.location.reload();
                });
                return;
            }else{
                $('#myModal').html(response);
                $('#myModal').modal();
            }
        });
    }
    //弹出图片选择框
    function getAutoEditImageForm(id){
        var url = $('#auto_reply_edit_image_url').val();
        var token = $('#_token').val();
        if(id==''){
            swal({
                title: "提示信息",
                text: '数据传输错误',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
            },function(){
                window.location.reload();
            });
            return;
        }

        var data = {'id':id,'_token':token};
        $.post(url,data,function(response){
            if(response.status=='-1'){
                swal({
                    title: "提示信息",
                    text: response.data,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                },function(){
                    window.location.reload();
                });
                return;
            }else{
                $('#myModal').html(response);
                $('#myModal').modal();
            }
        });
    }
    //弹出图片选择框
    function getAutoEditArticleForm(id){
        var url = $('#auto_reply_edit_article_url').val();
        var token = $('#_token').val();
        if(id==''){
            swal({
                title: "提示信息",
                text: '数据传输错误',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
            },function(){
                window.location.reload();
            });
            return;
        }

        var data = {'id':id,'_token':token};
        $.post(url,data,function(response){
            if(response.status=='-1'){
                swal({
                    title: "提示信息",
                    text: response.data,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                },function(){
                    window.location.reload();
                });
                return;
            }else{
                $('#myModal').html(response);
                $('#myModal').modal();
            }
        });
    }
    //弹出关键字修改框
    function getAutoEditForm(id){
        var url = $('#auto_reply_edit_url').val();
        var token = $('#_token').val();
        if(id==''){
            swal({
                title: "提示信息",
                text: '数据传输错误',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
            },function(){
                window.location.reload();
            });
            return;
        }

        var data = {'id':id,'_token':token};
        $.post(url,data,function(response){
            if(response.status=='-1'){
                swal({
                    title: "提示信息",
                    text: response.data,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                },function(){
                    window.location.reload();
                });
                return;
            }else{
                $('#myModal').html(response);
                $('#myModal').modal();
            }
        });
    }
    //弹出关键字修改框
    function getAutoDeleteForm(id){
        var url = $('#auto_reply_delete_url').val();
        var token = $('#_token').val();
        if(id==''){
            swal({
                title: "提示信息",
                text: '数据传输错误',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
            },function(){
                window.location.reload();
            });
            return;
        }

        var data = {'id':id,'_token':token};
        $.post(url,data,function(response){
            if(response.status=='-1'){
                swal({
                    title: "提示信息",
                    text: response.data,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                },function(){
                    window.location.reload();
                });
                return;
            }else{
                $('#myModal').html(response);
                $('#myModal').modal();
            }
        });
    }
</script>
</body>
</html>