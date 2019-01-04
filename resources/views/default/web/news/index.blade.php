@extends(themePath('.','web').'web.include.layouts.wall_news')
@section('title', getSeoInfoByType('article')['title'])
@section('keywords', getSeoInfoByType('article')['keywords'])
@section('description', getSeoInfoByType('article')['description'])
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
        .nav-div .nav-cate .ass_menu {display: none;}
    </style>
@endsection
@section('js')
    <script type="text/javascript" src="{{asset('/plugs/jquery/jquery.soChange-min.js')}}"></script>
    <script src="{{asset(themePath('/', 'web').'js/index.js')}}" ></script>
    <script type="text/javascript">
        $(function(){
            $(".nav-cate").hover(function(){
                $(this).children('.ass_menu').toggle();// 鼠标悬浮时触发
            });
        })
    </script>
@endsection
@section('content')
    <div class="clearfix nav-div">
        <div class="nav-cate">
            <div class="cate_title"><span class="ml30">原料分类</span><i class="iconfont icon-menu mr20 fr fs22"></i></div>
            <ul class="ass_menu">
                @foreach(getCategoryTree() as $k=>$level1_item)
                    @if($k<=5)
                        <li><span class="ass_title" title="{{$level1_item['cat_name']}}">{{$level1_item['cat_name']}}</span>
                            <i class="iconfont icon-right fr mr20"></i>
                            <div class="ass_fn whitebg">
                                <ul class="ass_fn_list">
                                    @if(isset($level1_item['_child']))
                                        @foreach($level1_item['_child'] as  $level2_item)
                                            <li>
                                                <h2 class="fn_title fl"><i class="iconfont fr icon-right fr mr20"></i><a class="fr" href="/goodsList?cate_id={{$level2_item['id']}}&cat_name={{$level2_item['cat_name']}}" title="{{$level2_item['cat_name']}}">{{$level2_item['cat_name']}}</a></h2>
                                                @if(isset($level2_item['_child']))
                                                    <div class="ass_fn_list_that ovh fl">
                                                        @foreach($level2_item['_child'] as $level3_item)
                                                            <span><a href="/goodsList?cate_id={{$level3_item['id']}}&cat_name={{$level3_item['cat_name']}}" title="{{$level3_item['cat_name']}}">{{$level3_item['cat_name']}}</a></span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="nav-menu">
            <ul>
                <a href="/"><li>首页</li></a>

                @foreach(getPositionNav('middle') as $item)
                    <a @if($item['is_nofollow']) rel="nofollow" @endif href="{{$item['url']}}"><li>{{$item['name']}}</li></a>
                @endforeach
            </ul>
        </div>
    </div>



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

