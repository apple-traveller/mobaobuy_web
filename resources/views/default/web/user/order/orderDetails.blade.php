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
@component(themePath('.','web').'web.include.partials.top_title', ['title_name' => '会员中心'])@endcomponent
<div class="w1200" style="margin-bottom: 40px;">
	<div class="crumbs" style="margin: 15px 0;">当前位置：<a href="/member">会员中心</a> &gt;<a href="/order/list">我的订单</a> &gt;<span class="gray">订单详情</span></div>
	<div class="order_pro_progress whitebg mt5">
		<div class="order_pro_stute">
			<span class="Order_number">订单单号：{{$orderDetailsInfo['orderInfo']['order_sn']}}</span>
			<span class="Order_number">订单来源：{{ getOrderFromText($orderDetailsInfo['orderInfo']['extension_code']) }}</span>
			@if($orderDetailsInfo['orderInfo']['order_status'] == 0)
				<span class="tac db fs24 fwb red mt30">已作废</span>
			@elseif($orderDetailsInfo['orderInfo']['order_status'] == 1)
				<span class="tac db fs24 fwb red mt30">待企业审核</span>
			@elseif($orderDetailsInfo['orderInfo']['order_status'] == 2)
				<span class="tac db fs24 fwb red mt30">待商家确认</span>
			@elseif($orderDetailsInfo['orderInfo']['order_status'] == 3)
				<span class="tac db fs24 fwb red mt30">已确认</span>
			@elseif($orderDetailsInfo['orderInfo']['order_status'] == 4)
				<span class="tac db fs24 fwb red mt30">已完成</span>
			@elseif($orderDetailsInfo['orderInfo']['order_status'] == 5)
				<span class="tac db fs24 fwb red mt30">待开票</span>
			@endif
		</div>
		<div class="order_pro_jd fl">
			<!-- <div class="order_jd_bg order_jd_bg1"></div> -->
			<ul  class="order_jd_text">
				<li>
					<img class="imgInfor" src="{{asset('/img/status_pay00.png')}}">

					<span class="jd_text_con black">提交订单</span>
					<span class="jd_text_date">{{$orderDetailsInfo['orderInfo']['add_time']}}</span>


				</li>

				@if(!empty($orderDetailsInfo['orderInfo']['confirm_time']))
					<li>
						<img  class="imgInfor" src="{{asset('/img/status_pay01.png')}}">
						<span class="jd_text_con black">卖家确认</span>
						<span class="jd_text_date">{{$orderDetailsInfo['orderInfo']['confirm_time']}}</span>
					</li>
				@endif

				@if(!empty($orderDetailsInfo['orderInfo']['pay_time']))
					<li>
						<img class="imgInfor" src="{{asset('/img/status_pay02.png')}}">
						<span class="jd_text_con black">付款时间</span>
						<span class="jd_text_date">{{$orderDetailsInfo['orderInfo']['pay_time']}}</span>
					</li>
				@endif

				@if(!empty($orderDetailsInfo['orderInfo']['shipping_time']))
					<li>
						<img class="imgInfor" src="{{asset('/img/status_pay03.png')}}">
						<span class="jd_text_con black">发货时间</span>
						<span class="jd_text_date">{{$orderDetailsInfo['orderInfo']['shipping_time']}}</span>
					</li>
				@endif

				@if(!empty($orderDetailsInfo['orderInfo']['shipping_time']))
					<li>
						<img class="imgInfor" src="{{asset('/img/status_pay04.png')}}">
						<span class="jd_text_con black">运输中</span>
						<span class="jd_text_date"></span>
					</li>
				@endif

				@if(!empty($orderDetailsInfo['orderInfo']['confirm_take_time']))

					<li>
						<img class="imgInfor" src="{{asset('/img/status_pay05.png')}}">
						<span class="jd_text_con black">确认收货时间</span>
						<span class="jd_text_date">{{$orderDetailsInfo['orderInfo']['confirm_take_time']}}</span>
					</li>
				@endif
			</ul>
		</div>
	</div>
	<!--物流信息-->
	<div class="whitebg br1 mt20 ovh">
		<div class="order_pro_stute">
			@if(!empty($orderDetailsInfo['delivery_info']))
				<span class="ml30 mt10 db" >本订单由第三方卖家为您发货</span>
				<span class="ml30 db mt20">
				@foreach($orderDetailsInfo['delivery_info'] as $k=>$v)
						物流公司：<span data-delivery_id="{{$v['id']}}">{{$v['shipping_name']}}</span><br>
						物流单号：<span @if($k+1 == count($orderDetailsInfo['delivery_info'])) data-delivery_id="{{$v['id']}}" id="delivery_id" @endif>{{$v['shipping_billno']}}</span><br>
					@endforeach
			</span>
			@else
				<span class="ml30 mt10 db" id="delivery_id" data-delivery_id="0">等待商家发货</span>
			@endif
		</div>
		<div class="fl wlgz_text">
			<ul class="wlxx">

			</ul>
		</div>
	</div>
	<!--收货人信息/商家信息/发票信息-->
	<div class="whitebg br1 mt20 ovh">
		<!--收货人信息-->
		<div class="consignee bbright">
			<h1 style="font-size:16px;">收货人信息</h1>
			<span class="ml20 db mt20">
			<span class="fl">收  货  人:</span>
			<span class="ml20">{{$orderDetailsInfo['orderInfo']['consignee']}}</span>
		</span>
			<span class="ml20 db mt5">
			<span class="fl">手机号码: </span>
			<span class="ml10">{{$orderDetailsInfo['orderInfo']['mobile_phone']}}</span>
		</span>
			<span class="ml20 ovh db mt5">
			<span class="fl">收货地址:</span>
			<span class="fl consignee_addr">
				{{$orderDetailsInfo['country']}}{{$orderDetailsInfo['province']}}{{$orderDetailsInfo['city']}}{{$orderDetailsInfo['district']}}<br>{{$orderDetailsInfo['orderInfo']['address']}}
			</span>
		</span>
			<span class="ml20 db mt5">
			<span class="fl">买家留言: </span>
			<span class="ml10">{{$orderDetailsInfo['orderInfo']['postscript']}}</span>
		</span>
		</div>
		<!--商家信息-->
		<div class="consignee bbright">
			<!-- 商家信息 -->

			<h1 style="font-size:16px;">商家信息</h1>
			<span class="ml20 db mt20" style="width: 410px" >
			<span class="fl">公司名称 :</span>
			<span class="ml10">{{$orderDetailsInfo['orderInfo']['shop_name']}}</span>
		</span>
			<span class="ml20 db ">
			<span class="fl">卖家留言 :</span>
			<span class="ml10">{{$orderDetailsInfo['orderInfo']['to_buyer']}}</span>
		</span>


		</div>

		<!--发票信息-->
		<div class="consignee ">
			<h1 style="font-size:16px;">发票信息</h1>
			<span class="ml20 db mt20" >
			<span class="fl">发票抬头：</span>
			<span class="ml10">
				@if($orderDetailsInfo['userInvoceInfo']['is_firm'])
					企业
				@else
					个人
				@endif
			</span>
		</span>
			@if($orderDetailsInfo['userInvoceInfo']['is_firm'])
				<span class="ml20 db ">
				<span class="fl">公司名称 :</span>
				<span class="ml10">{{$orderDetailsInfo['userInvoceInfo']['company_name']}}</span>
			</span>
				<span class="ml20 db ">
				<span class="fl">税号 :</span>
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
				<h1 style="font-size:16px;margin-left: 0;">付款凭证</h1>
				<div class="mt10">
					<span class="fl">支付凭证:</span>
					@if(!empty($orderDetailsInfo['orderInfo']['pay_voucher']))
						<div id="layer-photos-demo" class="layer-photos-demo" style="float:left;margin-left:10px;">
							<img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ getFileUrl($orderDetailsInfo['orderInfo']['pay_voucher']) }}" src="{{ getFileUrl($orderDetailsInfo['orderInfo']['pay_voucher']) }}">

							@else
								暂无
							@endif
						</div>

				</div>
			</div>
			<div class="fl mt20">
				<h1 style="font-size:16px;margin-left: 0;">合同</h1>
				<div class="payImg" style="margin-top: 10px; margin-left: 0px;">
					<span style="margin-top:2px;">合同:</span>
					@if(!empty($orderDetailsInfo['orderInfo']['contract']))
						<div style="float:right;margin-left:10px;">
							<a href="{{getFileUrl($orderDetailsInfo['orderInfo']['contract'])}}" target="_blank">下载
								<img style="width:100px;" src="{{getFileUrl($orderDetailsInfo['orderInfo']['contract'])}}">
							</a>
						</div>
					@else
						暂无
					@endif
				</div>
				<div class="payImg" style="margin-top:10px;margin-left: 0px;width: 277px;">
					<span style="margin-top:2px; float: left;width: 25%;">回传合同:</span>
					@component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/contract','name'=>'contract'])@endcomponent

				</div>
				<div class="payBtn"><input class="payImgSubmit" type="button" name="" value="提交"></div>

			</div>



		</div>

	</div>
	<!--订单列表-->
	<div class="whitebg br1 mt20 ovh">
		<ul class="order-list-brand">
			<li>
				<span style="width:29%">商品名称</span>
				<span style="width:20%">单价</span>
				<span style="width:20%">数量</span>
				<span style="width:29%">金额</span>
				<!-- <span>操作</span> -->
			</li>
			@foreach($orderDetailsInfo['goodsInfo'] as $v)
				<li>
					<span class="ovhwp" style="width:29%">{{$v['goods_name']}}</span>
					<span class="ovhwp" style="width:20%">￥{{$v['goods_price']}} </span>
					<span class="ovhwp" style="width:20%">{{$v['goods_number']}}kg</span>
					<span class="ovhwp" style="width:29%">￥{{number_format($v['goods_price'] * $v['goods_number'],2)}}</span>
					{{--<span></span>--}}
				</li>
			@endforeach
		</ul>
		<div class="Amount_money">
			<div class="db">
				<span>商品总额：</span>
				<span class="fr ml20">{{amount_format($orderDetailsInfo['orderInfo']['goods_amount'],2)}}</span>
			</div>
			<div class="db mt15">
				<span class="di">运       费：</span>
				<span class="fr ml20">￥{{$orderDetailsInfo['orderInfo']['shipping_fee']}}</span>
			</div>
			<div class="db mt20 red">
				<span class="lh35">应付总额：</span>
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
        getLogisticsInfo();

        //调用示例
        layer.photos({
            photos: '.layer-photos-demo'
            ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
        });
        $('.payBtn').click(function(){
            var contract = $('input[name=contract]').val();
            var orderno = '{{$orderDetailsInfo['orderInfo']['id']}}';
            if(contract == '' || orderno == ''){
                $.msg.alert('请选择合同后提交');
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
                    $.msg.alert('系统繁忙，请重试');
                }
            })
        })
    });
    //
    function getLogisticsInfo(){
        var _delivery_id = $('#delivery_id').data('delivery_id');
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
                        console.log(_html);
                        if(_html == ''){
                            _html = '<li><i class="external-cir"></i>暂时无法获取到该订单物流跟踪信息，请于商家联系。<div class="gray"></div></li>'
                        }
                        $('.wlxx').append(_html);
                    }else{
						//物流单第三方查询失败 查询站内维护物流信息
                        getInstationLogisticsInfo();
//                        var _html = '<li><i class="external-cir"></i>暂时无法获取到该订单物流跟踪信息，请于商家联系。<div class="gray"></div></li>';
//                        $('.wlxx').append(_html);
                        // $.msg.alert(data.msg);
                    }
                },
                error:function(){
                    var _html = '<li><i class="external-cir"></i>暂时无法获取到该订单物流跟踪信息，请于商家联系。<div class="gray"></div></li>';
                    $('.wlxx').append(_html);
                }
            })
        }else{
            var _html = '<li><i class="external-cir"></i>商家还未发货，暂无物流信息。<div class="gray"></div></li>';
            $('.wlxx').append(_html);
        }

    }
    function getInstationLogisticsInfo(){
        var _delivery_id = $('#delivery_id').data('delivery_id');
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
                        console.log(_html);
                        if(_html == ''){
                            _html = '<li><i class="external-cir"></i>暂时无法获取到该订单物流跟踪信息，请于商家联系。<div class="gray"></div></li>'
                        }
                        $('.wlxx').append(_html);
                    }else{
                        //物流单第三方查询失败 查询站内维护物流信息
                        var _html = '<li><i class="external-cir"></i>暂时无法获取到该订单物流跟踪信息，请于商家联系。<div class="gray"></div></li>';
                        $('.wlxx').append(_html);
                        // $.msg.alert(data.msg);
                    }
                },
                error:function(){
                    var _html = '<li><i class="external-cir"></i>暂时无法获取到该订单物流跟踪信息，请于商家联系。<div class="gray"></div></li>';
                    $('.wlxx').append(_html);
                }
            })
        }else{
            var _html = '<li><i class="external-cir"></i>商家还未发货，暂无物流信息。<div class="gray"></div></li>';
            $('.wlxx').append(_html);
        }

    }
</script>
</body>
</html>

