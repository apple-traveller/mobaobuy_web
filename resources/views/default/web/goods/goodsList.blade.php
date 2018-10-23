<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>产品列表</title>
	@include(themePath('.','web').'web.include.partials.base')
	<link rel="stylesheet" type="text/css" href="/css/index.css" />
	<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/layui/css/layui.css')}}" />
    <style>
        .Self-product-list li span{width:12.2%;}
        .news_pages ul.pagination {text-align: center;}
    </style>
    <script src="{{asset(themePath('/').'plugs/layui/layui.js')}}" ></script>
    <script type="text/javascript">
        $(function(){
            // 更多/收起
            $('.pro_more').click(function(){
                $(this).toggleClass('pro_up')
                var mPro=$(this).text();
                if (mPro=='收起') {
                    $(this).text('更多');
                    $(this).prev('.pro_brand_list').removeClass('heightcurr');
                } else{
                    $(this).text('收起');
                    $(this).prev('.pro_brand_list').addClass('heightcurr');
                }
            })
			//更多选项
            $('.more_filter_box').click(function(){
                var mText = $(this).text();
                if(mText=='更多选项...'){
                    $('.pro_screen').removeClass('height0');
                    $('.pro_screen').addClass('heightcurr')
                    $('.more_filter_box').text('隐藏选项...');
                    $('.pro_Open').toggleClass('pro_Open_down');
                }else{
                    $('.pro_screen').removeClass('heightcurr');
                    $('.more_filter_box').text('更多选项...');
                }
            });
        })

        paginate();
        function paginate(){
            layui.use(['laypage'], function() {
                var laypage = layui.laypage;
                laypage.render({
                    elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                    , count: "{{$total}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , prev: "上一页"
                    , next: "下一页"
					, theme: "#88be51" //样式
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/goodsList?currpage="+obj.curr;
                        }
                    }
                });
            });
        }

	</script>
</head>
<body>
<div class="clearfix height35 lh35 graybg">
	<div class="w1200">
		<div class="top_til">
			<a>登录</a>
			<a>注册</a>
			<a>帮助中心</a>
			<a>会员中心</a>
			<a>快速下单</a><span class="top_tel">400-000-0000</span>
		</div>
	</div>
</div>
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

			<a class="shopping_cart mt40 tac"><span class="fl ml25">我的购物车</span><i class="shopping_img fl"><img src="/images/cart_icon.png"/></i><span class="pro_cart_num white">{{$cart_count}}</span></a>
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
	<div class="w1200 pr">
		<div class="crumbs mt5 mb5"><span class="fl">当前位置：</span><a class="fl" href="/">产品列表</a> <div class="mode_add tac">江西 、湖北<i class="mode_close"></i></div><div class="mode_add tac ml10">湖北<i class="mode_close"></i></div> <div class="pro_Open pro_Open_up"></div><div class="fr">共<font class="orange">60</font>个相关产品</div></div>


		<div class="pro_screen">
			<div class="pro_brand">

				<dl class="fl filter_item"><dt class="fl">品牌:</dt> <dd class="pro_brand_list ml30"><a>海大</a><a>恒兴</a><a>通威</a><a>禾丰</a><a>骆驼</a><a>正红</a><a>五谷丰登</a><a>成农</a><a>五谷丰登</a><a>成农</a><a>成农</a><a>成农</a><a>成农</a><a>成农</a><a>成农</a><a>成农</a><a>成农</a></dd><div class="fl pro_brand_btn ml20 pro_more">更多</div><div class="fl pro_brand_btn ml20 pro_m_select">多选</div></dl>
			</div>
			<div class="pro_brand">
				<dl class="fl filter_item"><dt class="fl">种类:</dt> <dd class="pro_brand_list ml30"><a>VA</a><a>VE</a><a>VD3</a><a>泛酸钙</a><a>VB1</a><a>VB2</a><a>生物素</a><a>烟酰胺/烟酸</a><a>氯化胆碱</a><a>肌醇</a><a>VB6</a><a>成农</a><a>VB6</a><a>VB6</a><a>成农</a><a>成农</a><a>成农</a></dd><div class="fl pro_brand_btn ml20 pro_more">更多</div><div class="fl pro_brand_btn ml20 pro_m_select">多选</div></dl>
			</div>
			<div class="pro_brand" style="border-bottom: none;">
				<dl class="fl filter_item"><dt class="fl">地区:</dt>
					<dd class="fl"><label class=" check_box region ml20"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">全部</span></label></dd>
					<dd class="pro_brand_list" style="width: 770px;">
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">福建</span></label>
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">江西</span></label>
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">上海</span></label>
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">北京</span></label>
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">浙江</span></label>
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">安徽</span></label>
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">福建</span></label>
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">北京</span></label>
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">浙江</span></label>
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">安徽</span></label>
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">福建</span></label>
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">北京</span></label>
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">浙江</span></label>
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">安徽</span></label>
						<label class=" check_box region"><input class="check_box mr5 check_all fl mt10" name="" type="checkbox" value=""/><span class="fl">福建</span></label>

					</dd>
					<div class="fl pro_brand_btn region_btn ml20">确定</div><div class="fl pro_brand_btn region_btn ml20">取消</div>
				</dl>
			</div>

		</div>
		<div class="more_filter_box">更多选项...</div>
	</div>
	<div class="w1200 mt20 " style="margin-top: 20px;">
		<h1 class="product_title">产品列表</h1>
		<div class="scr">
			<div class="width1200">
				<div class="sequence-bar" style="padding:0;padding-right:10px;">
					<div class="fl">
						<a class="choose default active" href="#" style="height:39px;line-height:39px;margin-top:0;">综合</a>
					</div>
					<div class="fl">
						<ul>
							<li class="sm_breed goods_number"><span class="sm_breed_span num_bg1">数量</span></li>
							<li class="sm_breed shop_price1"><span @if($price_bg1!="") class="sm_breed_span price_bg price_bg1" @else class="sm_breed_span price_bg" @endif>价格</span></li>
							<li class="sm_breed add_time"><span class="sm_breed_span shelftime_bg1" style="width: 113px;">上架时间</span></li>
						</ul>
					</div>
					<div class="fr">
						<span class="fl fs13 mr10"><font class="orange">1</font>/4</span>
						<div class="fl page_mode page_border_left page_leftbg"></div>
						<div class="fl page_mode page_border_right page_rightbg"></div>
					</div>
					<form class="fl" id="formid" action="/goodsList">
						<input class="min-max" name="lowest" id="minPrice" @if($lowest!="") value="{{$lowest}}" @else value=""  @endif value="" placeholder="￥最低价" style="margin-left: 5px">
						<span class="line">-</span>
						<input class="min-max" name="highest" id="minPrice" @if($highest!="") value="{{$highest}}" @else value=""  @endif placeholder="￥最高价" style="margin-left: 5px">
						<input class="confirm active inline-block" id="btnSearchPrice" value="确定" type="submit" style="margin-left: 5px">
					</form>
				</div>
			</div>
		</div>
		<ul class="Self-product-list">

			<li><span class="num_bg1">店铺</span><span>品牌</span><span>种类</span><span>商品名称</span><span>数量（公斤）</span><span>单价（元/公斤）</span><span>发货地址</span><span>操作</span></li>
			@foreach($goodsList as $vo)
				<li><span>{{$vo['shop_name']}}</span><span>{{$vo['brand_name']}}</span><span class="ovh">{{$vo['cat_name']}}</span><span ><a class="orange" href="/goodsDetail?id={{$vo['id']}}&shop_id={{$vo['shop_id']}}">{{$vo['goods_name']}}</a></span><span>{{$vo['goods_number']}}</span><span>{{$vo['shop_price']}}</span><span>{{$vo['delivery_place']}}</span><span><button data-id="{{$vo['id']}}" class="P_cart_btn">加入购物车</button></span></li>
			@endforeach
		</ul>
		<!--页码-->
		<div class="news_pages">
			<ul id="page" class="pagination">

			</ul>
		</div>
	</div>
</div>

<!--底部-->
@include(themePath('.','web').'web.include.partials.footer_service')
@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')
<script>
    $(".goods_number").click(function(){
        window.location.href="/goodsList?orderType=goods_number:desc";
    });

    $(".add_time").click(function(){
        window.location.href="/goodsList?orderType=add_time:desc";
	});

    $(".price_bg").click(function () {
        $(this).toggleClass('price_bg1');
        var flag = $(this).hasClass("price_bg1");
        if(flag===true){
            window.location.href="/goodsList?orderType=shop_price:asc&price_bg1=1";
		}else{
            window.location.href="/goodsList?orderType=shop_price:desc&price_bg1=0";
		}
    })


    //加入购物车
	$(".P_cart_btn").click(function(){
		var id = $(this).attr("data-id");
		var number = 1;
		$.post("/cart",{'id':id,'number':number},function(res){
			if(res.code==1){
				var cart_count = res.data;
				$(".pro_cart_num").text(cart_count);
				$.msg.success(res.msg,1);
			}else{
				$.msg.alert(res.msg);
			}
		},"json");
	});


</script>
</body>
</html>
