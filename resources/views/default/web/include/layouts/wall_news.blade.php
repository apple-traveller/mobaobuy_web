<!doctype html>
<html lang="en">
<head>
    <title>会员中心 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    @yield('style')
</head>
<body style="background-color: rgb(244, 244, 244);">
@include(themePath('.','web').'web.include.partials.top')
@component(themePath('.','web').'web.include.partials.top_title', ['title_name' => '资讯中心'])@endcomponent

<div class="clearfix mt25 mb25">
    <div class="w1200">
        <div class="crumbs">当前位置：<a href="/">首页</a> &gt; <a href="/subject/list/56/page/1.html">今日资讯</a> &gt;<span class="gray">中石化华中PP价格上调通知</span></div>
        <!--左边部分-->
        @yield('content')
        <!--右边部分-->

        <div class="today_right_news fl ml15">
            <!--相关搜索-->
            <div class="today_news_search whitebg">
                <h1 class="today_news_top ovh"><span class="ml10">相关搜索</span></h1>
                <div class="ovh mt20 ml15 mb20"><input type="text" class="search_input br1 fl" id="search_info"/><div class="fl search_btn tac code_greenbg white" id="search_submit">搜索</div></div>
            </div>
            <!--资讯中心-->
            <div class="today_news_search whitebg mt20">
                <h1 class="today_news_top ovh"><span class="ml10">资讯中心</span></h1>
                <ul class="news_center">
                    @foreach($cat as $k=>$v)
                    <li><a href="/news.html?cat_id={{$v['id']}}" data_id = {{ $v['id'] }}>{{ $v['cat_name'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <!--热门资讯-->
            <div class="today_news_search whitebg mt20">
                <h1 class="today_news_top ovh"><span class="ml10">热门资讯</span></h1>
                <ul class="news_Hot">

                    @foreach($hot_news as $k=>$v)
                    <li><div class="news_list_num article_id @if($k+1<4) code_greenbg @else cdbg @endif fl mr10" data_id="{{ $v['id'] }}">{{ $k+1 }}</div><a class="fl">{{ $v['title'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@include(themePath('.','web').'web.include.partials.footer_service')
@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')
@yield('js')
<script>
    $('#search_submit').click(function () {
        let title = $('#search_info').val();
        window.location.href = "/news.html?title="+title;
    });
    $('.article_id').click(function () {
        let article = $("#data_id").val();
        window.location.href = "/news.html?id="+article;
    });
</script>
</body>
</html>
