@extends(themePath('.','web').'web.include.layouts.goods')
@section('title', '产品列表')
@section('css')
	<style>
		.Self-product-list li span{width:11%;}
		.news_pages ul.pagination {text-align: center;}
	</style>
@endsection
@section('js')
	<script>
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
	</script>
@endsection

@section('content')
	<div class="clearfix">
	<div class="w1200 pr">
		<div class="crumbs mt5 mb5"><span class="fl">当前位置：</span><a class="fl" href="/">产品列表</a>
			<div class="condition">

			</div>
			<div class="pro_Open pro_Open_up"></div>
			<div class="fr">共<font class="orange">{{$total}}</font>个相关产品</div></div>


		<div class="pro_screen">
			<div class="pro_brand">
				<dl class="fl filter_item">
					<dt class="fl">品牌:</dt>
					<dd class="pro_brand_list ml30">
						@foreach($brand as $vo)
							<a onclick="choseByBrand(1,this)" class="choseByBrand" >{{$vo['brand_name']}}</a>
						@endforeach
					</dd>
					<div class="fl pro_brand_btn ml20 pro_more">更多</div>
					<div class="fl pro_brand_btn ml20 pro_m_select">多选</div>
				</dl>
			</div>
			<div class="pro_brand">
				<dl class="fl filter_item">
					<dt class="fl">种类:</dt>
					<dd class="pro_brand_list ml30">
						@foreach($cate as $vo)
						<a onclick="choseByCate(1,this)" data-id="{{$vo['id']}}">{{$vo['cat_name']}}</a>
						@endforeach
					</dd>
					<div class="fl pro_brand_btn ml20 pro_more">更多</div>
					<div class="fl pro_brand_btn ml20 pro_m_select">多选</div>
				</dl>
			</div>
			<div class="pro_brand" style="border-bottom: none;">
				<dl class="fl filter_item"><dt class="fl">地区:</dt>
					<dd class="pro_brand_list" style="width: 850px;margin-left:25px;">
						@foreach($delivery_place as $vo)
						<label class=" check_box region"><input  class="check_box mr5 check_all fl mt10" name="" type="checkbox" data-id="{{$vo['region_id']}}" value="{{$vo['region_name']}}"/><span  class="fl">{{$vo['region_name']}}</span></label>
						@endforeach
					</dd>
					<div onclick="choseByRegion(1)"  class="fl pro_brand_btn region_btn ml20">确定</div><div class="fl pro_brand_btn region_btn ml20">取消</div>
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
							<li class="sm_breed shop_price1"><span @if($price_bg1==1) class="sm_breed_span price_bg price_bg1" @else class="sm_breed_span price_bg" @endif>价格</span></li>
							<li class="sm_breed add_time"><span class="sm_breed_span shelftime_bg1" style="width: 113px;">上架时间</span></li>
						</ul>
					</div>
					<div class="fr">


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

			<li class="table_title"><span class="num_bg1">店铺</span><span  style="width:8%;">品牌</span><span style="width:8%;">种类</span><span>商品名称</span><span style="width:8%;">数量（kg）</span><span>单价（元/kg）</span><span>发货地址</span><span style="width:15%;">联系人</span><span>操作</span></li>
			@foreach($goodsList as $vo)
				<li><span data-id="{{$vo['packing_spec']}}" id="packing_spec">{{$vo['shop_name']}}</span><span style="width:8%;">{{$vo['brand_name']}}</span><span class="ovh" style="width:8%;">{{$vo['cat_name']}}</span><span ><a class="orange" href="/goodsDetail?id={{$vo['id']}}&shop_id={{$vo['shop_id']}}">{{$vo['goods_name']}}</a></span><span style="width:8%;">{{$vo['goods_number']}}</span><span>{{$vo['shop_price']}}</span><span>{{$vo['delivery_place']}}</span><span style="width:15%;">{{$vo['salesman']}}/{{$vo['contact_info']}}</span><span><button  data-id="{{$vo['id']}}" class="P_cart_btn">加入购物车</button></span></li>
			@endforeach
		</ul>
		<!--页码-->
		<div class="news_pages">
			<ul id="page" class="pagination">

			</ul>
		</div>
	</div>
	</div>
@endsection

@section('bottom_js')
<script>
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
                        window.location.href="/goodsList?currpage="+obj.curr+"&orderType={{$orderType}}"+"&lowest={{$lowest}}"+"&highest={{$highest}}";
                    }
                }
            });
        });
    }
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
    $(document).delegate('.P_cart_btn','click',function(){
        var userId = "{{session('_web_user_id')}}";
        if(userId==""){
            $.msg.error("未登录",1);
            return false;
        }
        var id = $(this).attr("data-id");
        var number = $("#packing_spec").attr('data-id');
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
    //根据品牌筛选
    function choseByBrand(currpage,b_obj){
        var brand_name = $(b_obj).text();
        $(".condition").append('<div style="margin-left:20px;" class="mode_add tac ml10 condition_tag">'+brand_name+'<i style="cursor: pointer"  class="mode_close"></i></div>');
        $.ajax({
            type: "POST",
            url: "/condition/goodsList",
            data: {"brand_name":brand_name,'currpage':currpage},
            dataType: "json",
            success: function(res){
                if(res.code==200){
                    var data = res.data;
                    console.log(data);
                    var currpage = data.currpage;
                    var pageSize = data.pageSize;
                    var total = data.total;
                    var list = data.list;
                    $(".table_title").nextAll().remove();//去除已经出现的数据
                    $("#page").remove();//删除分页div
                    for (var i=0;i<list.length;i++)
                    {
                        $(".table_title").after('<li><span data-id="'+list[i].packing_spec+'" id="packing_spec">'+list[i].shop_name+'</span><span style="width:8%;">'+list[i].brand_name+'</span><span style="width:8%;" class="ovh">'+list[i].cat_name+'</span><span ><a class="orange" href="/goodsDetail?id='+list[i].id+'&shop_id='+list[i].shop_id+'">'+list[i].goods_name+'</a></span><span style="width:8%;">'+list[i].goods_number+'</span><span>'+list[i].shop_price+'</span><span>'+list[i].delivery_place+'</span><span style="width:15%;">'+list[i].salesman+'/'+list[i].contact_info+'</span><span><button data-id="'+list[i].id+'" class="P_cart_btn">加入购物车</button></span></li>');
                        $(".news_pages").append('<ul id="page" class="pagination"></ul>');

                    }
                    //分页
                    layui.use(['laypage'], function() {
                        var laypage = layui.laypage;
                        laypage.render({
                            elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                            , count: total //数据总数，从服务端得到
                            , limit: pageSize   //每页显示的条数
                            , curr: currpage  //当前页
                            , prev: "上一页"
                            , next: "下一页"
                            , theme: "#88be51" //样式
                            , jump: function (obj, first) {
                                if (!first) {
                                    choseByBrand(obj.curr,b_obj);
                                }
                            }
                        });
                    });
                }else{
                    $(".table_title").nextAll().remove();
                    $(".table_title").after('<li style="color:red;">没有相关数据</li>');
                }
            }
        });
	}

    //根据种类筛选
    function choseByCate(currpage,b_obj){
        var cate_id = $(b_obj).attr("data-id");
        var cat_name = $(b_obj).text();
        $(".condition").append('<div style="margin-left:20px;" class="mode_add tac ml10 condition_tag">'+cat_name+'<i style="cursor: pointer" class="mode_close"></i></div>');
        $.ajax({
            type: "POST",
            url: "/condition/goodsList",
            data: {"cate_id":cate_id,'currpage':currpage},
            dataType: "json",
            success: function(res){
                if(res.code==200){
                    var data = res.data;
                    console.log(data);
                    var currpage = data.currpage;
                    var pageSize = data.pageSize;
                    var total = data.total;
                    var list = data.list;
                    $(".table_title").nextAll().remove();//去除已经出现的数据
                    $("#page").remove();//删除分页div
                    for (var i=0;i<list.length;i++)
                    {
                        $(".table_title").after('<li><span data-id="'+list[i].packing_spec+'" id="packing_spec">'+list[i].shop_name+'</span><span style="width:8%;">'+list[i].brand_name+'</span><span style="width:8%;" class="ovh">'+list[i].cat_name+'</span><span ><a class="orange" href="/goodsDetail?id='+list[i].id+'&shop_id='+list[i].shop_id+'">'+list[i].goods_name+'</a></span><span style="width:8%;">'+list[i].goods_number+'</span><span>'+list[i].shop_price+'</span><span>'+list[i].delivery_place+'</span><span style="width:15%;">'+list[i].salesman+'/'+list[i].contact_info+'</span><span><button data-id="'+list[i].id+'" class="P_cart_btn">加入购物车</button></span></li>');
                        $(".news_pages").append('<ul id="page" class="pagination"></ul>');
                    }
                    //分页
                    layui.use(['laypage'], function() {
                        var laypage = layui.laypage;
                        laypage.render({
                            elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                            , count: total //数据总数，从服务端得到
                            , limit: pageSize   //每页显示的条数
                            , curr: currpage  //当前页
                            , prev: "上一页"
                            , next: "下一页"
                            , theme: "#88be51" //样式
                            , jump: function (obj, first) {
                                if (!first) {
                                    choseByCate(obj.curr,b_obj);
                                }
                            }
                        });
                    });
                }else{
                    $(".table_title").nextAll().remove();
                    $(".table_title").after('<li style="color:red;">没有相关数据</li>');
                }
            }
        });
    }

    //根据地区筛选
    function choseByRegion(currpage){
        var region_ids = [];
        var region_names = [];
        $(".pro_brand_list").find("input").each(function(){
            if($(this).is(':checked')){
                region_ids.push($(this).attr('data-id'));
                region_names.push($(this).val());
            }
        });
        $(".condition").append('<div style="margin-left:20px;" class="mode_add tac ml10 condition_tag">'+region_names.join(',')+'<i style="cursor: pointer" class="mode_close"></i></div>');
        $.ajax({
            type: "POST",
            url: "/condition/goodsList",
            data: {"place_id":region_ids.join("|"),'currpage':currpage},
            dataType: "json",
            success: function(res){
                if(res.code==200){
                    var data = res.data;
                    console.log(data);
                    var currpage = data.currpage;
                    var pageSize = data.pageSize;
                    var total = data.total;
                    var list = data.list;
                    $(".table_title").nextAll().remove();//去除已经出现的数据
                    $("#page").remove();//删除分页div
                    for (var i=0;i<list.length;i++)
                    {
                        $(".table_title").after('<li><span data-id="'+list[i].packing_spec+'" id="packing_spec">'+list[i].shop_name+'</span><span style="width:8%;">'+list[i].brand_name+'</span><span style="width:8%;" class="ovh">'+list[i].cat_name+'</span><span ><a class="orange" href="/goodsDetail?id='+list[i].id+'&shop_id='+list[i].shop_id+'">'+list[i].goods_name+'</a></span><span style="width:8%;">'+list[i].goods_number+'</span><span>'+list[i].shop_price+'</span><span>'+list[i].delivery_place+'</span><span style="width:15%;">'+list[i].salesman+'/'+list[i].contact_info+'</span><span><button data-id="'+list[i].id+'" class="P_cart_btn">加入购物车</button></span></li>');
                        $(".news_pages").append('<ul id="page" class="pagination"></ul>');
                    }
                    //分页
                    layui.use(['laypage'], function() {
                        var laypage = layui.laypage;
                        laypage.render({
                            elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                            , count: total //数据总数，从服务端得到
                            , limit: pageSize   //每页显示的条数
                            , curr: currpage  //当前页
                            , prev: "上一页"
                            , next: "下一页"
                            , theme: "#88be51" //样式
                            , jump: function (obj, first) {
                                if (!first) {
                                    choseByRegion(obj.curr);
                                }
                            }
                        });
                    });
                }else{
                    $(".table_title").nextAll().remove();
                    $(".table_title").after('<li style="color:red;">没有相关数据</li>');
                }
            }
        });
    }

    //删除筛选条件
    $(document).delegate('.mode_close','click',function(){
        $(this).parent('div').filter('.condition_tag').remove();

    });
</script>
@endsection