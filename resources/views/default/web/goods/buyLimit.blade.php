<!doctype html>
<html lang="en">
<head>
    <title>限时抢购 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    @yield('css')
		<link rel="stylesheet" href="css/global.css" />
		<link rel="stylesheet" href="css/index.css" />
		<script type="text/javascript" src="js/jquery-1.10.2.min.js" ></script>
		<script type="text/javascript">
			$(function(){
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
						
					</ul>
					
				</div>
				
				<div class="menu">
					<ul><li>首页</li><li>报价列表</li><li>拼团活动</li><li>限时秒杀</li><li>资讯中心</li><li>产品列表</li><li>帮助中心</li></ul>
				</div>
			</div>
		</div>
	</div>
	
	<div class="limit_bg">
		<div class="ms_title"></div>
		<div class="limit_date">2018年10月1日-2018年10月31日</div>
		
		
		<div class="w1200 ovh">
		<ul class="ms_list">
		@if(empty($promoteInfo))
			无抢购活动</ul>
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
	
	@include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
    @yield('js')
	</body>
</html>



