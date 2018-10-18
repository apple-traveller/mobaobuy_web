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

@endsection
@section('js')
    <script>

    </script>
@endsection
