@extends(themePath('.','web').'web.include.layouts.wall_news')
@section('title', getSeoInfoByType('article')['title'].'-'.$cat['cat_name'].'-秣宝')
@section('keywords', getSeoInfoByType('article')['keywords'].','.$cat['cat_name'])
    @if($cat['cat_name'] == '维生素行情播报')
        @section('description', '秣宝饲料原料采购网为中国饲料原料企业提供最新、全面、及时的维生素行情播报包括VA、VE、VD3、VB1、VB6、VB12等各类饲料维生素实时播报，维生素行情走势分析，维生素价格预测，秣宝饲料行情播报助力饲料行业蓬勃发展。')
    @elseif($cat['cat_name'] == '饲料行业')
            @section('description', '秣宝网为中国饲料原料行业提供最新、全面、及时的饲料行业相关新闻资讯，内容涵盖饲料原料、饲料行业新闻、饲料原料供求行情信息，秣宝饲料原料供应链平台助力饲料企业在饲料行业取得蓬勃发展。')
    @elseif($cat['cat_name'] == '饲料百科')
            @section('description', '秣宝饲料原料供应链平台为饲料行业提供饲料百科知识，包括饲料维生素行情信息，饲料氨基酸知识，以及微量元素等各类饲料添加剂百科知识，为饲料行业人员提供免费的饲料原料百科知识。')
    @endif
{{--@section('description', getSeoInfoByType('article')['description'])--}}
@section('style')
    <style>
        .crumbs {padding: 5px 0;overflow: hidden;clear: both;zoom: 1;}
        .crumbs a {padding: 0 5px;}
        .crumbs span {padding-left: 5px;}
        .today_news{width: 912px;height: auto;}
        .today_news_top{height: 50px;line-height: 50px;border-bottom:2px solid #75b335;}
        .today_news_list li{border-bottom: 1px solid #DEDEDE;margin-top:10px;overflow: hidden;}
        .news_content{width: 600px;margin-top: 10px;color: #666;}
        .mr10{margin-right:10px;}
        .ovh{overflow: hidden;}
        .news_pages{margin: 20px auto;}
        .news_pages ul.pagination {text-align: center;}
        .news_pages ul.pagination li {display: inline-block;}
        .news_pages ul.pagination li a {color: #ccc;float: left;padding: 4px 16px;text-decoration: none;transition: background-color .3s;
            border: 1px solid #ddd;margin: 0 4px;}
        .news_pages ul.pagination li a.active {color: #75b335;border: 1px solid #75b335;}
        .news_pages ul.pagination li a:hover:not(.active) {color: #75b335;border: 1px solid #75b335;}

        .today_news_search{width: 272px;overflow: hidden;}
        .search_input{height: 38px;line-height: 38px;box-sizing: border-box;padding: 6px;}
        .search_btn{width: 65px;height: 38px;line-height: 38px;}
        .news_center {width: 245px;margin: 10px auto;}
        .news_center li{line-height: 45px;border-bottom: 1px dashed #DEDEDE;}
        .news_center li a{display: block;}
        .news_center li:last-child{border-bottom: none;}

        .news_Hot{width: 245px;margin: 10px auto;}
        .news_Hot li{color:#999;font-size:16px;line-height: 35px;height: 35px;border: none;display: block;}
        .news_Hot li a:hover{text-decoration: underline;color: #ff6f17;}
        .news_list_num{width: 18px;line-height: 18px;margin-top:8px;text-align: center;color: #fff;}
        .cdbg{background-color: #cdcdcd;}

        .code_greenbg{background-color: #75b335;}
    </style>
@endsection
@section('js')
@endsection
@section('content')
    <div class="crumbs">
        当前位置：<a href="/">首页</a> &gt; <a href="/news.html">资讯中心</a>
        @if($cat['id'] > 0 && $cat['id'] != 2)
            &gt; <a href="/news/{{$cat['id']}}/1.html">{{ $cat['cat_name']}}</a>
        @elseif(!empty($title))
            &gt; {{$title}}
        @endif

    </div>

    <div class="today_news whitebg fl">
        <h2 class="today_news_top ovh"><span class="fs16 ml15 fl" style="font-weight: bold;">{{ $cat['cat_name']}}</span><span class="fr mr10">共<span class="green">{{ $list['total'] }}</span>条数据</span></h2>
        <ul class="ovh ml15 today_news_list mt15" style="min-height: 500px;">
            @foreach($list['list'] as $k=>$v)
            <li>
                <div class="fl mb15" style="width: 200px;height: 114px"><a rel="nofollow" href="/detail/{{ $v['id'] }}.html"><img alt="{{$v['title']}}" src="{{ getFileUrl($v['image']) }}" style="width: 200px;height: 114px"/></a></div>
                <div class="fl ml20">
                    <h2 class="fs18 mt10"><a href="/detail/{{ $v['id'] }}.html">{{ $v['title'] }}</a></h2>
                    <div class="mt30 gray"><span class="ovh">时间：{{ $v['add_time'] }}</span><span class="ml25">浏览量：{{ $v['click'] }}</span><span class="ml25">来源：{{ $v['author'] }}</span></div>
                    <p class="news_content ovhwp">{!! $v['description'] !!}</p>
                </div>
            </li>
            @endforeach
        </ul>
        {!! $linker !!}
    </div>
    <!--右边部分-->
@endsection
@section('js')
    <script>
       $(document).ready(function () {
           console.log($(".today_right_news"));
       })
        $(function () {
            console.log($(".today_right_news"));
        });
    </script>
@endsection

