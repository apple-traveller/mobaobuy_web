<!doctype html>
<html lang="en">
<head>
    <title>会员中心 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
</head>
<body style="background-color: rgb(244, 244, 244);">
    @include(themePath('.','web').'web.include.partials.top')
    @component(themePath('.','web').'web.include.partials.top_title', ['title_name' => '会员中心'])@endcomponent

    <div class="clearfix mt25 mb25">
        <div class="w1200">
            <div class="member_left">
                @if(session('_curr_deputy_user')['is_self'] && session('_curr_deputy_user')['is_firm'])
                {{--只有企业管理员才能进行企业管理--}}
                <div class="member_list_mode">
                    <h1 class=""><i class="iconfont icon-46"></i>企业管理</h1>
                    <ul class="member_left_list">
                        <li><a href="/createFirmUser">职员管理</a></li>
                        <li><a href="/firmUserAuthList">审核设置</a></li>
                        <li><div class="bottom"></div><div class="line"></div></li>
                    </ul>
                </div>
                @endif

                @if(session('_curr_deputy_user')['is_firm'] && (session('_curr_deputy_user')['is_self'] || session('_curr_deputy_user')['can_stock_in'] || session('_curr_deputy_user')['can_stock_out']))
                {{--只有企业才能进行库存管理--}}
                <div class="member_list_mode">
                    <h1 class=""><i class="iconfont icon-icons_goods"></i>库存管理</h1>
                    <ul class="member_left_list">
                        @if(session('_curr_deputy_user')['is_self'] || session('_curr_deputy_user')['can_stock_in'])
                        <li><a href="/stockIn">入库管理</a></li>
                        @endif
                        @if(session('_curr_deputy_user')['is_self'] || session('_curr_deputy_user')['can_stock_out'])
                        <li><a href="/stockOut">出库管理</a></li>
                        @endif
                        <li><a href="/stockNum">库存查询</a></li>
                        <li><div class="bottom"></div><div class="line"></div></li>
                    </ul>
                </div>
                @endif
                <div class="member_list_mode">
                    <h1 class=""><i class="iconfont icon-svgorder"></i>订单管理</h1>
                    <ul class="member_left_list">
                        <li><a href="/cart">购物车</a></li>
                        <li class="curr"><a href="/order">我的订单</a></li>
                        <li><div class="bottom"></div><div class="line"></div></li>
                    </ul>
                </div>
                <div class="member_list_mode">
                    <h1 class=""><i class="iconfont icon-userset"></i>账号管理</h1>
                    <ul class="member_left_list">
                        <li>用户信息</li>
                        <li><a href="/updateUserInfo">实名认证</a></li>
                        <li><a href="/forgotPwd">修改密码</a></li>
                        <li><a href="/paypwd">支付密码</a></li>
                        <li><a href="/collectGoodsList">我的收藏</a></li>
                        <li><a href="/addressList">收货地址</a></li>
                        <li><a href="/invoices">发票维护</a></li>
                        <li><div class="bottom"></div><div class="line"></div></li>
                    </ul>
                </div>
                <div class="member_list_mode">
                    <h1 class=""><i class="iconfont icon-huodong"></i>活动中心</h1>
                    <ul class="member_left_list">
                        <li>限时抢购</li>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @yield('content')

    @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
</body>
</html>