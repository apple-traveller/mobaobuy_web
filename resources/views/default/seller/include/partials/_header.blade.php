<ul class="layui-nav layui-layout-left" lay-filter="layui-header" style="position: relative;z-index: 2">
    <li class="layui-nav-item"><a href="">控制台</a></li>
    {{--<li class="layui-nav-item">--}}
        {{--<a href="javascript:;" data-url="/seller/shopUser" s_id="S040">店铺</a>--}}
        {{--<dl class="layui-nav-child">--}}
            {{--<dd><a href="/seller/shopUser" data-url="/seller/shopUser" s_id="S040">店铺资料</a></dd>--}}
            {{--<dd><a href="javascript:void(0);" data-url="/seller/shopUser" s_id="S041">职员列表</a></dd>--}}
        {{--</dl>--}}
    {{--</li>--}}
</ul>
<ul class="layui-nav layui-layout-right">
    <li class="layui-nav-item">
        <a href="javascript:;">
            <img src="{{asset(themePath('/').'layui/images/login/avtar.png')}}" class="layui-nav-img">
        </a>
        <dl class="layui-nav-child">
            <dd><a href="javascript:void(0);">商户：{{ $data['shop_name'] }}</a></dd>
            <dd><a href="javascript:void(0);">用户：{{ $data['user_name'] }}</a></dd>
            {{--{{ session('_seller')['real_name'] }}--}}
            {{--{{ session('_seller')['shop_info'] }}--}}
        </dl>
    </li>
    <li class="layui-nav-item" style="z-index: 12;width: 160px;overflow: hidden">
        <a href="/seller/logout">
            login out
        </a>

        <form id="logout-form" action="" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>
</ul>
