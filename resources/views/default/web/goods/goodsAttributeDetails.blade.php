@extends(themePath('.','web').'web.include.layouts.home')
@if(empty(getSeoInfoByType('goods')['title']))
	@section('title', $goodsInfo['goods_name'])
@else
	@section('title', $goodsInfo['goods_name'].'-'.getSeoInfoByType('goods')['title'])
@endif
@section('keywords', getSeoInfoByType('goods')['keywords'])
@section('description', getSeoInfoByType('goods')['description'])
@section('css')
	<link rel="stylesheet" href="{{asset(themePath('/').'css/global.css')}}" />
	<link rel="stylesheet" href="{{asset(themePath('/').'css/index.css')}}" />
	<link rel="stylesheet" href='/css/index.css' />

	{{--<link rel="stylesheet" type="text/css" href="{{asset('plugs/layui/css/layui.css')}}" />--}}
	{{--<link rel="stylesheet" type="text/css" href="https://www.sumibuy.com/css/global.css"/>--}}

	<style>
		.fn_title {
			width: 100px;
			text-align: right;
		}
		.nav-div .nav-cate .ass_menu {display: none;}

		.top-search-div .search-div .logo{
			background:none;
		}
		a:hover {color:green;}
		.supply_list_phy li{
			box-sizing: unset;
		}
		.supply_list_phy li:hover{
			box-sizing: unset;
		}
	</style>
@endsection
@section('js')
	<script src="{{asset(themePath('/', 'web').'js/index.js')}}" ></script>
	<script type="text/javascript">
        $(function(){
//            $(document).delegate('.phy_chart','mouseenter mouseleave',function(){
//                $(this).find('.tag').toggle();
//            })

            $(".nav-cate").hover(function(){
                $(this).children('.ass_menu').toggle();// 鼠标悬浮时触发
            });
        })
	</script>
@endsection
@section('content')
	<div class="clearfix" style="background-color:white;">
		<div class="w1200">
			<div class="crumbs mt5">{{trans('home.curr')}}：<a href="/goodsAttribute">{{trans('home.goods_property')}}</a> &gt; <a href="javascript:">{{getLangData($goodsInfo,'goods_name')}}</a><span class="gray"></span></div>
			
			<h1 class="fs20 tac fwb bb1 lh40 ">{{getLangData($goodsInfo,'goods_name')}}</h1>
			<div class="Physical_table_title Physical_table_Name">{{getLangData($goodsInfo,'goods_name')}}</div>
			<table class="Physical_table">
				<tr>
					<td class="">{{trans('home.brand')}}</td><td>{{getLangData($goodsInfo,'brand_name')}}</td>
					<td>{{trans('home.product_sn')}}</td><td>{{$goodsInfo['goods_sn']}}</td>
				</tr>
				<tr>
					<td>{{trans('home.package')}}</td><td>{{$goodsInfo['packing_spec']}}</td>
					<td>{{trans('home.packaging_unit')}}</td><td>{{$goodsInfo['unit_name']}}</td>
				</tr>
				<tr>
					<td>{{trans('home.spec2')}}</td><td>{{getLangData($goodsInfo,'packing_unit')}}</td>
					<td>{{trans('home.goods_model')}}</td><td>{{$goodsInfo['goods_model']}}</td>
				</tr>
				@if(!empty($goods_attr))

					@foreach($goods_attr as $k=>$v)
						@if($k == 0)
							<tr>
							<td class="">{{trans('home.content')}}</td><td>{{getLangData($goodsInfo,'goods_content')}}</td>
							<td class="">{{$v[0]}}</td><td class="ovhwp">{{$v[1]}}</td>
						@else
							@if($k%2 == 1)
								</tr><tr>
							@endif
							<td class="">{{$v[0]}}</td><td class="ovhwp">{{$v[1]}}</td>
						@endif
					@endforeach
						</tr>

				@else
					<tr>
					<td class="">{{trans('home.content')}}</td><td>{{getLangData($goodsInfo,'goods_content')}}</td></tr>
				@endif

				
				
				<!-- <tr ><td>用       途</td><td colspan="4">可做纯天然保健品食用，广泛用于营养品、食品添加剂和药品 </td></tr> -->
			</table>
			<div class="Physical_table_title Physical_table_supply">{{getLangData($goodsInfo,'goods_name')}}</div>
			<ul class="supply_list_phy">
				<style type="text/css">
					.supply_list_phy li:nth-child(one){border-top: 2px solid #000;}
				</style>
				@if(!empty($list))
					@foreach($list as $v)
						<li>
							<div class="supply_list_frist" style="width:230px;">
								<span class="supply_list_frist_com">{{trans('home.shop_name')}} : {{getLangData($v,'shop_name')}}</span>
								<!-- <span></span> <span class="ml15"></span> -->
								<span class="db">{{trans('home.contact')}} : {{$v['salesman']}} {{$v['contact_info']}}</span>
							</div>
							<div class="fl mb10 mt15 ml20" style="width:585px;">
								<span class="db"></span>
								<span>{{trans('home.goods_name')}} : {{getLangData($v,'goods_name')}}</span><span class="ml30">{{trans('home.price')}} : ¥{{$v['shop_price']}}/{{$goodsInfo['unit_name']}}</span><span class="ml20"></span>
								<span class="phy_qq">{{$v['QQ']}}</span>
							</div>
							{{--<div class="phy_chart" style="margin: 35px 100px"><div class="tag fl"><div class="arrow"></div>CSS气泡框实现</div></div>--}}
							<div class="phy_chart" style="margin: 35px 100px;background: none"><div class="tag fl"><div class="arrow"></div></div></div>
							<div class="phy_line fl"></div>
							<div class="phy_btn" style="margin-left:3px;"><a rel="nofollow" href="javascript:" onclick="javascript:window.open('http://wpa.qq.com/msgrd?v=3&uin={{$v['QQ']}}&site=qq&menu=yes');" >{{trans('home.enquiry_at_once')}}</a></div>
						</li>
					@endforeach
				@else
					 <li class="nodata">{{trans('home.no_data')}}</li>
				@endif
			</ul>
			{!! $linker !!}
		</div>
	</div>
@endsection


