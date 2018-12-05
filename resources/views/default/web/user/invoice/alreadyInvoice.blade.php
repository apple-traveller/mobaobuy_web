<!doctype html>
<html lang="en">
<head>
    <title>购物车 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    @yield('css')
    <style type="text/css">
        .logo {
            width: 170px;
            height: 55px;
            margin-top: 20px;
            float: left;
            background: url(../img/mobao_logo.png)no-repeat;
            background-size: 100% 100%;
        }
        .company_list li {
            float: left;
            width: 505px;
            margin-top: 15px;
        }
        .Collect_goods_address li:hover {
            border: 1px solid #75b335;
        }
        .Collect_goods_address li {
            float: left;
            margin-left: 20px;
            margin-top: 20px;
            width: 270px;
            height: 124px;
            border: 1px solid #D9D9D9;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
        }
        .supply_list li:first-child {
            background-color: #EEEEEE;
            border-bottom: none;
        }
        .supply_list li {
            overflow: hidden;
            border-bottom: 1px solid #DEDEDE;
            background-color: #fff;
        }
        .graybg {
            background: #f7f7f7;
        }
        .supply_list li span {
            margin-top: 23px;
            margin-bottom: 23px;
            width: 16.6%;
            float: left;
            text-align: center;
        }
        .fs14{font-size:14px;}
        .order_progress{width: 351px;margin-top: 45px;margin-bottom: 45px;}
        .cart_progress{width: 303px;margin:0 auto;height: 33px;}
        .cart_progress_02{background: url(../img/cart_icon03.png)no-repeat;}
        .progress_text{color: #999;margin-top: 5px;}
        .progress_text_curr{color: #75b335;}
        .my_cart{float: left;margin-left: 5px;}
        .order_information{float: left;margin-left: 91px;}
        .order_submit{float: left;margin-left: 70px;}
        .w1200{width: 1200px;margin: 0 auto;}
        .whitebg{background: #FFFFFF;}
        .shop_title li{float: left; text-align: center;}
        input[type='checkbox']{width: 20px;height: 20px;background-color: #fff;-webkit-appearance:none;border: 1px solid #c9c9c9;border-radius: 2px;outline: none;}
        .check_box input[type=checkbox]:checked{background: url(../img/interface-tickdone.png)no-repeat center;}
        .shop_list li {line-height: 115px;border-bottom: 1px solid #DEDEDE;overflow: hidden;}
        .shop_list li:last-child{border-bottom:none;}
        .orange,a.orange,a.orange:hover{color:#ff6600;}
        .tac{text-align:center !important;}
        .ovh{overflow: hidden;}
        .til_bg{background: url(default/img/time_s.png)no-repeat 485px 3px;}
        .til_text{width: 435px;margin: 20px auto;text-align: center;color: #666;}
        .comfirm{width: 360px;margin: 40px auto 80px;}
        .comfirm_btn{cursor: pointer; float:left;width: 170px;height: 50px;line-height: 50px;text-align: center;color: #fff;font-size: 16px;border-radius:3px;}
        .comfirm_btn_blue{background-color: #228cca;}
        .code_greenbg{background-color: #75b335;}
    </style>
</head>
<body style="background-color: rgb(244, 244, 244);">
@include(themePath('.','web').'web.include.partials.top')

<div class="clearfix whitebg">
    <div class="w1200">
        <a href="/" class="logo" style="margin-top: 45px;"></a>
        <div class="fr fs14 order_progress" >
            <div class="cart_progress cart_progress_02"></div>
            <div class="progress_text">
                <div class="my_cart progress_text_curr">选择订单</div>
                <div class="order_information">确认信息</div>
                <div class="order_submit">成功提交</div>
            </div>
        </div>
    </div>
</div>

<div class="w1200 whitebg ovh" style="margin-top: 20px;">
    <div class="til_bg tac fs26" style="margin-top: 75px;">发票等待审核</div>

    <div class=" til_text fs16" >发票流水号： {{ $re }}  <a href="/invoice/myInvoice" class="blue">【查询发票】</a><br/>由于行情波动、库存变化等原因、发票需要客服人员确认。</div>

</div>
<div class="w1200 graybg ovh" style="color: #666;">
    <div class="tac mt30 fs16">您也可以通过以下联系方式与客服取得联系</div>
    <div class="mt15 tac fs16"><span class="ml15">电话 : <font class="orange">{{getConfig('service_phone')}}</font></span><span class="ml15">QQ :<font class="orange">{{getConfig('service_qq')}}</font></span></div>
    <div class="comfirm ovh">
        <a href="/member" >
            <div class="comfirm_btn code_greenbg">会员中心
        </div>
        </a>
        <a href="/">
        <div class="comfirm_btn comfirm_btn_blue ml20">
            返回首页
        </div>
        </a>
    </div>
</div>

<div class="clearfix whitebg ovh mt40" style="font-size: 0;">
</div>
@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')

</body>
</html>
