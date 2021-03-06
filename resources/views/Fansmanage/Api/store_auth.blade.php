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
                <section class="vbox">
                    <section class="scrollable padder">
                        <div class="m-b-md">
                            <h3 class="m-b-none">公众号设置</h3>
                        </div>
                        <div class="col-lg-4">
                            @if(empty($wechat_info))
                            <section class="panel panel-default">
                                <header class="panel-heading font-bold">
                                    店铺公众号设置
                                </header>
                                <div class="panel-body">
                                    <form class="form-horizontal" method="get">
                                        <div class="form-group">
                                            <label class="col-sm-4 text-right" for="input-id-1">公众号ID</label>
                                            <div class="col-sm-8">
                                                <label class="label label-danger">未绑定</label>
                                            </div>
                                        </div>

                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">
                                            <label class="col-sm-4 text-right" for="input-id-1">公众号名称</label>
                                            <div class="col-sm-8">
                                                <label class="label label-danger">未绑定</label>
                                            </div>
                                        </div>

                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">
                                            <label class="col-sm-4 text-right" for="input-id-1">公众号主体</label>
                                            <div class="col-sm-8">
                                                <label class="label label-danger">未绑定</label>
                                            </div>

                                        </div>

                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">
                                            <label class="col-sm-4 text-right" for="input-id-1">授权状态</label>
                                            <div class="col-sm-8">
                                                <label class="label label-danger">未授权</label>
                                            </div>

                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">

                                            <div class="col-sm-12 text-center">
                                                <button class="btn btn-success" type="button" onclick="location.href='{{$url}}'">绑定公众服务号</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </section>
                            @else
                            <section class="panel panel-default">
                                <header class="panel-heading font-bold">
                                    店铺公众号设置
                                </header>
                                <div class="panel-body">
                                    <form class="form-horizontal" method="get">
                                        <div class="form-group clearfix text-center m-t">
                                            <div class="inline">
                                                <div class="thumb-lg">
                                                    <img src="{{ $wechat_info['head_img'] }}" class="img-circle" alt="...">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 text-right" for="input-id-1">公众号ID</label>
                                            <div class="col-sm-8">
                                                <label class="label label-info">{{$wechat_info['user_name']}}</label>
                                            </div>
                                        </div>

                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">
                                            <label class="col-sm-4 text-right" for="input-id-1">公众号名称</label>
                                            <div class="col-sm-8">
                                                <label class="label label-info">{{$wechat_info['nickname']}}</label>
                                            </div>
                                        </div>

                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">
                                            <label class="col-sm-4 text-right" for="input-id-1">公众号主体</label>
                                            <div class="col-sm-8">
                                                <label class="label label-info">{{$wechat_info['principal_name']}}</label>
                                            </div>

                                        </div>

                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">
                                            <label class="col-sm-4 text-right" for="input-id-1">授权状态</label>
                                            <div class="col-sm-8">
                                                <label class="label label-info">已授权</label>
                                            </div>

                                        </div>


                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">

                                            <div class="col-sm-12 text-center">
                                                <img src="{{$wechat_info['zerone_qrcode_url']}}" style="width: 150px; height: 150px;">
                                            </div>

                                        </div>

                                        <!--
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group">

                                            <div class="col-sm-12 text-center">
                                                <button class="btn btn-danger" type="button">解除绑定</button>
                                            </div>
                                        </div>
                                        -->
                                    </form>
                                </div>
                            </section>
                            @endif
                        </div>
                        <div class="col-lg-8">
                            <section class="panel panel-default">
                                <header class="panel-heading">
                                    公众号管理功能概览
                                </header>
                                <div class="row wrapper">

                                    <div class="well">
                                        <h3>温馨提示</h3>
                                        <p class="text-danger">1.店铺系统只能挂在公众号上，您需要绑定一个认证过的公众服务号</p>
                                        <p class="text-danger">2.一个店铺只能绑定一个公众号</p>
                                        <p class="text-danger">3.解除绑定公众号会导致您的店铺业务系统无法使用，请谨慎操作</p>
                                        <p class="text-danger">4.为保证所有功能正常，授权时请保持默认选择，把权限统一授权给零壹云管理凭条</p>
                                        <p class="text-danger">5.用户在微信公众平台官方进行改动造成的数据丢失，本系统概不负责</p>
                                    </div>

                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped b-t b-light text-center">
                                        <thead >
                                        <tr>
                                            <th  class="text-center">公众号管理功能</th>
                                            <th  class="text-center">未绑定公众服务号</th>
                                            <th  class="text-center">已绑定公众服务号</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>图文素材</td>
                                            <td><i class="fa fa-times text-lg text-danger"></i></td>
                                            <td><i class="fa fa-check text-lg text-success"></i></td>
                                        </tr>
                                        <tr>
                                            <td>消息群发</td>
                                            <td><i class="fa fa-times text-lg text-danger"></i></td>
                                            <td><i class="fa fa-check text-lg text-success"></i></td>
                                        </tr>
                                        <tr>
                                            <td>自动回复</td>
                                            <td><i class="fa fa-times text-lg text-danger"></i></td>
                                            <td><i class="fa fa-check text-lg text-success"></i></td>
                                        </tr>
                                        <tr>
                                            <td>模板消息</td>
                                            <td><i class="fa fa-times text-lg text-danger"></i></td>
                                            <td><i class="fa fa-check text-lg text-success"></i></td>
                                        </tr>
                                        <tr>
                                            <td>粉丝管理</td>
                                            <td><i class="fa fa-times text-lg text-danger"></i></td>
                                            <td><i class="fa fa-check text-lg text-success"></i></td>
                                        </tr>
                                        <tr>
                                            <td>标签管理</td>
                                            <td><i class="fa fa-times text-lg text-danger"></i></td>
                                            <td><i class="fa fa-check text-lg text-success"></i></td>
                                        </tr>
                                        <tr>
                                            <td>自定义菜单</td>
                                            <td><i class="fa fa-times text-lg text-danger"></i></td>
                                            <td><i class="fa fa-check text-lg text-success"></i></td>
                                        </tr>
                                        <tr>
                                            <td>个性化菜单</td>
                                            <td><i class="fa fa-times text-lg text-danger"></i></td>
                                            <td><i class="fa fa-check text-lg text-success"></i></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </div>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
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
    $(document).ready(function() {
        $('#editBtn').click(function(){
            $('#myModal').modal();
        });
        $('#save_btn').click(function(){
            swal({
                title: "温馨提示",
                text: "操作成功",
                type: "success"
            });
        });
    });
</script>
</body>
</html>