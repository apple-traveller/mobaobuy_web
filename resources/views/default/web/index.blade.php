<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>首页</title>
    <link rel="stylesheet" href="css/global.css" />
    <link rel="stylesheet" href="css/index.css" />
    <script type="text/javascript" src="js/jquery-1.10.2.min.js" ></script>
    <script type="text/javascript" src="js/jquery.soChange-min.js"></script>

    <!--banner-->
    <script type="text/javascript">
        $(function(){
            $('#change_2 .ys_bigimg').soChange({
                thumbObj:'#change_2 .ys_banner_icon span',
                thumbNowClass:'on',
                changeTime:2000,
            });
        });
    </script>
    <script type="text/javascript">
        $(function(){

            $(document).delegate('.supply_list>li','mouseenter',function(){

                $(this).find('.operation').text('收起');
                $(this).find('.supply_list_inside').show();
                $(this).addClass('supply_border_curr');

                $('.supply_list>li:first-child').removeClass("supply_border_curr");
            });
            $(document).delegate('.supply_list>li','mouseleave',function(){
                $(this).find('.operation').text('展开');
                $(this).find('.supply_list_inside').hide();
                $(this).removeClass('supply_border_curr');
            });
            //维生素行情
            $(function(){
                $('.Quotate li').hover(function(){
                    $(this).find('.Quotate_text').animate({bottom:"0px"});
                },function(){$(this).find('.Quotate_text').animate({bottom:"-30px"});})
            })
            //导航
            $('.ass_menu li').hover(function(){
                $(this).find('.ass_fn').toggle();
            })
        })
    </script>
</head>
<body style="background-color: #f4f4f4;">
<div class="clearfix height35 lh35 graybg">
    <div class="w1200">
        <div class="top_til">
            <a>登录</a>
            <a>注册</a>
            <a>帮助中心</a>
            <a>会员中心</a>
            <a>快速下单</a><span class="top_tel">400-000-0000</span></div>
    </div>
</div>

<div class="header">
    <div class="w1200">
        <div class="clearfix">
            <div class="logo" style="margin-top: 38px;"></div>
            <div class="index_search fl mt40">
                <input type="text" class="index_search_text fl" placeholder="请输入关键词、类别进行搜索"/><input type="button" class="index_search_btn white fs16 fl" value="搜 索"/>
                <a class="contact_artificial tac br1 db fl ml10">联系人工找货</a>
                <div class="hot_search_m">热门推荐：
                    <a href="#.html" target="_blank">7000F泰国PTT</a>
                    <a href="#.html" target="_blank">218WJ</a>
                    <a href="#.html" target="_blank">7000</a>
                    <a href="#.html" target="_blank">218w</a>
                    <a href="#.html" target="_blank">7000f</a>
                    <a href="#.html" target="_blank">9001台湾台塑</a>
                </div>
            </div>

            <a class="shopping_cart mt40 tac"><span class="fl ml25">我的购物车</span><i class="shopping_img fl"><img src="img/cart_icon.png"/></i><span class="pro_cart_num white">1</span></a>
        </div>
        <div class="clearfix">

            <div class="nav">
                <div class="fication_menu">原料分类</div>
                <ul class="ass_menu">
                    <li><span class="ass_title">维生素</span> <span class="ass_list-right ass_list-right_icon ass_list-right_icon01"></span>
                        <div class="ass_fn whitebg">
                            <ul class="ass_fn_list">
                                <li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VE</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VD3</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">烟酰胺/烟酸</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                            </ul>
                        </div>
                    </li>
                    <li><span class="ass_title">维生素</span> <span class="ass_list-right ass_list-right_icon ass_list-right_icon01"></span>
                        <div class="ass_fn whitebg">
                            <ul class="ass_fn_list">
                                <li><h1 class="fn_title fl">VB</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VE</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VD3</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">烟酰胺/烟酸</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                            </ul>
                        </div>
                    </li>
                    <li><span class="ass_title">维生素</span> <span class="ass_list-right ass_list-right_icon ass_list-right_icon01"></span>
                        <div class="ass_fn whitebg">
                            <ul class="ass_fn_list">
                                <li><h1 class="fn_title fl">VC</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VE</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VD3</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">烟酰胺/烟酸</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                            </ul>
                        </div>
                    </li>
                    <li><span class="ass_title">维生素</span> <span class="ass_list-right ass_list-right_icon ass_list-right_icon01"></span>
                        <div class="ass_fn whitebg">
                            <ul class="ass_fn_list">
                                <li><h1 class="fn_title fl">VD</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VE</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VD3</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">烟酰胺/烟酸</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                            </ul>
                        </div>
                    </li>
                    <li><span class="ass_title">维生素</span> <span class="ass_list-right ass_list-right_icon ass_list-right_icon01"></span>
                        <div class="ass_fn whitebg">
                            <ul class="ass_fn_list">
                                <li><h1 class="fn_title fl">VE</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VE</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VD3</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">烟酰胺/烟酸</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                            </ul>
                        </div>
                    </li>
                    <li><span class="ass_title">维生素</span> <span class="ass_list-right ass_list-right_icon ass_list-right_icon01"></span>
                        <div class="ass_fn whitebg">
                            <ul class="ass_fn_list">
                                <li><h1 class="fn_title fl">VF</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VE</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VD3</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                                <li><h1 class="fn_title fl">烟酰胺/烟酸</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
                            </ul>
                        </div>
                    </li>
                </ul>

            </div>

            <div class="menu">
                <ul><li>首页</li><li>报价列表</li><li>拼团活动</li><li>限时秒杀</li><li>资讯中心</li><li>产品列表</li><li>帮助中心</li></ul>
            </div>
        </div>
    </div>
</div>

<div class="clearfix play_banner" style="width:100%;height: 344px;position:relative;  z-index: 1;">
    <div class="ys_banner" id="change_2">
        <div class="ys_bigimg01">
            <a class="ys_bigimg" target="_blank" href="#" style="background: url(img/banner.png) no-repeat center top;width: 100%; height: 344px; "></a>
            <a class="ys_bigimg" target="_blank" href="#" style="background: url(img/banner.png) no-repeat center top;width: 100%; height: 344px; "></a>
            <a class="ys_bigimg" target="_blank" href="#" style="background: url(img/banner.png) no-repeat center top;width: 100%; height: 344px; "></a>
            <ul class="ys_banner_icon">
                <li><span>1</span></li>
                <li><span>2</span></li>
                <li><span>3</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="w1200 pr" style="z-index: 1;">
    <div class="member_center whitebg">
        <div class="member_header tac"><img src="img/hd.png"/></div>
        <div class="tac">尊敬的用户，欢迎来到秣宝网!</div>
        <div class="member_cnt">
            <div class="member_btn code_greenbg white">快速登录</div><div class="member_btn br1 gray ml20">快速登录</div>
            <input type="text" class="member_text member_lh32 graybg p5" placeholder="请输入手机号"/>
            <textarea class="member_text graybg member_h72 p5" placeholder="填写您的真实需求，提交给我们"></textarea>
            <button class="member_text tac member_lh32 code_greenbg white">立即找货</button>
        </div>
    </div>

    <div class="mt10 ovh">
        <!--限时秒杀-查看更多-->
        <div class="index_xs_ms"><a class="See_more tac ovh">查看更多></a></div>
        <!--秒杀进度-->
        <div class="fl pr">
            <div class="Time_limit_action whitebg pr ovh fl">

                <div class="Time_limit_action_top mt10">
                    <div class="Time_limit_action_progress  fs16 white fl">进度 68%</div><span class="fr mr15"><font class="orange">169</font>次浏览</span></div>
                <div class="mt40">
                    <div class="fs20 tac"><span>维生素C粉</span><span class="ml15">90公斤</span></div>
                    <div class="fs16 tac"><span>价格</span><span class="ml15"><font class="fs24 orange">￥50.00</font>/kg</span></div>
                </div>
                <div class="Time_limit_action_bottom graybg">
                    <div class="bottom_time">距离结束：<span class="orange">0天22小时27分钟22秒</span></div><div class="bottom_btn redbg fs16 white cp">参与秒杀</div>
                </div>
            </div>

            <div class="Time_limit_action whitebg pr ovh fl ml2">
                <div class="Time_limit_action_top mt10"><div class="Time_limit_action_progress  fs16 white fl">进度 68%</div><span class="fr mr15"><font class="orange">169</font>次浏览</span></div>
                <div class="mt40">
                    <div class="fs20 tac"><span>维生素C粉</span><span class="ml15">90公斤</span></div>
                    <div class="fs16 tac"><span>价格</span><span class="ml15"><font class="fs24 orange">￥50.00</font>/kg</span></div>
                </div>
                <div class="Time_limit_action_bottom graybg">
                    <div class="bottom_time fl tac">距离结束：<span class="orange">0天22小时27分钟22秒</span></div><div class="bottom_btn fl redbg tac fs16 white cp">参与秒杀</div>
                </div>
            </div>

            <div class="Time_limit_left leftPosition"><img src="img/ass-lt-left.png"/></div>
            <div class="Time_limit_left rightPosition"><img src="img/ass-lt-right.png"/></div>
        </div>
        <!--成交动态-->
        <div class="Tran_dynamics">
            <h1 class="ml20 mt15 fs16 fwb">成交动态</h1>
            <ul class="Tran_dynamics_list">
                <li>
                    <h1 class="ml5 mt5">维生素C粉</h1>
                    <div class="ml5 gray"><span>￥50.00</span><span class="ml10">2018/09/17</span><span class="ml10">19:15</span></div>
                </li>
                <li>
                    <h1 class="ml5 mt5">维生素C粉</h1>
                    <div class="ml5 gray"><span>￥50.00</span><span class="ml10">2018/09/17</span><span class="ml10">19:15</span></div>
                </li>
                <li>
                    <h1 class="ml5 mt5">维生素C粉</h1>
                    <div class="ml5 gray"><span>￥50.00</span><span class="ml10">2018/09/17</span><span class="ml10">19:15</span></div>
                </li>
                <li>
                    <h1 class="ml5 mt5">维生素C粉</h1>
                    <div class="ml5 gray"><span>￥50.00</span><span class="ml10">2018/09/17</span><span class="ml10">19:15</span></div>
                </li>
                <li>
                    <h1 class="ml5 mt5">维生素C粉</h1>
                    <div class="ml5 gray"><span>￥50.00</span><span class="ml10">2018/09/17</span><span class="ml10">19:15</span></div>
                </li>
            </ul>
        </div>
    </div>
    <!--自营报价-->

    <div class="Self-support mt30">
        <div class="ovh"><h1 class="Self-support-title">自营报价</h1><div class="fr mr20"><span>共<font class="lcolor">61</font>条自营报价</span><a class="ml30">查看更多></a></div></div>
        <ul class="Self-support-list">
            <li><span>品牌</span><span>种类</span><span>商品名称</span><span>单价（元/公斤）</span><span>数量（公斤）</span><span>发货地址</span><span>操作</span></li>
            <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place">下单</a></span></li>
            <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place">下单</a></span></li>
            <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place">下单</a></span></li>
            <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place">下单</a></span></li>
            <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place">下单</a></span></li>
            <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place">下单</a></span></li>
            <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place">下单</a></span></li>
            <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place">下单</a></span></li>
        </ul>
    </div>
</div>
<div class="w1200 tac fs30 fwb" style="margin-top: 30px;">一站式服务</div>
<div class="One_service_bg">

    <ul class="One_service">
        <li class="One_service_bg1">
            <div class="One_service_blue"></div>
            <div class="One_service_top">
                <div class="One_service_icon"><img src="img/index_wl_icon.png"/></div>
                <h1 class="tac fs18 fwb ">物流</h1>
                <div class="One_service_by ">运输、仓储、加工一体服务</div>
            </div>
        </li>
        <li class="One_service_bg2">
            <div class="One_service_blue"></div>
            <div class="One_service_top">
                <div class="One_service_icon"><img src="img/index_jr_icon.png"/></div>
                <h1 class="tac fs18 fwb">金融</h1>
                <div class="One_service_by">解决产业链上下游资金问题</div>
            </div>

        </li>
        <li class="One_service_bg3">
            <div class="One_service_blue"></div>
            <div class="One_service_top">
                <div class="One_service_icon"><img src="img/index_hq_icon.png"/></div>
                <h1 class="tac fs18 fwb">行情</h1>
                <div class="One_service_by">维生素最及时的行情和资讯</div>
            </div>

        </li>
        <li class="One_service_bg4">
            <div class="One_service_blue"></div>
            <div class="One_service_top">
                <div class="One_service_icon"><img src="img/index_ys_icon.png"/></div>
                <h1 class="tac fs18 fwb">云商</h1>
                <div class="One_service_by">用更少的人<br />接更多的单</div>
            </div>

        </li>
        <li class="One_service_bg5">
            <div class="One_service_blue"></div>
            <div class="One_service_top">
                <div class="One_service_icon"><img src="img/index_zn_icon.png"/></div>
                <h1 class="tac fs18 fwb">智能</h1>
                <div class="One_service_by">助力智慧维生素产业升级</div>
            </div>

        </li>
    </ul>
</div>
<!--供应商-->
<div class="w1200" style="margin-top: 30px;">
    <div class="ovh"><h1 class="Self-support-title">供应商</h1><div class="fr mr20"><a class="ml30">查看更多></a></div></div>

    <ul class="supply_list mt15">
        <li class="graybg">
            <span>公司名称</span><span>联系人</span><span>联系电话</span><span>主营品种</span><span>上传时间</span><span>操作</span>
        </li>
        <li>
            <div class="clearfix"><span>上海测试</span><span>小瑶瑶</span><span>15233254624</span><span>维生素</span><span>7小时前</span><span class="lcolor operation">展开</span></div>
            <div class="supply_list_inside" style="display: none;">
                <ul>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                </ul>
            </div>
        </li>
        <li>
            <div class="clearfix"><span>上海测试</span><span>小瑶瑶</span><span>15233254624</span><span>维生素</span><span>7小时前</span><span class="lcolor operation">展开</span></div>
            <div class="supply_list_inside" style="display: none;">
                <ul class="">
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                </ul>
            </div>
        </li>
        <li>
            <div class="clearfix"><span>上海测试</span><span>小瑶瑶</span><span>15233254624</span><span>维生素</span><span>7小时前</span><span class="lcolor operation">展开</span></div>
            <div class="supply_list_inside" style="display: none;">
                <ul class="">
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                </ul>
            </div>
        </li>
        <li>
            <div class="clearfix"><span>上海测试</span><span>小瑶瑶</span><span>15233254624</span><span>维生素</span><span>7小时前</span><span class="lcolor operation">展开</span></div>
            <div class="supply_list_inside" style="display: none;">
                <ul class="">
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                </ul>
            </div>
        </li>
        <li>
            <div class="clearfix"><span>上海测试</span><span>小瑶瑶</span><span>15233254624</span><span>维生素</span><span>7小时前</span><span class="lcolor operation">展开</span></div>
            <div class="supply_list_inside" style="display: none;">
                <ul class="">
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                    <li><span>恒兴</span><span>维生素</span><span class="ovh">维生素E粉</span><span class="lcolor fwb">80.00</span><span>1000</span><span>上海</span><span><a class="Self-support-place ml-20">下单</a></span></li>
                </ul>
            </div>
        </li>
    </ul>
</div>
<!--维生素行情-->
<div class="w1200" style="margin-top: 30px;">
    <div class="ovh"><h1 class="Self-support-title">维生素行情</h1><div class="fr mr20"><a class="ml30">查看更多></a></div></div>
    <div class="whitebg ovh mt10">
        <ul class="Quotate">
            <li>
                <div class="Quotate-img"><img src="img/list_bg1.jpg" /></div>
                <div class="Quotate_text">维生素市场价格行情动态</div>
            </li>
            <li>
                <div class="Quotate-img"><img src="img/list_bg2.jpg" /></div>
                <div class="Quotate_text">维生素市场价格行情动态</div>
            </li>
            <li>
                <div class="Quotate-img"><img src="img/list_bg3.jpg" /></div>
                <div class="Quotate_text">维生素市场价格行情动态</div>
            </li>
            <li>
                <div class="Quotate-img"><img src="img/list_bg4.jpg" /></div>
                <div class="Quotate_text">维生素市场价格行情动态</div>
            </li>
        </ul>

        <ul class="Quotate_right">
            <li><span class="fl ml5">2018年第29周维生素市场价格行情动态</span><span class="fr">(07/23)</span></li>
            <li><span class="fl ml5">2018年第29周维生素市场价格行情动态</span><span class="fr">(07/23)</span></li>
            <li><span class="fl ml5">2018年第29周维生素市场价格行情动态</span><span class="fr">(07/23)</span></li>
            <li><span class="fl ml5">2018年第29周维生素市场价格行情动态</span><span class="fr">(07/23)</span></li>
            <li><span class="fl ml5">2018年第29周维生素市场价格行情动态</span><span class="fr">(07/23)</span></li>
            <li><span class="fl ml5">2018年第29周维生素市场价格行情动态</span><span class="fr">(07/23)</span></li>
            <li><span class="fl ml5">2018年第29周维生素市场价格行情动态</span><span class="fr">(07/23)</span></li>
            <li><span class="fl ml5">2018年第29周维生素市场价格行情动态</span><span class="fr">(07/23)</span></li>
        </ul>
    </div>
</div>
<!--合作品牌-->
<div class="w1200" style="margin-top: 30px;">
    <div class="ovh"><h1 class="Self-support-title">合作品牌</h1></div>

    <ul class="Cooperative_brand">
        <li class="bb1 bbright"><div><img src="img/logo_01.png"/></div></li>
        <li class="bb1 bbright" ><div><img src="img/logo_02.png"/></div></li>
        <li class="bb1 bbright"><div><img src="img/logo_03.png"/></div></li>
        <li class="bb1 bbright"><div><img src="img/logo_04.png"/></div></li>
        <li class="bb1 bbright"><div><img src="img/logo_05.png"/></div></li>
        <li class="bb1"><div><img src="img/logo_06.png"/></div></li>
        <li class="bbright"><div><img src="img/logo_07.png"/></div></li>
        <li class="bbright"><div><img src="img/logo_08.png"/></div></li>
        <li class="bbright"><div><img src="img/logo_09.png"/></div></li>
        <li class="bbright"><div><img src="img/logo_10.png"/></div></li>
        <li class="bbright"><div><img src="img/logo_11.png"/></div></li>
        <li ><div><img src="img/logo_12.png"/></div></li>
    </ul>
</div>
<!--底部-->
<div class="footer">
    <div class="clearfix whitebg mt35">
        <div class="w1200">
            <ul class="footer_icon ovh">
                <li><div class="login_icon login_icon01 fl"></div><h1>品类齐全 轻松购物</h1></li>
                <li><div class="login_icon login_icon02 fl"></div><h1>便捷交易 订货零风险</h1></li>
                <li><div class="login_icon login_icon03 fl"></div><h1>多仓直发 极速配送</h1></li>
                <li><div class="login_icon login_icon04 fl"></div><h1>阳光采购 一站式服务</h1></li>
            </ul>
        </div>
    </div>

    <div class="clearfix whitebg " style="border-top: 1px solid #DEDEDE;font-size: 0;">

        <div class="footer_content">
            <ul class="footer_list mt30 mb30 ovh">
                <li>
                    <h4>关于秣宝</h4>
                    <a href="#.html" rel="nofollow">企业文化</a>
                    <a href="#.html" rel="nofollow">企业证照</a>
                    <a href="#.html" rel="nofollow">联系我们</a>
                </li>
                <li>
                    <h4>友情连接</h4>
                    <a href="#.html" rel="nofollow">秣宝官网</a>
                    <a href="#.html" rel="nofollow">秣宝官网</a>
                </li>
                <li>
                    <h4>新手指南</h4>
                    <a href="#.html" rel="nofollow">购物指南</a>
                    <a href="#.html" rel="nofollow">找回密码</a>
                    <a href="#.html" rel="nofollow">用户服务协议</a>
                </li>
                <li>
                    <h4>支付与买货</h4>
                    <a href="#.html" rel="nofollow">购物指南</a>
                    <a href="#.html" rel="nofollow">公司转账</a>
                    <a href="#.html" rel="nofollow">在线支付</a>
                </li>
                <li>
                    <h4>售后服务</h4>
                    <a href="#.html" rel="nofollow">发票说明</a>
                    <a href="#.html" rel="nofollow">物流配送</a>
                </li>

                <li>
                    <div class="tel" >
                        <p class="fs24 tac" style="color: #75b335;">400-004-0788</p>
                        <p class="tac" style="width: 190px; margin: 5px auto; color: #666;">周一至周日8:00-18:00（仅收市话费）</p>
                        <p class="tac"><a rel="nofollow"  href="#"><img border="0" class="mr5p" style="margin-top:3px;" src="img/custom.png"/></a></p>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
</body>
</html>
