@extends(themePath('.','web').'web.include.layouts.home')
@section('title', getSeoInfoByType('consign')['title'])
@section('keywords', getSeoInfoByType('consign')['keywords'])
@section('description', getSeoInfoByType('consign')['description'])
@section('css')
	<link rel="stylesheet" type="text/css" href="{{asset('plugs/layui/css/layui.css')}}" />
	{{--<link rel="stylesheet" href="{{asset(themePath('/').'css/global.css')}}" />--}}
	<link rel="stylesheet" href="/css/global.css" />
	<link rel="stylesheet" href="/css/index.css" />
	<style>
		.nav-div .nav-cate .ass_menu {display: none;}
		.top-search-div .search-div .logo{
			background:none;
		}
	</style>

@endsection
@section('js')
	{{--<script src="{{asset('plugs/layui/layui.all.js')}}"></script>--}}
	{{--<script src="{{asset(themePath('/', 'web').'js/index.js')}}" ></script>--}}
	<script src="https://cdn.bootcss.com/echarts/4.2.0-rc.2/echarts-en.common.js"></script>
	<script type="text/javascript">
        $(function(){
            $(".nav-cate").hover(function(){
                $(this).children('.ass_menu').toggle();// 鼠标悬浮时触发
            });

            $(document).delegate('.shop_num_plus','click',function(){
                var ipts=$(this).siblings('input.Bidders_record_text');
                var iptsVal=Number(ipts.val());//当前输入值
                var packing_spec = Number($(this).attr('packing_spec'));//规格
                var canSell = Number($(this).attr('canSell'));//规格

                if(iptsVal+packing_spec > canSell){
                    $.msg.error('不能大于可售');
                    return;
                }else{
                    ipts.val(iptsVal+packing_spec);
                }
            });

            $(document).delegate('.shop_num_reduce','click',function(){
                var ipts=$(this).siblings('input.Bidders_record_text');
                var iptsVal=Number(ipts.val());//当前输入值
                var packing_spec = Number($(this).attr('packing_spec'));//规格
                var canSell = Number($(this).attr('canSell'));//规格
                if (iptsVal-packing_spec < packing_spec) {
                    $.msg.error('已经是最低的购买数量了');
                    return;
                }else{
                     ipts.val(iptsVal-packing_spec);
                }


            })

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
		            data:["{{$goodsInfo['goods_name']}}"]
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
		                name:"{{$goodsInfo['goods_name']}}",
		                type:'line',
		                stack: '价格',
		                data:[]
		            }
		        ]
		    };

		    // 使用刚指定的配置项和数据显示图表。
		    myChart.setOption(option);

		    $.get('/price/ajaxcharts?id={{$goodsInfo['id']}}').done(function (data) {
		    	console.log(data);
		    	
		    	myChart.setOption({
		            xAxis: {
		                data: data.data.time
		            },
		            series: [{
		                // 根据名字对应到相应的系列
		                data: data.data.price
		            }]
		        });
		    	
		        
		    });

            //数量输入检测
            $('#goodsNum').blur(function(){
                var _self = $(this);
                //数量
                var goodsNumber = Number(_self.val());//当前输入值
                var packing_spec = Number(_self.attr('packing_spec'));//规格
                var activity_num = Number(_self.attr('activity_num'));//活动总量

                if((/^(\+|-)?\d+$/.test( goodsNumber ))&&goodsNumber>=packing_spec){
                    if(goodsNumber > activity_num){
                        _self.val(activity_num);
                    }else{
                        var _count = goodsNumber%packing_spec;
                        if(_count > 0){
                            _self.val(goodsNumber-_count);
                        }
                    }
                }else{
                    layer.msg('输入的数量有误');
                    _self.val(packing_spec);
                }
            });
        })

        function collectGoods(obj){
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
                            window.location.reload();
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
            if('{{session('_web_user_id')}}'){
                $.ajax({
                    url: "/consign/toBalance",
                    dataType: "json",
                    data: {
                        'goodsId' : goodsId,
                        'activityId' : activityId,
                        'goodsNum' : goodsNum
                    },
                    type: "POST",
                    success: function(data){
                        // console.log(data);return;
                        if(data.code){
                            // console.log(data);
                            window.location.href='/confirmOrder/'+activityIdEncrypt;
                        }else{
                            $.msg.alert(data.msg);
                        }
                    }
                })
            }else{
                window.location.href='/login';
            }

        }
	</script>
@endsection
@section('content')
	<div class="clearfix" style="background-color:white;">
		<div class="w1200 pr ovh">
			<div class="crumbs mt5">当前位置： <a href="javascript:">寄售清仓</a> &gt;<a href="javascript:">商品详情</a><span class="gray"></span></div>
			<div class="pro_chart mt5">
				<h1 class="pro_chart_title">
					商品价格走势
				</h1>
				<div class="pro_chart_img" id="price_zst">

				</div>
				<div>
                    {{--<span class="pro_chart_opert follow">收藏</span>--}}
                    {{--<span class="pro_chart_opert share ml20"></span>--}}
                    <span class="pro_chart_opert"></span>
                    <span class="pro_chart_opert ml20"></span>
                </div>
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
					<span class="xs_ms fl">清仓特卖</span>
				</div>
				<style type="text/css">
					.price_market{width:635px;height: 109px;background-color: #f4f4f4;}
					.limit_line{float:left;width: 1px;height: 45px;margin-top:32px;background-color: #cccccc;}

				</style>
				<div class="price_market">
					<div class="fl ml20">
						<div class="mt15" style="width: 500px;">
                            <span class="fs14" style="letter-spacing: 10px;">价格</span>
                            <span class="ml20 fs18"><font class="fwb red fs22">￥{{$goodsInfo['activity_price']}}</font>/{{$goodsInfo['unit_name']}}</span>
                        </div>
						<div class="mt20">
                            <span class="fs14" style="letter-spacing: 10px;">市场价</span>
                            <span class="ml25">￥{{$goodsInfo['market_price']}}/{{$goodsInfo['unit_name']}}</span>
                        </div>
					</div>
					<div class="limit_line"></div>
					<div class="tac ovh">
						<span class="db mt35">交货地</span>
						<span class="db red">{{$goodsInfo['delivery_place']}}</span>
					</div>
				</div>
				<div class="pro_detail">
					<span class="ml15 pro_detail_title letter-space fl" style="letter-spacing:8px;">可售量</span>
                    <span  class="pro_value">{{$goodsInfo['activity_num']}}{{$goodsInfo['unit_name']}}</span>
                    <span class="fl ">包装规格</span>
                    <span  class="ml35 fl">{{$goodsInfo['packing_spec'].$goodsInfo['unit_name'].'/'.$goodsInfo['packing_unit']}}</span>
				</div>
                <div class="pro_detail">
                    <span class="ml15 letter-space fl">批号</span>
                    <span  class="pro_value">{{$goodsInfo['goods_sn']}}</span>
                    <span class="fl letter-space">品牌</span>
                    <span  class="ml5 fl">{{$goodsInfo['brand_name']}}</span>
                </div>
                <div class="pro_detail">
                    <span class="ml15 letter-space fl" style="letter-spacing: 1px;width:88px">生产日期</span>
                    <span  class="pro_value">{{$goodsInfo['production_date']}}</span>
                </div>

                @if(!empty($goodsInfo['goods_attrs']))
                    @foreach($goodsInfo['goods_attrs'] as $k=>$v)
                        @if($k%2 == 0)
                            <div class="pro_detail">
                                <span class="ml15 letter-space fl">{{$v['attr']}}</span><span  class="pro_value">{{$v['value']}}</span>
                                @else
                                    <span class="fl letter-space">{{$v['attr']}}</span><span  class="ml5 fl">{{$v['value']}}</span>
                            </div>
                        @endif
                    @endforeach
                @endif
				<div class="pro_detail">
					<!-- <span class="ml15 pro_detail_title fl">商品含量</span><span  class="pro_value">50%</span> -->
				</div>
				<div class="pro_detail bd1"></div>
				<div class="pro_detail">

					<span class="ml15 fl pro_detail_title" style="letter-spacing: 2px; height: 28px;line-height: 28px;">采  购  量</span>
                    <div class="pur_volume ml15">
                        <span class="pur bbright shop_num_reduce" packing_spec="{{$goodsInfo['packing_spec']}}" canSell="{{$goodsInfo['activity_num']}}">-</span>
                        <input type="text" cid="{{$goodsInfo['id']}}" activity_num="{{$goodsInfo['activity_num']}}" packing_spec="{{$goodsInfo['packing_spec']}}" class="pur_num Bidders_record_text" value="{{$goodsInfo['packing_spec']}}" id="goodsNum" />
                        <span id="min_limit" packing_spec="{{$goodsInfo['packing_spec']}}" canSell="{{$goodsInfo['activity_num']}}" class="pur bbleft shop_num_plus">+</span>
                    </div>

				</div>

				<div class="mt30" style="margin-left: 115px;">
                    <button class="pro_detail_btn redbg" onclick="toBalance({{$goodsInfo['id']}},{{$goodsInfo['activity_id']}})">立即下单</button>

                    @if(session('_web_user_id'))
                        @if($goodsInfo['collectGoods'])
                         <button class="pro_detail_btn cccbg ml15 follow_btn" id="{{$goodsInfo['id']}}" aid="" onClick="collectGoods(this)">已收藏</button>
                         @else
                         <button class="pro_detail_btn cccbg ml15 follow_btn" id="{{$goodsInfo['id']}}" aid="" onClick="collectGoods(this)">收藏商品</button>
                         @endif
                    @else
                        <button class="pro_detail_btn cccbg ml15 follow_btn" id="{{$goodsInfo['id']}}" aid="" onClick="collectGoods(this)">收藏商品</button>
                    @endif
                   
				</div>
				<input type="hidden" name="" value="{{encrypt($goodsInfo['activity_id'])}}" id="activityId" />
			</div>
		</div>
	</div>
@endsection

