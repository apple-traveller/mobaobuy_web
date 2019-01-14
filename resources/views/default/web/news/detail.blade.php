@extends(themePath('.','web').'web.include.layouts.wall_news')
    @section('title', $article['title'].'-秣宝网')
    @section('keywords',$article['keywords'])
    @section('description', $article['description'])

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
        .info-detail-content  {
            font-size: 15px;
            line-height: 26px;
            text-indent: 30px;
            word-break: break-all;
            word-wrap: break-word;
            position: relative;
            padding: 10px 20px 20px 20px;
            background-color: #fff;
        }
        .info-detail-content  p {
            margin: 0 0 15px 0
        }
        .info-detail-content  a{
            color: #00a67c;
        }
        .nav-div .nav-cate .ass_menu {display: none;}
        .info-detail-content img{width:100%}
    </style>
@endsection
@section('js')
    <script>
        $(function(){
            $(".nav-cate").hover(function(){
                $(this).children('.ass_menu').toggle();// 鼠标悬浮时触发
            });
        })
    </script>
@endsection
@section('content')
    <div class="crumbs">当前位置：<a href="/">首页</a> &gt; <a href="/news/{{$cat['id']}}/1.html">{{ $cat['cat_name'] }}</a> &gt;<span class="gray">{{ $article['title'] }}</span></div>

    <div class="today_news whitebg fl">
        <style type="text/css">
            .w800p {width: 800px;margin: 0 auto;overflow: hidden;clear: both;}
            .info-detail-title {font-size: 22px; overflow: hidden;clear: both;text-align: center;padding: 20px 0;border-bottom: 1px solid #ebebeb;}
            .info-detail-bq {line-height: 40px;text-align: center;}
            .bshare-custom a {padding-left: 19px;height: 16px;_height: 18px;text-decoration: none;display: none;
                zoom: 1;vertical-align: middle;cursor: pointer;color: #333;margin-right: 3px;-moz-opacity: 1;-khtml-opacity: 1;opacity: 1;}

            .bshare-custom .bshare-qzone {background: url(img/top_logos_sprite.png) no-repeat 0 -234px;*display: inline;display: inline-block;}
            .bshare-custom .bshare-sinaminiblog {background: url(img/top_logos_sprite.png) no-repeat 0 -270px;*display: inline;display: inline-block;}
            .bshare-custom .bshare-renren {background: url(img/top_logos_sprite.png) no-repeat 0 -252px;*display: inline;display: inline-block;}
            .bshare-custom .bshare-qqmb {background: url(img/top_logos_sprite.png) no-repeat 0 -198px;*display: inline;display: inline-block;}
            .bshare-custom .bshare-neteasemb {background: url(img/top_logos_sprite.png) no-repeat 0 -162px;*display: inline;display: inline-block;}
            .bshare-custom .bshare-more {padding-left: 0 !important;color: #333 !important;*display: inline;display: inline-block;}
            .bshare-custom .bshare-more.more-style-addthis {background: url(img/more-style-addthis.png) no-repeat;}
            .bshare-custom #bshare-more-icon, .bshare-custom .bshare-more-iconcustom .bshare-more-icon { background: url(img/more.png) no-repeat;padding-left: 19px !important;}
            .bshare-custom .bshare-more-icon {background: url(img/more.png) no-repeat;padding-left: 19px !important;}
            .info-detail-content {
                padding-top: 10px;
            }
            .new_other {
                max-width: 45%;
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
            }
        </style>
        <div class="w800p">
            <h1 class="info-detail-title">
                {{ $article['title'] }}
            </h1>
            <div class="info-detail-bq gray">
                <div style="display: inline-block;">发布时间： {{ $article['add_time'] }}</div>
                <div style="display: inline-block;margin-left: 40px;">来源：{{ $article['author'] }}</div>
                <div class="bshare-custom" style="line-height:38px !important;display: inline-block;margin-left: 40px;"><div class="bsPromo bsPromo2"></div>
                    <div class="bsPromo bsPromo2"></div>
                </div>

            </div>
            <div class="info-detail-content">
                {!! $article['content'] !!}
            </div>
        </div>
        <div class="w800p pb10 ovh pt10 graybg pl10" style="margin-top:20px; margin-bottom:20px;">
            <p class="fl new_other">上一篇：
                @if(!empty($page_data['up_news_id']))
                <a href="/detail/{{$page_data['up_news_id']}}.html">{{ $page_data['up_news_title'] }}</a>
                    @else
                    <a href="javascript:void(0);">{{ $page_data['up_news_title'] }}</a>
                    @endif
            </p>
            <p class="fr new_other">下一篇：
                @if(!empty($page_data['down_news_id']))
                <a href="/detail/{{$page_data['down_news_id']}}.html">{{ $page_data['down_news_title'] }}</a>
                    @else
                    <a href="javascript:void(0);">{{ $page_data['down_news_title'] }}</a>
                    @endif
            </p>
        </div>
<style>
    .info-h3{overflow:hidden;clear:both;background:#fff;border-bottom:2px solid #75b335;line-height:42px;height:42px;font-weight: bold;font-size:16px;width:800px;margin:0 auto;}
    .relevan{width:800px;margin:0 auto;overflow: hidden;padding-bottom:30px;}
    .relevan li {line-height:40px;height:40px;float: left;width:380px;border-bottom:1px dotted #ebebeb;padding-right:20px;text-overflow:ellipsis;white-space:nowrap;overflow:hidden;}
    .relevan li  span{color:#ccc;padding-right:10px;}
</style>

        <h3 class="info-h3">相关资讯</h3>
        <ul class="relevan">

            @if($aboutNews)
                @foreach($aboutNews as $v)
            <li><span>{{$v['add_time']}}</span><a href="/detail/{{$v['id']}}.html" title="{{$v['title']}}" target="_blank">{{$v['title']}}</a></li>
                @endforeach
            @endif
        </ul>

    </div>
@endsection
@section('js')
    <script>

    </script>
@endsection
