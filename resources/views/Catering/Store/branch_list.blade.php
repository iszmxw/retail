<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8" />
    <title>零壹云管理平台 | 总分店管理系统</title>
    <link rel="stylesheet" href="{{asset('public/Catering')}}/js/jPlayer/jplayer.flat.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Catering')}}/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Catering')}}/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Catering')}}/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Catering')}}/css/simple-line-icons.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Catering')}}/css/font.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Catering')}}/css/app.css" type="text/css" />
    <link href="{{asset('public/Catering')}}/sweetalert/sweetalert.css" rel="stylesheet" />
    <!--[if lt IE 9]>
    <script src="{{asset('public/Catering')}}/js/ie/html5shiv.js"></script>
    <script src="{{asset('public/Catering')}}/js/ie/respond.min.js"></script>
    <script src="{{asset('public/Catering')}}/js/ie/excanvas.js"></script>
    <![endif]-->
</head>
<body class="">
<section class="vbox">
    <header class="bg-white-only header header-md navbar navbar-fixed-top-xs">
        @include('Catering/Public/Header')
    </header>
    <section>
        <section class="hbox stretch">

            <!-- .aside -->
            <aside class="bg-black dk aside hidden-print" id="nav">
                <section class="vbox">
                    <section class="w-f-md scrollable">
                        @include('Catering/Public/Nav')
                    </section>
                </section>
            </aside>
            <!-- /.aside -->
            <section id="content">
                <section class="vbox">
                    <section class="scrollable padder">
                        <div class="m-b-md">
                            <h3 class="m-b-none">总分店管理</h3>
                        </div>
                        <div class="col-sm-2">
                            <section class="panel panel-default"   style="height: 280px;">
                                <header class="panel-heading bg-light no-border">
                                    <div class="clearfix">
                                        <a href="#" class="pull-left thumb-md avatar b-3x m-r">

                                        </a>
                                        <div class="clear">
                                            <div class=" m-t-xs m-b-xs">
                                                刘记鸡煲王（总店）
                                                <i class="fa fa-cutlery text-success text-lg pull-right"></i>
                                            </div>

                                        </div>
                                    </div>
                                </header>
                                <div class="panel-body ">
                                    <div>
                                        分店类型：<label class="label label-success pull-right">总店</label>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <div>
                                        分店状态：<label class="label label-success pull-right">正常</label>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <div>
                                        分店主账号：<label class="label label-info pull-right">503020</label>
                                    </div>

                                </div>
                                <div class="panel-body" style="text-align:center;">
                                    <button class="btn btn-s-md btn-danger">进入总店</button>
                                </div>
                            </section>
                        </div>
                        <div class="col-sm-2">
                            <section class="panel panel-default"   style="height: 280px;">
                                <header class="panel-heading bg-light no-border">
                                    <div class="clearfix">
                                        <a href="#" class="pull-left thumb-md avatar b-3x m-r">

                                        </a>
                                        <div class="clear">
                                            <div class=" m-t-xs m-b-xs">
                                                刘记鸡煲王（总店）
                                                <i class="fa fa-cutlery text-success text-lg pull-right"></i>
                                            </div>

                                        </div>
                                    </div>
                                </header>
                                <div class="panel-body ">
                                    <div>
                                        分店类型：<label class="label label-primary pull-right">分店</label>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <div>
                                        分店状态：<label class="label label-success pull-right">正常</label>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <div>
                                        分店主账号：<label class="label label-info pull-right">503020</label>
                                    </div>

                                </div>
                                <div class="panel-body" style="text-align:center;">
                                    <button class="btn btn-s-md btn-danger">进入分店</button>
                                </div>
                            </section>
                        </div>
                        <div class="col-sm-2">
                            <section class="panel panel-default"   style="height: 280px;">
                                <header class="panel-heading bg-light no-border">
                                    <div class="clearfix">
                                        <a href="#" class="pull-left thumb-md avatar b-3x m-r">

                                        </a>
                                        <div class="clear">
                                            <div class=" m-t-xs m-b-xs">
                                                刘记鸡煲王（龙岗店）
                                                <i class="fa fa-cutlery text-success text-lg pull-right"></i>
                                            </div>

                                        </div>
                                    </div>
                                </header>
                                <div class="panel-body ">
                                    <div>
                                        分店类型：<label class="label label-primary pull-right">分店</label>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <div>
                                        分店状态：<label class="label label-success pull-right">正常</label>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <div>
                                        分店主账号：<label class="label label-info pull-right">503020</label>
                                    </div>

                                </div>
                                <div class="panel-body" style="text-align:center;">
                                    <button class="btn btn-s-md btn-danger">进入分店</button>
                                </div>
                            </section>
                        </div>
                        <div class="col-sm-2">
                            <section class="panel panel-default"   style="height: 280px;">
                                <header class="panel-heading bg-light no-border">
                                    <div class="clearfix">
                                        <a href="#" class="pull-left thumb-md avatar b-3x m-r">

                                        </a>
                                        <div class="clear">
                                            <div class=" m-t-xs m-b-xs">
                                                刘记鸡煲王（福田店）
                                                <i class="fa fa-cutlery text-success text-lg pull-right"></i>
                                            </div>

                                        </div>
                                    </div>
                                </header>
                                <div class="panel-body ">
                                    <div>
                                        分店类型：<label class="label label-primary pull-right">分店</label>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <div>
                                        分店状态：<label class="label label-success pull-right">正常</label>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <div>
                                        分店主账号：<label class="label label-info pull-right">503020</label>
                                    </div>

                                </div>
                                <div class="panel-body" style="text-align:center;">
                                    <button class="btn btn-s-md btn-danger">进入分店</button>
                                </div>
                            </section>
                        </div>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<script src="{{asset('public/Catering')}}/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{asset('public/Catering')}}/js/bootstrap.js"></script>
<!-- App -->
<script src="{{asset('public/Catering')}}/js/app.js"></script>
<script src="{{asset('public/Catering')}}/js/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{asset('public/Catering')}}/js/app.plugin.js"></script>
<script type="text/javascript" src="{{asset('public/Catering')}}/js/jPlayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="{{asset('public/Catering')}}/js/jPlayer/add-on/jplayer.playlist.min.js"></script>
<script type="text/javascript" src="{{asset('public/Catering')}}/js/jPlayer/demo.js"></script>
<script type="text/javascript" src="{{asset('public/Catering')}}/sweetalert/sweetalert.min.js"></script>


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
























