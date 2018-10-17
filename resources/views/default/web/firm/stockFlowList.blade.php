<!doctype html>
<html lang="en">
<head>
    <title>会员中心 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    <style type="text/css">
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
        /*实时库存详情-页面*/
        .select_txt{width: 200px;height: 34px;border: 1px solid #DEDEDE;position: relative;}
        .select_txt select{
        /*清除select的边框样式*/border: none;/*清除select聚焦时候的边框颜色*/outline: none;
        /*将select的宽高等于div的宽高*/width: 100%;height: 34px;line-height: 34px;
        /* 隐藏select的下拉图标*/ appearance: none;-webkit-appearance: none;-moz-appearance: none;
        /*通过padding-left的值让文字居中*/padding-left: 10px;
        }
        /*使用伪类给select添加自己想用的图标*/
        .select_txt:after{content: "";width: 20px;height: 8px;background: url(../img/xiala.png) no-repeat center;
        position: absolute;right: 10px;top: 40%;pointer-events: none;}
        .date_btn{width: 90px;height: 34px;line-height: 34px;background-color: #75b335;border-radius: 2px;cursor: pointer;}
        .br0{border: 0px;}
        .white,a.white,a.white:hover{color:#fff; text-decoration:none;}
        .product_table,.Real_time{width: 905px;margin: 0 auto;margin-top: 20px;}
        .product_table li:first-child{font-size:14px;height:40px;line-height:40px;border: 1px solid #DEDEDEA;background-color: #eeeeee;}
        .product_table li:nth-child(odd){background-color: #f4f4f4;}
        .product_table li{height: 45px;line-height: 45px;}
        .product_table li span{text-align: center;display: inline-block;float: left;}
        .product_table_btn{width: 60px;height: 25px;line-height: 25px;text-align: center;color: #fff;border-radius: 3px;}
        .cz_line{height: 14px;width: 1px;}
        .product_table .wh181{width: 181px;}
        .product_table .wh135{width: 135px;}
        .product_table .wh85{width: 85px;}
        .product_table .wh90{width: 90px;}
        .product_table .wh100{width: 100px;}
        .product_table .wh130{width: 130px;}
        .product_table .wh155{width: 155px;}
        .product_table .wh219{width: 219px;}
        .product_table .wh115{width: 115px;}
        .product_table .wh209{width: 209px;}
        .mt20{margin-top:20px;}
        .chuku li:last-child{height: 81px;line-height: 81px;background-color: #f4f4f4;font-size: 16px;}
        .ovhwp{overflow: hidden;text-overflow:ellipsis;white-space: nowrap;}
        .fs18{font-size:18px;}
        .orange,a.orange,a.orange:hover{color:#ff6600;}
        .fwb{font-weight:bold;}
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
                        <div class="fl select_txt">
                            <select name="" class="">
                                <option value="全部">全部</option>
                                <option value="维生素">维生素</option>
                            </select>
                        </div>
                        <button class="date_btn br0 white ml15">查询</button>
                        <button class="back_btn br0 white ml15">返回上一页</button>
                    </div>
                    
                    <ul class="product_table ovh mt20 chuku">
                        <li><span class="wh181">日期</span><span class="wh219">订单单号</span><span class="wh115">类型</span><span class="wh181 ovhwp">商品名称</span><span class="wh209">数量</span></li>
                        <li><span class="wh181">2018-08-08</span><span class="wh219">20180808001</span><span class="wh115">出库</span><span class="wh181 ovhwp">维生素E粉</span><span class="wh209">50</span></li>
                        <li><span class="wh181">2018-08-08</span><span class="wh219">20180808001</span><span class="wh115">出库</span><span class="wh181 ovhwp">维生素E粉</span><span class="wh209">50</span></li>
                        <li><span class="wh181">2018-08-08</span><span class="wh219">20180808001</span><span class="wh115">出库</span><span class="wh181 ovhwp">维生素E粉</span><span class="wh209">50</span></li>
                        <li><span class="wh181">2018-08-08</span><span class="wh219">20180808001</span><span class="wh115">出库</span><span class="wh181 ovhwp">维生素E粉</span><span class="wh209">50</span></li>
                        <li><span class="wh181">2018-08-08</span><span class="wh219">20180808001</span><span class="wh115">出库</span><span class="wh181 ovhwp">维生素E粉</span><span class="wh209">50</span></li>
                        <li><span class="wh181">2018-08-08</span><span class="wh219">20180808001</span><span class="wh115">出库</span><span class="wh181 ovhwp">维生素E粉</span><span class="wh209">50</span></li>
                        <li><span class="wh181">2018-08-08</span><span class="wh219">20180808001</span><span class="wh115">出库</span><span class="wh181 ovhwp">维生素E粉</span><span class="wh209">50</span></li>
                        <li><span style="float: right; margin-right: 65px;">可用库存数量：<font class="fs18 orange fwb">46kg</font></span></li>
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