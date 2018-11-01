<!doctype html>
<html lang="en">
<head>
    <title>物性表详情 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    @yield('css')
		<link rel="stylesheet" href="{{asset(themePath('/').'css/global.css')}}" />
		<link rel="stylesheet" href="/css/index.css" />
		<script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript">
			$(function(){
//				显示走势图
				$(document).delegate('.phy_chart','mouseenter mouseleave',function(){
					$(this).find('.tag').toggle();
				})
			})
		</script>
	</head>
	<body>
@include(themePath('.','web').'web.include.partials.top')
	<div class="header">
		<div class="w1200">
			<div class="clearfix">
				<div class="logo" style="margin-top: 38px;"></div>
				<div class="index_search fl mt40">
					<input type="text" class="index_search_text fl" placeholder="请输入关键词、类别进行搜索"/><input type="button" class="index_search_btn white fs16 fl" value="搜 索"/>
					<a class="contact_artificial tac br1 db fl ml10">联系人工找货</a>
					<div class="hot_search_m">热门推荐：
                        <a href="#.html" target="_blank">7000F泰国PTT</a>
                        <a href="#.html" target="_blank">218WJ</a>
                        <a href="#.html" target="_blank">7000</a>
                        <a href="#.html" target="_blank">218w</a>
                        <a href="#.html" target="_blank">7000f</a>
                        <a href="#.html" target="_blank">9001台湾台塑</a>
                	</div>
				</div>
				
				<a class="shopping_cart mt40 tac"><span class="fl ml25">我的购物车</span><i class="shopping_img fl"><img src="img/cart_icon.png"/></i><span class="pro_cart_num white">1</span></a>
			</div>
			<div class="clearfix">
				
				<div class="nav">
					<div class="fication_menu">原料分类</div>
					<ul class="ass_menu" style="display: none;">
						<li><span class="ass_title">维生素</span> <span class="ass_list-right ass_list-right_icon ass_list-right_icon01"></span>
						<div class="ass_fn whitebg">
							<ul class="ass_fn_list">
								<li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VE</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VD3</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">烟酰胺/烟酸</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
							</ul>
						</div>
						</li>
						<li><span class="ass_title">维生素</span> <span class="ass_list-right ass_list-right_icon ass_list-right_icon01"></span>
							<div class="ass_fn whitebg">
							<ul class="ass_fn_list">
								<li><h1 class="fn_title fl">VB</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VE</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VD3</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">烟酰胺/烟酸</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
							</ul>
						</div>
						</li>
						<li><span class="ass_title">维生素</span> <span class="ass_list-right ass_list-right_icon ass_list-right_icon01"></span>
							<div class="ass_fn whitebg">
							<ul class="ass_fn_list">
								<li><h1 class="fn_title fl">VC</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VE</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VD3</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">烟酰胺/烟酸</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
							</ul>
						</div>
						</li>
						<li><span class="ass_title">维生素</span> <span class="ass_list-right ass_list-right_icon ass_list-right_icon01"></span>
							<div class="ass_fn whitebg">
							<ul class="ass_fn_list">
								<li><h1 class="fn_title fl">VD</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VE</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VD3</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">烟酰胺/烟酸</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
							</ul>
						</div>
						</li>
						<li><span class="ass_title">维生素</span> <span class="ass_list-right ass_list-right_icon ass_list-right_icon01"></span>
							<div class="ass_fn whitebg">
							<ul class="ass_fn_list">
								<li><h1 class="fn_title fl">VE</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VE</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VD3</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">烟酰胺/烟酸</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
							</ul>
						</div>
						</li>
						<li><span class="ass_title">维生素</span> <span class="ass_list-right ass_list-right_icon ass_list-right_icon01"></span>
							<div class="ass_fn whitebg">
							<ul class="ass_fn_list">
								<li><h1 class="fn_title fl">VF</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VE</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VD3</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">VA</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
								<li><h1 class="fn_title fl">烟酰胺/烟酸</h1><div class="ass_fn_list_that ml35 ovh fl"><span>常规VA</span><span>VA棕榈酸酯</span><span>常规VA</span><span>VA醋酸酯</span><span>常规VA</span><span>常规VA</span></div></li>
							</ul>
						</div>
						</li>
					</ul>
					
				</div>
				
				<div class="menu">
					<ul><li>首页</li><li>报价列表</li><li>拼团活动</li><li>限时秒杀</li><li>资讯中心</li><li>产品列表</li><li>帮助中心</li></ul>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix">
		<div class="w1200">
			<div class="crumbs mt5">当前位置：<a href="/">产品列表</a> &gt; <a href="/subject/list/56/page/1.html">产品详情</a> &gt;<span class="gray"></span></div>
			
			<h1 class="fs20 tac fwb bb1 lh40 ">{{$goodsInfo['goods_name']}}</h1>
			<div class="Physical_table_title Physical_table_Name">{{$goodsInfo['goods_name']}}</div>
			<table class="Physical_table">
				<tr><td class="letW">品       牌</td><td>{{$goodsInfo['brand_name']}}</td><td>产品编码</td><td>{{$goodsInfo['goods_sn']}}</td></tr>
				<tr><td>包装规格</td><td>{{$goodsInfo['packing_spec']}}</td><td>单位    名称</td><td>{{$goodsInfo['unit_name']}}</td></tr>
				<tr><td>包装单位</td><td>{{$goodsInfo['packing_unit']}}</td><td>产品型号</td><td>{{$goodsInfo['goods_model']}}</td></tr>
				<tr><td>作       用</td><td class="ovhwp">维生素E粉是一种保健品，用于干性食品、婴幼儿奶粉、乳制品和液态食品的营养强化</td><td>保质期</td><td>50%</td></tr>
				<tr ><td>用       途</td><td colspan="4">可做纯天然保健品食用，广泛用于营养品、食品添加剂和药品 </td></tr>
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
								<span class="db">交易员 : 王萌萌15422654908</span>
							</div>
							<div class="fl mb10 mt15 ml20">
								<span class="db"></span>
								<span>商品名称 : {{$v['goods_name']}}</span><span class="ml30">单价（元/公斤） : ¥{{$v['shop_price']}}</span><span class="ml20"></span> 
								<span class="phy_qq">28564250485</span>
							</div>
							<div class="phy_chart"><div class="tag fl"><div class="arrow"></div>CSS气泡框实现</div></div>
							<div class="phy_line fl"></div>
							<div class="phy_btn">立即询价</div>
						</li>
					@endforeach
				@else
				无此产品供应商信息
				@endif
			</ul>
			 {!! $linker !!}
		</div>
	</div>
	
	@include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
    @yield('js')
	</body>
</html>



