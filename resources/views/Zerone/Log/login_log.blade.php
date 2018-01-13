<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>零壹新科技程序管理平台</title>

    <link href="{{asset('public/Zerone/library/bootstrap')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('public/Zerone/library/font')}}/css/font-awesome.css" rel="stylesheet">

    <link href="{{asset('public/Zerone')}}/css/animate.css" rel="stylesheet">
    <link href="{{asset('public/Zerone')}}/css/style.css" rel="stylesheet">

</head>

<body class="">

<div id="wrapper">

    @include('Zerone/Public/Nav')

    <div id="page-wrapper" class="gray-bg">
        @include('Zerone/Public/Header')

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-4">
                <h2>我的登陆日志</h2>
                <ol class="breadcrumb">
                    <li class="active">
                        <a href="JavaScript:;">个人中心</a>
                    </li>
                    <li >
                        <strong>我的登陆日志</strong>
                    </li>
                </ol>
            </div>

        </div>

        <div class="wrapper wrapper-content animated fadeInRight ecommerce">


            <div class="ibox-content m-b-sm border-bottom">

                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label" for="date_added">操作时间</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="date_added" type="text" class="form-control" value="2017-11-28">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label" for="date_modified">到</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="date_modified" type="text" class="form-control" value="2017-11-28">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label" for="amount"> &nbsp;</label>
                            <button type="button" class="block btn btn-info"><i class="fa fa-search"></i>搜索</button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">

                            <table class="table table-stripped toggle-arrow-tiny" data-page-size="15">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>登陆IP</th>
                                    <th>登陆地址</th>
                                    <th>操作时间</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>192.168.1.1</td>
                                    <td>本机</td>
                                    <td>2017-11-28 10:10:10</td>

                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>192.168.1.1</td>
                                    <td>本机</td>
                                    <td>2017-11-28 10:10:10</td>

                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>192.168.1.1</td>
                                    <td>本机</td>
                                    <td>2017-11-28 10:10:10</td>

                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>192.168.1.1</td>
                                    <td>本机</td>
                                    <td>2017-11-28 10:10:10</td>

                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>192.168.1.1</td>
                                    <td>本机</td>
                                    <td>2017-11-28 10:10:10</td>

                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>192.168.1.1</td>
                                    <td>本机</td>
                                    <td>2017-11-28 10:10:10</td>

                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>192.168.1.1</td>
                                    <td>本机</td>
                                    <td>2017-11-28 10:10:10</td>

                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>192.168.1.1</td>
                                    <td>本机</td>
                                    <td>2017-11-28 10:10:10</td>

                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>192.168.1.1</td>
                                    <td>本机</td>
                                    <td>2017-11-28 10:10:10</td>

                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>192.168.1.1</td>
                                    <td>本机</td>
                                    <td>2017-11-28 10:10:10</td>

                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>192.168.1.1</td>
                                    <td>本机</td>
                                    <td>2017-11-28 10:10:10</td>

                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="9" class="footable-visible">
                                        <ul class="pagination pull-right">
                                            <li class="footable-page-arrow disabled">
                                                <a data-page="first" href="#first">«</a>
                                            </li>

                                            <li class="footable-page-arrow disabled">
                                                <a data-page="prev" href="#prev">‹</a>
                                            </li>
                                            <li class="footable-page active">
                                                <a data-page="0" href="#">1</a>
                                            </li>
                                            <li class="footable-page">
                                                <a data-page="1" href="#">2</a>
                                            </li>
                                            <li class="footable-page">
                                                <a data-page="1" href="#">3</a>
                                            </li>
                                            <li class="footable-page">
                                                <a data-page="1" href="#">4</a>
                                            </li>
                                            <li class="footable-page">
                                                <a data-page="1" href="#">5</a>
                                            </li>
                                            <li class="footable-page-arrow">
                                                <a data-page="next" href="#next">›</a>
                                            </li>
                                            <li class="footable-page-arrow">
                                                <a data-page="last" href="#last">»</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>


        </div>

        @include('Zerone/Public/Footer')
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{asset('public/Zerone/library/jquery')}}/js/jquery-2.1.1.js"></script>
<script src="{{asset('public/Zerone/library/bootstrap')}}/js/bootstrap.min.js"></script>
<script src="{{asset('public/Zerone/library/metisMenu')}}/js/jquery.metisMenu.js"></script>
<script src="{{asset('public/Zerone/library/slimscroll')}}/js/jquery.slimscroll.min.js"></script>
<!-- Custom and plugin javascript -->
<script src="{{asset('public/Zerone')}}/js/inspinia.js"></script>
<script src="{{asset('public/Zerone/library/pace')}}/js/pace.min.js"></script>
<script src="{{asset('public/Zerone/library/sweetalert')}}/js/sweetalert.min.js"></script>
<script src="{{asset('public/Zerone/library/iCheck')}}/js/icheck.min.js"></script>
<script src="{{asset('public/Zerone/library/datapicker')}}/js/bootstrap-datepicker.js"></script>
<script src="{{asset('public/Zerone/library/switchery')}}/js/switchery.js"></script>
<!-- Mainly scripts -->
<script>
    $(document).ready(function() {
        $('#addbtn').click(function(){
            swal({
                title: "温馨提示",
                text: "修改成功",
                type: "success"
            });
        });
        $('#date_added').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'yyyy-mm-dd'
        });

        $('#date_modified').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

    });

</script>
</body>

</html>
