@extends(themePath('.','web').'web.include.layouts.home')
@section('title', '首页')
@section('css')
    <style>
        .Self-product-list li span{width:12.2%;}
        .news_pages ul.pagination {text-align: center;}
    </style>
@endsection
@section('js')
    <script>
        $(function(){

            $('#change_2 .ys_bigimg').soChange({
                thumbObj:'#change_2 .ys_banner_icon span',
                thumbNowClass:'on',
                changeTime:2000,
            });

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
@endsection

@section('content')
    <div class="clearfix play_banner" style="width:100%;height: 344px;position:relative;  z-index: 1;">
        <div class="ys_banner" id="change_2">
            <div class="ys_bigimg01">
                <a class="ys_bigimg" target="_blank" href="#" style="background: url(/images/banner.png) no-repeat center top;width: 100%; height: 344px; "></a>
                <a class="ys_bigimg" target="_blank" href="#" style="background: url(/images/banner.png) no-repeat center top;width: 100%; height: 344px; "></a>
                <a class="ys_bigimg" target="_blank" href="#" style="background: url(/images/banner.png) no-repeat center top;width: 100%; height: 344px; "></a>
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
            <div class="member_header tac"><img src="/images/hd.png"/></div>
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

                <div class="Time_limit_left leftPosition"><img src="/images/ass-lt-left.png"/></div>
                <div class="Time_limit_left rightPosition"><img src="/images/ass-lt-right.png"/></div>
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
            <div class="ovh"><h1 class="Self-support-title">自营报价</h1><div class="fr mr20"><span>共<font class="lcolor">61</font>条自营报价</span><a class="ml30 chakangengduo">查看更多></a></div></div>
            <ul class="Self-product-list">
                <li><span class="num_bg1">店铺</span><span>品牌</span><span>种类</span><span>商品名称</span><span>数量（公斤）</span><span>单价（元/公斤）</span><span>发货地址</span><span>操作</span></li>
                @foreach($goodsList as $vo)
                    <li><span data-id="{{$vo['packing_spec']}}" id="packing_spec">{{$vo['shop_name']}}</span><span>{{$vo['brand_name']}}</span><span class="ovh">{{$vo['cat_name']}}</span><span ><a class="orange" href="/goodsDetail?id={{$vo['id']}}&shop_id={{$vo['shop_id']}}">{{$vo['goods_name']}}</a></span><span>{{$vo['goods_number']}}</span><span>{{$vo['shop_price']}}</span><span>{{$vo['delivery_place']}}</span><span><button data-id="{{$vo['id']}}" class="P_cart_btn">加入购物车</button></span></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="w1200 tac fs30 fwb" style="margin-top: 30px;">一站式服务</div>
    <div class="One_service_bg">

        <ul class="One_service">
            <li class="One_service_bg1">
                <div class="One_service_blue"></div>
                <div class="One_service_top">
                    <div class="One_service_icon"><img src="/images/index_wl_icon.png"/></div>
                    <h1 class="tac fs18 fwb ">物流</h1>
                    <div class="One_service_by ">运输、仓储、加工一体服务</div>
                </div>
            </li>
            <li class="One_service_bg2">
                <div class="One_service_blue"></div>
                <div class="One_service_top">
                    <div class="One_service_icon"><img src="/images/index_jr_icon.png"/></div>
                    <h1 class="tac fs18 fwb">金融</h1>
                    <div class="One_service_by">解决产业链上下游资金问题</div>
                </div>

            </li>
            <li class="One_service_bg3">
                <div class="One_service_blue"></div>
                <div class="One_service_top">
                    <div class="One_service_icon"><img src="/images/index_hq_icon.png"/></div>
                    <h1 class="tac fs18 fwb">行情</h1>
                    <div class="One_service_by">维生素最及时的行情和资讯</div>
                </div>

            </li>
            <li class="One_service_bg4">
                <div class="One_service_blue"></div>
                <div class="One_service_top">
                    <div class="One_service_icon"><img src="/images/index_ys_icon.png"/></div>
                    <h1 class="tac fs18 fwb">云商</h1>
                    <div class="One_service_by">用更少的人<br />接更多的单</div>
                </div>

            </li>
            <li class="One_service_bg5">
                <div class="One_service_blue"></div>
                <div class="One_service_top">
                    <div class="One_service_icon"><img src="/images/index_zn_icon.png"/></div>
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
                    <div class="Quotate-img"><img src="/images/list_bg1.jpg" /></div>
                    <div class="Quotate_text">维生素市场价格行情动态</div>
                </li>
                <li>
                    <div class="Quotate-img"><img src="/images/list_bg2.jpg" /></div>
                    <div class="Quotate_text">维生素市场价格行情动态</div>
                </li>
                <li>
                    <div class="Quotate-img"><img src="/images/list_bg3.jpg" /></div>
                    <div class="Quotate_text">维生素市场价格行情动态</div>
                </li>
                <li>
                    <div class="Quotate-img"><img src="/images/list_bg4.jpg" /></div>
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
    <div class="w1200" style="margin:30px auto">
        <div class="ovh"><h1 class="Self-support-title">合作品牌</h1></div>

        <ul class="Cooperative_brand">
            <li class="bb1 bbright"><div><img src="/images/logo_01.png"/></div></li>
            <li class="bb1 bbright" ><div><img src="/images/logo_02.png"/></div></li>
            <li class="bb1 bbright"><div><img src="/images/logo_03.png"/></div></li>
            <li class="bb1 bbright"><div><img src="/images/logo_04.png"/></div></li>
            <li class="bb1 bbright"><div><img src="/images/logo_05.png"/></div></li>
            <li class="bb1"><div><img src="/images/logo_06.png"/></div></li>
            <li class="bbright"><div><img src="/images/logo_07.png"/></div></li>
            <li class="bbright"><div><img src="/images/logo_08.png"/></div></li>
            <li class="bbright"><div><img src="/images/logo_09.png"/></div></li>
            <li class="bbright"><div><img src="/images/logo_10.png"/></div></li>
            <li class="bbright"><div><img src="/images/logo_11.png"/></div></li>
            <li ><div><img src="/images/logo_12.png"/></div></li>
        </ul>
    </div>
@endsection

@section('bottom_js')
    <script>
        //加入购物车
        $(".P_cart_btn").click(function(){
            var userId = "{{session('_web_user_id')}}";
            if(userId==""){
                $.msg.error("未登录",1);
                return false;
            }
            var id = $(this).attr("data-id");
            var number = $("#packing_spec").attr('data-id');
            $.post("/cart",{'id':id,'number':number},function(res){
                if(res.code==1){
                    var cart_count = res.data;
                    $(".pro_cart_num").text(cart_count);
                    $.msg.success(res.msg,1);
                }else{
                    $.msg.alert(res.msg);
                }
            },"json");
        });

        $(".chakangengduo").click(function(){
            window.location.href="/goodsList";
        });
    </script>
@endsection