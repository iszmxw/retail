<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>登陆页面 | 零壹新科技服务商管理平台</title>

</head>

<body class="login-body">

<div class="container">

    <form class="form-signin" action="select_proxy.html">
        <h2 class="form-signin-heading">零壹新科技服务商管理平台</h2>
        <div class="login-wrap">
            <input type="text" class="form-control" placeholder="用户名" autofocus>
            <input type="password" class="form-control" placeholder="登陆密码">
            <button class="btn btn-lg btn-login btn-block" type="submit">登陆</button>
        </div>

    </form>

</div>

<script src="{{asset('public/Zerone/library/jquery')}}/js/jquery-2.1.1.js"></script>
<script src="{{asset('public/Zerone/library/bootstrap')}}/js/bootstrap.min.js"></script>
<script src="{{asset('public/Zerone/library/sweetalert')}}/js/sweetalert.min.js"></script>
<script>
    $(function(){
        //设置CSRF令牌
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    //更换验证码
    function changeCaptcha(){
        var url = $("#captcha_url").val();
        url = url + "/" + Math.random();
        $("#login_captcha").attr("src",url);
    }

    //提交表单
    function postForm(){
        var target = $("#currentForm");
        var url = target.attr("action");
        console.log(url);
        var data = target.serialize();
        console.log(data);
        $.post(url,data,function(json){
            if(json.status==1){
                window.location.reload();
            }else{
                swal({
                    title: "提示信息",
                    text: json.data,
                    confirmButtonColor:"#DD6B55",
                    confirmButtonText: "确定",
                    //type: "warning"
                });
                changeCaptcha();
            }
        });
    }
</script>

</body>
</html>