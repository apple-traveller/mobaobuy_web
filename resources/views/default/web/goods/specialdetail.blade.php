@extends(themePath('.','web').'web.include.layouts.home')
@if(empty(getSeoInfoByType('goods')['title']))
    @section('title', $info['goods_name'])
@else
    @section('title', $info['goods_name'].'-'.getSeoInfoByType('goods')['title'])
@endif
@section('keywords', getSeoInfoByType('goods')['keywords'])
@section('description', getSeoInfoByType('goods')['description'])
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('plugs/layui/css/layui.css')}}" />
    {{--<link rel="stylesheet" href="{{asset(themePath('/').'css/global.css')}}" />--}}
    <link rel="stylesheet" href="/css/global.css" />
    <link rel="stylesheet" href="/css/index.css" />
    <style>
        .nav-div .nav-cate .ass_menu {display: none;}
        .top-search-div .search-div .logo{background:none;}
        .input_data{ padding-left: 5px;   border: 1px solid #dedede; height: 27px; box-sizing: border-box;width:158px}
        .chart_btn{    cursor: pointer;border: none; background-color: #dcdcdc; padding: 3.5px 10px; color: #807b7b;font-size: 13px;}
        .chart_btn:hover{background-color: #75b335; color: #fff;}
        .chart_btn.currlight{background-color: #75b335; color: #fff;}
        .fn_title{width: 100px;}
        .info-detail-content {
            padding: 0 50px;
        }
        .info-detail-content  p {
            margin: 0 0 15px 0
        }
        .info-detail-content  a{
            color: #00a67c;
        }
        .nav-div .nav-cate .ass_menu {display: none;}
    </style>

@endsection
@section('js')
    <script>
        $(function(){
            $('.HistoryLi li').hover(function(){
                $(this).addClass('titlecurr').siblings().removeClass('titlecurr');
                $('.proitemlist>li').eq($(this).index()).show().siblings().hide();
            });
            $(".nav-cate").hover(function(){
                $(this).children('.ass_menu').toggle();// 鼠标悬浮时触发
            });

        });
    </script>
@endsection
@section('content')
    <div class="clearfix" style="background-color: rgb(244, 244, 244);">
        <div class="clearfix mb20">
            <div class="w1200 crumbs" style="margin: 10px auto">当前位置：<a href="javascript:">特殊规格</a> > <span class="gray">{{ $info['goods_name'] }}</span></div>
            <div class="w1200" style="min-height: 400px;background-color: #fff">
                <h1 class="info-detail-title">
                    {{ $info['goods_name'] }}
                </h1>
                <div class="info-detail-bq gray">
                    <div>发布时间： {{ $info['add_time'] }}</div>
                    {{--<div style="display: inline-block;margin-left: 40px;">来源：{{ $article['author'] }}</div>--}}
                    {{--<div class="bshare-custom" style="line-height:38px !important;display: inline-block;margin-left: 40px;"><div class="bsPromo bsPromo2"></div>--}}
                        {{--<div class="bsPromo bsPromo2"></div>--}}
                    {{--</div>--}}

                </div>
                <div class="info-detail-content">
                    {!! $info['goods_desc'] !!}
                </div>
            </div>
        </div>
    </div>
@endsection

