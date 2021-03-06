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
                            <h3 class="m-b-none">总分店管理</h3>
                        </div>
                        @foreach($list as $key=>$value)
                        <div class="col-sm-2">
                            <section class="panel panel-default"   style="/*height: 280px;*/ height: auto">
                                <header class="panel-heading bg-light no-border">
                                    <div class="clearfix">
                                        <a href="#" class="pull-left thumb-md avatar b-3x m-r">
                                        </a>
                                        <div class="clear">
                                            <div class=" m-t-xs m-b-xs">
                                                {{$value->organization_name}}
                                                <i class="fa fa-cutlery text-success text-lg pull-right"></i>
                                            </div>

                                        </div>
                                    </div>
                                </header>
                                <div class="panel-body ">
                                    <div>
                                        店铺使用的程序：<label class="label label-success pull-right">
                                            @if($value->asset_id == '10')
                                                零售retail版
                                            @elseif($value->asset_id == '12')
                                                零售simple版
                                            @endif
                                        </label>
                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <div>
                                        分店状态：
                                            @if($value->status == '1')
                                                <label class="label label-success pull-right">正常 </label>
                                            @else
                                                <label class="label label-warning pull-right">冻结 </label>
                                            @endif

                                    </div>
                                    <div class="line line-dashed b-b line-lg pull-in"></div>
                                    <div>
                                        分店主账号：<label class="label label-info pull-right">{{$value->account->account}}</label>
                                    </div>

                                </div>
                                {{--<div class="panel-body" style="text-align:center;">--}}
                                    {{--<button class="btn btn-s-md btn-danger">--}}
                                        {{--@if($value->OrganizationRetailinfo->type == '0')--}}
                                            {{--进入总店--}}
                                        {{--@else--}}
                                            {{--进入分店--}}
                                        {{--@endif--}}
                                    {{--</button>--}}
                                {{--</div>--}}

                            </section>
                        </div>
                        @endforeach
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
























