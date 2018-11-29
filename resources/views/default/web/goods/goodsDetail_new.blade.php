@extends(themePath('.','web').'web.include.layouts.home')

@section('title', '商品列表')
@section('css')
	<style>
		.Self-product-list li span{width:14%;}
		.news_pages ul.pagination {text-align: center;}
		.Self-product-list li span{width: 12.5%;float: left;text-align: center;}
		.pro_chart{float:left;width: 528px; }
		.pro_chart_title{line-height: 70px;text-align: center;font-size: 18px;border: 1px solid #DEDEDE;border-bottom: 1px solid #DEDEDE;}
		.pro_chart_img{height: 355px;border: 1px solid #DEDEDE;}
		.pro_price{width:660px;height: 56px;line-height: 56px;overflow: hidden;}
		.pro_detail{overflow: hidden;margin-top: 20px;}
		.pro_price_dj{width: 493px;height: 45px;line-height: 45px;margin-top: 5px;display: block;}
		.start_amount{float: left;width: 141px;line-height:20px;text-align: center;margin-top: 7px;}
		.pro_value{width: 270px;margin-left: 15px;float: left;}
		.letter-space{letter-spacing: 30px;}
		.pro_detail_title{width: 88px;}
		.pro_chart_opert{width: 50px;height: 18px;display: inline-block;color: #666;padding-left: 23px;margin-top: 10px;}
		.follow{background: url(/images/pro_detail_icon.png)no-repeat 0px -61px;}
		.share{background: url(/images/pro_detail_icon.png)no-repeat -124px 3px;}
		.follow_btn{background: #b1b1b1 url(/images/pro_detail_icon.png)no-repeat 20px 14px;}
		.pur_volume{float:left;border: 1px solid #DEDEDE; box-sizing:border-box;}
		.pur_volume .pur{cursor:pointer;width: 26px;text-align: center;float: left;height: 28px;line-height: 28px;background-color: #fafafa;box-sizing:border-box;}
		.pur_num{float:left;width: 50px;height: 28px;line-height: 28px;text-align: center;border: none;}
		.pro_detail_btn{cursor:pointer;width: 140px;height: 42px;line-height: 42px;border: none;font-size:16px;color: #fff;border-radius:3px;}
        .History_offo{height: 40px;line-height: 40px;border-bottom: 2px solid #75b335;background-color: #f0f0f0;box-sizing: border-box;}
        .History_offo h1{background-color: #75b335;text-align: center;width: 106px;color: #fff;font-size: 16px;}
        .History-product-list{margin-top: 10px;}
        .History-product-list li span{width: 14.2%;float: left;text-align: center;}
        .History-product-list li{height: 43px;line-height: 43px;background-color: #fff;border-bottom: 1px solid #CCCCCC;}
        .History-product-list li:first-child{height: 40px;line-height: 40px;background-color: #cccccc;}
        .History-product-list li:last-child{border-bottom: none;}
        .orangebg{background-color:#ff6f17;}
        .nav-div .nav-cate .ass_menu {display: none;}
		
		.mbao_pic{float:left;border:1px solid #DEDEDE;}
		.w300{float:left;width:240px;}
		.product_title{border:1px solid #dedede;line-height:42px;font-size:16px;padding:0 10px; background:#fcfcfc;}
		.product_list{border:1px solid #dedede;border-top:0 none;}
		.product_list li{padding:10px 15px;border-bottom:1px dotted #dedede;}
		.product_list li:last-child{border-bottom:0;}
		.product_list li .pirce{color:#ff6f17;padding-bottom:5px;}
		.w900{float:right;width:940px;}
		.detailwrap{border:1px solid #dedede;border-top:0 none;}
		.pro_parameter{padding:15px 0;margin:0 20px;border-bottom:1px dotted #dedede; overflow:hidden;}
		.pro_parameter li{float:left;width:198px;padding-right:26px;line-height:30px;height:30px;text-overflow:ellipsis;white-space:nowrap; overflow:hidden;}
    </style>
    

@endsection
@section('js')
<script src="https://cdn.bootcss.com/echarts/4.2.0-rc.2/echarts-en.common.js"></script>
<script type="text/javascript" src="https://hanlei525.github.io/layui-v2.4.3/layui-v2.4.5/layui.js"> </script>
    <link href="https://hanlei525.github.io/layui-v2.4.3/layui-v2.4.5/css/layui.css" rel="stylesheet" type="text/css"/>
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

            //数量输入检测
            $('#pur_num').blur(function(){
                var _self = $(this);
                //数量
                var goodsNumber = Number(_self.val());//当前输入值
                var packing_spec = Number(_self.attr('packing_spec'));//规格
                var can_num = Number(_self.attr('can_num')); //可售
                if((/^(\+|-)?\d+$/.test( goodsNumber ))&&goodsNumber>0){
                    if(goodsNumber > can_num){
                        var _count = can_num%packing_spec; //整除为0
                        if(_count>0){
                            $(".pur_num").val(can_num - _count);
                        }else{
                            $(".pur_num").val(can_num);
                        }
                    }else{
                        var _count2 = goodsNumber%packing_spec;
                        if(_count2>0){
                            // $(".pur_num").val(goodsNumber - _count2);
                             $(".pur_num").val(packing_spec);
                        }else if(_count2=0){
                        	$(".pur_num").val(goodsNumber);
                        }
                    }
                }else{
                    $.msg.error('输入的数量有误');
                    _self.val(packing_spec);
                }
            });

            $(".nav-cate").hover(function(){
                $(this).children('.ass_menu').toggle();// 鼠标悬浮时触发
            });

            //折线图
            var myChart = echarts.init(document.getElementById('price_zst'));
            // 指定图表的配置项和数据
            var option = {
                title: {
                    text: ''
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data:["{{$good_info['goods_name']}}"]
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data:[]
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                    {
                        name:"{{$good_info['goods_name']}}",
                        type:'line',
                        stack: '价格',
                        data:[]
                    }
                ]
            };

            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);

            $.get('/price/ajaxcharts?id={{$good_info['goods_id']}}').done(function (data) {
                // console.log(data);
                
                myChart.setOption({
                    xAxis: {
                        data: data.data.time
                    },
                    series: [{
                        // 根据名字对应到相应的系列
                        data: data.data.price
                    }]
                });
                
                
            })
        })
	</script>
@endsection

@section('content')
    <div class="clearfix" style="background-color:white;">
	<div class="w1200 pr ovh">
		<div class="crumbs mt5">当前位置：<a href="/goodsList">商品列表</a> &gt;<span class="gray">{{$good_info['goods_name']}}</span></div>
		<div class="mbao_pic"><img src="/default/images/img_001.jpg?v=2019"  width="400" height="400"/></div>
		<div class="fl ml35 mt5">
			<h1 class="fwb fs16">{{$good_info['goods_full_name']}}</h1>
			<span class="red mt5 db"></span>
			<div class="pro_price f4bg mt10">
				<div class="pro_price_dj fl"><span class="ml15 letter-space">单价</span><span class="ml15 fwb"><font class="fs22 red">￥{{$good_info['shop_price']}}元</font>/kg</span></div>

			</div>
			<div class="pro_detail">
				<span class="ml15 pro_detail_title letter-space fl" style="letter-spacing:8px;">可售数</span><span  class="pro_value">{{$good_info['goods_number']}}{{$good_info['unit_name']}}</span>
                <span class="fl ">包装规格</span><span  class="ml35 fl">{{$good_info['packing_spec']}}{{$good_info['packing_unit']}}</span>
			</div>

			<div class="pro_detail">
				<span class="ml15 letter-space fl">编号</span><span  class="pro_value">{{$good_info['goods_sn']}}</span>
                <span class="fl letter-space">品牌</span><span  class="ml5 fl">{{$good_info['brand_name']}}</span>
			</div>

            <div class="pro_detail">
                <span class="ml15 pro_detail_title fl" style="letter-spacing:8px;">业务员</span><span  class="pro_value">{{$good_info['salesman']}}</span>
                <span class="fl">联系方式</span><span  class="ml35 fl">{{$good_info['contact_info']}}</span>
            </div>

            <div class="pro_detail">
                <span class="ml15 pro_detail_title fl">生产日期</span><span  class="pro_value">{{$good_info['production_date']}}</span>
                 <span class="fl letter-space">含量</span><span  class="ml5 fl">{{$good_info['goods_content']}}</span>
            </div>

			<!-- <div class="pro_detail">
				<span class="ml15 pro_detail_title fl">商品属性</span>
				@foreach($good_info['goods_attr'] as $vo)
					<span style="width:100px;color:#88be51;"  class="pro_value">{{$vo}}</span>
				@endforeach
			</div> -->
			<div class="pro_detail bd1"></div>
			<div class="pro_detail">

				<span class="ml15 fl pro_detail_title" style="letter-spacing: 2px; height: 28px;line-height: 28px;">采  购  量</span>
                <div class="pur_volume ml15">
                    <span class="pur shop_num_reduce">-</span>
                        <input type="text" cid="{{$good_info['id']}}" can_num="{{$good_info['goods_number']}}" packing_spec="{{$good_info['packing_spec']}}" id="pur_num" class="pur_num" value="{{$good_info['packing_spec']}}" />
                    <span class="pur shop_num_plus">+</span>
                </div>
			</div>

			<div class="mt30" style="margin-left: 115px;">
                @if(session('_web_user_id'))
                    @if($collectGoods)
                        <button class="pro_detail_btn orangebg">加入购物车</button><button class="pro_detail_btn cccbg ml15 follow_btn">已收藏</button>
                    @else
                        <button class="pro_detail_btn orangebg">加入购物车</button><button class="pro_detail_btn cccbg ml15 follow_btn">收藏商品</button>
                    @endif
                @else
                    <button class="pro_detail_btn orangebg">加入购物车</button><button class="pro_detail_btn cccbg ml15 follow_btn">收藏商品</button>
                @endif
				
			</div>
		</div>
       
       <!--<div class="pro_chart mt5">
			<h1 class="pro_chart_title">
				商品价格走势
			</h1>
			<div class="pro_chart_img" id="price_zst">

			</div>

		</div>
		--> 
	</div>
        <div class="w1200" style="margin-top:30px;">
        
        <div class="w300">
        	<h3 class="product_title">热卖推荐</h3>
            
            <ul class="product_list">
                @foreach($goodsList as $k=>$v)
                    <li>
                        <p class="tac"><a href="#" title=""><img src="/default/images/img_001.jpg?v=2019" width="150" height="150" alt="维生素"/></a></p>
                        <p class="pirce">900元/KG</p>
                        <p class="txt"><a href="#" title="">新和成 饲料级维生素饲料级维生素</a></p>
                    </li>
                @endforeach

                <li>
                	<p class="tac"><a href="#" title=""><img src="/default/images/img_001.jpg?v=2019" width="150" height="150" alt="维生素"/></a></p>
                    <p class="pirce">900元/KG</p>
                    <p class="txt"><a href="#" title="">新和成 饲料级维生素饲料级维生素</a></p>
                </li>
                <li>
                	<p class="tac"><a href="#" title=""><img src="/default/images/img_001.jpg?v=2019" width="150" height="150" alt="维生素"/></a></p>
                    <p class="pirce">900元/KG</p>
                    <p class="txt"><a href="#" title="">新和成 饲料级维生素饲料级维生素</a></p>
                </li>
                <li>
                	<p class="tac"><a href="#" title=""><img src="/default/images/img_001.jpg?v=2019" width="150" height="150" alt="维生素"/></a></p>
                    <p class="pirce">900元/KG</p>
                    <p class="txt"><a href="#" title="">新和成 饲料级维生素饲料级维生素</a></p>
                </li>
            </ul>
            
            <h3 class="product_title mt20">浏览记录</h3>
            
            <ul class="product_list">
            	<li>
                	<p class="tac"><a href="#" title=""><img src="/default/images/img_001.jpg?v=2019" width="150" height="150" alt="维生素"/></a></p>
                    <p class="pirce">900元/KG</p>
                    <p class="txt"><a href="#" title="">新和成 饲料级维生素饲料级维生素</a></p>
                </li>
                <li>
                	<p class="tac"><a href="#" title=""><img src="/default/images/img_001.jpg?v=2019" width="150" height="150" alt="维生素"/></a></p>
                    <p class="pirce">900元/KG</p>
                    <p class="txt"><a href="#" title="">新和成 饲料级维生素饲料级维生素</a></p>
                </li>
                <li>
                	<p class="tac"><a href="#" title=""><img src="/default/images/img_001.jpg?v=2019" width="150" height="150" alt="维生素"/></a></p>
                    <p class="pirce">900元/KG</p>
                    <p class="txt"><a href="#" title="">新和成 饲料级维生素饲料级维生素</a></p>
                </li>
                <li>
                	<p class="tac"><a href="#" title=""><img src="/default/images/img_001.jpg?v=2019" width="150" height="150" alt="维生素"/></a></p>
                    <p class="pirce">900元/KG</p>
                    <p class="txt"><a href="#" title="">新和成 饲料级维生素饲料级维生素</a></p>
                </li>
            </ul>
            
        </div>
        <div class="w900">
        	<h3 class="product_title">商品详情</h3>
            <div class="detailwrap">
                {!! $good_info['goods_desc'] !!}
                {{--<ul class="pro_parameter">--}}
                    {{--<li>品　　牌：新和成</li>--}}
                    {{--<li>可 售 数：600kg</li>--}}
                    {{--<li>包装规格：20箱</li>--}}
                    {{--<li>编　　号：P000002</li>--}}
                    {{--<li>生产日期：2018-9-9</li>--}}
                    {{--<li>含　　量：10%</li>--}}
                    {{--<li>含　　量：10%</li>--}}
                    {{--<li>含　　量：10%</li>--}}
                {{--</ul>--}}
                {{--<div style="width:860px;overflow:hidden;padding:20px;">--}}
                {{----}}
                    {{--<p class="tac"><img src="/default/images/img_001.jpg?v=2019" width="400" height="400" alt="维生素"/></p>--}}
                    {{--<p style="font-size:18px;line-height:38px;">中文名称：维生素A英文名称：vitamin A其他名称：视黄醇(retinol)定义：所有β紫萝酮衍生物的总称。一种在结构上与胡萝卜素相关的脂溶性维生素。有维生素A1及维生素A2两种。</p>--}}
                    {{--<p class="tac"><img src="/default/images/img_001.jpg?v=2019" width="400" height="400" alt="维生素"/></p>--}}
                    {{--<p style="font-size:18px;line-height:38px;">中文名称：维生素A英文名称：vitamin A其他名称：视黄醇(retinol)定义：所有β紫萝酮衍生物的总称。一种在结构上与胡萝卜素相关的脂溶性维生素。有维生素A1及维生素A2两种。</p>--}}
                    {{--<p class="tac"><img src="/default/images/img_001.jpg?v=2019" width="400" height="400" alt="维生素"/></p>--}}
                    {{--<p style="font-size:18px;line-height:38px;">中文名称：维生素A英文名称：vitamin A其他名称：视黄醇(retinol)定义：所有β紫萝酮衍生物的总称。一种在结构上与胡萝卜素相关的脂溶性维生素。有维生素A1及维生素A2两种。</p>--}}
                    {{--<p class="tac"><img src="/default/images/img_001.jpg?v=2019" width="400" height="400" alt="维生素"/></p>--}}
                    {{--<p style="font-size:18px;line-height:38px;">中文名称：维生素A英文名称：vitamin A其他名称：视黄醇(retinol)定义：所有β紫萝酮衍生物的总称。一种在结构上与胡萝卜素相关的脂溶性维生素。有维生素A1及维生素A2两种。</p>--}}
                {{--</div>--}}
            </div>
        </div>
        <!--
            <div class="History_offo">
                <h1>历史报价</h1>
            </div>

            <ul class="History-product-list br1">
                <li>
                    <span style="width:15%">报价日期</span>
                    <span style="width:10%">种类</span>
                    <span style="width:25%">商品名称</span>
                    <span style="width:10%">单价（元/kg）</span>
                    <span style="width:10%">数量（kg）</span>
                    <span style="width:10%">发货地址</span>
                    <span style="width:20%">联系人</span>
                </li>
                @foreach($goodsList as $vo)
                    <li>
                        <span style="width:15%">{{$vo['add_time']}}</span>
                        <span style="width:10%" class="ovh">{{$vo['cat_name']}}</span>
                        <span style="width:25%">{{$vo['goods_full_name']}}</span>
                        <span style="width:10%">{{$vo['goods_number']}}</span>
                        <span style="width:10%">{{$vo['shop_price']}}</span>
                        <span style="width:10%">{{$vo['delivery_place']}}</span>
                        <span style="width:20%">{{$vo['salesman']}}/{{$vo['contact_info']}}</span>
                    </li>
                @endforeach
            </ul>

            {{--<ul class="Self-product-list">--}}
                {{--<li><span class="num_bg1">报价日期</span><span>品牌</span><span>种类</span><span>商品名称</span><span>数量（kg）</span><span>单价（元/kg）</span><span>发货地址</span><span>联系人</span></li>--}}
                {{--@foreach($goodsList as $vo)--}}
                    {{--<li style="width:1200px;height: 60px;clear:both;"><span>{{$vo['add_time']}}</span><span>{{$vo['brand_name']}}</span><span class="ovh">{{$vo['cat_name']}}</span><span >{{$vo['goods_name']}}</span><span>{{$vo['goods_number']}}</span><span>{{$vo['shop_price']}}</span><span>{{$vo['delivery_place']}}</span><span>{{$vo['salesman']}}/{{$vo['contact_info']}}</span></li>--}}
                {{--@endforeach--}}
            {{--</ul>--}}
            <!--页码
            <div class="news_pages">
                <ul id="page" class="pagination">

                </ul>
            </div>
            -->
           
            
        </div>
    </div>
    <div class="clearfix whitebg ovh mt10" style="font-size: 0;">
@endsection

@section('bottom_js')
	<script>
        $(".shop_num_reduce").click(function(){
            var number = parseInt($(".pur_num").val());
            var packing_spec = parseInt("{{$good_info['packing_spec']}}");
            if(number<=packing_spec){
                $(".pur_num").val(number);
            }else{
                $(".pur_num").val(number-packing_spec);
            }
        });

        $(".shop_num_plus").click(function(){
            var number = parseInt($(".pur_num").val());
            var packing_spec = parseInt("{{$good_info['packing_spec']}}");
            var can_num = parseInt($(".pur_num").attr('can_num'));
            if(number + packing_spec > can_num){
                var _count = can_num%packing_spec;
                if(_count>0){
                    $(".pur_num").val(can_num - _count);
                }else{
                    $(".pur_num").val(can_num);
                }

            }else{
                $(".pur_num").val(number+packing_spec);
            }
        });

        $(".orangebg").click(function(){
            var userId = "{{session('_web_user_id')}}";
            if(userId==""){
                layer.confirm('请先登录再进行操作。', {
                    btn: ['去登陆','再看看'] //按钮
                }, function(){
                    window.location.href='/login';
                }, function(){

                });
                return false;
            }
            var id = "{{$good_info['id']}}";
            var number =  $(".pur_num").val();
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

        $(".follow_btn").click(function(){
            var userId = "{{session('_web_user_id')}}";
            if(userId==""){
                layer.confirm('请先登录再进行操作。', {
                    btn: ['去登陆','再看看'] //按钮
                }, function(){
                    window.location.href='/login';
                }, function(){

                });
                return false;
            }
            var goods_id = "{{$good_info['goods_id']}}";
            $.post("/addCollectGoods",{'id':goods_id},function(res){
                if(res.code==1){
                    $.msg.success("收藏成功",1);
                    window.location.reload();
                }else{
                    $.msg.alert(res.msg);
                }
            },"json");
        });

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
                    , theme: "#88be51"
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/goodsDetail?currpage="+obj.curr+"&shop_id={{$shop_id}}&id={{$id}}";
                        }
                    }
                });
            });
        }
	</script>
@endsection

