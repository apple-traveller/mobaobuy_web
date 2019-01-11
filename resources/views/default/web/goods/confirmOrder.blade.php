<!doctype html>
<html lang="en">
<head>
	<title>确认订单 - @yield('title')</title>
	@include(themePath('.','web').'web.include.partials.base')
	@yield('css')
	<style type="text/css">
		.logo {
			width: 170px;
			height: 55px;
			margin-top: 20px;
			float: left;
			background: url(/default/img/mobao_logo.png)no-repeat;
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
			position: relative;
		}
		.Collect_goods_address {
			margin-left: 10px;
			margin-top: 0px;
		}
		/*.Collect_goods_address li:hover {*/
			/*border: 1px solid #75b335;*/
		/*}*/
		.Collect_goods_address li.mrxs-curr{border:1px solid #75b335;background: url("/default/img/addr_curr.png")no-repeat -22px -8px;}
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
		.Collect_goods_address li.check_address:hover{border: 1px solid #75b335;}
		.Collect_goods_address li.check_address:last-child:hover{border: 1px solid #D9D9D9;}
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
			margin-right: 40px;
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
		.fs14{font-size:14px;}
		.order_progress{width: 351px;margin-top: 45px;margin-bottom: 45px;}
		.cart_progress{width: 303px;margin:0 auto;height: 33px;}
		.cart_progress_02{background: url(/default/img/cart_icon02.png)no-repeat;}
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

		.select_btn{padding: 6px 24px;
			border: 1px solid #eca57a;
			color: #eca57a;
			background: none;
			border-radius: 3px;
			position: absolute;
			top: 16px;
			right: 16px;cursor: pointer;}
		.select_btn:hover{background-color: #eca57a;color: #fff;}

		.address_default {
			width: 270px;
			line-height: 36px;
			position: absolute;
			bottom: 0;
			top: 84px;
			right: -164px;
		}
		.address_list{cursor:pointer;}
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
	@if(session('_curr_deputy_user')['is_firm'] == 0 && session('_curr_deputy_user')['is_self'] == 1)
		<div class="whitebg mt20 ovh">
				<h1 class="ml30 fs18 mt40">开票信息</h1>
				<div class="company_information" id="invoiceInfo">
					<ul class="company_list">
						<li><span class="company_title">发票抬头 :</span><span class="ml5">个人</span></li>
					</ul>
				</div>
			</div>
	@else
		@if(!empty($invoiceInfo))
			<div class="whitebg mt20 ovh">
				<h1 class="ml30 fs18 mt40">开票信息</h1>
				<div class="company_information" id="invoiceInfo">
					<ul class="company_list">
						<li><span class="company_title">公司名称 :</span><span class="ml5">{{ $invoiceInfo['company_name'] }}</span></li>
						<li><span class="company_title" style="letter-spacing: 5.0px;">税        号 :</span><span class="ml5">{{ $invoiceInfo['tax_id'] }}</span></li>
						<li><span class="company_title">开  户  行 :</span><span class="ml5">{{ $invoiceInfo['bank_of_deposit'] }}</span></li>
						<li><span class="company_title">银行账号 :</span><span class="ml5">{{ $invoiceInfo['bank_account'] }}</span></li>
						<li><span class="company_title">开票电话 :</span><span class="ml5">{{ $invoiceInfo['company_telephone'] }}</span></li>
						<li><span class="company_title">开票地址 :</span><span class="ml5">{{ $invoiceInfo['company_address'] }}</span></li>
					</ul>
				</div>
			</div>
		@else

		@endif
	@endif


	<div class="address whitebg ovh mt20 ">
		<h1 class="ml30 fs18 mt30">收货地址</h1>

		@if(!empty($addressList))
		<ul class="Collect_goods_address ml30 mt10 ovh mb20">
			@foreach($addressList as $k=>$v)
			<li class="address_list @if($v['is_select'] == 1) mrxs-curr @else check_address @endif" data-id="{{ $v['id'] }}">
				<div class="mt20 ml20 ovh @if($v['is_default'] == 1) mrxs-curr @endif"><span class="fl">{{ $v['consignee'] }}</span><span class="fr mr20 gray">{{ $v['mobile_phone'] }}</span></div>
				<span class="address_detail ml20 mr20 mt10">{{ $v['address_names'] }}</span>
				<div class="address_default">
					<div class="address_default_edit">
						@if($v['is_default'] == 1)
							<span class="mr20 cp " style="color: #74b334">默认</span>
						@else
							<span class="mr20 cp " ></span>
						@endif
					</div>
				</div>
			</li>
			@endforeach
		</ul>
			@else

				<div class="ml300 " style="margin-bottom: 25px;">
					@if(session('_curr_deputy_user')['is_self'] == 0 && session('_curr_deputy_user')['is_firm'] == 1)
						企业暂未维护地址,无法下单
						@else
						暂未维护地址 <a href="/addressList" style="color: #74b334">前去维护地址信息</a>
					@endif
				</div>
			@endif
	</div>

	{{--@if(session('cartSession')['from'] != 'promote')--}}
		{{--<div class="address whitebg ovh mt20 ">--}}
		{{--<h1 class="ml30 fs18 mt30">付款方式</h1>--}}
		{{--<ul class="Collect_goods_address ml30 mt10 ovh mb20">--}}
			{{--<li class="payTypeList" data-id="" style="height: 80px;border:none;">--}}
				{{--<label style="clear:both;margin-top:20px;"><input name="payType" type="radio" value="1" checked="checked" />在线支付 </label> <br>--}}
				{{--<label style="clear:both;margin-top:20px;"><input name="payType" type="radio" value="2" />货到付款</label> --}}
			{{--</li>--}}
		{{--</ul>--}}
			{{----}}
	{{--</div>--}}
	{{--@endif--}}


	<div class="address whitebg ovh mt20">
		<h1 class="ml30 fs18 mt30">商品信息</h1>
		<ul class="supply_list mt15" style="width: 1140px; margin: 20px auto; border-bottom:1px solid #DEDEDE;">
			<li class="graybg">
				<span>商品</span>
				<span>单价（元）</span>
				<span>数量</span>
				<!-- <span>发货地</span> -->
				<span></span>
				<span>小计</span>
			</li>
			@foreach($goodsList as $k =>$v)
			<li class="graybg">
				<span class="ovhwp">{{ $v['goods_name'] }}</span>
				<span class="green">¥{{ $v['goods_price'] }}/{{$v['unit_name']}}</span>
				<span>{{ $v['goods_number'] }}{{$v['unit_name']}}</span>
				<!-- <span>@if(isset($v['delivery_place'])) {{ $v['delivery_place']}} @endif</span> -->
				<span></span>
				<span class="orange subtotal">￥@if(isset($v['account'])) {{ $v['account'] }}/{{$v['unit_name']}} @else {{ number_format($v['account_money'],2) }} @endif</span>
			</li>
			@endforeach
		</ul>
		<form action="/createOrder" method="post" id="form">
		<div class="address_line">
			<div class="fl"><span class="gray">给卖家留言：</span><input type="text" name="words" style="width: 314px;height: 30px;line-height: 30px;border: 1px solid #e6e6e6;padding-left: 5px;box-sizing: border-box;" placeholder="选填：对本次交易的说明"/></div>
			<div class="fr">
				
				<div class="ovh"><span class="fl gray">小计:</span><span class="ordprice fl tar orange total_price">@if(!empty($goods_amount)) {{amount_format($goods_amount)}} @endif</span></div>
				<div class="mt10 ovh mr30"><span class="fl gray">运费:</span><span class="ordprice fl tar orange">不含运费</span></div>
				<div class="mt10 ovh"><span class="fl gray lh40">总计:</span><span class="ordprice fl tar orange fs22 total_price">@if(!empty($goods_amount)) {{amount_format($goods_amount)}} @endif</span></div>
			</div>
		</div>
		<div class="address_line cccbg" style="height: 1px;"></div>
		<div class="address_sumb fr mr30 cp">提交订单</div><a href="/cart" class="fr gray" style="line-height: 50px;">< 返回</a>
		</form>
		<input type="hidden" name="" id="activityPromoteId" @if(isset($id))  value="{{encrypt($id)}}" @else value="" @endif >
	</div>
</div>


<div class="clearfix whitebg ovh mt40" style="font-size: 0;"></div>
@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')
<script>
//	$(function () {
//		var num = $("span.subtotal").text();
//		var sum = 0;
//        $("span.subtotal").each(function(){
//            sum =sum+parseInt($(this).text());
//		});
//		$(".total_price").text(number_format(sum,2));
//    });
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
	$(".change_list").click(function () {
		var invoice_id = $(this).attr('data-id');
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
//    $(".check_address").click(function () {
//        var address_id = $(this).attr('data-id');
//        $.ajax({
//            url:'/updateDefaultAddress',
//            data:{'address_id':address_id},
//            type:"POST",
//            success:function (res) {
//                console.log(res);
//                if (res.code == 1){
//                    setTimeout(window.location.reload(),1000);
//                }else{
//                    setTimeout(window.location.reload(),1000);
//                }
//            }
//        });
//    });

	//修改收货地址
	$(".check_address").click(function () {
        var address_id = $(this).attr('data-id');
        $.ajax({
            url:'/editOrderAddress',
            data:{'address_id':address_id},
            type:"POST",
            success:function (res) {
                console.log(res);
                if (res.code == 1){
                    setTimeout(window.location.reload(),1000);
                }else{
                    $.msg.error(res.msg);
                }
            }
        });
	});
    $(".address_sumb").click(function () {
//    	var payType = $('.payTypeList input[name=payType]:checked').val();
    	var activityPromoteId = $('#activityPromoteId').val();
		var words =  $("input[ name='words' ]").val();
		$.ajax({
			url:'/createOrder',
			data:{
			    'words':words,
			    'activityPromoteId':activityPromoteId,
//			    'payType':payType
			},
			type:'post',
			success:function (res) {
                if (res.code==1){
                    window.location.href="/orderSubmission.html?re="+JSON.stringify(res.data);
                } else {
                    layer.msg(res.msg);
                }
            }
		});
    });
</script>
</body>
</html>
