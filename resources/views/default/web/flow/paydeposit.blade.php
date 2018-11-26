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

        //提交
        function payVoucherSave(){
            //付款凭证
             var orderSn = $('input[type=hidden]').val();
             var payVoucher = $('input[name=pay_voucher]').val();
             $.ajax({
                url:'/payVoucherSave',
                data:{'orderSn':orderSn,'payVoucher':payVoucher},
                type:'POST',
                dataType:'json',
                success:function(res){
                    if(res.code){
                        $.msg.alert('上传成功');
                        window.location.reload();
                    }else{
                        $.msg.alert(res.msg);
                    }
                }
             })
        }
    </script>
    <style type="text/css">
        .block_bg{display:none;height: 100%;left: 0;position: fixed; top: 0;width: 100%;background: #000;opacity: 0.8;z-index:2;}
        .power_edit{display:none;z-index: 2;width:520px;  left:50%; top:50%;margin-top:-175px;position:fixed;margin-left:-250px;height: 30%;}
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
        .box-info{
            margin: 0px 10px;
            float: left;
        }
    </style>
</head>

<body style="background-color: rgb(244, 244, 244);">
@include(themePath('.','web').'web.include.partials.top')
@component(themePath('.','web').'web.include.partials.top_title', ['title_name' => '收银台'])@endcomponent

<div class="clearfix mt25">
    <div class="w1200 whitebg">
        <div class="payment-order-box">
            <div class="box-info">
                订单号：{{$order_info['order_sn']}}
            </div>
            <div class="box-info">
                寄送至：{{$order_info['region']}}
            </div>
            <div class="box-info">
                收货人：{{$order_info['consignee']}} {{$order_info['mobile_phone']}}
            </div>
            <div class="box-info">
                支付订金：{{$order_info['deposit']}}元
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="" value="{{encrypt($order_info['order_sn'])}}">

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
                    <div class="p-mode-item alipay"><input type="button" onclick="window.open('{{url('/payment/orderPay?order_id='.$order_info['id'].'&pay_type=alipay_deposit')}}')" /></div>
                    <div class="p-mode-item wxpay"><input type="button" onclick="window.open('{{url('/payment/orderPay?order_id='.$order_info['id'].'&pay_type=wxpay_deposit')}}')"/></div>
                </div>
            </div>
        </div>
    </div>
</div>

 <div class="block_bg"></div>
    <!--编辑框-->
    <div class="power_edit whitebg" id="power_edit_frame" style="">
        <div class="pay_title f4bg"><span class="fl pl30 gray fs16">支付信息</span><a class="fr frame_close mr15 mt15"><img src="img/close.png" width="15" height="15"></a></div>
        <ul class="power_list ml30 mt25">
            <li>
                <div class="ovh mt10"><span>商家信息:</span>{{$sellerInfo['real_name']}}</div>
                <div class="ovh mt10"><span>开户银行:</span>{{$sellerInfo['bank_of_deposit']}}</div>
                <div class="ovh mt10"><span>银行账户:</span>{{$sellerInfo['bank_account']}}</div>
                <div class="ovh mt10"><span>上传付款凭证:</span></div>
                
            </li>
            @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/payVoucher','name'=>'pay_voucher'])@endcomponent
            <li style="clear:both;margin-top:30px;"><div style="margin-top:20px; margin-left: 80px;cursor: pointer;" class="til_btn fl tac  code_greenbg" onclick="payVoucherSave()">提 交</div><div class="til_btn tac  blackgraybg fl cancel" style="margin-left: 45px;margin-top: 20px;cursor: pointer;">取消</div></li>
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
