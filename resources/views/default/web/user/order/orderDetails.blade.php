<!doctype html>
<html lang="en">
<head>
	<title>会员中心 - @yield('title')</title>
	@include(themePath('.','web').'web.include.partials.base')
	<link rel="stylesheet" href="/default/css/global.css" />
	<link rel="stylesheet" href="/default/css/index.css" />
	<style>
		/*订单状态*/
		.order_pro_progress{border: 1px solid #DEDEDE;overflow: hidden;border-top: 2px solid #75b335;}
		.order_pro_stute{float:left;margin-top:30px;margin-bottom:20px;border-right: 1px solid #DEDEDE;width:285px;height: 188px;overflow: hidden;}
		.Order_number{display:block;margin-left: 20px;margin-right: 55px; margin-top: 15px;}
		.order_pay_btn{padding:0 48px;margin-left:75px;margin-right: 75px;margin-top:20px;display:inline-block;font-size:18px;height: 40px;line-height: 40px;border: 1px solid #ED1E2D;border-radius: 2px;}
		.order_jd_bg{width: 771px;height: 30px;margin-left: 70px;margin-top: 80px;}
		.order_jd_bg1{background: url(/img/status_pay00.png)no-repeat 0px 0px;}
		.order_jd_text{margin-top:55px;margin-left: 20px;width: 882px;overflow: hidden;}
		.order_jd_text li{float:left;width: 95px;text-align: center;margin-top: 10px;color: #999;margin-left: 6%;position: relative;}
		.order_jd_text li:first-child{margin-left: 0px;}
		.jd_text_con{display: block;margin-top: 10px;}
		.jd_text_date{color: #999;}
		/*物流信息*/
		.wlgz_text{overflow-y: auto;width:912px;height: 178px;margin-top: 35px;}
		.wlxx{margin-left: 30px;}
		.wlxx li{position: relative; border-left: 1px solid #DEDEDE;padding-left: 20px;padding-bottom: 10px;color: #666;}
		.external-cir{position:absolute;top:0px;left:-7px;border-radius:25px;display:inline-block;width: 8px;height: 8px;border: 3px solid #f3a7a9;background-color: #e5383c;}
		/*收货人信息*/
		.consignee{color:#333;float:left;margin:24px 0;height: 188px;}
		.consignee h1{margin-left:20px;}
		.consignee_addr{margin-left:10px;width: 230px;margin-right: 50px;}
		/*订单列表*/
		.order-list-brand li:first-child{background-color: #f4f4f4;height: 32px;line-height: 32px;border-bottom: none;}
		.order-list-brand li{height: 65px; line-height: 65px;border-bottom: 1px solid #DEDEDE;}
		.order-list-brand li span{display: inline-block;text-align: center;}
		.imgInfor{margin-left: 34px;display: block;}
		/*商品总额*/
		.Amount_money{float: right;margin-right: 75px;margin-top: 30px;margin-bottom: 30px;}
		/*商家信息*/
		.bussine_infor{float: left;width: 48%;}
		/*付款凭证*/
		.payImg{  float: left;  width: 210px; height: 170px; margin: 0 20px;}
		.type-file-box{width:71%}
		.payBtn{float:left;margin-top: 10px;margin-left: 20px;}
		.payImgSubmit{    padding: 9px 75px;border: none;background-color: #75b336;color: #fff;cursor:pointer;}
		/*.type-file-box .type-file-button{ float:right;}*/
	</style>
</head>
<body style="background-color: rgb(244, 244, 244);">
@include(themePath('.','web').'web.include.partials.top')
@component(themePath('.','web').'web.include.partials.top_title', ['title_name' => trans('home.member_center')])@endcomponent
<div class="w1200" style="margin-bottom: 40px;">
	<div class="crumbs" style="margin: 15px 0;">{{trans('home.curr')}}：<a href="/member">{{trans('home.member_center')}}</a> &gt;<a href="/order/list">{{trans('home.my_order')}}</a> &gt;<span class="gray">{{trans('home.order_details')}}</span></div>
	<div class="order_pro_progress whitebg mt5">
		<div class="order_pro_stute">
			<span class="Order_number">{{trans('home.order_number')}}：{{$orderDetailsInfo['orderInfo']['order_sn']}}</span>
			<span class="Order_number">{{trans('home.order_source')}}：{{ getOrderFromText($orderDetailsInfo['orderInfo']['extension_code']) }}</span>
			@if($orderDetailsInfo['orderInfo']['order_status'] == 0)
				<span class="tac db fs24 fwb red mt30">{{trans('home.invalid')}}</span>
			@elseif($orderDetailsInfo['orderInfo']['order_status'] == 1)
				<span class="tac db fs24 fwb red mt30">{{trans('home.wait_enterprise_audit')}}</span>
			@elseif($orderDetailsInfo['orderInfo']['order_status'] == 2)
				<span class="tac db fs24 fwb red mt30">{{trans('home.business_confirm')}}</span>
			@elseif($orderDetailsInfo['orderInfo']['order_status'] == 3)
				<span class="tac db fs24 fwb red mt30">{{trans('home.confirmed')}}</span>
			@elseif($orderDetailsInfo['orderInfo']['order_status'] == 4)
				<span class="tac db fs24 fwb red mt30">{{trans('home.completed')}}</span>
			@elseif($orderDetailsInfo['orderInfo']['order_status'] == 5)
				<span class="tac db fs24 fwb red mt30">{{trans('home.wait_open_ticket')}}</span>
			@endif
		</div>
		<div class="order_pro_jd fl">
			<!-- <div class="order_jd_bg order_jd_bg1"></div> -->
			<ul  class="order_jd_text">
				<li>
					<img class="imgInfor" src="{{asset('/img/status_pay00.png')}}">
					<span class="jd_text_con black">{{trans('home.sub_order')}}</span>
					<span class="jd_text_date">{{$orderDetailsInfo['orderInfo']['add_time']}}</span>
				</li>

				@if(!empty($orderDetailsInfo['orderInfo']['confirm_time']))
					<li>
						<img  class="imgInfor" src="{{asset('/img/status_pay01.png')}}">
						<span class="jd_text_con black">{{trans('home.seller_confirm')}}</span>
						<span class="jd_text_date">{{$orderDetailsInfo['orderInfo']['confirm_time']}}</span>
					</li>
				@endif

				@if(!empty($orderDetailsInfo['orderInfo']['pay_time']))
					<li>
						<img class="imgInfor" src="{{asset('/img/status_pay02.png')}}">
						<span class="jd_text_con black">{{trans('home.payment_time')}}</span>
						<span class="jd_text_date">{{$orderDetailsInfo['orderInfo']['pay_time']}}</span>
					</li>
				@endif

				@if(!empty($orderDetailsInfo['orderInfo']['shipping_time']))
					<li>
						<img class="imgInfor" src="{{asset('/img/status_pay03.png')}}">
						<span class="jd_text_con black">{{trans('home.delivery_time2')}}</span>
						<span class="jd_text_date">{{$orderDetailsInfo['orderInfo']['shipping_time']}}</span>
					</li>
				@endif

				@if(!empty($orderDetailsInfo['orderInfo']['shipping_time']))
					<li>
						<img class="imgInfor" src="{{asset('/img/status_pay04.png')}}">
						<span class="jd_text_con black">{{trans('home.in_transit')}}</span>
						<span class="jd_text_date"></span>
					</li>
				@endif

				@if(!empty($orderDetailsInfo['orderInfo']['confirm_take_time']))

					<li>
						<img class="imgInfor" src="{{asset('/img/status_pay05.png')}}">
						<span class="jd_text_con black">{{trans('home.confirm_receipt_time')}}</span>
						<span class="jd_text_date">{{$orderDetailsInfo['orderInfo']['confirm_take_time']}}</span>
					</li>
				@endif
			</ul>
		</div>
	</div>
	<!--物流信息-->
	@if(!empty($orderDetailsInfo['delivery_info']))
		@foreach($orderDetailsInfo['delivery_info'] as $k=>$v)
			<div class="whitebg br1 mt20 ovh getLogistics">
				<div class="order_pro_stute">
					@if(!empty($v))
						<span class="ml30 mt10 db" >{{trans('home.order_detail_delivery_tips')}}</span>
						<span class="ml30 db mt20">
							{{trans('home.logistics_company')}}：<span>{{$v['shipping_name']}}</span><br>
							{{trans('home.logistics_number')}}：<span>{{$v['shipping_billno']}}</span><br>
						</span>
					@else
						<span class="ml30 mt10 db" id="delivery_id" data-delivery_id="0">{{trans('home.wait_shop_delivery')}}</span>
					@endif
				</div>
				<div class="fl wlgz_text">
					<ul class="wlxx" data-delivery_id="{{$v['id']}}">

					</ul>
				</div>
			</div>
		@endforeach
	@else
		<div class="whitebg br1 mt20 ovh getLogistics">
			<div class="order_pro_stute">
				<span class="ml30 mt10 db" id="delivery_id" data-delivery_id="0">{{trans('home.wait_shop_delivery')}}</span>
			</div>
			<div class="fl wlgz_text">
				<ul class="wlxx" data-delivery_id="0">

				</ul>
			</div>
		</div>
	@endif

	<!--收货人信息/商家信息/发票信息-->
	<div class="whitebg br1 mt20 ovh">
		<!--收货人信息-->
		<div class="consignee bbright">
			<h1 style="font-size:16px;">{{trans('home.consignee_info')}}</h1>
			<span class="ml20 db mt20">
			<span class="fl">{{trans('home.consignee_name')}}:</span>
			<span class="ml20">{{$orderDetailsInfo['orderInfo']['consignee']}}</span>
		</span>
			<span class="ml20 db mt5">
			<span class="fl">{{trans('home.mobile')}}: </span>
			<span class="ml10">{{$orderDetailsInfo['orderInfo']['mobile_phone']}}</span>
		</span>
			<span class="ml20 ovh db mt5">
			<span class="fl">{{trans('home.shipping_address')}}:</span>
			<span class="fl consignee_addr">
				{{$orderDetailsInfo['country']}}{{$orderDetailsInfo['province']}}{{$orderDetailsInfo['city']}}{{$orderDetailsInfo['district']}}<br>{{$orderDetailsInfo['orderInfo']['address']}}
			</span>
		</span>
			<span class="ml20 db mt5">
			<span class="fl">{{trans('home.buyer_message')}}: </span>
			<span class="ml10">{{$orderDetailsInfo['orderInfo']['postscript']}}</span>
		</span>
		</div>
		<!--商家信息-->
		<div class="consignee bbright">
			<!-- 商家信息 -->

			<h1 style="font-size:16px;">{{trans('home.business_info')}}</h1>
			<span class="ml20 db mt20" style="width: 410px" >
			<span class="fl">{{trans('home.company')}} :</span>
			<span class="ml10">{{$orderDetailsInfo['orderInfo']['shop_name']}}</span>
		</span>
			<span class="ml20 db ">
			<span class="fl">{{trans('home.seller_message')}} :</span>
			<span class="ml10">{{$orderDetailsInfo['orderInfo']['to_buyer']}}</span>
		</span>


		</div>

		<!--发票信息-->
		<div class="consignee ">
			<h1 style="font-size:16px;">{{trans('home.invoice_information')}}</h1>
			<span class="ml20 db mt20" >
			<span class="fl">{{trans('home.invoice_title')}}：</span>
			<span class="ml10">
				@if($orderDetailsInfo['userInvoceInfo']['is_firm'])
					{{trans('home.order_detail_enterprise')}}
				@else
					{{trans('home.header_personal')}}
				@endif
			</span>
		</span>
			@if($orderDetailsInfo['userInvoceInfo']['is_firm'])
				<span class="ml20 db ">
				<span class="fl">{{trans('home.company')}} :</span>
				<span class="ml10">{{$orderDetailsInfo['userInvoceInfo']['company_name']}}</span>
			</span>
				<span class="ml20 db ">
				<span class="fl">{{trans('home.tax_id')}} :</span>
				<span class="ml10">{{$orderDetailsInfo['userInvoceInfo']['tax_id']}}</span>
			</span>
			@endif
		</div>
	</div>
	<!--收货人信息/商家信息/发票信息-->
	<div class="whitebg br1 mt20 ovh">

		<!-- 付款凭证 -->
		<div  class="consignee "  style="margin-top: 10px;">

			<div class="payImg bbright" style="margin-top:20px;">
				<h1 style="font-size:16px;margin-left: 0;">{{trans('home.payment_voucher')}}</h1>
				<div class="mt10">
					<span class="fl">{{trans('home.payment_voucher')}}:</span>
					@if(!empty($orderDetailsInfo['orderInfo']['pay_voucher']))
						<div id="layer-photos-demo" class="layer-photos-demo" style="float:left;margin-left:10px;">
							<img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ getFileUrl($orderDetailsInfo['orderInfo']['pay_voucher']) }}" src="{{ getFileUrl($orderDetailsInfo['orderInfo']['pay_voucher']) }}">
						</div>
					@else
						{{trans('home.not_available')}}
					@endif
					<br>
					@if($orderDetailsInfo['orderInfo']['extension_code'] == 'wholesale')
						<div class="" style="float:left;margin-top:25px;">
						<span class="fl" style="margin-top:10px;">{{trans('home.deposit_voucher')}}:</span>
						@if(!empty($orderDetailsInfo['orderInfo']['deposit_pay_voucher']))
							<div id="layer-photos-demo" class="layer-photos-demo" style="float:left;margin-left:10px;">
								<img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ getFileUrl($orderDetailsInfo['orderInfo']['deposit_pay_voucher']) }}" src="{{ getFileUrl($orderDetailsInfo['orderInfo']['deposit_pay_voucher']) }}">
							</div>
						@else
							{{trans('home.not_available')}}
						@endif
						</div>
					@endif
				</div>
			</div>
			<div class="fl mt20">
				<h1 style="font-size:16px;margin-left: 0;">{{trans('home.contract')}}</h1>
				<div class="payImg" style="margin-top: 10px; margin-left: 0px;">
					<span style="margin-top:2px;">{{trans('home.contract')}}:</span>
					@if(!empty($orderDetailsInfo['orderInfo']['contract']))
						<div style="float:right;margin-left:10px;">
							<a href="{{getFileUrl($orderDetailsInfo['orderInfo']['contract'])}}" target="_blank">{{trans('home.download')}}
								<img style="width:100px;" src="{{getFileUrl($orderDetailsInfo['orderInfo']['contract'])}}">
							</a>
						</div>
					@else
						{{trans('home.not_available')}}
					@endif
				</div>
				<div class="payImg" style="margin-top:10px;margin-left: 0px;width: 277px;">
					<span style="margin-top:2px; float: left;width: 25%;">{{trans('home.return_contract')}}:</span>
					@component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/contract','name'=>'contract'])@endcomponent

				</div>
				<div class="payBtn"><input class="payImgSubmit" type="button" name="" value="{{trans('home.sub')}}"></div>

			</div>



		</div>

	</div>
	<!--订单列表-->
	<div class="whitebg br1 mt20 ovh">
		<ul class="order-list-brand">
			<li>
				<span style="width:29%">{{trans('home.goods_name')}}</span>
				<span style="width:20%">{{trans('home.price')}}</span>
				<span style="width:20%">{{trans('home.num')}}</span>
				<span style="width:29%">{{trans('home.order_amount')}}</span>
				<!-- <span>操作</span> -->
			</li>
			@foreach($orderDetailsInfo['goodsInfo'] as $v)
				<li>
					<span class="ovhwp" style="width:29%">{{$v['goods_name']}}</span>
					<span class="ovhwp" style="width:20%">￥{{$v['goods_price']}}/{{$v['unit_name']}} </span>
					<span class="ovhwp" style="width:20%">{{$v['goods_number']}}{{$v['unit_name']}}</span>
					<span class="ovhwp" style="width:29%">￥{{number_format($v['goods_price'] * $v['goods_number'],2)}}</span>
					{{--<span></span>--}}
				</li>
			@endforeach
		</ul>
		<div class="Amount_money">
			<div class="db">
				<span>{{trans('home.total')}}：</span>
				<span class="fr ml20">{{amount_format($orderDetailsInfo['orderInfo']['goods_amount'],2)}}</span>
			</div>
			<div class="db mt15">
				<span class="di">{{trans('home.freight')}}：</span>
				<span class="fr ml20">￥{{$orderDetailsInfo['orderInfo']['shipping_fee']}}</span>
			</div>
			<div class="db mt20 red">
				<span class="lh35">{{trans('home.total_payable')}}：</span>
				<span class="fr ml20 fs22">{{amount_format($orderDetailsInfo['orderInfo']['order_amount'],2)}}</span>
			</div>
		</div>
	</div>

</div>




@include(themePath('.','web').'web.include.partials.footer_service')
@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')
<script type="text/javascript">
    $(function(){
        //请求快递物流信息
		$('.getLogistics').each(function(){
            getLogisticsInfo(this);
		});

        //调用示例
        layer.photos({
            photos: '.layer-photos-demo'
            ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
        });
        $('.payBtn').click(function(){
            var contract = $('input[name=contract]').val();
            var orderno = '{{$orderDetailsInfo['orderInfo']['id']}}';
            if(contract == '' || orderno == ''){
                $.msg.alert('{{trans('home.choose_contract')}}');
                return;
            }
            $.ajax({
                url:'/checkOrderContract',
                type:'post',
                data:{'contract':contract,'orderno':orderno},
                dataType:'json',
                success:function(res){
                    if(res.code){
                        $.msg.alert(res.msg);
                        window.location.reload();
                    }else{
                        $.msg.alert(res.msg);
                    }
                },
                error:function(){
                    $.msg.alert('{{trans('home.system_busy')}}');
                }
            })
        })
    });
    //
    function getLogisticsInfo(obj){
        var _delivery_id = $(obj).find('.wlxx').data('delivery_id');
        if(_delivery_id != 0){
            $.ajax({
                url: "/logistics/detail",
                dataType: "json",
                data:{
                    'id': _delivery_id
                },
                type:"get",
                success:function(data){
                    if(data.code == 1){
                        var _list = data.data.Traces;
                        var _length = data.data.Traces.length;
                        var _html = '';

                        for(var i=(_length-1); i>=0; i--){
                            _html += '<li><i class="external-cir"></i>'+_list[i].AcceptStation+'<div class="gray">'+_list[i].AcceptTime+'</div></li>';
                        }
                        if(_html == ''){
                            _html = '<li><i class="external-cir"></i>{{trans('home.no_logistics_info_tips')}}<div class="gray"></div></li>'
                        }
                        $(obj).find('.wlxx').append(_html);
                    }else{
						//物流单第三方查询失败 查询站内维护物流信息
                        getInstationLogisticsInfo(obj);
                    }
                },
                error:function(){
                    var _html = '<li><i class="external-cir"></i>{{trans('home.no_logistics_info_tips')}}<div class="gray"></div></li>';
                    $(obj).find('.wlxx').append(_html);
                }
            })
        }else{
            var _html = '<li><i class="external-cir"></i>{{trans('home.not_shipped_tips')}}<div class="gray"></div></li>';
            $(obj).find('.wlxx').append(_html);
        }

    }
    function getInstationLogisticsInfo(obj){
        var _delivery_id = $(obj).find('.wlxx').data('delivery_id');
        if(_delivery_id != 0){
            $.ajax({
                url: "/logistics/instation",
                dataType: "json",
                data:{
                    'id': _delivery_id
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
                        $(obj).find('.wlxx').append(_html);
                    }else{
                        //物流单第三方查询失败 查询站内维护物流信息
                        var _html = '<li><i class="external-cir"></i>{{trans('home.no_logistics_info_tips')}}<div class="gray"></div></li>';
                        $(obj).find('.wlxx').append(_html);
                        // $.msg.alert(data.msg);
                    }
                },
                error:function(){
                    var _html = '<li><i class="external-cir"></i>{{trans('home.no_logistics_info_tips')}}<div class="gray"></div></li>';
                    $(obj).find('.wlxx').append(_html);
                }
            })
        }else{
            var _html = '<li><i class="external-cir"></i>{{trans('home.not_shipped_tips')}}<div class="gray"></div></li>';
            $(obj).find('.wlxx').append(_html);
        }

    }
</script>
</body>
</html>

