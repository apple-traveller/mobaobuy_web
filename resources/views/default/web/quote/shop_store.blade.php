@extends(themePath('.','web').'web.include.layouts.home')
@if(isset($t) && $t==2)
    @section('title', getSeoInfoByType('brand_quote')['title'])
    @section('keywords', getSeoInfoByType('brand_quote')['keywords'])
    @section('description', getSeoInfoByType('brand_quote')['description'])
@else
    @section('title', getSeoInfoByType('quote')['title'])
    @section('keywords', getSeoInfoByType('quote')['keywords'])
    @section('description', getSeoInfoByType('quote')['description'])
@endif
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/','web').'css/quotelist.css')}}" />
	<style>
        .trade-close-btn {border: 1px solid #efefef;background: #efefef;color: #656565;border-radius: 3px;padding: 4px 10px;cursor: default;}
		.nav-div .nav-cate .ass_menu {display: none;}
        .sort_down{background: url(/images/common_icon.png)no-repeat 64px 17px;}
        .sort_up{background: url(/images/common_icon.png)no-repeat 64px -10px}
        .sort_down_up{background: url(/images/down_up.png)no-repeat 63px 13px;}
        .add_time .sort_down_up{background: url(/images/down_up.png)no-repeat 92px 13px;}
        .add_time .sort_down{background: url(/images/common_icon.png)no-repeat 92px 17px;}
        .add_time .sort_up{background: url(/images/common_icon.png)no-repeat 92px -10px;}
        .Self-product-list li span{display: block;height:55px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;}
        .Self-product-list li:first-child span{height:40px;}
        .supply_quote_list li{height: 89px;overflow: initial;}
        .bggreen{background-color: #75b335;color:#fff;}
        .good {
            width: 1200px;
            margin: 0 auto;
            overflow: hidden;
            clear: both;
        }
        .good_l {
            float: left;
            margin-top: 20px;
            width: 100%;
        }
        .good_l ul li {

            float: left;
            width: 100%;
            height: 146px;
            background: #fff;
        }
        .good_l ul li:nth-child(even){background-color: #f9f9f9;}
        .logo_img {
            width: 90px;
            height: 87px;
            line-height: 87px;
            text-align: center;
            margin-left: 30px;
            margin-top: 30px;
        }
        img {
            vertical-align: middle;
        }
        .fs14 {
            font-size: 14px;
        }
        .detail {
            margin-top: 30px;
            margin-left: 25px;
            width: 1020px;
        }
        .detail span {
            float: left;
            padding-top: 2px;
            font-family: "微软雅黑";
            color: #666666;
            width: 755px;
        }
        .gd_btns {
            cursor: pointer;
            float: right;
            display: block;
            line-height: 27px;
            width: 138px;
            height: 27px;
            background: #75b335;
            color: #FFFFFF;
            font-size: 14px;
            border-radius: 5px;
            text-align: center;
            margin-right: 10px;
            margin-top: -27px;
        }
        .gd_btns:hover{
            color:#fff;
        }
        .wrap_bargain {
            background: url(/default/img/shop_store_bg.jpg) no-repeat center top rgb(244, 244, 244);
            overflow: hidden;
            clear: both;
            height: 350px;
        }
	</style>
@endsection
@section('js')
    <script src="{{asset('/plugs/jquery/jquery.marquee.min.js')}}" ></script>
    <script src="{{asset(themePath('/', 'web').'js/index.js')}}" ></script>
	<script>
        $(function(){
            //$(".nav-div .nav-cate .ass_menu").css("display: none");
            $(".nav-cate").hover(function(){
                $(this).children('.ass_menu').toggle();// 鼠标悬浮时触发
            });
            //选择项高亮切换
            $('.sm_breed').click(function(){
                $('.choose').removeClass('bggreen');
                $(this).addClass('bggreen').siblings().removeClass('bggreen');
            });
        })
	</script>
@endsection

@section('content')
    {{--<div><img src="/default/img/shop_store_bg.jpg" style="width: 100%;"/></div>--}}
    <div class="wrap_bargain"></div>
	<div class="clearfix good">
        @if(!empty($storeList))
            <div class="w1200 mt20 good_l" style="margin-top: 20px;">

                <h2 class="product_title" style="background-color: #fff;">
                    {{trans('home.direct_stores_list')}}
                    <div class="fr mr20" style="font-size: 14px">
                        <span>{{trans('home.self_quote_prefix')}} <font class="green"> {{$total}} </font>{{trans('home.stationed')}}</span>
                    </div>
                </h2>
                <ul class="bd_wrap_items">
                    @foreach($storeList as $k=>$v)
                        <li>
                            <div class="logo_img fl gcolor"><img width="50" height="57" src="http://img.sumibuy.com/brand/20171227094915_8553.png"></div>
                            <div class="fl detail fs14">
                                <div style="font-weight: 400">{{trans('home.brand_dealer')}}：{{getLangData($v,'store_name')}}</div>
                                <div>{{trans('home.business_category')}}：{{getLangData($v,'main_cat')}}</div>
                                <div style="width: 800px">
                                    <div style="float: left;width:65%">{{trans('home.main_brand')}}：{{getLangData($v,'main_brand')}}</div>
                                    <div style="float: left;width:35%">{{trans('home.delivery_area')}}：{{getLangData($v,'delivery_area')}}</div>
                                </div>
                                <div style="width: 800px">
                                    <div style="float: left;width:65%">{{trans('home.spec')}}：{{getLangData($v,'spec')}}</div>
                                    <div style="float: left;width:35%">{{trans('home.delivery_method')}}：{{getLangData($v,'delivery_method')}}</div>
                                </div>
                                <a class="gd_btns" href="/goodsList/2?store_id={{$v['id']}}" href="javascript:" target="_blank">{{trans('home.entry')}}</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
                <!--页码-->
            <div class="news_pages" style="margin-top: 20px;text-align: center;">
                <ul id="page" class="pagination"></ul>
            </div>
        @else
            <div class="nodata1">{{trans('home.none_quoted')}}</div>
        @endif
    </div>
@endsection

@section('bottom_js')
<script>
    paginate();

    //分页
    function paginate(){
        layui.use(['laypage'], function() {
            var laypage = layui.laypage;
            laypage.render({
                elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                , count: "{{$total}}" //数据总数，从服务端得到
                , limit: "{{$pageSize}}"   //每页显示的条数
                , curr: "{{$currpage}}"  //当前页
                , prev: "{{trans('home.prev')}}"
                , next: "{{trans('home.next')}}"
                , theme: "#88be51" //样式
                , jump: function (obj, first) {
                    if (!first) {
                        getInfo(obj.curr);
                    }
                }
            });
        });
    }

</script>
@endsection