@extends(themePath('.','web').'web.include.layouts.home')
@section('title', getSeoInfoByType('index')['title'])
@section('keywords', getSeoInfoByType('index')['keywords'])
@section('description', getSeoInfoByType('index')['description'])
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/','web').'css/index.css')}}" />
    <style>
        .supply_quote_list li{height: 89px;overflow: initial;}
        .custom_service {width: 80px;margin-top: 20px;line-height: 22px; height: 22px;position: relative;z-index: 9999999;}
        .custom_service .custom_service_p {cursor: pointer;}
        .custom_service .custom_service_popup {position: absolute;top: -95px;left: -60px;width: 200px;height: 88px;border: 1px solid #cde1f6;background: #f9fdff;display: none;}
        .custom_service .custom_service_popup .custom_service_popup_p {margin-top: 10px;}
        .custom_service .custom_service_popup .custom_service_popup_text {text-align: left;float: left;width: 100%;padding-left: 10px;padding-top: 5px;}
        .custom_service .custom_service_popup i {background: url('/default/img/custom_service2.png') no-repeat;width: 24px;height: 13px;position: absolute;bottom: -13px;left: 50%;margin-left: -12px;}
        .custom_service .custom_service_popup .custom_service_popup_text .sc_img {float: right;margin-right: 4px;}
        .ys_banner_icon {position: absolute;left: 50%;bottom: 15px;overflow: hidden;margin-left: -80px;}
        .ys_banner_icon li {display: -moz-inline-stack;display: inline-block;}
        .ys_banner_icon span {float: left; margin: 0 5px;border-radius: 25px;background: #fff;cursor: pointer;width: 14px;height: 14px;text-indent: -9999px;}
        .ys_banner_icon span.on {border-radius: 15px;background: #75b335}

        .in_box {
            margin: 0 auto;
            overflow: hidden;
            padding-top: 1px;
            width: 1200px;
        }
        .box4 {
            margin-top: -1px;
            float: left;
            width: 1198px;

        }
        .box4 .s {
            float: left;
            width: 81px;
            height: 39px;
            font-size: 14px;
            line-height: 39px;
            text-align: right;
        }
        .box4 .list {
            overflow: hidden;
            float: left;
            width: 1082px;
            height: 39px;
        }
        .box4 .list.all{
            height: auto;
        }
        .box4 .list .list_div {
            padding: 0;
            float: left;
            width: 1082px;
        }
        .box4 .list a {
            float: left;
            margin-right: 15px;
            height: 39px;
            font-size: 14px;
            line-height: 39px;
            color: #666;
            white-space: nowrap;
        }
        .box4 .close, .box4 .open {
            float: left;
            margin: 7px 9px 0 0;
            width: 26px;
            height: 26px;
            background: url(images/footer_close.png) no-repeat 0 0px;
        }
        .box4 .open{
            background-position: 0 -51px;
        }
    </style>
@endsection
@section('js')
    <script type="text/javascript" src="{{asset('/plugs/jquery/jquery.marquee.min.js')}}" ></script>
    <script type="text/javascript" src="{{asset(themePath('/', 'web').'js/index.js')}}" ></script>
    <script type="text/javascript" src="{{asset(themePath('/', 'web').'js/jquery.soChange-min.js')}}"></script>

    <script>
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

            $('.quote_list li').hover(function(){
                $(this).find('.custom_service_popup').show();
            },function(){
                $('.custom_service_popup').hide();
            });




        })
    </script>

    <script type="text/javascript">
        $(function(){
            $('#change_2 .ys_bigimg').soChange({
                thumbObj:'#change_2 .ys_banner_icon span',
                thumbNowClass:'on',
                changeTime:3000,
            });
        });
    </script>
@endsection

@section('top_ad')
    @if(!empty($top_ad))
        <a  style="display:block;" @if(strlen(trim($top_ad['ad_link']))!=0) target="_blank" href="{{$top_ad['ad_link']}}" @else href="#" @endif>
            <div  style="background:url('{{getFileUrl($top_ad['ad_img'])}}') no-repeat center top;height:80px;"></div>
        </a>
    @else

    @endif
@endsection

@section('content')
    {{--<div style="background:url() no-repeat center top;height:80px;"></div>--}}

    <div class="play_banner">
        <div class="ys_bigimg01" id="change_2">
            @foreach($banner_ad as $item)
                <a class="ys_bigimg" target="_blank" href="{{$item['ad_link']}}" style="background: url({{getFileUrl($item['ad_img'])}}) no-repeat center top;width: 100%; height: 344px;position: absolute; "></a>
            @endforeach
            <ul class="ys_banner_icon">
                @foreach($banner_ad as $item)
                    <li><span></span></li>
                @endforeach
            </ul>
        </div>

        @if(session('_web_user_id'))
            <div class="member_center_div">
                <div class="member_center">
                    <div class="member_header">
                        <div class="header_img fl"><img src="/images/hd.png"/></div>
                        <div class="header_text">
                            <span class="ovhwp" style="display: block;" title="{{session('_web_user.nick_name')}}">{{session('_web_user.nick_name')}}</span>
                            @if(session('_web_user.is_firm'))
                                <span class="db">【企业用户】</span>
                            @else
                                <span class="db">【个人用户】</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <ul class="order-stute">
                            <a rel="nofollow" href="/order/list?tab_code=waitAffirm"><li class="tac"><span class="db red">{{$order_status['waitAffirm']}}</span><span>待确认</span></a>
                            <a rel="nofollow" href="/order/list?tab_code=waitPay"><li><span class="db red">{{$order_status['waitPay']}}</span><span>待付款</span></a>
                            <a rel="nofollow" href="/order/list?tab_code=waitConfirm"><li><span class="db red">{{$order_status['waitConfirm']}}</span><span>待收货</span></a>
                        </ul>
                    </div>
                    <input type="hidden" name="" id="demand-phone" value="{{session('_web_user')['user_name']}}">
                    <textarea class="demand-text" style="resize: none; width:220px;height: 104px;" id="demand-text" placeholder="填写您的真实需求，提交给我们"></textarea>
                    <button class="opt-btn" id="demand-btn" style="width:100%;">立即找货</button>
                </div>
            </div>
        @else
        <div class="member_center_div">
            <div class="member_center tac">
                <div class="member_header tac"><img src="/images/hd.png"/></div>
                <div class="tac">尊敬的用户，欢迎来到秣宝网!</div>
                <div class="mt5 pl10 pr10">
                    <a rel="nofollow" href="{{route('login')}}">
                        <div class="login-btn">
                            登录
                        </div>
                    </a>
                    <a rel="nofollow" href="{{route('register')}}">
                        <div class="reg-btn">
                            注册
                        </div>
                    </a>
                </div>
                <input type="text" class="contact-input" id="demand-phone" autocomplete="off" placeholder="请输入联系方式"/>
                <textarea style="resize: none; width:220px;height:60px" class="demand-text" id="demand-text" placeholder="填写您的真实需求，提交给我们"></textarea>
                <button class="opt-btn" id="demand-btn" style="width:100%;">立即找货</button>
            </div>
        </div>
        @endif
    </div>

    <div class="w1200 pr" style="z-index: 1;">
        <div class="mt10 ovh">
            <!--限时秒杀-查看更多-->
            <div class="index_xs_ms"><a rel="nofollow" href="/buyLimit" class="See_more tac ovh"><span style="color:#fff">查看更多></span></a></div>
            <!--秒杀进度-->
            <div class="fl pr" style="margin-bottom: 4px;">
                @for ($i = 0; $i < 2; $i++)
                    @php $item=$promote_list[$i]??[]; @endphp
                    @if(empty($item))
                        <div class="Time_limit_action whitebg pr  fl @if($i) ml2 @endif">
                            <div class="Time_limit_action_top mt10">
                                <div class="Time_limit_action_progress  fs16 white fl">进度 0%</div>
                                <span class="fr mr15">
                                    <font class="green">0</font>次浏览
                                </span>
                            </div>
                            <div class="mt40">
                                <div class="fs20 tac">
                                    <span>暂无活动 敬请期待</span>
                                </div>
                                {{--<div class="fs16 tac">--}}
                                    {{--<span>价格</span>--}}
                                    {{--<span class="ml15">--}}
                                        {{--<font class="fs24 orange">￥???</font>/kg--}}
                                    {{--</span>--}}
                                {{--</div>--}}
                            </div>
                            <div class="Time_limit_action_bottom graybg">
                                <div class="bottom_time">距离结束：<span class="orange count-down-text">0天0小时0分钟0秒</span></div><div class="bottom_btn redbg fs16 white cp" style="background-color: #75b335;">敬请期待</div>
                            </div>
                        </div>
                    @else
                        <div class="Time_limit_action whitebg pr ovh fl @if($i) ml2 @endif">
                            <div class="Time_limit_action_top mt10">
                                <div class="Time_limit_action_progress  fs16 white fl">进度 {{number_format(100 - $item['available_quantity']/$item['num']*100)}}%</div><span class="fr mr15"><font class="green">{{$item['click_count']}}</font>次浏览</span></div>
                            <div class="mt40">
                                <div class="fs20 tac"><span>{{$item['goods_name']}}</span><span class="ml15">{{$item['num']}}KG</span></div>
                                <div class="fs16 tac"><span>价格</span><span class="ml15"><font class="fs24 orange">{{amount_format($item['price'])}}</font>/KG</span></div>
                            </div>
                            @if($item['is_over'])
                                <div class="Time_limit_action_bottom graybg">
                                    <div class="bottom_time">距离结束：<span class="orange count-down-text">0天0小时0分钟0秒</span></div>
                                    <div class="bottom_btn redbg fs16 white cp" style="background-color: #aca9a9">已结束</div>
                                </div>
                            @elseif($item['is_soon'])
                                <div class="Time_limit_action_bottom graybg count-down" data-endtime="{{strtotime($item['begin_time'])*1000}}">
                                    <div class="bottom_time">距离开始：<span class="orange count-down-text">0天0小时0分钟0秒</span></div>
                                    <div class="bottom_btn redbg fs16 white cp">敬请期待</div>
                                </div>
                            @else
                                <div class="Time_limit_action_bottom graybg count-down" data-endtime="{{strtotime($item['end_time'])*1000}}">
                                    <div class="bottom_time">距离结束：<span class="orange count-down-text">0天0小时0分钟0秒</span></div>
                                    @if($item['available_quantity'] == 0)
                                        <a href="javascript:void(0)">
                                            <div class="bottom_btn redbg fs16 white cp" style="background-color: #ccc;">已售完</div>
                                        </a>
                                     @else
                                        <a href="/buyLimitDetails/{{encrypt($item['id'])}}">
                                            <div class="bottom_btn redbg fs16 white cp">参与秒杀</div>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                @endfor

                <div class="Time_limit_left leftPosition"><img src="/images/ass-lt-left.png"/></div>
                <div class="Time_limit_left rightPosition"><img src="/images/ass-lt-right.png"/></div>
            </div>
            <!--成交动态-->
            <div class="Tran_dynamics">
                <h1 class="ml20 mt15 fs16 fwb">成交动态</h1>
                <div class="trans_marquee">
                    <ul class="Tran_dynamics_list">
                        @if(!empty($trans_list))
                            @foreach($trans_list as $item)
                                @if($item['add_time'] <= \Carbon\Carbon::now())
                                    <li>
                                        <h1 class="ml5 mt5 ovhwp" title="{{$item['goods_name']}}">{{$item['goods_name']}}</h1>
                                        <div class="ml5 gray"><span>{{$item['goods_number']}}kg</span><span class="ml10">{{$item['add_time']}}</span></div>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <!--自营报价-->
        <div class="Self-support mt30">
            <div class="ovh"><h1 class="Self-support-title">自营报价</h1><div class="fr mr20"><span>共<font class="green">{{$goodsList['total']}}</font>条自营报价</span><a rel="nofollow" class="ml30" href="/goodsList/1">查看更多></a></div></div>
            <ul class="Self-product-list quote_list">
                <li>
                    <!-- <span>品牌</span> -->
                    <span style="width:12%;">品种</span>
                    <span style="width:15%;">厂商&nbsp;&nbsp;&nbsp;规格</span>
                    <span style="width:12%;">可售数量（KG）</span>
                    <span style="width:10%;">单价（元/KG）</span>
                    <span style="width:7%;">发货地</span>
                    <span style="width:7%;">交货方式</span>
                    <span style="width:10%;">交货时间</span>
                    <span style="width:10%;">更新时间</span>
                    <span style="width:6%;">联系方式</span>
                    <span style="width:10%;">操作</span>
                </li>
                @if(!empty($goodsList['list']))

                    @foreach($goodsList['list'] as $vo)
                        <li>
                           <!--  <span data-id="{{$vo['packing_spec']}}" id="packing_spec">{{$vo['brand_name']}}</span> -->
                            <span class="ovh" data-id="{{$vo['packing_spec']}}" id="packing_spec" style="width:12%;">{{$vo['cat_name']}}</span>
                            <span style="width:15%;"><i class="space_hidden"style="width:100%;"><a class="blue" href="/goodsDetail/{{$vo['id']}}/{{$vo['shop_id']}}">{{$vo['goods_full_name']}}</a></i></span>
                            <span style="width:12%;">{{$vo['goods_number']}}</span>
                            <span style="width:10%;color:red;">{{'￥'.number_format($vo['shop_price'], 2)}}</span>
                            <span style="width:7%;">{{$vo['delivery_place']}}</span>
                             <span style="width:7%;">{{$vo['delivery_method']}}</span>
                             <span style="width:10%;">{{$vo['delivery_time']}}</span>
                            <span style="width:10%;">{{ \Carbon\Carbon::parse($vo['add_time'])->diffForHumans()}}</span>
                            <span style="width:6%;">
                                <div class="custom_service">
                                    <p class="custom_service_p"><img src="{{asset(themePath('/','web').'img/custom_service.png')}}"></p>
                                    <div class="custom_service_popup" style="display: none;">
                                        <p class="custom_service_popup_p">联系方式</p>
                                        <div class="custom_service_popup_text">
                                            <p>
                                                <span style="width:60px;text-align: right">{{$vo['salesman']}}</span>&nbsp;&nbsp;&nbsp;&nbsp;{{$vo['contact_info']}}</p>
                                            <p class="blue" style="cursor: pointer" onclick="javascript:window.open('http://wpa.qq.com/msgrd?v=3&uin={{$vo['QQ']}}&site=qq&menu=yes');">
                                                <span style="width:60px;text-align: right">
                                                    <img class="sc_img" src="{{asset(themePath('/','web').'img/login_qq.gif')}}" />
                                                </span>
                                                &nbsp;&nbsp;&nbsp;&nbsp;{{$vo['QQ']}}
                                            </p>
                                        </div>
                                        <i></i>
                                    </div>
                                </div>
                            </span>
                            <span style="width:10%;">
                                @if(($vo['goods_number'] && $vo['expiry_time'] > \Carbon\Carbon::now()) || ($vo['goods_number'] && $vo['expiry_time'] == '0000-00-00 00:00:00') || ($vo['goods_number'] && $vo['expiry_time'] == ''))
                                    <button data-id="{{$vo['id']}}" class="P_cart_btn">加入购物车</button>
                                @elseif($vo['goods_number'] <= 0)
                                    <button class="trade-close-btn">已售完</button>
                                @elseif($vo['expiry_time'] < \Carbon\Carbon::now())
                                    <button class="trade-close-btn">已过期</button>
                                @endif
                            </span>
                        </li>
                    @endforeach
                @else
                    <li class="nodata">无相关数据</li>
                @endif
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
    @if(!empty($shops))
        <div class="w1200" style="margin-top: 30px;">
            <div class="ovh"><h1 class="Self-support-title">供应商</h1><div class="fr mr20"><a rel="nofollow" class="ml30" href="/goodsList">查看更多></a></div></div>

            <ul class="supply_list mt15">
                <li class="graybg">
                    <span>公司名称</span>
                    <span>联系人</span>
                    <span>联系电话</span>
                    <span>主营品种</span>
                    <span>更新时间</span>
                    <span>操作</span>
                </li>
                @if(!empty($shops))
                    @foreach($shops as $shop)
                    <li>
                        <div class="clearfix">
                            <span>{{$shop['company_name']}}</span>
                            <span>{{$shop['contactName']}}</span>
                            <span>{{$shop['contactPhone']}}</span>
                            <span>{{$shop['major_business']}}</span>
                            <span>1小时前</span>
                            <span class="lcolor operation">展开</span>
                        </div>
                        <div class="supply_list_inside" style="display: none;">
                            <ul class="quote_list supply_quote_list">
                                @if(isset($shop['quotes']) && !empty($shop['quotes']))
                                    @foreach($shop['quotes'] as $quote)
                                        <li>
                                            <span style="width:14%;">{{$quote['cat_name']}}</span>
                                            {{--<span>{{$quote['goods_full_name']}}</span>--}}
                                            <span style="width:20%;" class="ovh"><a class="green" href="/goodsDetail/{{$quote['id']}}/{{$quote['shop_id']}}">{{$quote['goods_full_name']}}</a></span>
                                            <span style="width:14%;">{{$quote['goods_number']}}</span>
                                            <span style="width:14%;" class="lcolor fwb">{{amount_format($quote['shop_price'],2)}}</span>
                                            <span style="width:14%;">{{$quote['delivery_place']}}</span>
                                            {{--<span><a class="Self-support-place ml-20">下单</a></span>--}}
                                            <span style="width:10%;">
                                                <div class="custom_service" style="margin-top: 0px">
                                                    <p class="custom_service_p"><img src="{{asset(themePath('/','web').'img/custom_service.png')}}"></p>
                                                    <div class="custom_service_popup" style="">
                                                        <p class="custom_service_popup_p">联系方式</p>
                                                        <div class="custom_service_popup_text">
                                                            <p>
                                                                <span style="width:60px;text-align: right;width: 60px;text-align: right;margin-top: 0;margin-bottom: 0;">{{$quote['salesman']}}</span>&nbsp;&nbsp;&nbsp;&nbsp;{{$quote['contact_info']}}
                                                            </p>
                                                            <p class="blue" style="cursor: pointer" onclick="javascript:window.open('http://wpa.qq.com/msgrd?v=3&uin={{$quote['QQ']}}&site=qq&menu=yes');">
                                                                <span style="width:60px;text-align: right;margin-top: 0;margin-bottom: 0;">
                                                                    <img class="sc_img" src="{{asset(themePath('/','web').'img/login_qq.gif')}}" />
                                                                </span>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;{{$quote['QQ']}}
                                                            </p>
                                                        </div>
                                                        <i></i>
                                                    </div>
                                                </div>
                                            </span>
                                            <span style="width:14%;">
                                                @if($quote['goods_number'])
                                                    <button data-id="{{$quote['id']}}" class="P_cart_btn" style="margin-top:-10px;">加入购物车</button>
                                                @else
                                                    <button class="trade-close-btn" style="margin-top:-10px;">已售完</button>
                                                @endif
                                            </span>

                                        </li>
                                    @endforeach
                                @else
                                    <li class="nodata">无相关数据</li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endforeach
                @else
                    <li class="nodata">无相关数据</li>
                @endif
            </ul>
        </div>
    @endif
    <!--维生素行情-->
    <style>
        .nil_bf{background:#fff;border-bottom:1px solid #ebebeb;}
        .news_items_list{float:left;overflow:hidden;line-height:46px;height:46px;}
        .news_items_list li{float:left;}
        .news_items_list li .Self-support-title{border-left:0;padding-left:0;line-height:44px;height:44px;margin:0 12px;font-size:18px;}
        .news_items_list li.curr .Self-support-title{border-bottom:2px solid #75b335;color:#75b335;cursor: pointer;}
        .nil_more{float:right;line-height:46px;height:46px;margin-right:10px;}
    </style>


<script>
    $(function(){
        $('.news_items_list li').hover(function(){
            $('.nil_more').attr('href',$(this).attr('href'));
            $(this).addClass('curr').siblings().removeClass('curr');
            $('.nil_items>li').eq($(this).index()).show().siblings().hide();
        });

    });
</script>


    @if(!empty($article_list))
        <div class="w1200" style="margin-top:30px;">
        <div class="ovh nil_bf">
                <ul class="news_items_list">
                    @foreach($article_list as $k=>$v)
                        @if($loop->first)
                            <li class="curr" href="/news/{{ $k }}/1.html" data_id = {{ $k }}><h1 class="Self-support-title">{{ $v['cat_name'] }}</h1></li>
                        @else
                            <li href="/news/{{ $k }}/1.html" data_id = {{ $k }}><h1 class="Self-support-title">{{ $v['cat_name'] }}</h1></li>
                        @endif
                    @endforeach
                </ul>
            <a rel="nofollow" class="nil_more" href="/news.html">查看更多></a>
        </div>
        <div class="whitebg ovh">
            <ul class="nil_items">
                {{--{{dd($article_list)}}--}}
                @foreach($article_list as $k=>$v)
                    <li @if(!$loop->first) style="display: none;" @endif>
                        <ul class="Quotate">

                                    @foreach($v['list'] as $k=>$vv)
                                        @if($k <= 3)
                                        <a rel="nofollow" href="detail/{{$vv['id']}}.html">
                                            <li>
                                                <div class="Quotate-img" >
                                                    <img width="100%" src="{{getFileUrl($vv['image'])}}" />
                                                </div>
                                                <div class="Quotate_text">{{$vv['title']}}</div>
                                            </li>
                                        </a>
                                        @endif
                                    @endforeach
                        </ul>

                        <ul class="Quotate_right">
                            @foreach($v['list'] as $item)
                                <a href="detail/{{$item['id']}}.html">
                                    <li>
                                        <span class="fl ml5">{{$item['title']}}</span>
                                        <span class="fr">({{ \Carbon\Carbon::parse($item['add_time'])->format('m/d') }})</span>
                                    </li>
                                </a>

                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>
    @endif

    <!--合作品牌-->
    @if(!empty($brand_list))
        <div class="w1200" style="margin:30px auto">
            <div class="ovh">
                <h1 class="Self-support-title">合作品牌</h1>
            </div>
            <ul class="Cooperative_brand">
                @foreach($brand_list as $item)
                    <li @if(($loop->iteration % 6) > 0) class="bb1 bbright" @endif>
                        <div><img src="{{getFileUrl($item['brand_logo'])}}"/></div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif



@endsection
@section('friend_link')
 @if(!empty($friend_link))
     <div style="background-color: #f7f7f7">
         <div class="in_box" style=" ">
             <div class="box4">
                 <span class="s">友情链接：</span>
                 <div class="list">
                     <div class="list_div">
                         @foreach($friend_link as $v)
                             <a href="javascript:void(0);" onclick="window.location.href='{{isIncludeHttp($v['link_url'])}}'" target="_blank" title="{{$v['link_name']}}">{{$v['link_name']}}</a>
                         @endforeach
                     </div>
                 </div>
                 <a href="javascript:;" class="close"></a>
             </div>
         </div>
     </div>

@endif
<script>
    $(function () {
        $(document).on("click",".box4 .close",function(){
            $(this).prev(".list").addClass("all");
            $(this).addClass("open").removeClass("close");
        });
        $(document).on("click",".box4 .open",function(){
            $(this).prev(".list").removeClass("all");
            $(this).addClass("close").removeClass("open");
        });
    })


</script>
@endsection
@section('bottom_js')
    <script>
        //加入购物车
        $(".P_cart_btn").click(function(){
            var userId = "{{session('_web_user_id')}}";
            if(userId==""){
                layer.confirm('请先登录再进行操作。', {
                    btn: ['去登陆','再看看'] //按钮
                }, function(){
                    window.location.href='/login';
                }, function(){

                });
                return false;
            }
            var id = $(this).attr("data-id");
//            var number = $("#packing_spec").attr('data-id');
            var number = $(this).parent().siblings().attr('data-id');
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
    </script>

@endsection

