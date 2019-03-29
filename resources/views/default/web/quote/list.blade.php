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
        .heightold{height:40px}
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
            // 更多/收起
            $('.pro_more').click(function(){
                $(this).toggleClass('pro_up');
                var mPro=$(this).text();
                if (mPro=='{{trans('home.retract')}}') {
                    $(this).text('{{trans('home.more2')}}');
                    $(this).prev('.pro_brand_list').removeClass('heightcurr');
                    $(this).prev('.pro_brand_list').addClass('heightold');
                } else{
                    $(this).text('{{trans('home.retract')}}');
                    $(this).prev('.pro_brand_list').addClass('heightcurr');
                    $(this).prev('.pro_brand_list').removeClass('heightold');
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
            //选择项高亮切换
            $('.sm_breed').click(function(){
                $('.choose').removeClass('bggreen');
                $(this).addClass('bggreen').siblings().removeClass('bggreen');
            });
        })
	</script>
@endsection

@section('content')
	<div class="clearfix" style="background-color: rgb(248,248,248);">
	<div class="w1200 pr">
		<div class="crumbs mt5 mb5">
            <span class="fl">{{trans('home.curr')}}：</span>
            @if($t == 1)
                <a class="fl" href="/goodsList/1">{{trans('home.self_quote')}}</a>
            @elseif($t == 2)
                @if(!empty($store_info))
                    <a class="fl" href="/goodsList/2?store_id={{$store_info['id']}}">{{trans('home.direct_sale')}} ({{getLangData($store_info,'store_name')}}) </a>
                    <input type="hidden" name="store_id" id="store_id" value="{{$store_info['id']}}" />
                @else
                    <a class="fl" href="/goodsList/2">{{trans('home.direct_sale')}}</a>
                @endif
            @elseif($t == 3)
                <a class="fl" href="/goodsList/3">{{trans('home.supplier')}}</a>
            @else
                <a class="fl" href="/goodsList">{{trans('home.quote')}}</a>
            @endif

            <div class="condition">
                <div style="margin-left:20px;display: none;" class="mode_add tac ml10 condition_tag" id="brand_tag" brand_id="">
                    <i style="cursor: pointer" class="mode_close close_brand"></i>
                </div>
                @if(isset($cate_id) && isset($cat_name) && !empty($cate_id) && !empty($cat_name))
                    <div style="margin-left:20px;" class="mode_add tac ml10 condition_tag" id="cate_tag" cate_id="{{$cate_id}}">
                        {{$cat_name}}<i style="cursor: pointer" class="mode_close close_cate"></i>
                    </div>
                @else
                    <div style="margin-left:20px;display: none;" class="mode_add tac ml10 condition_tag" id="cate_tag" cate_id="">
                        <i style="cursor: pointer" class="mode_close close_cate"></i>
                    </div>
                @endif
            </div>

            @if(!empty($search_data['list']))
                <div class="pro_Open pro_Open_up"></div>
			    <div class="fr">{{trans('home.self_quote_prefix')}}<font class="green" id="relevant_total"> {{$search_data['total']}} </font>{{trans('home.quote_suffix')}}</div>
            @endif
        </div>
        @if(!empty($search_data['list']))
            <div class="pro_screen">
                @if(!empty($search_data['filter']['brands']))
                <div class="pro_brand">
                    <dl class="fl filter_item">
                        <dt class="fl">{{trans('home.brand')}}:</dt>
                        <dd class="pro_brand_list ml30 heightold pro_brand_width">
                            @foreach($search_data['filter']['brands'] as $vo)
                                <a onclick="choseByBrand(1,this)" class="choseByBrand" data-id="{{$vo['id']}}">{{getLangData($vo,'brand_name')}}</a>
                            @endforeach
                        </dd>
                        <div class="fl pro_brand_btn ml20 pro_more pro_more_brand" style="display: none">{{trans('home.more2')}}</div>
                        {{--<div class="fl pro_brand_btn ml20 pro_m_select">多选</div>--}}
                    </dl>
                </div>
                @endif
                @if(!empty($search_data['filter']['cates']))
                <div class="pro_brand">
                    <dl class="fl filter_item">
                        <dt class="fl">{{trans('home.cate')}}:</dt>
                        <dd class="pro_brand_list ml30 heightold pro_cate_width">
                            @foreach($search_data['filter']['cates'] as $vo)
                                <a onclick="choseByCate(1,this)" data-id="{{$vo['id']}}">{{getLangData($vo,'cat_name')}}</a>
                            @endforeach
                        </dd>
                        <div class="fl pro_brand_btn ml20 pro_more pro_more_cate" style="display: none">{{trans('home.more2')}}</div>
                        {{--<div class="fl pro_brand_btn ml20 pro_m_select">多选</div>--}}
                    </dl>
                </div>
                @endif
                @if(!empty($search_data['filter']['city_list']))
                <div class="pro_brand" style="border-bottom: none;">
                    <dl class="fl filter_item"><dt class="fl">{{trans('home.area')}}:</dt>
                        <dd class="pro_brand_list" style="width: 850px;margin-left:25px;">
                            @foreach($search_data['filter']['city_list'] as $vo)
                                <label class=" check_box region">
                                    <input  class="check_box mr5 check_all fl mt10" name="region_box" type="checkbox" data-id="{{$vo['region_id']}}" value="{{$vo['region_name']}}"/>
                                    <span  class="fl">{{$vo['region_name']}}</span>
                                </label>
                            @endforeach
                        </dd>
                        <div onclick="getInfo(1)"  class="fl pro_brand_btn region_btn ml20">{{trans('home.ok')}}</div>
                        <div class="fl pro_brand_btn region_btn ml20 cancel_region">{{trans('home.cancel')}}</div>
                    </dl>
                </div>
                @endif
            </div>
        @endif
            {{--<div class="more_filter_box">更多选项...</div>--}}
	</div>
        @if(!empty($search_data['list']))
            <div class="w1200 mt20 " style="margin-top: 20px;">
                <h2 class="product_title">{{trans('home.quote')}}</h2>
                <div class="scr">
                    <div class="width1200">
                        <div class="sequence-bar" style="padding:0;padding-right:10px;">
                            <div class="fl">
                                @if($t == 1)
                                    <a class="choose default bggreen" href="/goodsList/1" style="height:39px;line-height:39px;margin-top:0;border:0;border-right: solid 1px #e3e3e3;">{{trans('home.all')}}</a>
                                @elseif($t == 2)
                                    <a class="choose default bggreen" href="/goodsList/2" style="height:39px;line-height:39px;margin-top:0;border:0;border-right: solid 1px #e3e3e3;">{{trans('home.all')}}</a>
                                @elseif($t == 3)
                                    <a class="choose default bggreen" href="/goodsList/3" style="height:39px;line-height:39px;margin-top:0;border:0;border-right: solid 1px #e3e3e3;">{{trans('home.all')}}</a>
                                @else
                                    <a class="choose default bggreen" href="/goodsList" style="height:39px;line-height:39px;margin-top:0;border:0;border-right: solid 1px #e3e3e3;">{{trans('home.all')}}</a>
                                @endif

                            </div>
                            <div class="fl">
                                <ul id="sort" sort_name="" class="chooselist">
                                    <li class="sm_breed goods_number" sort=""><span class="sm_breed_span sort_down_up">{{trans('home.num')}}</span></li>
                                    <li class="sm_breed shop_price" sort=""><span class="sm_breed_span sort_down_up">{{trans('home.price')}}</span></li>
                                    <li class="sm_breed add_time" sort=""><span class="sm_breed_span sort_down_up" style="width: 113px;">{{trans('home.shelf_time')}}</span></li>
                                </ul>
                            </div>
                            <div class="fr">

                            </div>
                            <form class="fl" id="formid">
                                <input class="min-max" name="lowest" id="minPrice" @if($lowest!="") value="{{$lowest}}" @else value=""  @endif placeholder="{{trans('home.lowest_price')}}" style="margin-left: 5px">
                                <span class="line">-</span>
                                <input class="min-max" name="highest" id="maxPrice" @if($highest!="") value="{{$highest}}" @else value=""  @endif placeholder="{{trans('home.highest_price')}}" style="margin-left: 5px">
                                <input class="confirm active inline-block" id="btnSearchPrice" value="{{trans('home.ok')}}" type="button" style="margin-left: 5px">
                            </form>

                        </div>
                    </div>
                </div>
                <input type="hidden" id="t" value="{{$t}}" />
                <ul class="Self-product-list">

                    <li class="table_title">
                        <span style="width:12%" class="num_bg1">{{trans('home.store')}}</span>
                        <span style="width:10%;">{{trans('home.cate')}}</span>
                        <span style="width:9%">{{trans('home.brand')}}</span>
                        <span style="width:12%">{{trans('home.spec')}}</span>
                        {{--<span style="width:7%;">数量</span>--}}
                        <span style="width:8%;">{{trans('home.price')}}</span>
                        <span style="width:8%;">{{trans('home.goods_source')}}</span>
                        <span style="width:8%;">{{trans('home.delivery_area')}}</span>
                        <span style="width:8%;">{{trans('home.delivery_method')}}</span>
                        <span style="width:15%;">{{trans('home.contact')}}</span>
                        <span style="width:10%;float:right;">{{trans('home.operation')}}</span>
                    </li>
                    @if(!empty($search_data['list']))
                        @foreach($search_data['list'] as $vo)
                            <li>
                                <span style="width:12%" title="{{getLangData($vo,'store_name')}}" data-id="{{$vo['packing_spec']}}" id="packing_spec">@if(!empty($vo['store_name'])){{getLangData($vo,'store_name')}}@else无@endif</span>
                                <span style="width:10%;" title="{{getLangData($vo,'cat_top_name')}}" class="ovh">{{getLangData($vo,'cat_top_name')}}</span>
                                <span style="width:9%" title="{{getLangData($vo,'brand_name')}}">{{getLangData($vo,'brand_name')}}</span>
                                <span style="width:12%" title="{{getLangData($vo,'goods_content').' '.getLangData($vo,'simple_goods_name')}}"><a class="blue" href="/goodsDetail/{{$vo['id']}}/{{$vo['shop_id']}}">{{getLangData($vo,'goods_content').' '.getLangData($vo,'simple_goods_name')}}</a></span>
                                {{--<span style="width:7%">{{$vo['goods_number']}}{{$vo['unit_name']}}</span>--}}
                                <span style="width:8%;color:red">￥{{$vo['min_price']}}/{{$vo['unit_name']}}</span>
                                <span style="width:8%;">{{getLangGoodsSource($vo['goods_source'])}}</span>
                                <span style="width:8%;">{{$vo['delivery_place']}}</span>
                                <span style="width:8%;">{{getLangData($vo,'delivery_method')}}</span>
                                <span style="width:15%">{{$vo['salesman']}}/{{$vo['contact_info']}}
                                    <img onclick="javascript:window.open('http://wpa.qq.com/msgrd?v=3&uin={{$vo['QQ']}}&site=qq&menu=yes');" style="margin-left:5px;" class="sc_img" src="{{asset(themePath('/','web').'img/login_qq.gif')}}" />
                                </span>

                                <span style="width:10%;float:right;">
                                    @if(($vo['goods_number'] && $vo['expiry_time'] > \Carbon\Carbon::now()) || ($vo['goods_number'] && $vo['expiry_time'] == '0000-00-00 00:00:00') || ($vo['goods_number'] && $vo['expiry_time'] == ''))
                                            <button data-id="{{$vo['id']}}" class="P_cart_btn" num="{{$vo['min_price_num']}}">{{trans('home.add_cart')}}</button>
                                    @elseif($vo['goods_number'] <= 0)
                                            <button class="trade-close-btn">{{trans('home.sold_out')}}</button>
                                    @elseif($vo['expiry_time'] < \Carbon\Carbon::now())
                                            <button class="trade-close-btn">{{trans('home.overdue')}}</button>
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <!--页码-->
                <div class="news_pages" style="margin-top: 20px;text-align: center;">
                    <ul id="page" class="pagination"></ul>
                </div>
            </div>
        @else
            @if(!empty($t))
                <li class="nodata1">{{trans('home.none_quoted')}}</li>
            @else
                <li class="nodata">{{trans('home.quote_list_tips')}}</li>
            @endif
        @endif
    </div>
@endsection

@section('bottom_js')
<script>
    paginate();

    //取消地区选择
    $('.cancel_region').click(function(){
        $("input[name='region_box']").each(function(){
            $(this).attr("checked",false);
        });
        getInfo(1);
    });

    $(".goods_number").click(function(){//sort_goods_number
        setSort('goods_number');
    });

    $(".add_time").click(function(){
        setSort('add_time');
	});

    $(".shop_price").click(function () {
        setSort('shop_price');
    });


    //加入购物车
    $(document).delegate('.P_cart_btn','click',function(){
        var userId = "{{session('_web_user_id')}}";
        if(userId==""){
            $.msg.error("{{trans('home.no_login')}}",1);
            return false;
        }
        var id = $(this).attr("data-id");
//        var number = $("#packing_spec").attr('data-id');
        var number = $(this).attr('data-id');
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


    //价格筛选
    $('#btnSearchPrice').click(function(){
        getInfo(1);
    });

    //删除筛选条件
    $(function(){
        var _cate_width = 0;
        var _brand_width = 0;
        //品牌更多按钮
        $('.pro_brand_width a').each(function(){
            _brand_width += $(this).width()+30;
        });
        if(_brand_width >= 920){
            $('.pro_more_brand').show();
        }
        //类型更多按钮
        $('.pro_cate_width a').each(function(){
            _cate_width += $(this).width()+30;
        });
        if(_cate_width >= 920){
            $('.pro_more_cate').show();
        }

        $(document).delegate('.close_brand','click',function(){
            $('#brand_tag').hide();
            $('#brand_tag').empty();
            $('#brand_tag').attr('brand_id','');
            var _t = $('#t').val();
            if(_t == 1 || _t == 2){
                getInfo(1);
            }else{
                window.location.href = '/goodsList'
            }

        });
        $(document).delegate('.close_cate','click',function(){
//            var _href = window.location.href;
//            _href = _href.match(/&cat_name(\S*)/)[1];
            $('#cate_tag').hide();
            $('#cate_tag').empty();
            $('#cate_tag').attr('cate_id','');

            var _t = $('#t').val();
            if(_t == 1 || _t == 2){
                getInfo(1);
            }else{
                window.location.href = '/goodsList'
            }
        });
    });

    //分页
    function paginate(){
        layui.use(['laypage'], function() {
            var laypage = layui.laypage;
            laypage.render({
                elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                , count: "{{$search_data['total']}}" //数据总数，从服务端得到
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
    //根据品牌筛选
    function choseByBrand(currpage,b_obj){
        var _brand_name = $(b_obj).text();
        var _brand_id = $(b_obj).attr("data-id");
        $('#brand_tag').empty();
        $('#brand_tag').attr('brand_id',_brand_id);
        $('#brand_tag').append(_brand_name+'<i style="cursor: pointer"  class="mode_close close_brand"></i>');
        $('#brand_tag').show();
        getInfo(currpage);
    }
    //根据种类筛选
    function choseByCate(currpage,b_obj){
        var cate_id = $(b_obj).attr("data-id");
        var cat_name = $(b_obj).text();
        $('#cate_tag').empty();
        $('#cate_tag').attr('cate_id',cate_id);
        $('#cate_tag').append(cat_name+'<i style="cursor: pointer"  class="mode_close close_cate"></i>');
        $('#cate_tag').show();
        getInfo(currpage);
    }
    //请求ajax获取列表数据
    function getInfo(currpage){
        var _keyword = $('.search-input').val();
        var _cate_id = $('#cate_tag').attr('cate_id');
        var _brand_id = $('#brand_tag').attr('brand_id');
        var region_ids = [];
        var region_names = [];
        $("input[name='region_box']").each(function(){
            if($(this).is(':checked')){
                region_ids.push($(this).attr('data-id'));
                region_names.push($(this).val());
            }
        });
        var _highest = $('#maxPrice').val();
        var _lowest = $('#minPrice').val();
        {{--var _orderType = "{{$orderType}}";--}}
        var _place_id = region_ids.join("|");

        //获取排序筛选
        var _name = $('#sort').attr('sort_name');
        var _goods_number = '';
        var _shop_price = '';
        var _add_time = '';
        if(_name == 'goods_number'){
            _goods_number = $('.goods_number').attr('sort');
            $('.shop_price span').attr('class','sm_breed_span sort_down_up');
            $('.add_time span').attr('class','sm_breed_span sort_down_up');
        }else if(_name == 'shop_price'){
            _shop_price = $('.shop_price').attr('sort');
            $('.goods_number span').attr('class','sm_breed_span sort_down_up');
            $('.add_time span').attr('class','sm_breed_span sort_down_up');
        }else if(_name == 'add_time'){
            _add_time = $('.add_time').attr('sort');
            $('.goods_number span').attr('class','sm_breed_span sort_down_up');
            $('.shop_price span').attr('class','sm_breed_span sort_down_up');
        }

        var _t = $('#t').val();
        var _store_id = $('#store_id').val();
        $.ajax({
            type: "get",
            url: "/condition/goodsList",
            data: {
                "brand_id":_brand_id,
                "currpage":currpage,
                'highest':_highest,//最高价
                'lowest':_lowest,//最低价
//                'orderType':_orderType,//排序
                'cate_id':_cate_id,//分类
                'place_id':_place_id,//地区
                'sort_goods_number':_goods_number,//数量排序
                'sort_shop_price':_shop_price,//价格排序
                'sort_add_time':_add_time,//时间排序
                'keyword':_keyword,//时间排序
                't':_t, //
                'store_id':_store_id //直营店铺id
            },
            dataType: "json",
            success: function(res){
//                if(_keyword != ''){
//                    changeURL();
//                }
//                changeURL();
                if(res.code==200){
                    var data = res.data;
                    var currpage = data.currpage;
                    var pageSize = data.pageSize;
                    var total = data.total;
                    var list = data.list;
                    var locale = "{{App::getLocale()}}";
//                    console.log(list);
                    $('#t').val(res.data.t);
                    $(".table_title").nextAll().remove();//去除已经出现的数据
                    $("#page").remove();//删除分页div
                    var _html = '';
                    var imgUrlLeft = '<img onclick="javascript:window.open(';
                    var imgUrlRight = '&site=qq&menu=yes\')';
                    for (var i=0;i<list.length;i++)
                    {
                        var _store_name = '无';
                        if(list[i].store_name){
                            _store_name = jqGetLangData(locale,list[i],'store_name');
                        }
                        if(list[i].goods_number && list[i].expiry_time > '{{\Carbon\Carbon::now()}}' || (list[i].goods_number && list[i].expiry_time == '0000-00-00 00:00:00') || (list[i].goods_number && list[i].expiry_time == null)){
                            var _add_cart = '<button data-id="'+list[i].id+'" class="P_cart_btn">{{trans('home.add_cart')}}</button>';
                        }else if(list[i].goods_number <= 0){
                            var _add_cart = '<button class="trade-close-btn">{{trans('home.sold_out')}}</button>';
                        }else if(list[i].expiry_time < '{{\Carbon\Carbon::now()}}'){
                            var _add_cart = '<button class="trade-close-btn">{{trans('home.overdue')}}</button>';
                        }

                        _html += '<li>' +
                            '<span data-id="'+list[i].packing_spec+'" id="packing_spec" style="width:12%;">'+_store_name+'</span>' +
                            '<span style="width:10%;" class="ovh">'+jqGetLangData(locale,list[i],'cat_top_name')+'</span>' +
                            '<span  style="width:9%;">'+jqGetLangData(locale,list[i],'brand_name')+'</span>' +
                            '<span  style="width:12%;"><a class="blue" href="/goodsDetail/'+list[i].id+'/'+list[i].shop_id+'">'+jqGetLangData(locale,list[i],'goods_content')+' '+jqGetLangData(locale,list[i],'simple_goods_name')+'</a></span>' +
//                            '<span style="width:8%;">'+list[i].goods_number+'</span>' +
                            '<span style="color:red;width:8%;">￥'+list[i].min_price+'/'+list[i].unit_name+'</span>' +
                            '<span style="width:8%;">'+jqGetLangGoodsSource(locale,list[i].goods_source)+'</span>' +
                            '<span style="width:8%;">'+list[i].delivery_place+'</span>' +
                            '<span style="width:8%;">'+jqGetLangData(locale,list[i],'delivery_method')+'</span>' +

                            '<span style="width:15%;">'+list[i].salesman+'/'+list[i].contact_info+imgUrlLeft+'http://wpa.qq.com/msgrd?v=3&uin='+list[i].QQ+imgUrlRight+';" style="margin-left:5px;" class="sc_img" src="{{asset(themePath('/','web').'img/login_qq.gif')}}" /></span>' +
                            '<span style="width:10%;float:right;">'+_add_cart+'</span>' +
                            '</li>';
                    }
                    $(".table_title").after(_html);
                    $(".news_pages").append('<ul id="page" class="pagination"></ul>');
                    $('#relevant_total').text(total);
                    //分页
                    layui.use(['laypage'], function() {
                        var laypage = layui.laypage;
                        laypage.render({
                            elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                            , count: total //数据总数，从服务端得到
                            , limit: pageSize //每页显示的条数
                            , curr: currpage //当前页
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
                }else{
                    $(".table_title").nextAll().remove();
                    $(".table_title").after('<li style="color:red;">没有相关数据</li>');
                }
            }
        });
    }
    //排序
    function setSort(_name){
        var _this = $('.'+_name); //.goods_name
        var _obj = $('.'+_name+' span'); //.goods_name span
        var _down_up = _obj.hasClass("sort_down_up");
        var _down = _obj.hasClass("sort_down");
        var _up = _obj.hasClass("sort_up");
        if(_down_up == true && _down == false && _up == false){//默认情况 没用goods_number排序 此时点第一下执行倒序
            _this.attr('sort','desc');
            _obj.attr('class','sm_breed_span sort_down');
            $('#sort').attr('sort_name',_name);
            getInfo(1);
        }else if(_down_up == false && _down == true && _up == false){//此时是倒序 点击后正序
            _this.attr('sort','asc');
            _obj.attr('class','sm_breed_span sort_up');
            $('#sort').attr('sort_name',_name);
            getInfo(1);
        }else if(_down_up == false && _down == false && _up == true){//此时是正序 点击后倒序
            _this.attr('sort','desc');
            _obj.attr('class','sm_breed_span sort_down');
            $('#sort').attr('sort_name',_name);
            getInfo(1);
        }
    }

</script>
@endsection