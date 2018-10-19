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
                <ul class="news_center cat_list">

                </ul>
            </div>
            <!--热门资讯-->
            <div class="today_news_search whitebg mt20">
                <h1 class="today_news_top ovh"><span class="ml10">热门资讯</span></h1>
                <ul class="news_Hot">

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
    $(function () {
        $.ajax({
            'url': '/side_bar',
            'type':'post',
            success:function (res) {
                let cat = '';
                res['cat'].map(function (item,index) {
                    cat +='<li><a href="/news.html?cat_id='+item.id+'" data_id = '+item.id+'>'+item.cat_name+'</a></li>';
                });
                $('.cat_list').append(cat);

                let hot_new = '';
                res['hot_news'].map(function (item,index) {
                    if (index+1<4){
                        hot_new +='<li class="article_id" data_id="'+item.id+'"><div class="news_list_num code_greenbg fl mr10" >'+(index+1)+'</div><a class="fl">'+item.title+'</a></li>';
                    }else {
                        hot_new +='<li class="article_id" data_id="'+item.id+'"><div class="news_list_num cdbg fl mr10" >'+(index+1)+'</div><a class="fl">'+item.title+'</a></li>';
                    }
                });
                $(".news_Hot").append(hot_new);
            }
        });
    });
    $('#search_submit').click(function () {
        let title = $('#search_info').val();
        window.location.href = "/news.html?title="+title;
    });
    $('.news_Hot').on('click','.article_id',function () {
        let article = $(this).attr('data_id');
        window.location.href = "/detail.html?id="+article;
    });
</script>
</body>
</html>
