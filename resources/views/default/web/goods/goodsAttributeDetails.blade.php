@extends(themePath('.','web').'web.include.layouts.home')
@section('title', '抢购详情')
@section('css')
	<link rel="stylesheet" href="{{asset(themePath('/').'css/global.css')}}" />
	<link rel="stylesheet" href="/css/index.css" />
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
            $(document).delegate('.phy_chart','mouseenter mouseleave',function(){
                $(this).find('.tag').toggle();
            })

            $(".nav-cate").hover(function(){
                $(this).children('.ass_menu').toggle();// 鼠标悬浮时触发
            });
        })
	</script>
@endsection
@section('content')
	<div class="clearfix" style="background-color:white;">
		<div class="w1200">
			<div class="crumbs mt5">当前位置：<a href="/goodsAttribute">产品物性</a> &gt; <a href="javascript:">{{$goodsInfo['goods_name']}}</a><span class="gray"></span></div>
			
			<h1 class="fs20 tac fwb bb1 lh40 ">{{$goodsInfo['goods_name']}}</h1>
			<div class="Physical_table_title Physical_table_Name">{{$goodsInfo['goods_name']}}</div>
			<table class="Physical_table">
				<tr><td class="letW">品 牌</td><td>{{$goodsInfo['brand_name']}}</td><td>产品编码</td><td>{{$goodsInfo['goods_sn']}}</td></tr>
				<tr><td>包装规格</td><td>{{$goodsInfo['packing_spec']}}</td><td>单位名称</td><td>{{$goodsInfo['unit_name']}}</td></tr>
				<tr><td>包装单位</td><td>{{$goodsInfo['packing_unit']}}</td><td>产品型号</td><td>{{$goodsInfo['goods_model']}}</td></tr>
				<tr><td class="letW">属  性</td><td class="ovhwp">{{$goodsInfo['goods_attr']}}</td><td class="letW">含 量</td><td>{{$goodsInfo['goods_content']}}</td></tr>
				<!-- <tr ><td>用       途</td><td colspan="4">可做纯天然保健品食用，广泛用于营养品、食品添加剂和药品 </td></tr> -->
			</table>
			<div class="Physical_table_title Physical_table_supply">{{$goodsInfo['goods_name']}}</div>
			<ul class="supply_list_phy">
				<style type="text/css">
					.supply_list_phy li:nth-child(one){border-top: 2px solid #000;}
				</style>
				@if(!empty($list))
					@foreach($list as $v)
						<li>
							<div class="supply_list_frist">
								<span class="supply_list_frist_com">店铺 : {{$v['shop_name']}}</span> 
								<span></span> <span class="ml15"></span>
								<span class="db">联系人 : {{$v['salesman']}} {{$v['contact_info']}}</span>
							</div>
							<div class="fl mb10 mt15 ml20">
								<span class="db"></span>
								<span>商品名称 : {{$v['goods_name']}}</span><span class="ml30">单价（元/kg） : ¥{{$v['shop_price']}}元</span><span class="ml20"></span>
								<span class="phy_qq">{{$v['QQ']}}</span>
							</div>
							<div class="phy_chart"><div class="tag fl"><div class="arrow"></div>CSS气泡框实现</div></div>
							<div class="phy_line fl"></div>
							<div class="phy_btn"><a rel="nofollow" href="javascript:" onclick="javascript:window.open('http://wpa.qq.com/msgrd?v=3&uin={{$v['QQ']}}&site=qq&menu=yes');">立即询价</a></div>
						</li>
					@endforeach
				@else
				无此产品供应商信息
				@endif
			</ul>
			 {!! $linker !!}
		</div>
	</div>
@endsection


