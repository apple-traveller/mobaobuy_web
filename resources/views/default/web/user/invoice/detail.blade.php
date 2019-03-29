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

            //获取物流信息
            getLogisticsInfo();
        })
        //
        function getLogisticsInfo(){
            var _id = $('.order_pro_stute').attr('data-id');
            if(_id != 0){
                $.ajax({
                    url: "/logistics/detail",
                    dataType: "json",
                    data:{
                        'id': _id,
                        'search_type':'invoice'
                    },
                    type:"get",
                    success:function(data){
                        if(data.code === 1){
                            var _list = data.data.Traces;
                            var _length = data.data.Traces.length;
                            var _html = '';
                            for(var i=(_length-1); i>=0; i--){
                                _html += '<li><i class="external-cir"></i>'+_list[i].AcceptStation+'<div class="gray">'+_list[i].AcceptTime+'</div></li>';
                            }
                            if(_html === ''){
                                _html = '<li><i class="external-cir"></i>{{trans('home.no_logistics_info_tips')}}<div class="gray"></div></li>'
                            }
                            $('.wlxx').append(_html);
                        }else{
                            getInstationLogisticsInfo();
//                            $('.wlxx').append('<li><i class="external-cir"></i>暂时无法获取到该订单物流跟踪信息，请于商家联系。<div class="gray"></div></li>');
                        }
                    },
                    error:function(){
                        $('.wlxx').append('<li><i class="external-cir"></i>{{trans('home.no_logistics_info_tips')}}<div class="gray"></div></li>');
                    }
                })
            }else{
                $('.wlxx').append('<li><i class="external-cir"></i>{{trans('home.not_shipped_tips')}}<div class="gray"></div></li>');
            }

        }

        function getInstationLogisticsInfo(){
            var _delivery_id = $('.order_pro_stute').attr('data-id');
            if(_delivery_id != 0){
                $.ajax({
                    url: "/logistics/instation",
                    dataType: "json",
                    data:{
                        'id': _delivery_id,
                        'search_type':'invoice'
                    },
                    type:"get",
                    success:function(data){
                        if(data.code == 1){
                            var _list = data.data;
                            var _length = data.data.length;
                            var _html = '';

                            for(var i=0; i<_length; i++){
                                _html += '<li><i class="external-cir"></i>'+_list[i].shipping_content+'<div class="gray">'+_list[i].add_time+'</div></li>';
                            }
                            if(_html == ''){
                                _html = '<li><i class="external-cir"></i>{{trans('home.no_logistics_info_tips')}}<div class="gray"></div></li>'
                            }
                            $('.wlxx').append(_html);
                        }else{
                            //物流单第三方查询失败 查询站内维护物流信息
                            var _html = '<li><i class="external-cir"></i>{{trans('home.no_logistics_info_tips')}}<div class="gray"></div></li>';
                            $('.wlxx').append(_html);
                            // $.msg.alert(data.msg);
                        }
                    },
                    error:function(){
                        var _html = '<li><i class="external-cir"></i>{{trans('home.no_logistics_info_tips')}}<div class="gray"></div></li>';
                        $('.wlxx').append(_html);
                    }
                })
            }else{
                var _html = '<li><i class="external-cir"></i>{{trans('home.not_shipped_tips')}}<div class="gray"></div></li>';
                $('.wlxx').append(_html);
            }

        }
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
            <div class="logo fl"></div><div class="w_name fs24 gray fl mt20 ml20">{{trans('home.member_center')}}</div>
        </div>
    </div>
</div>
<div class=" clearfix mt5">
    <div class="w1200">
        <div class="crumbs">{{trans('home.curr')}}：<a href="/member">{{trans('home.member_center')}}</a> &gt; <a href="/invoice/myInvoice">{{trans('home.my_invoice')}}</a> &gt;<span class="gray">{{trans('home.invoice_details')}}</span></div>
        <div class="order_pro_progress whitebg mt5">
            <div class="order_pro_">
                <span class="invoice_number">{{trans('home.invoice_number')}}：{{$invoiceInfo['invoice_numbers']}}</span>
                @if($invoiceInfo['status'] == 0)
                    <span class="tac db fs24 fwb red mt15">{{trans('home.cancelled')}}</span>
                @elseif($invoiceInfo['status'] == 1)
                    <span class="tac db fs24 fwb red mt15">{{trans('home.wait_open_ticket')}}</span>
                @elseif($invoiceInfo['status'] == 2)
                    <span class="tac db fs24 fwb red mt15">{{trans('home.invoiced')}}</span>
                @endif
            </div>
        </div>
        <!--物流信息-->
        <div class="whitebg br1 mt20 ovh">
            @if(!empty($invoiceInfo))
                <div class="order_pro_stute" @if(!empty($invoiceInfo['id'])) data-id="{{$invoiceInfo['id']}}" @else data-id="0" @endif>
                    <span class="ml30 db mt20">{{trans('home.logistics_company')}}：@if(!empty($invoiceInfo['shipping_name'])) {{ $invoiceInfo['shipping_name'] }} @else {{trans('home.no_logistics_company')}} @endif </span>
                    <span class="ml30 db mt20">{{trans('home.logistics_number')}}：@if(!empty($invoiceInfo['shipping_billno'])) {{ $invoiceInfo['shipping_billno'] }} @else {{trans('home.no_logistics_number')}} @endif </span>
                </div>
            @else
                <div class="order_pro_stute" data-id="0">
                    <span class="ml30 db mt20">{{trans('home.wait_shop_open_invoice')}}</span>
                </div>
            @endif
            <div class="fl wlgz_text">
                <ul class="wlxx">

                </ul>
            </div>
        </div>
        <!--收货人信息/商家信息/发票信息-->
        <div class="whitebg br1 mt20 ovh">
            <!--收货人信息-->
            <div class="consignee bbright">
                <h1>{{trans('home.receiver_info')}}</h1>
                <span class="ml20 db mt20"><span class="fl">{{trans('home.receiver')}}:</span> <span class="ml20">{{$invoiceInfo['consignee']}}</span></span>
                <span class="ml20 ovh db mt5"><span class="fl">{{trans('home.ticket_collection_address')}}:</span><span class="fl consignee_addr">{{$invoiceInfo['address_str']}}</span></span>
                <span class="ml20 db mt20"><span class="fl">{{trans('home.mobile')}}: </span><span class="ml10">{{$invoiceInfo['mobile_phone']}}</span></span>
            </div>
            <!--商家信息-->
            <div class="consignee bbright">
                <h1>{{trans('home.business_info')}}</h1>
                <span class="ml20 db mt20" style="margin-right: 266px;"><span class="fl">{{trans('home.company')}} :</span> <span class="ml10">{{$invoiceInfo['shop_name']}}</span></span>
                <span class="ml20 db "><span class="fl">{{trans('home.contact_way')}} :</span> <span class="ml10">{{ $invoiceInfo['member_phone'] }}</span></span>
            </div>
            <!--发票信息-->
            <div class="consignee ">
                <h1>{{trans('home.invoice_info')}}</h1>
                <span class="ml20 db mt20" >
                    <span class="fl">{{trans('home.invoice_type')}}：</span>
                    <span class="ml10">
                        @if($invoiceInfo['invoice_type'] == 1)
                            {{trans('home.general_invoice')}}
                        @elseif($invoiceInfo['invoice_type']==2)
                            {{trans('home.special_invoice')}}
                        @endif
                    </span>
                </span>
            </div>
        </div>
        <!--订单列表-->
        <div class="whitebg br1 mt20 ovh">
            <ul class="order-list-brand">
                <li>
                    <span>{{trans('home.order_number')}}</span>
                    <span>{{trans('home.goods_name')}}</span>
                    <span>{{trans('home.price')}}</span>
                    <span>{{trans('home.num')}}</span>
                </li>
                @foreach($invoiceGoods as $v)
                    <li>
                        <span>{{$v['order_sn']}}</span>
                        <span class="ovhwp" style="height: 40px;">{{$v['goods_name']}}</span>
                        <span>￥{{$v['goods_price']}} </span>
                        <span>{{$v['invoice_num']}}KG</span>
                    </li>
                @endforeach
            </ul>
            <div class="Amount_money">
                <div class="db"><span>{{trans('home.total_invoice')}}：</span><span class="fr ml20">￥{{ $invoiceInfo['invoice_amount'] }}</span></div>
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


