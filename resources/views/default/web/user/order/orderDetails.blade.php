<!doctype html>
<html lang="en">
<head>
    <title>订单详情 - @yield('title')</title>
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
			.order_pro_stute{float:left;margin-top:30px;margin-bottom:20px;border-right: 1px solid #DEDEDE;width:285px;height: 188px;overflow: hidden;}
			.Order_number{display:block;margin-left: 20px;margin-right: 55px; margin-top: 15px;}
			.order_pay_btn{padding:0 48px;margin-left:75px;margin-right: 75px;margin-top:20px;display:inline-block;font-size:18px;height: 40px;line-height: 40px;border: 1px solid #ED1E2D;border-radius: 2px;}
			.order_jd_bg{width: 771px;height: 30px;margin-left: 70px;margin-top: 80px;}
			.order_jd_bg1{background: url(/default/img/order_icon01.png)no-repeat 0px 0px;}
			.order_jd_text{margin-left: 20px;}.order_jd_text li{float:left;width: 109px;text-align: center;margin-top: 10px;color: #999;}
			.order_jd_text li:first-child{margin-left: 0px;}
			.jd_text_con{padding-left: 10px; padding-right: 10px;}
			.jd_text_date{color: #999;}
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
			<div class="crumbs">当前位置：<a href="/member">会员中心</a> &gt;<a href="/order/list">我的订单</a> &gt;<span class="gray">订单详情</span></div>
		<div class="order_pro_progress whitebg mt5">
			<div class="order_pro_stute">
				<span class="Order_number">订单单号：{{$orderDetailsInfo['orderInfo']['order_sn']}}</span>
				@if($orderDetailsInfo['orderInfo']['order_status'] == 0)
					<span class="tac db fs24 fwb red mt30">已作废</span>
					@elseif($orderDetailsInfo['orderInfo']['order_status'] == 1)
					<span class="tac db fs24 fwb red mt30">待企业审核</span>
					@elseif($orderDetailsInfo['orderInfo']['order_status'] == 2)
					<span class="tac db fs24 fwb red mt30">待商家确认</span>
					@elseif($orderDetailsInfo['orderInfo']['order_status'] == 3)
					<span class="tac db fs24 fwb red mt30">已确认</span>
					@elseif($orderDetailsInfo['orderInfo']['order_status'] == 4)
					<span class="tac db fs24 fwb red mt30">等待付款</span>
					<a class="order_pay_btn red">付款</a>
				@endif

			</div>
			<div class="order_pro_jd fl">
				<div class="order_jd_bg order_jd_bg1"></div>
				<ul  class="order_jd_text">
					<li>
						<span class="jd_text_con black">提交订单</span>
						<span class="jd_text_date">{{$orderDetailsInfo['orderInfo']['add_time']}}</span>
					</li>
				
				</ul>
			</div>
	    </div>
	   <!--物流信息-->
	    <div class="whitebg br1 mt20 ovh">
	    	<div class="order_pro_stute">
				<span class="ml30 mt10 db" >本订单由第三方卖家为您发货</span>
				<span class="ml30 db mt20">物流单号：暂无</span>
			</div>
			<div class="fl wlgz_text">
				<ul class="wlxx">
					<li>
						<i class="external-cir"></i>
						您提交了订单，请等待系统确认
						<div class="gray">{{$orderDetailsInfo['orderInfo']['add_time']}}</div>
					</li>
				
				</ul>
			</div>
	    </div>
	    <!--收货人信息/商家信息/发票信息-->
	    <div class="whitebg br1 mt20 ovh">
	    	<!--收货人信息-->
	    	<div class="consignee bbright">
	    		<h1 style="font-size:16px;">收货人信息</h1>
	    		<span class="ml20 db mt20"><span class="fl">收  货  人:</span> <span class="ml20">{{$orderDetailsInfo['orderInfo']['consignee']}}</span></span>
	    		<span class="ml20 ovh db mt5"><span class="fl">收货地址:</span><span class="fl consignee_addr"> {{$orderDetailsInfo['country']}}{{$orderDetailsInfo['province']}}{{$orderDetailsInfo['city']}}{{$orderDetailsInfo['district']}}<br>{{$orderDetailsInfo['orderInfo']['address']}}</span></span>
	    		<span class="ml20 db mt20"><span class="fl">手机号码: </span><span class="ml10">{{$orderDetailsInfo['orderInfo']['mobile_phone']}}</span></span>
	    		<span class="ml20 db mt20"><span class="fl">买家留言: </span><span class="ml10">{{$orderDetailsInfo['orderInfo']['postscript']}}</span></span>
	    	</div>
	    	<!--商家信息-->
	    	<div class="consignee bbright">
	    		<h1 style="font-size:16px;">商家信息</h1>
	    		<span class="ml20 db mt20" style="margin-right: 266px;"><span class="fl">公司名称 :</span> <span class="ml10">{{$orderDetailsInfo['orderInfo']['shop_name']}}</span></span>
	    		<span class="ml20 db "><span class="fl">卖家留言 :</span> <span class="ml10">{{$orderDetailsInfo['orderInfo']['to_buyer']}}</span></span>
	    	</div>
	    	<!--发票信息-->
	    	<div class="consignee ">
	    		<h1 style="font-size:16px;">发票信息</h1>
	    		<span class="ml20 db mt20" ><span class="fl">发票抬头：</span> <span class="ml10">@if($orderDetailsInfo['userInvoceInfo']['is_firm']) 企业 @else个人 @endif</span></span>
	    		@if($orderDetailsInfo['userInvoceInfo']['is_firm'])
	    		<span class="ml20 db "><span class="fl">公司名称 :</span> <span class="ml10">{{$orderDetailsInfo['userInvoceInfo']['company_name']}}</span></span>
	    		<span class="ml20 db "><span class="fl">税号 :</span> <span class="ml10">{{$orderDetailsInfo['userInvoceInfo']['tax_id']}}</span></span>
	    		@endif
	    	</div>
	    </div>
	    <!--订单列表-->
	    <div class="whitebg br1 mt20 ovh">
	    	<ul class="order-list-brand">
	    		<li><span>商品名称</span><span>单价</span><span>数量</span><span>金额</span><!-- <span>操作</span> --></li>
	    		<!-- <li><span>维生素C</span><span>￥50.00 </span><span>2kg</span><span>待付款</span><span></span></li>
	    		<li><span>维生素C</span><span>￥50.00 </span><span>2kg</span><span>待付款</span><span></span></li> -->
	    		@foreach($orderDetailsInfo['goodsInfo'] as $v)
	    		<li><span>{{$v['goods_name']}}</span><span>￥{{$v['goods_price']}} </span><span>{{$v['goods_number']}}kg</span><span>{{number_format($v['goods_price'] * $v['goods_number'],2)}}</span><span></span></li>
	    		@endforeach
	    	</ul>
	    	<div class="Amount_money">
	    		<div class="db"><span>商品总额：</span><span class="fr ml20">￥{{$orderDetailsInfo['orderInfo']['goods_amount']}}</span></div>
	    		<div class="db mt15"><span class="di">运       费：</span><span class="fr ml20">￥{{$orderDetailsInfo['orderInfo']['shipping_fee']}}</span></div>
	    		<div class="db mt20 red"><span class="lh35">应付总额：</span><span class="fr ml20 fs22">￥{{$orderDetailsInfo['orderInfo']['order_amount']}}</span></div>
	    	</div>
		</div>
	</div>







     @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
    @yield('js')
</body>
</html>


