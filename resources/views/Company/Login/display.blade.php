<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8" />
    <title>零壹云管理系统 - 商户管理平台登录</title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="{{asset('public/Company/library/jPlayer')}}/jplayer.flat.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Company')}}/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Company')}}/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Company')}}/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Company')}}/css/simple-line-icons.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Company')}}/css/font.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/Company')}}/css/app.css" type="text/css" />
    <!--[if lt IE 9]>
    <script src="{{asset('public/Company/library/ie')}}/html5shiv.js"></script>
    <script src="{{asset('public/Company/library/ie')}}/respond.min.js"></script>
    <script src="{{asset('public/Company/library/ie')}}/excanvas.js"></script>
    <![endif]-->
</head>
<body class="bg-success dker">
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="container aside-xl">
        <a class="navbar-brand block" href="index.html"><span class="h1 font-bold">ZERONE</span></a>
        <section class="m-b-lg">
            <header class="wrapper text-center">
                <strong>零壹云管理系统 - 商户管理平台登录</strong>
            </header>
            <form action="index.html">
                <div class="form-group">
                    <input type="email" placeholder="账号|手机号码" class="form-control  input-lg text-center no-border">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="登录密码" class="form-control  input-lg text-center no-border">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="验证码" class="col-sm-6 input-lg text-center no-border">
                    <img src="http://o2o.01nnt.com/tooling/login/captcha/1516698884" class="col-sm-6" id="login_captcha" onclick="return changeCaptcha();">
                    <div style="clear: both;"></div>
                </div>


                <button type="button" onclick="location.href = 'index.html'" class="btn btn-lg btn-warning lt b-white b-2x btn-block"><i class="icon-arrow-right pull-right"></i><span class="m-r-n-lg">登录</span></button>

                <div class="line line-dashed"></div>

            </form>
        </section>
    </div>
</section>
<!-- footer -->
<footer id="footer">
    <div class="text-center padder">
        <p>
            <small>Web app framework base on Bootstrap<br>&copy; 2014</small>
        </p>
    </div>
</footer>


<!-- / footer -->
<script src="{{asset('public/Company/library/jquery')}}/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{asset('public/Company/library/bootstrap')}}/js/bootstrap.js"></script>
<!-- App -->
<script src="{{asset('public/Company')}}/js/app.js"></script>
<script src="{{asset('public/Company')}}/js/app.plugin.js"></script>
<script src="{{asset('public/Company/library/slimscroll')}}/js/jquery.slimscroll.min.js"></script>
<script src="{{asset('public/Company/jPlayer/jPlayer')}}/jquery.jplayer.min.js"></script>
<script src="{{asset('public/Company/jPlayer/jPlayer')}}/add-on/jplayer.playlist.min.js"></script>
<script src="{{asset('public/Company/jPlayer/jPlayer')}}/add-on/demo.js"></script>
</body>
</html>