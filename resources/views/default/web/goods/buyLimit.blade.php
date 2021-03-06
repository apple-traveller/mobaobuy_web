@extends(themePath('.','web').'web.include.layouts.home')
@section('title', getSeoInfoByType('promote')['title'])
@section('keywords', getSeoInfoByType('promote')['keywords'])
@section('description', getSeoInfoByType('promote')['description'])
@section('css')
	<link rel="stylesheet" type="text/css" href="{{asset('plugs/layui/css/layui.css')}}" />
	{{--<link rel="stylesheet" href="css/index.css" />--}}
	<style>
		.ms_list{width: 1200px;margin: 0 auto;margin-left: -5px;margin-bottom: 20px;overflow: hidden;}
		.ms_list li{float:left;margin-left:10px;margin-top:15px;width: 290px;background-color: #fff;overflow: hidden;padding-bottom: 10px;}
		.ms_list_center{width: 250px;margin: 0 auto;margin-top: 35px;}
		.ms_list_center .mx_addr{height: 32px;line-height:30px;border: 1px solid #c9e1b1;color:#75b335;background-color:#f6fbf1;box-sizing: border-box;text-align: center;}
		.mx_progress{width: 172px;height:10px;background-color: #eeeeee;float: left;margin-top: 8px;margin-right: 50px;}
		.mx_progress_com{width: 62px;height:10px;background-color: #75b335;}
		.addr_dw{background: url(/images/dwzb.png)no-repeat 0px 2px;padding-left: 20px;color: #666;}
		.mx_price{width: 250px; height: 65px;line-height: 65px;margin-top:15px;margin-bottom:10px;text-align: center;background-color: #f6fbf1;font-size: 16px;}
		.mx_btn{width: 252px;height: 58px;line-height:58px;margin-bottom:25px;color:#fff;text-align:center;background: #f42424 url(/images/xs_ms.png)no-repeat 63px 21px;border-radius:3px;font-size: 22px;}
		.ms_title {
			width: 557px;
			margin: 65px auto 30px;
			height: 178px;
			background: url(/images/xsms_title.png)no-repeat;
		}
		.Rules_activity{margin-left:48px;margin-top:40px;width: 134px;height: 44px;line-height: 44px;background-color: #f8e509;border-radius:20px;text-align: center;font-size: 20px;color: #c42809;font-weight: bold;}
		.Rules_text{margin-left:48px;margin-top: 20px;margin-bottom: 40px;}
		.Rules_text li{margin-top: 10px;color: #fff;font-size: 18px;}
		.limit_bg {
			background: url(/images/limit_bg.png)no-repeat;
			background-size: 100% 100%;
			width: 100%;
			overflow: hidden;
		}
		.nav-div .nav-cate .ass_menu {display: none;}
		.top-search-div .search-div .logo{background:none;margin-top: 0px}
		.bottom_time{width: 154px;color: #666;float: left;text-align: left;}
		.bottom_btn {width: 96px;float: right;text-align: center;height: 38px;border-radius: 5px;line-height: 35px;}
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
	<div class="limit_bg">
		<div class="ms_title"></div>
		<div class="w1200 ovh">
			@if(empty($promoteInfo))
				<li class="nodata" style="font-size:30px;">{{trans('home.none_activity')}}</li>
			@else
			<ul class="ms_list">
				@foreach($promoteInfo as $v)
				<li>
					<div class="ms_list_center">
						<div class="ovh">
							<h2 class="fs18 fl ovhwp" style="height: 36px;width:250px;">{{getLangData($v,'goods_name')}}</h2><span class=" ovh di"><font class="orange"> {{$v['click_count']}} </font>{{trans('home.browse')}}</span>
						</div>
						<div class="ovh mt10">
							<div class="mx_addr fl" style="width: 117px;">{{getLangData($v,'shop_name')}}</div><div class="mx_addr fl ml15" style="width: 117px;">{{$v['num']}}{{$v['unit_name']}}</div>
						</div>
						<div class="ovh mt10 ">
							<div class="mx_progress" style="width:250px;">
								@if($v['available_quantity'] <= 0)
									<div class="mx_progress_com" style="width: 0%"></div>
								@elseif($v['num'] <= 0)
									<div class="mx_progress_com" style="width: 100%"></div>
								@else
									<div class="mx_progress_com" style="width: {{(int)(((float)$v['available_quantity'])*100/(float)$v['num'])}}%"></div>
								@endif
							</div>
							<span class="fl fs16 gray">{{trans('home.stock')}}@if($v['available_quantity']>0) {{$v['available_quantity']}} @else 0 @endif{{$v['unit_name']}}</span>
						</div>
						<!-- <div class="tac mt40 ovh"><span class="addr_dw">上海  浦东新区</span></div> -->
						<div class="mx_price"><font class="gray">{{trans('home.price')}}</font> <font class="orange fs24">￥{{$v['price']}}</font>/{{$v['unit_name']}}</div>

						@if($v['is_over'])
							<div class="graybg">
								<div class="bottom_time"><p>{{trans('home.distance_end')}}：</p><span class="orange count-down-text">0{{trans('home.day')}}0{{trans('home.hour')}}0{{trans('home.minute')}}0{{trans('home.second')}}</span></div>
								<div class="bottom_btn b1b1b1bg fs16 white cp" style="background-color: #ccc;">{{trans('home.end')}}</div>
							</div>
						@elseif($v['is_soon'])
							<div class="graybg count-down" data-endtime="{{strtotime($v['begin_time'])*1000}}">
								<div class="bottom_time"><p>{{trans('home.distance_begin')}}：</p><span class="orange count-down-text">0{{trans('home.day')}}0{{trans('home.hour')}}0{{trans('home.minute')}}0{{trans('home.second')}}</span></div>
								<div class="bottom_btn b1b1b1bg fs16 white cp" style="background-color:#ccc;">{{trans('home.expect')}}</div>
							</div>
						@elseif($v['available_quantity'] == 0)
							<div class="graybg">
								<div class="bottom_time"><p>{{trans('home.distance_end')}}：</p><span class="orange count-down-text">0{{trans('home.day')}}0{{trans('home.hour')}}0{{trans('home.minute')}}0{{trans('home.second')}}</span></div>
								<div class="bottom_btn b1b1b1bg fs16 white cp" style="background-color: #ccc;">{{trans('home.sold_out')}}</div>
							</div>
						@else
							<div class="graybg count-down" data-endtime="{{strtotime($v['end_time'])*1000}}">
								<div class="bottom_time"><p>{{trans('home.distance_end')}}：</p><span class="orange count-down-text">0{{trans('home.day')}}0{{trans('home.hour')}}0{{trans('home.minute')}}0{{trans('home.second')}}</span></div>
								<a href="/buyLimitDetails/{{encrypt($v['id'])}}"><div class="bottom_btn redbg fs16 white cp">{{trans('home.partaking')}}</div></a>
							</div>
						@endif
						{{--<div class="mx_btn"><a href="/buyLimitDetails/{{encrypt($v['id'])}}">立即抢购</a></div>--}}
					</div>
				</li>
				@endforeach
			@endif
		</ul>
	
	</div>
	<div class="w1200 redbg ovh" style="margin-bottom: 30px;">
		
		<div class="Rules_activity">{{trans('home.rules')}}</div>
		<ul class="Rules_text">
			<li>1.{{trans('home.rules_1')}}</li>
			<li>2.{{trans('home.rules_2')}}</li>
			<li>3.{{trans('home.rules_3')}}：{{getConfig('service_phone')}}</li>
		</ul>
	</div>
	</div>
@endsection



