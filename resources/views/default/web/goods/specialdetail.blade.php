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
    </style>

@endsection
@section('content')
    <div class="clearfix" style="background-color:white;">
        <div class="w1200 pr ovh">
            <div class="crumbs mt5">当前位置：<a href="javascript:">特殊规格</a> > <span class="gray">{{ $info['goods_full_name'] }}</span></div>
            <div class="w1200p" style="min-height: 400px">
                <h1 class="info-detail-title">
                    {{ $info['goods_full_name'] }}
                </h1>
                <div class="info-detail-bq gray">
                    <div style="display: inline-block;">发布时间： {{ $info['add_time'] }}</div>
                    {{--<div style="display: inline-block;margin-left: 40px;">来源：{{ $article['author'] }}</div>--}}
                    <div class="bshare-custom" style="line-height:38px !important;display: inline-block;margin-left: 40px;"><div class="bsPromo bsPromo2"></div>
                        <div class="bsPromo bsPromo2"></div>
                    </div>

                </div>
                <div class="info-detail-content">
                    {!! $info['goods_desc'] !!}
                </div>
            </div>
        </div>
        <div class="clearfix whitebg ovh mt10" style="font-size: 0;"></div>
    </div>
    <div class="clearfix whitebg ovh mt10" style="font-size: 0;"></div>
@endsection

