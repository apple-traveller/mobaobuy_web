<!doctype html>
<html lang="en">
<head>
    <title>{{trans('home.physical_table')}} - {{getSeoInfoByType('goods')['title']}}</title>
	<meta name="description" content="{{getSeoInfoByType('goods')['description']}}" />
	<meta name="keywords" content="{{getSeoInfoByType('goods')['keywords']}}" />
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
		<a href="/" ><div class="phy_serach_logo"></div></a>
	<div class="phy_serach  mt40">
		<form>
			<input type="text" class="phy_serach_text fl" name="goods_name" placeholder="{{trans('home.enter_brand_cate_tips')}}" id="goodsAttribute">
			<input type="submit" class="phy_search_btn white fs16 fl" id="on-search" value="{{trans('home.header_search')}}">
		</form>
		<div class="hot_search_m white mt3">{{trans('home.header_hot')}}：
			@foreach(explode(',',getConfig('search_keywords')) as $item)
				<a href="/goodsList?keyword={{$item}}" target="_blank">{{$item}}</a>
			@endforeach
		</div>
	</div>
	</div>
	<ul class="phy_serach_list">
		<table id="data-table" class="table table-border table-bordered table-bg table-hover dataTable order-table">
			@if(isset($list))
				@foreach($list as $v)
					<li>
						<div  class="phy_serach_Name gray">
							<h1 class="fs16 black fwb">{{getLangData($v,'goods_full_name')}}</h1>
							<div class="db mt5">
								<span> {{trans('home.brand')}} : {{getLangData($v,'brand_name')}}</span>
								<span class="ml20"> {{trans('home.content')}}：{{getLangData($v,'goods_content')}}</span>
								<span class="ml20">{{trans('home.packaging_unit')}} :<font class="blue">{{getLangData($v,'packing_unit')}}</font></span>
								<span class="ml20"> {{trans('home.spec2')}} : <font class="lcolor">{{$v['packing_spec']}}{{$v['unit_name']}}/{{getLangData($v,'packing_unit')}}</font></span>
							</div>
							<!-- <span class="db mt5">属       性 : </span> -->
						</div>
						<div class="phy_serach_line"></div>
						<a href="/goodsAttributeDetails/{{encrypt($v['id'])}}"><div class="phy_search_list_btn">{{trans('home.view_suppliers')}}</div></a>
					</li>
				@endforeach
			@else
				{{trans('home.no_goods')}}
			@endif
		</table>
	</ul>
	{!! $linker !!}
	@include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
    @yield('js')
	</body>
</html>
