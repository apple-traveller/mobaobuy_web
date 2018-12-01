@extends(themePath('.','web').'web.include.layouts.home')
@section('title', '集采拼团')
@section('css')
	<link rel="stylesheet" type="text/css" href="{{asset('plugs/layui/css/layui.css')}}" />
	<link rel="stylesheet" href="css/index.css" />
	<style>
		.nav-div .nav-cate .ass_menu {display: none;}
		.top-search-div .search-div .logo{background:none;margin-top: 0}
		.bottom_time{width: 154px;color: #666;float: left;text-align: left;}
		.bottom_btn {width: 96px;float: right;text-align: center;height: 38px;border-radius: 5px;line-height: 35px;}

		.collect_bananer{height: 554px;}
		.collect_bananer_01{height: 277px;background: url(/default/img/collect_banner_01.jpg)no-repeat center;}
		.collect_bananer_02{height: 277px;background: url(/default/img/collect_banner_02.jpg)no-repeat center;}
		.collect_bg{background-color: #f25802;}
		.collect_main{width: 1200px; margin: 0 auto;overflow: hidden;}
		.collect_title{text-align:center;height:50px;line-height:50px;font-size:30px;color:#fff;background: url(/default/img/collect_title.png)no-repeat center;}

		.ms_list{width: 1200px;margin: 0 auto;margin-left: -10px;margin-bottom: 20px;overflow: hidden;}
		.ms_list li{float:left;margin-left:10px;margin-top:15px;width: 290px;background-color: #fff;overflow: hidden;}
		.ms_list_center{width: 250px;margin: 0 auto;margin-top: 20px;}
		.ms_list_center .mx_addr{height: 32px;line-height:30px;font-size: 17px;border: 1px solid #f93b0b;color:#f42424;background-color:#fff3ee;box-sizing: border-box;text-align: left;padding:0 5px;}
		.mx_progress{width: 156px;height:10px;background-color: #eeeeee;float: left;margin-top: 8px;margin-right: 5px}
		.mx_progress_com{height:10px;
			background: -webkit-linear-gradient(left,rgba(229,30,53,1),rgba(255,86,23,1)); /* Safari 5.1 - 6 */
			background: -o-linear-gradient(right,rgba(229,30,53,1),rgba(255,86,23,1)); /* Opera 11.1 - 12*/
			background: -moz-linear-gradient(right,rgba(229,30,53,1),rgba(255,86,23,1)); /* Firefox 3.6 - 15*/
			background: linear-gradient(to right, rgba(229,30,53,1), rgba(255,86,23,1)); /* 标准的语法 */
		}
		.addr_dw{background: url(/default/img/dwzb.png)no-repeat 0px 2px;padding-left: 20px;color: #666;}
		.mx_price{width: 250px; height: 65px;line-height: 65px;margin-top:15px;margin-bottom:10px;text-align: center;background-color: #fff1ec;font-size: 16px;}
		.mx_btn{width: 252px;height: 46px;line-height:46px;margin-bottom:25px;color:#fff;text-align:center;background: #f42424 url(/default/img/xs_action_icon.png)no-repeat 60px 12px;border-radius:3px;font-size: 22px;cursor: pointer;}

		.collect_end_time{height: 35px;line-height: 35px;
			background-color: #f25802;color: #fff;width: 250px;border-bottom-right-radius: 20px;
			border-top-right-radius: 20px;text-align: center;margin-top: 20px;font-size: 16px;
		}
		.collect_active_bg{
			background-color: #eb3505;
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
	<div class="collect_bananer">
		<div class="collect_bananer_01"></div>
		<div class="collect_bananer_02"></div>
	</div>
	<div class="collect_bg ovh">
		<div class="collect_main">
			<div class="collect_title">集采火拼</div>
			<div class="w1200 ovh">
				<ul class="ms_list">
					@if(empty($wholesaleInfo))
					<div class="nodata"><li>无相关数据</li></div>
					@else
						@foreach($wholesaleInfo as $v)
							<li>
								@if($v['is_over'])
									<div class="collect_end_time " id="collect_end_time"  >
										距离结束：<span id="End_time" class="count-down-text">0天0小时0分钟0秒</span>
									</div>
								@elseif($v['is_soon'])
									<div class="collect_end_time count-down" id="collect_end_time" data-endtime="{{$v['begin_time']}}">
										距离开始：<span id="End_time" class="count-down-text">0天0小时0分钟0秒</span>
									</div>
								@else
									<div class="collect_end_time count-down" data-endtime="{{$v['end_time']}}">
										距离结束：<span class="count-down-text">0天0小时0分钟0秒</span>
									</div>
								@endif
								<div class="ms_list_center">
									<div class="ovh">
										<h1 class="fs20 ovhwp" style="height: 36px;" title="{{$v['goods_name']}}">{{$v['goods_name']}}</h1>
									</div>
									<div class="ovh mt10">
										<div class="mx_addr fl">{{$v['shop_name']}}</div>
										{{--<div class="mx_addr fl ml15" style="width: 117px;">自提</div>--}}
									</div>
									<div class="ovh mt20 ">
										<div class="mx_progress">
											@if((float)$v['partake_quantity'] <= 0)
												<div class="mx_progress_com" style="width: 0%;"></div>
											@elseif((float)$v['num'] <= 0)
												<div class="mx_progress_com" style="width: 100%;"></div>
											@else
												<div class="mx_progress_com" style="width: {{(int)((float)$v['partake_quantity']*100/(float)$v['num'])}}%;"></div>
											@endif
										</div>
										@if((float)$v['partake_quantity'] <= 0)
											<span class="fl fs16 gray">已参与0%</span>
										@elseif((float)$v['num'] <= 0)
											<span class="fl fs16 gray">已参与100%</span>
										@else
											<span class="fl fs16 gray">已参与{{(int)((float)$v['partake_quantity']*100/(float)$v['num'])}}%</span>
										@endif

									</div>
									<div class="tac mt20 ovh">
										<span class="fr pt10 ovh di gray">
											<span style="margin: 0 20px 0 0">目标：{{$v['num']}}kg</span>
											<font class="orange">{{$v['click_count']}}</font>次浏览
										</span>
									</div>
									<div class="mx_price">
										<font class="gray">单价不超过</font>
										<font class="orange fs24">￥{{$v['price']}}</font>/kg
									</div>
									@if($v['is_over'])
										<div class="mx_btn" style='background: #b1b1b1;'>已结束</div>
									@elseif($v['is_soon'])
										<div class="mx_btn" style='background: #b1b1b1;'>敬请期待</div>
									@else
										<a href="/wholesale/detail/{{encrypt($v['id'])}}"><div class="mx_btn">立即参与</div></a>
									@endif
								</div>
							</li>
						@endforeach
					@endif
				</ul>

			</div>
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



