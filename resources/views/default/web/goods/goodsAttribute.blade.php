<!doctype html>
<html lang="en">
<head>
    <title>物性表 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    @yield('css')
		<link rel="stylesheet" href="css/global.css" />
	
		<link rel="stylesheet" href="/css/index.css" />
		<!-- <script type="text/javascript" src="js/jquery-1.10.2.min.js" ></script> -->
		<script type="text/javascript">
		
		</script>
	</head>
	<body>
	<div class="Physical_search_bg">
	<div class="clearfix height35 lh35">
		@include(themePath('.','web').'web.include.partials.top')
	</div>
	<div class="phy_serach_logo"></div>
	<div class="phy_serach  mt40">
		<form>
			<input type="text" class="phy_serach_text fl" name="goods_name" placeholder="请输入 品牌、种类、商品名称如 : 海大" id="goodsAttribute">
			<input type="submit" class="phy_search_btn white fs16 fl" id="on-search" value="搜 索">
		</form>
			<div class="hot_search_m white mt3">热门推荐：
                        <a href="#.html" target="_blank">7000F泰国PTT</a>
                        <a href="#.html" target="_blank">218WJ</a>
                        <a href="#.html" target="_blank">7000</a>
                        <a href="#.html" target="_blank">218w</a>
                        <a href="#.html" target="_blank">7000f</a>
                        <a href="#.html" target="_blank">9001台湾台塑</a>
            </div>
	</div>
	</div>
	
	<ul class="phy_serach_list">
		<table id="data-table" class="table table-border table-bordered table-bg table-hover dataTable order-table">
		@if(isset($list))
			@foreach($list as $v)
			<li>
				<div  class="phy_serach_Name gray">
					<h1 class="fs16 black fwb">{{$v['goods_name']}}</h1>
					<div class="db mt5"><span> 品       牌 : {{$v['brand_name']}}</span><span class="ml20"> 产品型号：{{$v['goods_model']}}</span><span class="ml20">包装单位 :<font class="blue">{{$v['packing_unit']}}</font></span><span class="ml20"> 包装规格 : <font class="lcolor">{{$v['packing_spec']}}kg</font></span></div>
					<span class="db mt5">作       用 : 维生素E粉是一种保健品，用于干性食品、婴幼儿奶粉、乳制品和液态食品的营养强化</span>
				</div>
				<div class="phy_serach_line"></div>
				<div class="phy_search_list_btn"><a href="/goodsAttributeDetails/{{encrypt($v['id'])}}">查看供应商</a></div>
			</li>
			@endforeach
		@else
		无产品
		@endif
		</table>
	</ul>
	 {!! $linker !!}
	<!--页码-->	

			<!--底部-->
	   @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
    @yield('js')
	</body>
</html>
