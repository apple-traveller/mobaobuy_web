@extends(themePath('.','web').'web.include.layouts.home')
@section('title', getSeoInfoByType('promote')['title'])
@section('keywords', getSeoInfoByType('promote')['keywords'])
@section('description', getSeoInfoByType('promote')['description'])
@section('css')
	<link rel="stylesheet" type="text/css" href="{{asset('plugs/layui/css/layui.css')}}" />
	{{--<link rel="stylesheet" href="{{asset(themePath('/').'css/global.css')}}" />--}}
	<link rel="stylesheet" href="/css/global.css" />
	<link rel="stylesheet" href="/css/index.css" />
	<style>
		.nav-div .nav-cate .ass_menu {display: none;}
		.top-search-div .search-div .logo{background:none;}
        .input_data{ padding-left: 5px;   border: 1px solid #dedede; height: 27px; box-sizing: border-box;width:144px}
        .chart_btn{    cursor: pointer;border: none; background-color: #dcdcdc; padding: 3.5px 10px; color: #807b7b;font-size: 13px;}
        .chart_btn:hover{background-color: #75b335; color: #fff;}
        .chart_btn.currlight{background-color: #75b335; color: #fff;}
        .fn_title{width: 100px;}
        .detail_table{table-layout: fixed; }
        .detail_table tr{height: 40px;color: #666;}
        .detail_table tr td{white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;}
        .detail_table tr td:nth-child(odd){width: 90px; display: inline-block; margin-top: 9px; margin-right: 15px;
            text-align: right;}
        .detail_table tr td:nth-child(even){width: 210px;}
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
                        }else{
                            window.location.reload();return;
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
                var iptsVal= Number(ipts.val());
                var packing_spec = Number(ipts.attr('packing_spec'));//规格
                var min_num = Number(ipts.attr('min-limit'));//起售量
                var max_num = Number(ipts.attr('max-limit'));//起售量
                var can_num = Number(ipts.attr('canSell'));//可售
                if(max_num != 0){
                    if(iptsVal+packing_spec > max_num){
                        $.msg.error('{{trans('home.error_max_limit_num_tips')}}');
                        return;
                    }
                }

                if(iptsVal+packing_spec > can_num){
                    $.msg.error('{{trans('home.error_max_num_tips')}}');
                    return;
                }else{
                    ipts.val(iptsVal + packing_spec);
                }

            });
//            $('.shop_num_reduce').click(function(){
            $(document).delegate('.shop_num_reduce','click',function(){
                var ipts=$(this).siblings('input.Bidders_record_text');
                var iptsVal= Number(ipts.val());
                var packing_spec = Number(ipts.attr('packing_spec'));//规格
                var min_num = Number(ipts.attr('min-limit'));//起售量
                if (iptsVal-packing_spec < min_num) {
                    $.msg.error('{{trans('home.error_min_num_tips')}}');
                    return;
                }else{
                     ipts.val(iptsVal-packing_spec);
                }


            })

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
                    data:['{{trans('home.price_trend')}}']
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
                        name:'{{trans('home.price_index')}}',//上证指数
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
            $('#goodsNum').change(function(){
                var _self = $(this);
                //数量
                var goodsNumber = Number(_self.val());//当前输入
                var packing_spec = Number(_self.attr('packing_spec'));//规格
                var min_num = Number(_self.attr('min-limit'));//起售量
                var can_num = Number(_self.attr('canSell'));//可售
                var max_num = Number(_self.attr('max-limit'));
                //当前购物车数据id 检测是否是数字&&
                if((/^(\+|-)?\d+$/.test( goodsNumber ))&&goodsNumber>min_num){
                    if(goodsNumber > max_num){
                        layer.msg('{{trans('home.error_max_limit_num_tips')}}');
                        window.location.reload();
                        return;
                    }
                    if(goodsNumber>can_num){
                        layer.msg('{{trans('home.error_max_num_tips')}}');
                        _self.val(can_num);
                    }else{
                        var _count = goodsNumber%packing_spec;
                        if(_count>0){
                            _self.val(goodsNumber-_count);
                        }
                    }
                }else{
                    layer.msg('{{trans('home.error_min_num_tips')}}');
                    _self.val(min_num);
                }
            });
        });
        //收藏
        function collectGoods(obj){
            var userId = "{{session('_web_user_id')}}";
            if(userId==""){
                layer.confirm('{{trans('home.no_login_msg')}}。', {
                    btn: ['{{trans('home.login')}}','{{trans('home.see_others')}}'] //按钮
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
                            $.msg.alert('{{trans('home.collection_success')}}');
                            window.location.reload();
                        }else{
                            $.msg.alert(data.msg);
                        }
                    }
                })
            }
        }
        //去结算
        function toBalance(goodsId,activityId){
            var userId = "{{session('_web_user_id')}}";
             if(userId > 0){
                 $.ajax({
                    url: "/isReal",
                    dataType: "json",
                    data: {
                    'userId':userId
                    },
                    async:false, 
                    type: "POST",
                    success: function (data) {
                        if(data.code == 0){
                             layer.confirm('{{trans('home.no_real_name_msg')}}。', {
                                btn: ['{{trans('home.go_real_name')}}','{{trans('home.see_others')}}'] //按钮
                            }, function(){
                                window.location.href='/account/userRealInfo';
                            }, function(){

                            });
                            return;
                        }else{

                            toBalances(goodsId,activityId);
                        }
                    }
                 })
                 
             }else{
                 layer.confirm('{{trans('home.no_login_msg')}}。', {
                    btn: ['{{trans('home.login')}}','{{trans('home.see_others')}}'] //按钮
                     }, function(){
                    window.location.href='/login';
                    }, function(){

                });
                return;
             }
         }
        function toBalances(goodsId,activityId){
            var goodsNum = $('#goodsNum').val();
            var activityIdEncrypt = $('#activityId').val();
            if('{{session('_web_user_id')}}'){
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
			<div class="crumbs mt5">{{trans('home.curr')}}：<a href="javascript:">{{trans('home.buy_limit')}}</a> &gt; <a href="javascript:">{{trans('home.product_details')}}</a><span class="gray"></span></div>
			<div class="pro_chart mt5" style="position:relative">
                <div style="position:absolute;left:110px;top:200px;"><img src="/images/mobao_logo1.png" style="opacity:0.8;" width="250"/></div>
				<h1 class="pro_chart_title">
                    {{trans('home.product_price_trend')}}
				</h1>
                <div style="margin: 10px 0">
                    <input type="text" class="Wdate input_data" autocomplete="off" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'%y-%M-%d\'}'})" id="begin_time" placeholder="{{trans('home.start_time')}}">
                    <input type="text" class="Wdate input_data" autocomplete="off" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'begin_time\')}',maxDate:'%y-%M-%d'})" id="end_time" placeholder="{{trans('home.end_time')}}">
                    <input type="button" class="chart_btn chart_search_btn" value="{{trans('home.query')}}" />
                    <input type="hidden" class="hid_type " value="1" />
                    <input type="hidden" class="goods_id" value="{{$goodsInfo['goods_id']}}" />
                    <input class="get_chart_day chart_btn currlight" type="button" value="{{trans('home.by_day')}}">
                    <input class="get_chart_week chart_btn" type="button" value="{{trans('home.by_week')}}">
                    <input class="get_chart_month chart_btn" type="button" value="{{trans('home.monthly')}}">
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
				<h1 class="fwb fs16">{{getLangData($goodsInfo,'goods_full_name')}}</h1>
				<span class="red mt5 db"></span>
				<style type="text/css">
					.Time_limit{height:46px;background: url(/img/limit_time.png)no-repeat;}
					.xs_ms{margin-left:15px;width:95px;height:46px;line-height: 46px;background: url(/img/xs_ms.png)no-repeat 0px 16px;font-size: 18px;color: #fff; padding-left: 20px;}
					.time_mode{margin-top:11px;width: 24px;height: 24px;border-radius:6px;background-color: #323232;overflow: hidden;line-height: 24px;text-align: center;color: #fff;}
					.Surplus_time{float:right;width:230px;height: 46px;line-height: 46px;margin-right: 20px;}
				</style>
				<div class="Time_limit mt3">
					<span class="xs_ms fl">{{trans('home.buy_limit')}}</span>
					<div class="Surplus_time" >
						<span class="white fl" >{{trans('home.remaining_time')}}</span>
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
						<div class="mt15" style="width: 500px;"><span class="fs14">{{trans('home.price_spike')}}</span><span class="ml20 fs18"><font class="fwb red fs22">￥{{$goodsInfo['activity_price']}}</font>/{{$goodsInfo['unit_name']}}</span></div>
						<div class="mt20"><span class="fs14">{{trans('home.market_price')}}</span><span class="ml25">￥{{$goodsInfo['market_price']}}/{{$goodsInfo['unit_name']}}</span></div>
					</div>
					<div class="limit_line"></div>
					<div class="tac ovh">
						<span class="db mt35">{{trans('home.cumulative_sale')}}</span>
						<span class="db red">{{$goodsInfo['activity_num'] - $goodsInfo['available_quantity']}} {{$goodsInfo['unit_name']}}</span>
					</div>
				</div>
                <table class="detail_table mt10 ">
                    <tbody>
                    <tr>
                        <td>{{trans('home.stock')}}</td>
                        <td>@if($goodsInfo['available_quantity']>0) {{$goodsInfo['available_quantity']}} @else 0 @endif{{$goodsInfo['unit_name']}}</td>
                        <td>{{trans('home.spec2')}}</td>
                        <td title="{{$goodsInfo['packing_spec'].$goodsInfo['unit_name'].'/'.getLangData($goodsInfo,'packing_unit')}}">
                            {{$goodsInfo['packing_spec'].$goodsInfo['unit_name'].'/'.getLangData($goodsInfo,'packing_unit')}}
                        </td>
                    </tr>
                    <tr>
                        <td >{{trans('home.number')}}</td>
                        <td>{{$goodsInfo['goods_sn']}}</td>
                        <td >{{trans('home.brand')}}</td>
                        <td title="{{getLangData($goodsInfo,'brand_name')}}">{{getLangData($goodsInfo,'brand_name')}}</td>
                    </tr>
                    </tbody>
                </table>
                {{--{{dd($goodsInfo['goods_attrs'])}}--}}
                @if(!empty($goodsInfo['goods_attrs']))
                    @foreach($goodsInfo['goods_attrs'] as $k=>$v)
                        @if($k%2 == 0)
                            <div class="pro_detail">
                            <span class="ml15 letter-space fl" @if(mb_strlen($v['attr'],'UTF8') >=4) style="letter-spacing:0;width: 88px;" @elseif(mb_strlen($v['attr'],'UTF8') == 3) style="letter-spacing: 8px;width: 88px;" @endif>{{$v['attr']}}</span><span  class="pro_value">{{$v['value']}}</span>
                        @else
                            <span class="fl letter-space" @if(mb_strlen($v['attr'],'UTF8') >=4) style="letter-spacing:0;width: 88px;" @elseif(mb_strlen($v['attr'],'UTF8') == 3) style="letter-spacing: 8px;width: 88px;" @endif>{{$v['attr']}}</span><span  class="ml5 fl">{{$v['value']}}</span>
                            </div>
                        @endif
                    @endforeach
                 @endif
				<div class="pro_detail">
					<!-- <span class="ml15 pro_detail_title fl">商品含量</span><span  class="pro_value">50%</span> -->
				</div>
				<div class="pro_detail bd1"></div>
				<div class="pro_detail">

					<span class="ml15 fl pro_detail_title" style="height: 28px;line-height: 28px;width:120px">{{trans('home.purchase_num')}}</span>
                    <div class="pur_volume ml15">
                        <span class="pur shop_num_reduce">-</span>
                        <input type="text" cid="{{$goodsInfo['id']}}" min-limit="{{$goodsInfo['min_limit']}}" packing_spec="{{$goodsInfo['packing_spec']}}" canSell="{{$goodsInfo['available_quantity']}}" max-limit="{{$goodsInfo['max_limit']}}" class="pur_num Bidders_record_text" value="{{$goodsInfo['min_limit']}}" id="goodsNum" />
                        <span class="pur shop_num_plus" >+</span>
                    </div>

				</div>

				<div class="mt30" style="margin-left: 115px;">
                    @if($goodsInfo['seconds']>0)
                        <button class="pro_detail_btn redbg" onclick="toBalance({{$goodsInfo['id']}},{{$goodsInfo['activity_id']}})">{{trans('home.order_immediately')}}</button>
                    @else
                        <button class="pro_detail_btn b1b1b1bg">{{trans('home.end')}}</button>
                    @endif
                    @if(session('_web_user_id'))
                        @if($goodsInfo['collectGoods'])
                         <button class="pro_detail_btn cccbg ml15 follow_btn" id="{{$goodsInfo['id']}}" aid="" onClick="collectGoods(this)">{{trans('home.collected')}}</button>
                         @else
                         <button class="pro_detail_btn cccbg ml15 follow_btn" id="{{$goodsInfo['id']}}" aid="" onClick="collectGoods(this)">{{trans('home.collection')}}</button>
                         @endif
                    @else
                        <button class="pro_detail_btn cccbg ml15 follow_btn" id="{{$goodsInfo['id']}}" aid="" onClick="collectGoods(this)">{{trans('home.collection')}}</button>
                    @endif
                   
				</div>
				<input type="hidden" name="" value="{{encrypt($goodsInfo['activity_id'])}}" id="activityId" />
			</div>
		</div>
	</div>
@endsection

