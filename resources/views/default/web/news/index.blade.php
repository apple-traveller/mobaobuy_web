@extends(themePath('.','web').'web.include.layouts.wall_news')
@section('title', '资讯首页')
@section('style')
    <style>
        .crumbs {padding: 5px 0;overflow: hidden;clear: both;zoom: 1;}
        .crumbs a {padding: 0 5px;}
        .crumbs span {padding-left: 5px;}
        .today_news{width: 912px;height: auto;}
        .today_news_top{height: 50;line-height: 50px;border-bottom:2px solid #75b335;}
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
    <div class="crumbs">当前位置：<a href="/">首页</a> &gt; <a href="/news/list/{{$cat['id']}}/page/1.html">{{ $cat['cat_name']}}</a></div>

    <div class="today_news whitebg fl">
        <h1 class="today_news_top ovh"><span class="fs16 ml15 fl">{{ $cat['cat_name']}}</span><span class="fr mr10">共<span class="orange">{{ $list['total'] }}</span>条数据</span></h1>
        <ul class="ovh ml15 today_news_list mt15">
            @foreach($list['list'] as $k=>$v)
            <li>
                <div class="fl mb15" style="width: 200px;height: 128px"><a href="/detail/{{ $v['id'] }}.html"><img src="{{ getFileUrl($v['image']) }}" style="width: 200px;height: 128px"/></a></div>
                <div class="fl ml20">
                    <h1 class="fs18 mt10"><a href="/detail/{{ $v['id'] }}.html">{{ $v['title'] }}</a></h1>
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

    </script>
@endsection

