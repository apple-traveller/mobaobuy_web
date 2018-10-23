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
			background: url(default/img/mobao_logo.png)no-repeat;
			background-size: 100% 100%;
		}
		.company_list {
			overflow: hidden;
			margin-left: 20px;
			margin-top: 15px;
			margin-bottom: 30px;
		}
		.company_list li {
			float: left;
			width: 505px;
			margin-top: 15px;
		}
		.company_information {
			width: 1140px;
			margin: 10px auto 30px;
			border: 1px solid #ff6f17;
			box-sizing: border-box;
			background-color: #fefce9;
		}
		.Collect_goods_address {
			margin-left: 10px;
			margin-top: 0px;
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
		.Collect_goods_address {
			margin-left: 10px;
			margin-top: 0px;
		}
		.address_detail {
			width: 225px;
			float: left;
			color: #666;
		}
		.mr20 {
			margin-right: 20px;
		}
		.cccbg {
			background: #CCCCCC;
		}
		.mr30 {
			margin-right: 30px;
		}
		.lh40 {
			line-height: 40px;
		}
		.mt20 {
			margin-top: 20px;
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
		.address_sumb {
			width: 170px;
			margin-left: 30px;
			margin-bottom: 40px;
			border-radius: 3px;
			height: 50px;
			line-height: 50px;
			background-color: #75b335;
			text-align: center;
			font-size: 16px;
			color: #fff;
		}
		.ordprice {
			width: 115px;
			float: left;
			text-align: center;
			color: #ff6f17;
		}
		.address_line {
			width: 1140px;
			margin: 20px auto;
			overflow: hidden;
		}
		.default_text {
			float: right;
			margin-right: 20px;
			color: #999;
			display: block;
		}
		.fs14{font-size:14px;}
		.order_progress{width: 351px;margin-top: 45px;margin-bottom: 45px;}
		.cart_progress{width: 303px;margin:0 auto;height: 33px;}
		.cart_progress_02{background: url(default/img/cart_icon02.png)no-repeat;}
		.progress_text{color: #999;margin-top: 5px;}
		.progress_text_curr{color: #75b335;}
		.my_cart{float: left;margin-left: 5px;}
		.order_information{float: left;margin-left: 58px;}
		.order_submit{float: left;margin-left: 50px;}
		.w1200{width: 1200px;margin: 0 auto;}
		.whitebg{background: #FFFFFF;}
		.shop_title li{float: left; text-align: center;}
		input[type='checkbox']{width: 20px;height: 20px;background-color: #fff;-webkit-appearance:none;border: 1px solid #c9c9c9;border-radius: 2px;outline: none;}
		.check_box input[type=checkbox]:checked{background: url(../img/interface-tickdone.png)no-repeat center;}
		.fl{float:left;}
		.shop_list li {line-height: 115px;border-bottom: 1px solid #DEDEDE;overflow: hidden;}
		.shop_list li:last-child{border-bottom:none;}
		.orange,a.orange,a.orange:hover{color:#ff6600;}
		.tac{text-align:center !important;}
		.ovh{overflow: hidden;}
		.cp{cursor:pointer;}
		.qiehuan{width: 90px;height: 30px;line-height: 30px;background: url(default/img/pro_more.png)no-repeat 63px 13px;
			margin-right: 30px;font-size: 15px;border: 1px solid #dedede;text-align: center;cursor: pointer;color: #999;}
		.qiehuan.active{background: url(default/img/pro_more.png)no-repeat 63px -14px;}
		.ml300 { margin-left: 400px !important; }
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
				<div class="my_cart progress_text_curr">我的购物车</div>
				<div class="order_information">订单信息完善</div>
				<div class="order_submit">成功提交订单</div>
			</div>
		</div>
	</div>
</div>
<div class="w1200">
	<!--公司信息-->
	<div class="whitebg mt20 ovh">
		<h1 class="ml30 fs18 mt40">开票信息 <span class="fr qiehuan" id="change_btn">更多</span></h1>
		<div class="company_information" id="invoiceInfo">
			<ul class="company_list">
				<li><span class="company_title">公司名称 :</span><span class="ml5">{{ $invoicesInfo['company_name'] }}</span></li>
				<li><span class="company_title" style="letter-spacing: 5.0px;">税        号 :</span><span class="ml5">{{ $invoicesInfo['tax_id'] }}</span></li>
				<li><span class="company_title">开  户  行 :</span><span class="ml5">{{ $invoicesInfo['bank_of_deposit'] }}</span></li>
				<li><span class="company_title">银行账号 :</span><span class="ml5">{{ $invoicesInfo['bank_account'] }}</span></li>
				<li><span class="company_title">开票电话 :</span><span class="ml5">{{ $invoicesInfo['company_telephone'] }}</span></li>
				<li><span class="company_title">开票地址 :</span><span class="ml5">{{ $invoicesInfo['company_address'] }}</span></li>
				<li><span class="company_title">收票人 :</span><span class="ml5">{{ $invoicesInfo['consignee_name'] }} {{ $invoicesInfo['consignee_mobile_phone'] }}</span></li>
				<li><span class="company_title">收票人地址 :</span><span class="ml5">{{ $invoicesInfo['address_str'] }}{{ $invoicesInfo['consignee_address'] }}</span></li>
			</ul>

		</div>
		<div  id ="change_list" style="display:none;">
			<span class="ml300" style="color: #00CC00"><b>********************** 双击选择 **********************</b></span>
			@foreach($invoicesList as $k=>$v)
		<div class="company_information change_list" data-id="{{ $v['id'] }}" readonly="readonly">
			<ul class="company_list">
				<li><span class="company_title">公司名称 :</span><span class="ml5">{{ $v['company_name'] }}</span></li>
				<li><span class="company_title" style="letter-spacing: 5.0px;">税        号 :</span><span class="ml5">{{ $v['tax_id'] }}</span></li>
				<li><span class="company_title">开  户  行 :</span><span class="ml5">{{ $v['bank_of_deposit'] }}</span></li>
				<li><span class="company_title">银行账号 :</span><span class="ml5">{{ $v['bank_account'] }}</span></li>
				<li><span class="company_title">开票电话 :</span><span class="ml5">{{ $v['company_telephone'] }}</span></li>
				<li><span class="company_title">开票地址 :</span><span class="ml5">{{ $v['company_address'] }}</span></li>
				<li><span class="company_title">收票人 :</span><span class="ml5">{{ $v['consignee_name'] }} {{ $v['consignee_mobile_phone'] }}</span></li>
				<li><span class="company_title">收票人地址 :</span><span class="ml5">{{ $v['address_str'] }}{{ $v['consignee_address'] }}</span></li>
			</ul>
		</div>
				@endforeach
		</div>
	</div>
	<div class="address whitebg ovh mt20 ">
		<h1 class="ml30 fs18 mt30">收货地址</h1>

		<ul class="Collect_goods_address ml30 mt10 ovh mb20">
			@foreach($addressList as $k=>$v)
			<li class="address_list" data-id="{{ $v['id'] }}">
				<div class="mt20 ml20 ovh"><span class="fl">{{ $v['consignee'] }}</span><span class="fr mr20 gray">{{ $v['mobile_phone'] }}</span></div>
				<span class="address_detail ml20 mr20 mt10">{{ $v['address_names'] }}{{ $v['address'] }}</span>
				@if($v['is_default'] == 1) <span class="default_text cp">默认</span> @endif
			</li>
			@endforeach
		</ul>
		<span class="ml300" style="color: #00CC00"><b>********************** 双击选择 **********************</b></span>
	</div>
	<div class="address whitebg ovh mt20">
		<h1 class="ml30 fs18 mt30">商品信息</h1>
		<ul class="supply_list mt15" style="width: 1140px; margin: 20px auto; border-bottom:1px solid #DEDEDE;">
			<li class="graybg">
				<span>商品</span><span>单价（元）</span><span>数量（公斤）</span><span>运费（元）</span><span></span><span>小计</span>
			</li>
			@foreach($goodsList as $k =>$v)
			<li class="graybg">
				<span class="ovhwp">{{ $v['goods_name'] }}</span><span class="orange">¥{{ $v['goods_price'] }}</span><span>{{ $v['goods_number'] }}</span><span>待商家审核</span><span></span><span class="orange subtotal">{{ $v['goods_price']*$v['goods_number'] }}</span>
			</li>
			@endforeach
		</ul>
		<form action="/createOrder" method="post" id="form">
		<div class="address_line">
			<div class="fl"><span class="gray">给卖家留言：</span><input type="text" name="words" style="width: 314px;height: 30px;line-height: 30px;border: 1px solid #e6e6e6;padding-left: 5px;box-sizing: border-box;" placeholder="选填：对本次交易的说明"/></div>
			<div class="fr">

				<div class="ovh"><span class="fl gray">小计:</span><span class="ordprice fl tar orange total_price">¥169.00</span></div>
				<div class="mt10 ovh mr30"><span class="fl gray">运费:</span><span class="ordprice fl tar orange">待商家审核</span></div>
				<div class="mt10 ovh"><span class="fl gray lh40">总计:</span><span class="ordprice fl tar orange fs22 total_price">¥229.00</span></div>
			</div>

		</div>
		<div class="address_line cccbg" style="height: 1px;"></div>
		<div class="address_sumb fr mr30 cp"><a href="javascript:void(0);">提交订单</a></div><a class="fr gray" style="line-height: 50px;">< 返回购物车</a>
		</form>
	</div>
</div>



@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')
<script>
	$(function () {
		let num = $("span.subtotal").text();
		sum = 0;
        $("span.subtotal").each(function(){
            sum =sum+parseInt($(this).text());
		});
		$(".total_price").text('￥'+sum);
    });
    var click_num = 1;
	$('#change_btn').click(function () {

	    $('.qiehuan').toggleClass('active');

	    var ui = document.getElementById('change_list');
		if (click_num == 1){
		    $("#invoiceInfo")[0].style.display="none";
            ui.style.display="";
            click_num = 0;
		} else {
            $("#invoiceInfo")[0].style.display="";
            ui.style.display="none";
            click_num = 1;
		}
    })
    /**
	 * 修改默认开票
     */
	$(".change_list").dblclick(function () {
		let invoice_id = $(this).attr('data-id');
      	$.ajax({
			url:'/updateDefaultInvoice',
			data:{'invoice_id':invoice_id},
			type:"POST",
			success:function (res) {
			    console.log(res);
				if (res.code == 1){
				    setTimeout(window.location.reload(),1000);
				}else{
                    setTimeout(window.location.reload(),1000);
				}
            }
		});
    });
    /**
	 * 修改默认地址
     */
    $(".address_list").dblclick(function () {
        let address_id = $(this).attr('data-id');
        $.ajax({
            url:'/updateDefaultAddress',
            data:{'address_id':address_id},
            type:"POST",
            success:function (res) {
                console.log(res);
                if (res.code == 1){
                    setTimeout(window.location.reload(),1000);
                }else{
                    setTimeout(window.location.reload(),1000);
                }
            }
        });
    });
    $(".address_sumb").click(function () {
		let words =  $("input[ name='words' ]").val();
		console.log(words);
		$.ajax({
			url:'/createOrder',
			data:{
			    'words':words
			},
			type:'post',
			success:function (res) {
                if (res.code==1){
                    window.location.href="/orderSubmission.html?re="+res.data;
                } else {
                    layer.msg(res.msg);
                }
            }
		});
		// $("#form").submit();
    });
</script>
</body>
</html>
