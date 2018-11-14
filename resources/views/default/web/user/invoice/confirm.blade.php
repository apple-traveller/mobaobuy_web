<!doctype html>
<html lang="en">
<head>
	<title>开票申请  @yield('title')</title>
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
		/*.Collect_goods_address li.mrxs-curr:hover {*/
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
		.fs14{font-size:14px;}
		.order_progress{width: 351px;margin-top: 45px;margin-bottom: 45px;}
		.cart_progress{width: 303px;margin:0 auto;height: 33px;}
		.cart_progress_02{background: url(../img/cart_icon02.png)no-repeat;}
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
		.fl{float:left;}
		.shop_list li {line-height: 115px;border-bottom: 1px solid #DEDEDE;overflow: hidden;}
		.shop_list li:last-child{border-bottom:none;}
		.orange,a.orange,a.orange:hover{color:#ff6600;}
		.tac{text-align:center !important;}
		.ovh{overflow: hidden;}
		.cp{cursor:pointer;}
		.qiehuan{width: 90px;height: 30px;line-height: 30px;background: url(../img/pro_more.png)no-repeat 63px 13px;
			margin-right: 30px;font-size: 15px;border: 1px solid #dedede;text-align: center;cursor: pointer;color: #999;}
		.qiehuan.active{background: url(../img/pro_more.png)no-repeat 63px -14px;}
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
				<div class="my_cart progress_text_curr">选择订单</div>
				<div class="order_information">确认信息</div>
				<div class="order_submit">成功提交</div>
			</div>
		</div>
	</div>
</div>
<div class="w1200">
	<!--公司信息-->
	@if($invoiceInfo['is_firm'])
		<div class="whitebg mt20 ovh">
			<h1 class="ml30 fs18 mt40">开票信息</h1>
				<div class="company_information" id="invoiceInfo">
					<ul class="company_list">
						<li><span class="company_title">公司名称 :</span><span class="ml5">{{ $invoiceInfo['company_name'] }}</span></li>
						<li><span class="company_title" style="letter-spacing: 5.0px;">税        号 :</span><span class="ml5">{{ $invoiceInfo['tax_id'] }}</span></li>
						@if($invoiceInfo['is_special'])
							<li><span class="company_title">开  户  行 :</span><span class="ml5">{{ $invoiceInfo['bank_of_deposit'] }}</span></li>
							<li><span class="company_title">银行账号 :</span><span class="ml5">{{ $invoiceInfo['bank_account'] }}</span></li>
							<li><span class="company_title">开票电话 :</span><span class="ml5">{{ $invoiceInfo['company_telephone'] }}</span></li>
							<li><span class="company_title">开票地址 :</span><span class="ml5">{{ $invoiceInfo['company_address'] }}</span></li>
							@else
						@endif
					</ul>
				</div>
		</div>
	@else
		<div class="whitebg mt20 ovh">
			<h1 class="ml30 fs18 mt40">开票信息</h1>
				<div class="company_information" id="invoiceInfo">
					<ul class="company_list">
						<li><span class="company_title">发票抬头 :</span><span class="ml5">个人</span></li>
					</ul>
				</div>
		</div>
	@endif
	<div class="address whitebg ovh mt20 ">
		<h1 class="ml30 fs18 mt30">收票地址</h1>

		@if(!empty($addressList))
		<ul class="Collect_goods_address ml30 mt10 ovh mb20">
			@foreach($addressList as $k=>$v)
			<li class="address_list @if($v['is_select'] == 1) mrxs-curr @else check_address @endif" data-id="{{ $v['id'] }}">
				<div class="mt20 ml20 ovh"><span class="fl">{{ $v['consignee'] }}</span><span class="fr mr20 gray">{{ $v['mobile_phone'] }}</span></div>
				<span class="address_detail ml20 mr20 mt10">{{ $v['address_names'] }}{{ $v['address'] }}</span>
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
			<div class="ml300 ">
			暂无地址信息 <a href="/addressList" style="color: #74b334">前去维护地址信息</a>
			</div>
			@endif
	</div>
	<div class="address whitebg ovh mt20">
		<h1 class="ml30 fs18 mt30">商品信息</h1>
		<ul class="supply_list mt15" style="width: 1140px; margin: 20px auto; border-bottom:1px solid #DEDEDE;">
			<li class="graybg">
				<span>商品</span>
				<span>商品编码</span>
				<span>单价（元）</span>
				<span>已发货数量（kg）</span>
				<span></span>
				<span>小计</span>
			</li>
			@foreach($goodsList['list'] as $k =>$v)
			<li class="graybg">
				<span class="ovhwp">{{ $v['goods_name'] }}</span>
				<span class="orange">¥{{ $v['goods_sn'] }}</span>
				<span>{{ $v['goods_price'] }}</span>
				<span>{{ $v['goods_number'] }}</span>
				<span></span><span class="orange subtotal">{{ $v['goods_price']*$v['goods_number'] }}</span>
			</li>
			@endforeach
		</ul>
		<form id="form">
			{{--<input type="hidden" name="address_id" id="address_id" value="{{ $addressList[0]['id'] }}">--}}
			<div class="address_line">
				<!-- <div class="ovh mt10">
					<span>开票类型:</span>
					<input type="radio" name="invoice_type" value="1" id="1" title="普通发票" @if($invoice_type == 1) checked="checked" @endif style="margin-left: 27px;"><label for="1" style="cursor: pointer">增值普通发票</label>
					<input type="radio" name="invoice_type" value="2" id="2" title="增值发票" @if($invoice_type == 2) checked="checked" @endif style="margin-left: 27px;"><label for="2" style="cursor: pointer">增值专用发票</label>
				</div> -->
				<div class="ovh mt10">
					<input type="hidden" name="total_amount" value="{{ $total_amount }}" style="display: none" id="total_amount">
					<input type="hidden" name="goodsList" value="{{ json_encode( $goodsList['list'])  }}" style="display: none">
				</div>
				<div class="fr mr20">开票总金额<span class="orange">￥{{ $total_amount }}</span></div>
			</div>
			<div class="address_line cccbg" style="height: 1px;"></div>
			<div class="address_sumb fr mr30 cp"><a href="javascript:void(0);">提交申请</a></div>
		</form>
	</div>
</div>


<div class="clearfix whitebg ovh mt40" style="font-size: 0;"></div>
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
	$(".change_list").click(function () {
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
	 * 选择收票地址
     */
    $(".check_address").click(function () {
        let address_id = $(this).attr('data-id');
        $.ajax({
            url:'/invoice/editInvoiceAddress',
            data:{'address_id':address_id},
            type:"POST",
            success:function (res) {
                if (res.code == 1){
                    setTimeout(window.location.reload(),1000);
                }else{
                    $.msg.error(res.msg);
                }
            }
        });
    });
    /**
     * 选择开票类型
     */
    $("input[name=invoice_type]").click(function(){
		let invoice_type = $(this).val();
        $.ajax({
            url:'/invoice/editInvoiceType',
            data:{'invoice_type':invoice_type},
            type:"POST",
            success:function (res) {
                if (res.code == 1){
                }else{
                    $.msg.error(res.msg);
                }
            }
        });
	});
//    $(".check_address").click(function () {
//        let invoice_type = $(this).attr('data-id');
//        $.ajax({
//            url:'/invoice/editInvoiceType',
//            data:{'invoice_type':invoice_type},
//            type:"POST",
//            success:function (res) {
//                if (res.code == 1){
//                    setTimeout(window.location.reload(),1000);
//                }else{
//                    $.msg.error(res.msg);
//                }
//            }
//        });
//    });
    $(".address_sumb").click(function () {
		let _form = $("#form").serializeArray();
		$.ajax({
			url: '/invoice/apply',
			data:_form,
			type:'POST',
			success:function (res) {
				if (res.code == 1){
				    window.location.href="/invoice/waitFor.html?re="+res.data;
				} else {
				    $.msg.alert(res.msg);
				}
            }
		});
    });
</script>
</body>
</html>
