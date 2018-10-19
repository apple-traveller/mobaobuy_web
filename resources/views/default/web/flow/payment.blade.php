<!doctype html>
<html lang="en">
<head>
    <title>收银台</title>
    @include(themePath('.','web').'web.include.partials.base')
</head>
<body style="background-color: rgb(244, 244, 244);">
@include(themePath('.','web').'web.include.partials.top')
@component(themePath('.','web').'web.include.partials.top_title', ['title_name' => '收银台'])@endcomponent

<div class="clearfix mt25">
    <div class="w1200 whitebg">
        <div class="payment-order-box">
            订单号： {{$order_info['order_sn']}}
            寄送至：{{$order_info['region']}} 收货人：{{$order_info['consignee']}} {{$order_info['mobile_phone']}}
        </div>
    </div>
</div>

<div class="clearfix mt25 mb20">
    <div class="w1200 whitebg">
        <div class="payment-box">
            <div class="payment-list">
                <div class="p-mode-tit"><h3>线下支付</h3></div>
                <div class="p-mode-list">
                    <div class="p-mode-item alipay"></div>
                    <div class="p-mode-item wxpay"></div>
                </div>
            </div>
            <div class="payment-list mt20">
                <div class="p-mode-tit"><h3>在线支付</h3></div>
                <div class="p-mode-list">
                    <div class="p-mode-item alipay"><input type="button" onclick="window.open('{{url('/payment/orderPay?order_id='.$order_info['id'].'&pay_type=alipay')}}')" /></div>
                    <div class="p-mode-item wxpay"><input type="button" onclick="window.open('{{url('/payment/orderPay?order_id='.$order_info['id'].'&pay_type=wxpay')}}')"/></div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .payment-order-box{padding: 30px;}

    .payment-box{padding: 30px;}
    .payment-box .p-mode-tit {padding-bottom: 15px;border-bottom: 1px solid #d2d2d2;}
    .payment-box .p-mode-tit h3{font-size: 18px;height: 18px;line-height: 18px;padding-left: 10px;border-left: 4px solid #f42424;}
    .payment-box .p-mode-list {margin-top: 20px;width: calc(100% + 12px);overflow: hidden;}
    .payment-box .p-mode-item {float: left;width: 178px;height: 88px;border: 1px solid #d2d2d2;text-align: center;position: relative;margin: 0 12px 12px 0;text-align:center}
    .payment-box .p-mode-item input[type="button"]{border: 0;width: 178px;height: 88px;display: block;font-size: 0;outline: 0;cursor: pointer;}
    .p-mode-list .alipay input[type="button"] {background: url({{asset(themePath('/','web').'/img/alipay-icon.png')}}) center center no-repeat;}
    .p-mode-list .wxpay input[type="button"] {background: url({{asset(themePath('/','web').'/img/wxpay-icon.png')}}) center center no-repeat;}
</style>

@include(themePath('.','web').'web.include.partials.footer_service')
@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')
@yield('js')
</body>
</html>
