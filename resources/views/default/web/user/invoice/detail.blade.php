<!doctype html>
<html lang="en">
<head>
    <title>开票 - 详情@yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    @yield('css')
    <link rel="stylesheet" href="/default/css/global.css" />
    <link rel="stylesheet" href="/default/css/index.css" />
    <script type="text/javascript">
        $(function(){
            $('.acount_tab').hover(function(){
                $('.acount_tab').addClass('whitebg');
                $('.acount_select').show();
            },function(){
                $('.acount_tab').removeClass('whitebg');
                $('.acount_select').hide()
            })
        })
    </script>
    <style>
        /*订单状态*/
        .order_pro_progress{border: 1px solid #DEDEDE;overflow: hidden;border-top: 2px solid #75b335;}
        .order_pro_stute{float:left;margin-top:30px;margin-bottom:20px;width:285px;height: 188px;overflow: hidden;border-right: 1px solid #DEDEDE;}
        .invoice_number{display: block;margin-left: 65px;margin-right: 55px;margin-top: 10px;float: left;margin-bottom: 15px;}
        .order_jd_text li:first-child{margin-left: 0px;}
        /*物流信息*/
        .wlgz_text{overflow-y: auto;width:912px;height: 178px;margin-top: 35px;}
        .wlxx{margin-left: 30px;}
        .wlxx li{position: relative; border-left: 1px solid #DEDEDE;padding-left: 20px;padding-bottom: 10px;color: #666;}
        .external-cir{position:absolute;top:0px;left:-7px;border-radius:25px;display:inline-block;width: 8px;height: 8px;border: 3px solid #f3a7a9;background-color: #e5383c;}
        /*收货人信息*/
        .consignee{color:#333;float:left;margin:24px 0;height: 188px;}
        .consignee h1{margin-top: 15px;margin-left: 20px;}
        .consignee_addr{margin-left:10px;width: 200px;margin-right: 100px;}
        /*订单列表*/
        .order-list-brand li:first-child{background-color: #f4f4f4;height: 32px;line-height: 32px;border-bottom: none;}
        .order-list-brand li{height: 65px; line-height: 65px;border-bottom: 1px solid #DEDEDE;}
        .order-list-brand li span{width: 20%;display: inline-block;text-align: center;}
        /*商品总额*/
        .Amount_money{float: right;margin-right: 75px;margin-top: 30px;margin-bottom: 30px;}
    </style>
</head>
<body style="background-color: rgb(244, 244, 244);">
@include(themePath('.','web').'web.include.partials.top')
<div class="clearfix whitebg">
    <div class="w1200 ovh">
        <div class="mb30 mt10 ovh">
            <div class="logo fl"></div><div class="w_name fs24 gray fl mt20 ml20">会员中心</div>
        </div>
    </div>
</div>
<div class=" clearfix mt5">
    <div class="w1200">
        <div class="crumbs">当前位置：<a href="/member">会员中心</a> &gt; <a href="/invoice/myInvoice">我的开票</a> &gt;<span class="gray">订单详情</span></div>
        <div class="order_pro_progress whitebg mt5">
            <div class="order_pro_">
                <span class="invoice_number">开票流水号：{{$invoiceInfo['invoice_numbers']}}</span>
                @if($invoiceInfo['status'] == 0)
                    <span class="tac db fs24 fwb red mt15">已取消</span>
                @elseif($invoiceInfo['status'] == 1)
                    <span class="tac db fs24 fwb red mt15">待开票</span>
                @elseif($invoiceInfo['status'] == 2)
                    <span class="tac db fs24 fwb red mt15">已开票</span>
                @endif
            </div>
        </div>
        <!--物流信息-->
        <div class="whitebg br1 mt20 ovh">
            <div class="order_pro_stute">
                <span class="ml30 db mt20">物流单号：@if(!empty($invoiceInfo['shipping_billno'])) {{ $invoiceInfo['shipping_billno'] }} @else 暂无运单号 @endif </span>
            </div>
            <div class="fl wlgz_text">
                <ul class="wlxx">
                    <li>
                        <i class="external-cir"></i>
                        您提交了订单，请等待系统确认
                        <div class="gray">2018-09-22   12:00:00</div>
                    </li>
                    <li>
                        <i class="external-cir"></i>
                        您提交了订单，请等待系统确认
                        <div class="gray">2018-09-22   12:00:00</div>
                    </li>
                    <li>
                        <i class="external-cir"></i>
                        您提交了订单，请等待系统确认
                        <div class="gray">2018-09-22   12:00:00</div>
                    </li>
                    <li>
                        <i class="external-cir"></i>
                        您提交了订单，请等待系统确认
                        <div class="gray">2018-09-22   12:00:00</div>
                    </li>
                    <li>
                        <i class="external-cir"></i>
                        您提交了订单，请等待系统确认
                        <div class="gray">2018-09-22   12:00:00</div>
                    </li>
                </ul>
            </div>
        </div>
        <!--收货人信息/商家信息/发票信息-->
        <div class="whitebg br1 mt20 ovh">
            <!--收货人信息-->
            <div class="consignee bbright">
                <h1>收票人信息</h1>
                <span class="ml20 db mt20"><span class="fl">收  货  人:</span> <span class="ml20">{{$invoiceInfo['consignee']}}</span></span>
                <span class="ml20 ovh db mt5"><span class="fl">收货地址:</span><span class="fl consignee_addr">{{$invoiceInfo['address']}}</span></span>
                <span class="ml20 db mt20"><span class="fl">手机号码: </span><span class="ml10">{{$invoiceInfo['mobile_phone']}}</span></span>
            </div>
            <!--商家信息-->
            <div class="consignee bbright">
                <h1>商家信息</h1>
                <span class="ml20 db mt20" style="margin-right: 266px;"><span class="fl">公司名称 :</span> <span class="ml10">{{$invoiceInfo['shop_name']}}</span></span>
                <span class="ml20 db "><span class="fl">联系方式 :</span> <span class="ml10">{{ $invoiceInfo['member_phone'] }}</span></span>
            </div>
            <!--发票信息-->
            <div class="consignee ">
                <h1>发票信息</h1>
                <span class="ml20 db mt20" ><span class="fl">发票类型：</span> <span class="ml10">@if($invoiceInfo['invoice_type'] == 1)普通发票 @elseif($invoiceInfo['invoice_type']==2) 专用增值发票 @endif</span></span>
            </div>
        </div>
        <!--订单列表-->
        <div class="whitebg br1 mt20 ovh">
            <ul class="order-list-brand">
                <li><span>订单流水号</span><span>商品名称</span><span>单价</span><span>数量</span></li>
                @foreach($invoiceGoods as $v)
                    <li><span>{{$v['order_sn']}}</span><span>{{$v['goods_name']}}</span><span>￥{{$v['goods_price']}} </span><span>{{$v['invoice_num']}}kg</span><span></span><span></span></li>
                @endforeach
            </ul>
            <div class="Amount_money">
                <div class="db"><span>开票总额：</span><span class="fr ml20">￥{{ $invoiceInfo['invoice_amount'] }}</span></div>
            </div>
        </div>
    </div>
</div>
    <div class="clearfix" style="height: 28px;"></div>
@include(themePath('.','web').'web.include.partials.footer_service')
@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')
@yield('js')
</body>
</html>


