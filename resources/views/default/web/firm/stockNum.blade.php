<!doctype html>
<!doctype html>
<html lang="en">
<head>
    <title>会员中心 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    <style type="text/css">
        /*实时库存-页面*/
        .Real_time li:first-child{font-size:14px;height:40px;line-height:40px;border: 1px solid #DEDEDEA;background-color: #eeeeee;}
        .Real_time li{height: 45px;line-height: 45px;}
        .Real_time li:nth-child(odd){background-color: #f4f4f4;}
        .Real_time li span{text-align: center;display: inline-block;float: left;width: 33.3%;}
        .Real_time li:nth-child(odd){background-color: #f4f4f4;}
        .real_time{width: 60px;height: 24px;line-height: 24px;display: block;margin: 10px auto; color: #fff;border-radius: 3px;}
        .product_table,.Real_time{width: 905px;margin: 0 auto;margin-top: 20px;}
        .member_right{width: 968px;box-sizing: border-box; min-height: 842px;height: auto;}
        .whitebg{background: #FFFFFF;}
        .fl{float:left;}
        .ml15{margin-left:15px;}
        .br1{border: 1px solid #DEDEDE;}
        .pr {position:relative; }.pa{position: absolute;}
        .member_right_title_icon{background: url(../img/member_title_icon.png)no-repeat 0px 6px;}
        .mt25{margin-top:25px;}
        .ml30{margin-left:30px;}
        .pl20{padding-left:20px;}
        .fs16{font-size:16px;}
        .reward_table{width: 905px;margin: 0 auto;margin-top: 20px;margin-bottom: 70px;}
        .ovh{overflow: hidden;}
        .border_text{width: 184px;height: 34px;padding: 6px;box-sizing: border-box;border: 1px solid #DEDEDE;}
        .date_btn{width: 90px;height: 34px;line-height: 34px;background-color: #75b335;border-radius: 2px;cursor: pointer;}
        .br0{border: 0px;}
        .white,a.white,a.white:hover{color:#fff; text-decoration:none;}
        .tac{text-align:center !important;}
        .ovhwp{overflow: hidden;text-overflow:ellipsis;white-space: nowrap;}
        .code_greenbg{background-color: #75b335;} 
        .reward_table_bottom{position:absolute;bottom: 5px;right: 27px;}
        .reward_table_bottom ul.pagination {display: inline-block;padding: 0;margin: 0;}
        .reward_table_bottom ul.pagination li {height: 20px;line-height: 20px;display: inline;}
        .reward_table_bottom ul.pagination li a {color: #ccc;float: left;padding: 4px 16px;text-decoration: none;transition: background-color .3s;border: 1px solid #ddd;margin: 0 4px;}
        .reward_table_bottom ul.pagination li a.active {color: #75b335;border: 1px solid #75b335;}
        .reward_table_bottom ul.pagination li a:hover:not(.active) {color: #75b335;border: 1px solid #75b335;}
    </style>
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
            <!--右部分-->
            <div class="member_right whitebg fl ml15 br1 pr">
            <!--标题-->
                <h1 class="member_right_title_icon mt25 ml30 pl20 fs16">实时库存列表</h1>
                <div class="reward_table ovh">
                    <div class="ovh">
                        <div class="fl"><input type="text" class="border_text" placeholder="商品名称"/></div><button class="date_btn br0 white ml15">查询</button>
                    </div>
                    
                    <ul class="Real_time">
                        <li><span class="fl tac">名称</span><span class="fl tac">库存剩余数量(kg)</span><span class="fl tac">操作</span></li>
                        <li><span class="fl tac ovhwp">维生素E粉</span><span class="fl tac">80</span><span class="fl tac"><a class="real_time code_greenbg">查看</a></span></li>
                        <li><span class="fl tac ovhwp">维生素E粉</span><span class="fl tac">80</span><span class="fl tac"><a class="real_time code_greenbg">查看</a></span></li>
                        <li><span class="fl tac ovhwp">维生素E粉</span><span class="fl tac">80</span><span class="fl tac"><a class="real_time code_greenbg">查看</a></span></li>
                        <li><span class="fl tac ovhwp">维生素E粉</span><span class="fl tac">80</span><span class="fl tac"><a class="real_time code_greenbg">查看</a></span></li>
                    </ul>
                </div>
                <!--页码-->
                <div class="reward_table_bottom">
                <ul class="pagination">
                <li><a href="#">首页</a></li>
                  <li><a href="#">上一页</a></li>
                  <li><a href="#">1</a></li>
                  <li><a class="active" href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">下一页</a></li>
                  <li><a href="#">尾页</a></li>
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