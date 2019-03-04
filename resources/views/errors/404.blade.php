@extends(themePath('.','web').'web.include.layouts.home')
@section('css')
    <style type="text/css">
        .nav-div .nav-cate .ass_menu {display: none;}
        .not_found{text-align:center;background:url(/img/not_found.jpg) no-repeat center 100px #f4f4f4;height:400px;font-size:16px;}
        .not_found_p{padding-top:260px;color:#c4c4c4;}
        .not_found_a{background:#75b335;border-radius:5px;color:#fff;padding:8px 20px;text-decoration:none; display:inline-block;margin-top:10px;}
        .not_found_a:hover{background:#67a22b;color:#f4f4f4;}
    </style>
@endsection
@section('js')
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
<div class="not_found">
    <p class="not_found_p">{{trans('home.error_404_tips')}}</p>
    <p><a class="not_found_a" href="/">{{trans('home.back_home')}}</a></p>
</div>
@endsection

