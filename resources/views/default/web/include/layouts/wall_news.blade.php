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
                <div class="ovh mt20 ml15 mb20"><input type="text" class="search_input br1 fl"/><div class="fl search_btn tac code_greenbg white">搜索</div></div>
            </div>
            <!--资讯中心-->
            <div class="today_news_search whitebg mt20">
                <h1 class="today_news_top ovh"><span class="ml10">资讯中心</span></h1>
                <ul class="news_center">
                    <li><a>今日资讯</a></li>
                    <li><a>最新资讯</a></li>
                    <li><a>热门资讯</a></li>
                </ul>
            </div>
            <!--热门资讯-->
            <div class="today_news_search whitebg mt20">
                <h1 class="today_news_top ovh"><span class="ml10">热门资讯</span></h1>
                <ul class="news_Hot">

                    <li><div class="news_list_num orangebg fl mr10">1</div><a class="fl">猪饲料分为哪些类别?</a></li>
                    <li><div class="news_list_num code_greenbg fl mr10">2</div><a class="fl">猪饲料分为哪些类别?</a></li>
                    <li><div class="news_list_num code_greenbg fl mr10">3</div><a class="fl">猪饲料分为哪些类别?</a></li>
                    <li><div class="news_list_num cdbg fl mr10">4</div><a class="fl">猪饲料分为哪些类别?</a></li>
                    <li><div class="news_list_num cdbg fl mr10">5</div><a class="fl">猪饲料分为哪些类别?</a></li>
                    <li><div class="news_list_num cdbg fl mr10">4</div><a class="fl">猪饲料分为哪些类别?</a></li>
                    <li><div class="news_list_num cdbg fl mr10">5</div><a class="fl">猪饲料分为哪些类别?</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

@include(themePath('.','web').'web.include.partials.footer_service')
@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')
@yield('js')
</body>
</html>
