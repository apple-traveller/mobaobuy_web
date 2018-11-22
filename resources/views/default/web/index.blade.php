@extends(themePath('.','web').'web.include.layouts.home')
@section('title', '首页')
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
    </style>
@endsection
@section('js')
    <script src="{{asset('/plugs/jquery/jquery.marquee.min.js')}}" ></script>
    <script src="{{asset(themePath('/', 'web').'js/index.js')}}" ></script>

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
        <div class="banner-imgs-div">
            @foreach($banner_ad as $item)
                <a class="banner-item" target="_blank" href="{{$item['ad_link']}}" style="background: url({{getFileUrl($item['ad_img'])}}) no-repeat center top;width: 100%; height: 344px;position: absolute; "></a>
            @endforeach
        </div>

        @if(session('_web_user_id'))
            <div class="member_center_div">
                <div class="member_center">
                    <div class="member_header">
                        <div class="header_img fl"><img src="/images/hd.png"/></div>
                        <div class="header_text">
                            <span>{{session('_web_user.nick_name')}}</span>
                            @if(session('_web_user.is_firm'))
                                <span class="db">【企业用户】</span>
                            @else
                                <span class="db">【个人用户】</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <ul class="order-stute">
                            <a href="/order/list?tab_code=waitAffirm"><li class="tac"><span class="db red">{{$order_status['waitAffirm']}}</span><span>待确认</span></a>
                            <a href="/order/list?tab_code=waitPay"><li><span class="db red">{{$order_status['waitPay']}}</span><span>待付款</span></a>
                            <a href="/order/list?tab_code=waitConfirm"><li><span class="db red">{{$order_status['waitConfirm']}}</span><span>待收货</span></a>
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
                    <div class="login-btn"><a href="{{route('login')}}">登录</a></div><div class="reg-btn"><a href="{{route('register')}}">注册</a></div>
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
            <div class="index_xs_ms"><a href="/buyLimit" class="See_more tac ovh"><span style="color:#fff">查看更多></span></a></div>
            <!--秒杀进度-->
            <div class="fl pr" style="margin-bottom: 4px;">
                @for ($i = 0; $i < 2; $i++)
                    @php $item=$promote_list[$i]??[]; @endphp
                    @if(empty($item))
                        <div class="Time_limit_action whitebg pr  fl @if($i) ml2 @endif">
                            <div class="Time_limit_action_top mt10">
                                <div class="Time_limit_action_progress  fs16 white fl">进度 0%</div><span class="fr mr15"><font class="green">0</font>次浏览</span></div>
                            <div class="mt40">
                                <div class="fs20 tac"><span>暂无活动 敬请期待</span></div>
                                <div class="fs16 tac"><span>价格</span><span class="ml15"><font class="fs24 orange">￥???</font>/kg</span></div>
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
                                <div class="fs20 tac"><span>{{$item['goods_name']}}</span><span class="ml15">{{$item['num']}}kg</span></div>
                                <div class="fs16 tac"><span>价格</span><span class="ml15"><font class="fs24 orange">{{amount_format($item['price'])}}</font>/kg</span></div>
                            </div>
                            @if($item['is_over'])
                                <div class="Time_limit_action_bottom graybg">
                                    <div class="bottom_time">距离结束：<span class="orange count-down-text">0天0小时0分钟0秒</span></div>
                                    <div class="bottom_btn redbg fs16 white cp" style="background-color: #aca9a9">已结束</div>
                                </div>
                            @elseif($item['is_soon'])
                                <div class="Time_limit_action_bottom graybg count-down" data-endtime="{{$item['begin_time']}}">
                                    <div class="bottom_time">距离开始：<span class="orange count-down-text">0天0小时0分钟0秒</span></div>
                                    <div class="bottom_btn redbg fs16 white cp">敬请期待</div>
                                </div>
                            @else
                                <div class="Time_limit_action_bottom graybg count-down" data-endtime="{{$item['end_time']}}">
                                    <div class="bottom_time">距离结束：<span class="orange count-down-text">0天0小时0分钟0秒</span></div>
                                    <a href="/buyLimitDetails/{{encrypt($item['id'])}}">
                                        <div class="bottom_btn redbg fs16 white cp">参与秒杀</div>
                                    </a>
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
                                <li>
                                    <h1 class="ml5 mt5">{{$item['goods_name']}}</h1>
                                    <div class="ml5 gray"><span>{{$item['goods_number']}}kg</span><span class="ml10">{{$item['add_time']}}</span></div>
                                </li>
                            @endforeach
                        @endif
                        @if(!empty($trans_false_list))
                            @foreach($trans_false_list as $item)
                                @if($item['add_time'] <= \Carbon\Carbon::now())
                                    <li>
                                        <h1 class="ml5 mt5">{{$item['goods_name']}}</h1>
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
            <div class="ovh"><h1 class="Self-support-title">自营报价</h1><div class="fr mr20"><span>共<font class="green">{{$goodsList['total']}}</font>条自营报价</span><a class="ml30" href="/goodsList">查看更多></a></div></div>
            <ul class="Self-product-list quote_list">
                <li>
                    <!-- <span>品牌</span> -->
                    <span style="width:12%;">种类</span>
                    <span style="width:18%;">商品名称</span>
                    <span style="width:12%;">剩余数量（kg）</span>
                    <span style="width:12%;">单价（元/kg）</span>
                    <span style="width:12%;">发货地</span>
                    <span style="width:12%;">更新时间</span>
                    <span style="width:6%;">联系方式</span>
                    <span style="width:12%;">操作</span>
                </li>
                @foreach($goodsList['list'] as $vo)
                    <li>
                       <!--  <span data-id="{{$vo['packing_spec']}}" id="packing_spec">{{$vo['brand_name']}}</span> -->
                        <span class="ovh" data-id="{{$vo['packing_spec']}}" id="packing_spec" style="width:12%;">{{$vo['cat_name']}}</span>
                        <span style="width:18%;"><a class="green" href="/goodsDetail?id={{$vo['id']}}&shop_id={{$vo['shop_id']}}">{{$vo['goods_full_name']}}</a></span>
                        <span style="width:12%;">{{$vo['goods_number']}}</span>
                        <span style="width:12%;">{{'￥'.number_format($vo['shop_price'], 2)}}</span>
                        <span style="width:12%;">{{$vo['delivery_place']}}</span>
                        <span style="width:12%;">{{ \Carbon\Carbon::parse($vo['add_time'])->diffForHumans()}}</span>
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
                        <span style="width:12%;">
                            @if($vo['goods_number'])
                                <button data-id="{{$vo['id']}}" class="P_cart_btn">加入购物车</button>
                            @else
                                <button class="trade-close-btn">已售完</button>
                            @endif
                        </span>
                    </li>
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
        <div class="ovh"><h1 class="Self-support-title">供应商</h1><div class="fr mr20"><a class="ml30" href="/goodsList">查看更多></a></div></div>

        <ul class="supply_list mt15">
            <li class="graybg">
                <span>公司名称</span><span>联系人</span><span>联系电话</span><span>主营品种</span><span>操作</span>
            </li>
            @foreach($shops as $shop)
            <li>
                <div class="clearfix"><span>{{$shop['company_name']}}</span><span>{{$shop['contactName']}}</span><span>{{$shop['contactPhone']}}</span><span>{{$shop['major_business']}}</span><span class="lcolor operation">展开</span></div>
                <div class="supply_list_inside" style="display: none;">
                    <ul class="quote_list supply_quote_list">
                        @foreach($shop['quotes'] as $quote)
                            <li>
                                <span style="width:14%;">{{$quote['cat_name']}}</span>
                                {{--<span>{{$quote['goods_full_name']}}</span>--}}
                                <span style="width:20%;" class="ovh"><a class="green" href="/goodsDetail?id={{$quote['id']}}&shop_id={{$quote['shop_id']}}">{{$quote['goods_full_name']}}</a></span>
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
                    </ul>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    <!--维生素行情-->
    <div class="w1200" style="margin-top: 30px;">
        <div class="ovh"><h1 class="Self-support-title">维生素行情</h1><div class="fr mr20"><a class="ml30" href="/news.html">查看更多></a></div></div>
        <div class="whitebg ovh mt10">

            <ul class="Quotate">
                @for ($i = 0; $i < 4; $i++)
                    @php $article = $article_list[$i]??[]; @endphp
                    @if(!empty($article))
                    <li><a href="detail.html?id={{$article['id']}}">
                        <div class="Quotate-img"><img src="{{getFileUrl($article['image'])}}" /></div>
                        <div class="Quotate_text">{{$article['title']}}</div>
                        </a>
                    </li>
                    @endif
                @endfor
            </ul>

            <ul class="Quotate_right">
                @foreach($article_list as $item)
                <li><a href="detail.html?id={{$item['id']}}"><span class="fl ml5">{{$item['title']}}</span><span class="fr">({{ \Carbon\Carbon::parse($item['add_time'])->format('m/d') }})</span></a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <!--合作品牌-->
    <div class="w1200" style="margin:30px auto">
        <div class="ovh"><h1 class="Self-support-title">合作品牌</h1></div>

        <ul class="Cooperative_brand">
            @foreach($brand_list as $item)
            <li @if(($loop->iteration % 6) > 0) class="bb1 bbright" @endif><div><img src="{{getFileUrl($item['brand_logo'])}}"/></div></li>
            @endforeach
        </ul>
    </div>
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
    </script>
@endsection