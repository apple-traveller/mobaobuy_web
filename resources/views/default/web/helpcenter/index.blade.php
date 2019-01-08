@extends(themePath('.','web').'web.include.layouts.wall_helpCenter')

@section('keywords', $detail['keywords'])
@section('description', $detail['description'])

@section('title', $detail['title'].'-秣宝饲料原料采购网')
@section('css')

    <style>
        .nav-div .nav-cate .ass_menu {display: none;}
    </style>
@endsection
@section('content')

    <div class="today_news whitebg fl">
        <div class="w800p">
            <h1 class="info-detail-title" align="center" style="width: 900px;">

                {{ $detail['title'] }}
            </h1>
            <div class="info-detail-bq gray">
                <div class="bshare-custom" style="line-height:38px !important;display: inline-block;margin-left: 40px;"><div class="bsPromo bsPromo2"></div>
                    <div class="bsPromo bsPromo2"></div>
                </div>

            </div>
            <div class="info-detail-content">
                {!! $detail['content'] !!}
            </div>
        </div>
    </div>

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
