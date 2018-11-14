<!doctype html>
<html lang="en">
<head>
    <title>收银台</title>
    @include(themePath('.','web').'web.include.partials.base')

    <script type="text/javascript">
        $(function(){
               
                 //隐藏关闭框
                $('.cancel,.frame_close').click(function(){

                     $('#power_edit_frame,.block_bg').remove();
                     window.location.reload();
                })

                $('.accounting_payment').click(function(){
                    $('#power_edit_frame').show();
                    $('.block_bg').show();
                })
        })
    </script>
    <style type="text/css">
        .block_bg{display:none;height: 100%;left: 0;position: fixed; top: 0;width: 100%;background: #000;opacity: 0.8;z-index:2;}
        .power_edit{display:none;z-index: 2;width:520px;  left:50%; top:50%;margin-top:-275px;position:fixed;margin-left:-250px;}
        .whitebg{background: #FFFFFF;}
        .pay_title{height: 50px;line-height: 50px;}
        .f4bg{background-color: #f4f4f4;}
        .pl30{padding-left:30px;}
        .gray,a.gray,a.gray:hover{color:#aaa;}
        .fs16{font-size:16px;}
        .fr{float:right;}
        .frame_close{width: 15px;height: 15px;line-height:0;
     display: block;outline: medium none;
     transition: All 0.6s ease-in-out;
     -webkit-transition: All 0.6s ease-in-out;
     -moz-transition: All 0.6s ease-in-out;
     -o-transition: All 0.6s ease-in-out;}
      .whitebg{background: #FFFFFF;}
    </style>
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
                    <div class="p-mode-item accounting_payment"></div>
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

 <div class="block_bg"></div>
    <!--编辑框-->
    <div class="power_edit whitebg" id="power_edit_frame">
        <div class="pay_title f4bg"><span class="fl pl30 gray fs16">新增/编辑</span><a class="fr frame_close mr15 mt15"><img src="img/close.png" width="15" height="15"></a></div>
        <ul class="power_list ml30 mt25">
            <li>
                <div class="ovh mt10"><span>手机号码:</span><input type="text" class="pay_text fl" id="firmUserPhone" placeholder="请输入员工手机号码"/></div>
                <div class="ml">注：职员必须先用手机号在平台注册个人账号并实名认证</div>
            </li>
            <li><div class="ovh mt10"><span>职员姓名:</span><input type="text" class="pay_text fl" id="firmUserName" placeholder="请输入员工姓名"/></div></li>
            <li>
                <div class="power_cate mt10 br1 ovh">
                <ul class="power_cate_check_box ovh">
              
                </ul>
                </div>
            </li>
            <li><div class="til_btn fl tac  code_greenbg" style="margin-left: 80px;" onclick="addFirmUserSave()">保 存</div><div class="til_btn tac  blackgraybg fl cancel" style="margin-left: 45px;">取消</div></li>
        </ul>
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
