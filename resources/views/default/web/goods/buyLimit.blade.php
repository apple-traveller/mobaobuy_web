@extends(themePath('.','web').'web.include.layouts.home')
@section('title', '限时抢购')
@section('css')
	<link rel="stylesheet" type="text/css" href="{{asset('plugs/layui/css/layui.css')}}" />
	<link rel="stylesheet" href="css/global.css" />
	<link rel="stylesheet" href="css/index.css" />
	<style>
		.nav-div .nav-cate .ass_menu {display: none;}
		.top-search-div .search-div .logo{
			background:none;
		}
	</style>

@endsection
@section('js')
		<script type="text/javascript">
			$(function(){
                $(".nav-cate").hover(function(){
                    $(this).children('.ass_menu').toggle();// 鼠标悬浮时触发
                });
				function Remaine_time(ntime,nday,nhour,nminute,nsecond){
					var intDiff=parseInt(ntime);//总秒数
					window.setInterval(function(){
						var day=0,hour=0,minute=0,second=0;
						if(intDiff>0){
							day=Math.floor(intDiff/(60*60*24));
							hour=Math.floor(intDiff/(60*60))-(day*24);
							minute=Math.floor(intDiff/60)-(day*24*60)-(hour*60);
							second=Math.floor(intDiff)-(day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
						}
						if(hour<=9)hour='0'+hour;
						if(minute<=9)minute='0'+minute;
						if(second<=9)second='0'+second;
						nday.html(day+"天");
						nhour.html('<s></s>'+hour);
						nminute.html('<s></s>'+minute);
						nsecond.html('<s></s>'+second);
						intDiff--;
					},1000)

				}
				Remaine_time(10800,$('.day_show1'),$('.hour_show1'),$('.minute_show1'),$('.second_show1'));
			})
		</script>
@endsection
@section('content')
	<div class="limit_bg">
		<div class="ms_title"></div>
		<div class="limit_date">2018年10月1日-2018年10月31日</div>
		
		
		<div class="w1200 ovh">
		<ul class="ms_list">
			@if(empty($promoteInfo))
				无抢购活动
			@else
				@foreach($promoteInfo as $v)
				<li>
					<div class="ms_list_center">
						<div class="ovh">
							<h1 class="fs24 fl" style="height: 36px;">{{$v['goods_name']}}</h1><span class="fr pt10 ovh di"><font class="orange">{{$v['click_count']}}</font>次浏览</span>
						</div>
						<div class="ovh mt30">
							<div class="mx_addr fl" style="width: 117px;">{{$v['shop_name']}}</div><div class="mx_addr fl ml15" style="width: 117px;">{{$v['num']}}公斤</div>
						</div>
						<div class="ovh mt20 ">
							<div class="mx_progress"><div class="mx_progress_com"></div></div><span class="fl fs16 ml10 gray">可售{{$v['available_quantity']}}公斤</span>
						</div>
						<!-- <div class="tac mt40 ovh"><span class="addr_dw">上海  浦东新区</span></div> -->
						<div class="mx_price"><font class="gray">单价</font> <font class="orange fs24">￥{{$v['price']}}</font>\公斤</div>
						<div class="mx_btn"><a href="/buyLimitDetails/{{encrypt($v['id'])}}">立即抢购</a></div>
					</div>
				</li>
				@endforeach
			@endif
		</ul>
	
	</div>
	<div class="w1200 redbg ovh" style="margin-bottom: 30px;">
		
		<div class="Rules_activity">活动规则</div>
		<ul class="Rules_text">
			<li>1.本活动对所有会员开放</li>
			<li>2.秒杀订单需要在2个工作日内完成支付，逾期未付款，系统将自动取消订单</li>
			<li>3.如有任何疑问，请联系在线客服或拨打免费服务热线：400-100-1234</li>
		</ul>
	</div>
	</div>
@endsection



