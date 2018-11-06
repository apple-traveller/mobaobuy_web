<!doctype html>
<html lang="en">
<head>
    <title>抢购详情 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    @yield('css')
		<link rel="stylesheet" href="{{asset(themePath('/').'css/global.css')}}" />
		<link rel="stylesheet" href="/css/index.css" />
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

				$('.nav').hover(function(){
					$('.ass_menu').toggle();
				})
//导航
				$('.ass_menu li').hover(function(){
					$(this).find('.ass_fn').toggle();
				})




			
			
			
			//规格
    		var thisMul = $('.shop_num_plus').attr('pid');

    		//最小可购数
    		var min_limit = $('#min_limit').attr('min-limit');
    		//可售数量
			var canSell = $('.shop_num_plus').attr('canSell');
			var NumNew;
			$(document).delegate('.shop_num_plus','click',function(){
				var ipts=$(this).siblings('input.Bidders_record_text');
				var iptsVal=ipts.attr('value');
				if(Number(ipts.val())+Number(thisMul)>Number(canSell)){
					alert('不能大于可售');
					return;
				}else{
					NumNew=Number(ipts.val())+Number(thisMul);
					ipts.val(Number(NumNew));
				}
			});

			$(document).delegate('.shop_num_reduce','click',function(){
				var ipts=$(this).siblings('input.Bidders_record_text');
				var iptsVal=ipts.attr('value');
				if (Number(ipts.val())-Number(thisMul)<Number(min_limit)) {
					alert('已经是最低的购买数量了');
					return;
				}else{
					NumNew=Number(ipts.val())-Number(thisMul);
					ipts.val(Number(NumNew));
				}

			})
			})

			function collectGoods(obj){
				var id = $(obj).attr('id');
				if(id>0){
					$.ajax({
						url: "/addCollectGoods",
						dataType: "json",
						data:{
							'id': id
						},
						type:"POST",
						success:function(data){
							if(data.code){
								$.msg.alert('收藏成功');
							}else{
								$.msg.alert(data.msg);
							}
						}
					})
				}
			}

			function toBalance(goodsId,activityId){
				var goodsNum = $('#goodsNum').val();
				var activityIdEncrypt = $('#activityId').val();
				$.ajax({
					url: "/buyLimitToBalance",
					dataType: "json",
					data: {
						'goodsId' : goodsId,
						'activityId' : activityId,
						'goodsNum' : goodsNum
					},
					type: "POST",
					success: function(data){
						if(data.code){
							 window.location.href='/confirmOrder/'+activityIdEncrypt;
						}else{
							$.msg.alert(data.msg);
						}
					}
				})
			}
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
				
				<a class="shopping_cart mt40 tac"><span class="fl ml25">我的购物车</span><i class="shopping_img fl"><img src="/img/cart_icon.png"/></i><span class="pro_cart_num white">1</span></a>
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
		<div class="w1200 pr ovh">
			<div class="crumbs mt5">当前位置：<a href="/">产品列表</a> &gt; <a href="/subject/list/56/page/1.html">产品详情</a> &gt;<span class="gray"></span></div>
		<div class="pro_chart mt5">
			<h1 class="pro_chart_title">
				商品价格走势
			</h1>
			<div class="pro_chart_img">
				
			</div>
			<div><span class="pro_chart_opert follow">收藏</span><span class="pro_chart_opert share ml20"></span></div>
		</div>
		<div class="fl ml35 mt5">
			<h1 class="fwb fs16">{{$goodsInfo['goods_name']}}</h1>
			<span class="red mt5 db"></span>
			<style type="text/css">
				.Time_limit{height:46px;background: url(/img/limit_time.png)no-repeat;}
				.xs_ms{margin-left:15px;width:95px;height:46px;line-height: 46px;background: url(/img/xs_ms.png)no-repeat 0px 16px;font-size: 18px;color: #fff; padding-left: 20px;}
			.time_mode{margin-top:11px;width: 24px;height: 24px;border-radius:6px;background-color: #323232;overflow: hidden;line-height: 24px;text-align: center;color: #fff;}
			.Surplus_time{float:right;width:200px;height: 46px;line-height: 46px;margin-right: 20px;}
			</style>
			<div class="Time_limit mt3">
				<span class="xs_ms fl">限时秒杀</span>
				<div class="Surplus_time" >
					<span class="white fl" >剩余时间</span>
					<span class="time_mode fl ml10 hour_show1">00</span>
					<span class="fl ml5">:</span>
					<span class="time_mode fl ml5 minute_show1">00</span>
					<span class="fl ml5">:</span>
					<span class="time_mode fl ml5 second_show1">00</span>
				</div>
			</div>
			<style type="text/css">
				.price_market{width:635px;height: 109px;background-color: #f4f4f4;}
				.limit_line{float:left;width: 1px;height: 45px;margin-top:32px;background-color: #cccccc;}
				
			</style>
			<div class="price_market">
				<div class="fl ml20">
					<div class="mt15" style="width: 500px;"><span class="fs14" style="letter-spacing: 10px;">秒杀价</span><span class="ml20 fs18"><font class="fwb red fs22">￥{{$goodsInfo['activity_price']}}</font>/kg</span></div>
					<div class="mt20"><span class="fs14" style="letter-spacing: 10px;">市场价</span><span class="ml25">￥{{$goodsInfo['market_price']}}/kg</span></div>
				</div>
				<div class="limit_line"></div>
				<div class="tac ovh">
					<span class="db mt35">累计售出</span>
					<span class="db red">{{$goodsInfo['activity_num'] - $goodsInfo['available_quantity']}} kg</span>
				</div>
			</div>
			<div class="pro_detail">
			<span class="ml15 pro_detail_title letter-space fl">库存</span><span  class="pro_value">{{$goodsInfo['activity_num']}}kg</span><span class="fl ">包装规格</span><span  class="ml35 fl">{{$goodsInfo['packing_spec']}}kg</span>
			</div>
			<div class="pro_detail">
			<span class="ml15 letter-space fl">批号</span><span  class="pro_value">{{$goodsInfo['goods_sn']}}</span><span class="fl letter-space">品牌</span><span  class="ml5 fl">{{$goodsInfo['brand_name']}}</span>
			</div>
			<div class="pro_detail">
			<!-- <span class="ml15 pro_detail_title fl">产品含量</span><span  class="pro_value">50%</span> -->
			</div>
			<div class="pro_detail bd1"></div>
			<div class="pro_detail">
				
			<span class="ml15 fl pro_detail_title" style="letter-spacing: 2px; height: 28px;line-height: 28px;">采  购  量</span><div class="pur_volume ml15"><span class="pur bbright shop_num_reduce" pid="{{$goodsInfo['packing_spec']}}" canSell="{{$goodsInfo['activity_num'] - $goodsInfo['available_quantity']}}">-</span><input type="text" class="pur_num Bidders_record_text" value="{{$goodsInfo['min_limit']}}" id="goodsNum" /><span id="min_limit" min-limit="{{$goodsInfo['min_limit']}}" class="pur bbleft shop_num_plus" pid="{{$goodsInfo['packing_spec']}}" canSell="{{$goodsInfo['activity_num'] - $goodsInfo['available_quantity']}}">+</span></div>
			
			</div>
			
			<div class="mt30" style="margin-left: 115px;">
				<button class="pro_detail_btn redbg" onclick="toBalance({{$goodsInfo['id']}},{{$goodsInfo['activity_id']}})">立即下单</button><button class="pro_detail_btn cccbg ml15 follow_btn" id="{{$goodsInfo['id']}}" aid="" onClick="collectGoods(this)">收藏商品</button>
			</div>
			<input type="hidden" name="" value="{{encrypt($goodsInfo['activity_id'])}}" id="activityId" />
		</div>
		</div>	
	</div>	
	
	<!--底部-->
	@include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
    @yield('js')
	
	</body>
</html>

