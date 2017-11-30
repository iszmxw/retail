<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    	<span>
                            <img alt="image"  src="{{asset('public/Program')}}/images/zerone_logo.png" />
                         </span>

                </div>
                <div class="logo-element">
                    01
                </div>
            </li>
            <li class="active">
                <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">系统管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="active"><a href="index.html">管理首页</a></li>
                    <li><a href="addaccount.html">添加账号</a></li>

                    <li><a href="allctrllog.html">所有操作记录</a></li>
                    <li><a href="allloginlog.html">所有登陆记录</a></li>
                </ul>
            </li>
            <li>
                <a href="index.html"><i class="fa fa-user"></i> <span class="nav-label">个人中心</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="editpassword.html">登陆密码修改</a></li>

                    <li><a href="ctrllog.html">我的操作日志</a></li>
                    <li><a href="loginlog.html">我的登录日志</a></li>
                </ul>
            </li>

            <li>
                <a href="index.html"><i class="fa fa-language"></i> <span class="nav-label">程序管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="addsystem.html">添加程序</a></li>
                    <li><a href="system.html">程序列表</a></li>
                </ul>
            </li>
            <li>
                <a href="index.html"><i class="fa fa-slack"></i> <span class="nav-label">功能模块管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="addfuncmodule.html">添加模块</a></li>
                    <li><a href="funcmodule.html">模块列表</a></li>
                </ul>
            </li>
            <li>
                <a href="index.html"><i class="fa fa-steam"></i> <span class="nav-label">功能节点管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="addnode.html">添加节点</a></li>
                    <li><a href="node.html">节点列表</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ url('program/quit') }}"><i class="fa fa-sign-out"></i> <span class="nav-label">退出登录</span></a>
            </li>


        </ul>

    </div>
</nav>