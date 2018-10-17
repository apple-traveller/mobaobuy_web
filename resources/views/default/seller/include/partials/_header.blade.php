<ul class="layui-nav layui-layout-left">
    <li class="layui-nav-item"><a href="">控制台</a></li>
    <li class="layui-nav-item">
        <a href="javascript:;">下拉菜单</a>
        <dl class="layui-nav-child">
            <dd><a href="">邮件管理</a></dd>
            <dd><a href="">消息管理</a></dd>
            <dd><a href="">授权管理</a></dd>
        </dl>
    </li>
</ul>
<ul class="layui-nav layui-layout-right">
    <li class="layui-nav-item">
        <a href="javascript:;">
            <img src="{{asset(themePath('/').'layui/images/login/avtar.png')}}" class="layui-nav-img">
        </a>
        <dl class="layui-nav-child">
            <dd><a href="javascript:void(0);">seller</a></dd>
            <dd><a href="javascript:void(0);">shop_name</a></dd>
            {{--{{ session('_seller')['real_name'] }}--}}
            {{--{{ session('_seller')['shop_info'] }}--}}
        </dl>
    </li>
    <li class="layui-nav-item">
        <a href="/seller/logout"
           >
            login out
        </a>

        <form id="logout-form" action="" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>
</ul>
