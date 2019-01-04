<!doctype html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')" />
    <meta name="keywords" content="@yield('keywords')" />
    @include(themePath('.','web').'web.include.partials.base')
    @yield('style')


</head>
<body style="background-color: rgb(244, 244, 244);">
@include(themePath('.','web').'web.include.partials.top')
@component(themePath('.','web').'web.include.partials.top_title', ['title_name' => '资讯中心'])@endcomponent

<div class="clearfix mt25 mb25">

    <div class="w1200">
        <!--左边部分111-->
        @yield('content')
        <!--右边部分-->
        <div class="today_right_news fl ml15">
            <!--相关搜索1222-->
            <div class="today_news_search whitebg">
                <h2 class="today_news_top ovh"><span class="ml10" style="font-weight: bold;">相关搜索</span></h2>
                <div class="ovh mt20 ml15 mb20"><input type="text" class="search_input br1 fl" value="@if(!empty($title)){{$title}}@endif" id="search_info"/><div class="fl search_btn tac code_greenbg white" style="cursor: pointer" id="search_submit">搜索</div></div>
            </div>
            <!--资讯中心-->
            <div class="today_news_search whitebg mt20">
                <h2 class="today_news_top ovh"><span class="ml10" style="font-weight: bold;">资讯中心</span></h2>
                <ul class="news_center cat_list">
                    @foreach(getNewsSidebar()['cat'] as $v1)
                        <li><a href="/news/{{ $v1['id'] }}/1.html" data_id = {{ $v1['id'] }}>{{ $v1['cat_name'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <!--热门资讯-->
            <div class="today_news_search whitebg mt20">
                <h2 class="today_news_top ovh"><span class="ml10" style="font-weight: bold;">热门资讯</span></h2>
                <ul class="news_Hot">
                    @foreach(getNewsSidebar()['hot_news'] as $k2=>$v2)
                        @if ($k2+1<4)
                        <li class="article_id" data_id="{{ $v2['id'] }}"><div class="news_list_num code_greenbg fl mr10">{{$k2+1}}</div><a class="fl ovhwp" style="width: 190px;height: 36px;">{{ $v2['title'] }}</a></li>
                        @else
                        <li class="article_id" data_id="{{ $v2['id'] }}"><div class="news_list_num cdbg fl mr10" >{{$k2+1}}</div><a class="fl ovhwp" style="width: 190px;height: 36px;">{{ $v2['title'] }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <div class="today_news_search whitebg mt20">
                <h2 class="today_news_top ovh"><span class="ml10" style="font-weight: bold;">最新资讯</span></h2>
                <ul class="news_Hot">
                    @foreach(getLatestNews() as $k2=>$v2)
                        @if ($k2 < 5)
                            <li class="article_id" data_id="{{ $v2['id'] }}"><div class="news_list_num code_greenbg fl mr10">{{$k2+1}}</div><a class="fl ovhwp" style="width: 190px;height: 36px;">{{ $v2['title'] }}</a></li>
                        @endif
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
        var title = $('#search_info').val();
        window.location.href = "/news.html?title="+title;
    });
    $('.news_Hot').on('click','.article_id',function () {
        var article = $(this).attr('data_id');
        window.location.href = "/detail/"+article+".html";
    });
</script>
</body>
</html>
