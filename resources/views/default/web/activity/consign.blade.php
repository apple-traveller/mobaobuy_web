@extends(themePath('.','web').'web.include.layouts.home')
@section('title', '清仓特卖')
@section('css')
	<link rel="stylesheet" type="text/css" href="{{asset('plugs/layui/css/layui.css')}}" />
	
	<style>
		.Rules_activity{margin-left:48px;margin-top:40px;width: 134px;height: 44px;line-height: 44px;background-color: #f8e509;border-radius:20px;text-align: center;font-size: 20px;color: #c42809;font-weight: bold;}
.Rules_text{margin-left:48px;margin-top: 20px;margin-bottom: 40px;}
.Rules_text li{margin-top: 10px;color: #fff;font-size: 18px;}
.ms_list{width: 1200px;margin: 0 auto;margin-left: -5px;margin-bottom: 20px;overflow: hidden;}
.ms_list li{float:left;margin-left:10px;margin-top:15px;width: 290px;background-color: #fff;overflow: hidden;padding-bottom: 10px;}
.ms_list_center{width: 250px;margin: 0 auto;margin-top: 35px;}
.ms_list_center .mx_addr{height: 32px;line-height:30px;border: 1px solid #c9e1b1;color:#75b335;background-color:#f6fbf1;box-sizing: border-box;text-align: center;}
.mx_progress{width: 172px;height:10px;background-color: #eeeeee;float: left;margin-top: 8px;margin-right: 50px;}
.mx_progress_com{width: 62px;height:10px;background-color: #75b335;}
.addr_dw{background: url(/images/dwzb.png)no-repeat 0px 2px;padding-left: 20px;color: #666;}
.mx_price{width: 250px; height: 65px;line-height: 65px;margin-top:15px;margin-bottom:10px;text-align: center;background-color: #f6fbf1;font-size: 16px;}
.mx_btn{width: 252px;height: 58px;line-height:58px;margin-bottom:25px;color:#fff;text-align:center;background: #f42424 url(/images/xs_ms.png)no-repeat 63px 21px;border-radius:3px;font-size: 22px;}
		.nav-div .nav-cate .ass_menu {display: none;}
		.top-search-div .search-div .logo{background:none;margin-top: 0}
		.bottom_time{width: 154px;color: #666;float: left;text-align: left;}
		.bottom_btn {width: 96px;float: right;text-align: center;height: 38px;border-radius: 5px;line-height: 35px;}
		.ClearSale_banner{height: 539px;background: url(/default/img/ClearSale_banner.jpg)no-repeat center;}
		.ClearSale_bg{background-color: #db0505;}
		.ClearSale_main{width: 1200px;margin: 0 auto;}
		.ClearSale_title{height:70px;background: url(/default/img/ClearSale_title.png)no-repeat center;}
		.ClearSale_seize{width:1200px;margin: 30px auto 10px;text-align: center;}
		.ms_list_center .bq__addr {height: 32px;line-height: 30px;border: 1px solid #ffa800;color: #ff6000;
			background-color: #fff6f0;box-sizing: border-box;text-align: left;padding:0 5px;}
		.bq__progress_com {height: 10px; background-color: #ffba00;}
		.bq_price {width: 250px;height: 65px;line-height: 65px;margin-top: 15px;margin-bottom: 10px;text-align: center;background-color: #fff6f0;font-size: 16px;}
		.mx_progress{
			margin-right: 5px;
		}
	</style>

@endsection
@section('js')
	<script src="{{asset(themePath('/', 'web').'js/index.js')}}" ></script>
	<script type="text/javascript">
		$(function(){
			$(".nav-cate").hover(function(){
				$(this).children('.ass_menu').toggle();// 鼠标悬浮时触发
			});
		})
	</script>
@endsection
@section('content')
	<div class="ClearSale_banner"></div>
	<div class="ClearSale_bg ovh">
		<div class="ClearSale_main">
			<div class="ClearSale_title"></div>
			<div class="ClearSale_seize"><img src="/default/img/seize.png"/></div>
			@if(!empty($consignInfo))
				<ul class="ms_list">

						@foreach($consignInfo as $v)
							<li>
								<div class="ms_list_center">
									<div class="ovh">
										<h1 class="fs20" title="{{$v['goods_name']}}" style="height: 36px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$v['goods_name']}}</h1>
									</div>
									<div class="ovh mt10">
										<div class="bq__addr fl">{{$v['shop_name']}}</div>
									</div>
									<div class="ovh mt10 ">
										<div class="mx_progress">
											@if((int)((float)$v['total_number']-(float)$v['goods_number']) == 0)
												<div class="bq__progress_com" style="width: 0%;"></div>
											@else
												<div class="bq__progress_com" style="width: {{(int)(((float)$v['total_number']-(float)$v['goods_number'])*100/(float)$v['total_number'])}}%;"></div>
											@endif

										</div>
										@if((int)((float)$v['total_number']-(float)$v['goods_number']) == 0)
											<span class="fl fs16 gray">已售0%</span>
										@else
											<span class="fl fs16 gray">已售{{(int)(((float)$v['total_number']-(float)$v['goods_number'])*100/(float)$v['total_number'])}}%</span>
										@endif
									</div>
									<div class="tac mt30 ovh" style="text-align: left !important;">
										<span class="addr_dw">{{$v['delivery_place']}}</span>
										<span class="fr ovh di gray">可售 {{$v['goods_number']}}kg</span>
									</div>
									<div class="bq_price">
										<font class="gray">单价</font>
										<font class="orange fs24">￥{{$v['shop_price']}}</font>/kg
									</div>
									<a href="/consign/detail/{{encrypt($v['id'])}}">
										<div class="mx_btn">立即抢购</div>
									</a>
								</div>
							</li>
						@endforeach
					</ul>
				@else
					<ul>
						<li class="nodata">暂无活动 敬请期待</li>
					</ul>
				@endif

		</div>
		<div class="w1200 collect_active_bg ovh" style="margin-bottom: 30px;">

			<div class="Rules_activity">活动规则</div>
			<ul class="Rules_text">
				<li>1.本活动对所有会员开放</li>
				<li>2.集采火拼活动订单需要在30分钟内完成支付，逾期未付款，系统将自动取消订单</li>
				<li>3.如有任何疑问，请联系在线客服或拨打免费服务热线：400-100-1234</li>
			</ul>
		</div>
	</div>

@endsection



