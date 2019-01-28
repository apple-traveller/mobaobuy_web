@extends(themePath('.','web').'web.include.layouts.home')
@section('title', getSeoInfoByType('wholesale')['title'])
@section('keywords', getSeoInfoByType('wholesale')['keywords'])
@section('description', getSeoInfoByType('wholesale')['description'])
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
        .input_data{ padding-left: 5px;   border: 1px solid #dedede; height: 27px; box-sizing: border-box;width:158px}
        .chart_btn{    cursor: pointer;border: none; background-color: #dcdcdc; padding: 3.5px 10px; color: #807b7b;font-size: 13px;}
        .chart_btn:hover{background-color: #75b335; color: #fff;}
        .chart_btn.currlight{background-color: #75b335; color: #fff;}
        .fn_title{width: 100px;}
	</style>

@endsection
@section('js')
	{{--<script src="{{asset('plugs/layui/layui.all.js')}}"></script>--}}
	{{--<script src="{{asset(themePath('/', 'web').'js/index.js')}}" ></script>--}}
	{{--<script src="https://cdn.bootcss.com/echarts/4.2.0-rc.2/echarts-en.common.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.1.0/echarts-en.js"></script>
    <script type="text/javascript" src="{{asset(themePath('/','web').'plugs/My97DatePicker/4.8/WdatePicker.js')}}"></script>
	<script type="text/javascript">
        $(function(){
            $(".nav-cate").hover(function(){
                $(this).children('.ass_menu').toggle();// 鼠标悬浮时触发
            });
            @if($goodsInfo['seconds'] > 0)
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
                        hour += day*24;
                        if(hour<=9)hour='0'+hour;
                        if(minute<=9)minute='0'+minute;
                        if(second<=9)second='0'+second;
                        nday.html(day);
                        nhour.html('<s></s>'+hour);
                        nminute.html('<s></s>'+minute);
                        nsecond.html('<s></s>'+second);
                        intDiff--;
                    },1000)
                }
                Remaine_time('{{$goodsInfo['seconds']}}',$('.day_show1'),$('.hour_show1'),$('.minute_show1'),$('.second_show1'));
            @endif

            $(document).delegate('.shop_num_plus','click',function(){
                var ipts=$(this).siblings('input.Bidders_record_text');
                var iptsVal=Number(ipts.val());//当前输入值
                var packing_spec = Number($(this).attr('packing_spec'));//规格
                var max_num = Number($(this).attr('max_limit'));//最大限购量
                console.log(max_num);
                if(max_num == 0){
                    ipts.val(iptsVal+packing_spec);
                }else if(iptsVal+packing_spec > max_num){
                    ipts.val(max_num);
                }else{
                    ipts.val(iptsVal+packing_spec);
                }
            });

            $(document).delegate('.shop_num_reduce','click',function(){
                var ipts=$(this).siblings('input.Bidders_record_text');
                var iptsVal=Number(ipts.val());//当前输入值
                var packing_spec = Number($(this).attr('packing_spec'));//规格
                var min_num = Number($(this).attr('min-limit'));//起售量
                if (iptsVal-packing_spec < min_num) {
                    $.msg.error('已经是最低的购买数量了');
                    return;
                }else{
                     ipts.val(iptsVal-packing_spec);
                }
            });

            var myChart = echarts.init(document.getElementById('price_zst'));
            var option = {
                tooltip : {
                    trigger: 'axis',
                    formatter: function (params) {
                        var res = params[0].seriesName + ' ' + params[0].name;
//                        res += '<br/>  最低价 : ' + params[0].value[1] + '  最高价 : ' + params[0].value[2];
                        return res;
                    }
                },
                legend: {
                    data:['价格走势']
                },
                dataZoom : {
                    show : true,
                    realtime: true,
                    start : 0,
                    end : 100
                },
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : true,
                        axisTick: {onGap:false},
                        splitLine: {show:false},
                        data : []
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        scale:true,
                        boundaryGap: [0.01, 0.01]
                    }
                ],
                series : [
                    {
                        name:'价格指数',//上证指数
                        type:'k',
                        barMaxWidth: 20,
                        data:[ // 开盘，收盘，最低，最高

                        ],
                    }
                ]
            };
            myChart.setOption(option);
            //页面初始化获取按日的全部信息
            getChartInfo();

            $('.get_chart_day').click(function(){
                $('.hid_type').val(1);
                $(this).siblings().removeClass('currlight');
                $(this).addClass('currlight');
                getChartInfo()
            });
            $('.get_chart_week').click(function(){
                $('.hid_type').val(2);
                $(this).siblings().removeClass('currlight');
                $(this).addClass('currlight');
                getChartInfo()
            });
            $('.get_chart_month').click(function(){
                $('.hid_type').val(3);
                $(this).siblings().removeClass('currlight');
                $(this).addClass('currlight');
                getChartInfo()
            });
            $('.chart_search_btn').click(function(){
                getChartInfo()
            });

            function getChartInfo(){
                var _goods_id = $('.goods_id').val();
                var _type = $('.hid_type').val();
                var _begin_time = $('#begin_time').val();
                var _end_time = $('#end_time').val();
                $.get('/price/ajaxcharts?id='+_goods_id+'&type='+_type+'&begin_time='+_begin_time+'&end_time='+_end_time).done(function (data) {
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
                })
            }

            //数量输入检测
            $('#goodsNum').blur(function(){
                var _self = $(this);
                //数量
                var goodsNumber = Number(_self.val());//当前输入值
                var packing_spec = Number(_self.attr('packing_spec'));//规格
                var min_num = Number(_self.attr('min-limit'));//最小起购量
                var max_num = Number(_self.attr('max_limit'));//最大限购量

                if((/^(\+|-)?\d+$/.test( goodsNumber ))&&goodsNumber>=min_num){
                    var _count = goodsNumber%packing_spec;
                    if(_count > 0){
                        if(goodsNumber > max_num){
                            _self.val(max_num);
                        }
//                        _self.val(goodsNumber-_count);
                    }
                }else{
                    layer.msg('输入的数量有误');
                    _self.val(min_num);
                }
            });
        });

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
                    url: "/wholesale/toBalance",
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
			<div class="crumbs mt5">当前位置：<a href="javascript:">集采火拼</a> &gt; <a href="javascript:">商品详情</a><span class="gray"></span></div>
			<div class="pro_chart mt5" style="position:relative">
                <div style="position:absolute;left:110px;top:200px;"><img src="/images/mobao_logo1.png" style="opacity:0.8;" width="250"/></div>
				<h1 class="pro_chart_title">
					商品价格走势
				</h1>
                <div style="margin: 10px 0">
                    <input type="text" class="Wdate input_data" autocomplete="off" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'%y-%M-%d\'}'})" id="begin_time" placeholder="开始时间">
                    <input type="text" class="Wdate input_data" autocomplete="off" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'begin_time\')}',maxDate:'%y-%M-%d'})" id="end_time" placeholder="结束时间">
                    <input type="button" class="chart_btn chart_search_btn" value="查询" />
                    <input type="hidden" class="hid_type " value="1" />
                    <input type="hidden" class="goods_id" value="{{$goodsInfo['goods_id']}}" />
                    <input class="get_chart_day chart_btn currlight" type="button" value="按日">
                    <input class="get_chart_week chart_btn" type="button" value="按周">
                    <input class="get_chart_month chart_btn" type="button" value="按月">
                </div>
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
				<h1 class="fwb fs16">{{$goodsInfo['goods_full_name']}}</h1>
				<span class="red mt5 db"></span>
				<style type="text/css">
					.Time_limit{height:46px;background: url(/img/limit_time.png)no-repeat;}
					.xs_ms{margin-left:15px;width:95px;height:46px;line-height: 46px;background: url(/img/xs_ms.png)no-repeat 0px 16px;font-size: 18px;color: #fff; padding-left: 20px;}
					.time_mode{margin-top:11px;width: 24px;height: 24px;border-radius:6px;background-color: #323232;overflow: hidden;line-height: 24px;text-align: center;color: #fff;}
					.Surplus_time{float:right;width:200px;height: 46px;line-height: 46px;margin-right: 20px;}
				</style>
				<div class="Time_limit mt3">
					<span class="xs_ms fl">集采火拼</span>
					<div class="Surplus_time" >
						<span class="white fl" >剩余时间</span>
                        {{--<span class="time_mode fl ml10 day_show1">00</span>--}}
                        {{--<span class="fl ml5">天</span>--}}
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
						<div class="mt15" style="width: 500px;"><span class="fs14" style="letter-spacing: 10px;">最高价</span><span class="ml20 fs18"><font class="fwb red fs22">￥{{$goodsInfo['activity_price']}}</font>/{{$goodsInfo['unit_name']}}</span></div>
						<div class="mt20"><span class="fs14" style="letter-spacing: 10px;">市场价</span><span class="ml25">￥{{$goodsInfo['market_price']}}/{{$goodsInfo['unit_name']}}</span></div>
					</div>
					<div class="limit_line"></div>
					<div class="tac ovh">
						<span class="db mt35">已参与</span>
						<span class="db red">{{$goodsInfo['partake_quantity']}}{{$goodsInfo['unit_name']}}</span>
					</div>
				</div>
				<div class="pro_detail">
					<span class="ml15 pro_detail_title letter-space fl" style="letter-spacing:8px;">目标数</span><span  class="pro_value">{{$goodsInfo['activity_num']}}{{$goodsInfo['unit_name']}}</span><span class="fl ">包装规格</span><span  class="ml35 fl">{{$goodsInfo['packing_spec'].$goodsInfo['unit_name'].'/'.$goodsInfo['packing_unit']}}</span>
				</div>
				<div class="pro_detail">
					<span class="ml15 letter-space fl">批号</span><span  class="pro_value">{{$goodsInfo['goods_sn']}}</span><span class="fl letter-space">品牌</span><span  class="ml5 fl">{{$goodsInfo['brand_name']}}</span>
				</div>
				<div class="pro_detail">
					<!-- <span class="ml15 pro_detail_title fl">商品含量</span><span  class="pro_value">50%</span> -->
				</div>
				<div class="pro_detail bd1"></div>
				<div class="pro_detail">

					<span class="ml15 fl pro_detail_title" style="letter-spacing: 2px; height: 28px;line-height: 28px;">采  购  量</span>
                    <div class="pur_volume ml15">
                        <span class="pur bbright shop_num_reduce" min-limit="{{$goodsInfo['min_limit']}}" packing_spec="{{$goodsInfo['packing_spec']}}">-</span>
                        <input type="text" cid="{{$goodsInfo['id']}}"  min-limit="{{$goodsInfo['min_limit']}}" packing_spec="{{$goodsInfo['packing_spec']}}" class="pur_num Bidders_record_text" value="{{$goodsInfo['min_limit']}}" id="goodsNum" max_limit="{{$goodsInfo['max_limit']}}" />
                        <span id="min_limit" max_limit="{{$goodsInfo['max_limit']}}" min-limit="{{$goodsInfo['min_limit']}}" class="pur bbleft shop_num_plus" packing_spec="{{$goodsInfo['packing_spec']}}">+</span>
                    </div>

				</div>

				<div class="mt30" style="margin-left: 115px;">
                    @if($goodsInfo['seconds']>0)
                        <button class="pro_detail_btn redbg" onclick="toBalance({{$goodsInfo['id']}},{{$goodsInfo['activity_id']}})">立即下单</button>
                    @else
                        <button class="pro_detail_btn b1b1b1bg">已结束</button>
                    @endif
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

