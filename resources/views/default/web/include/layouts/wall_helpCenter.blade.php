<!doctype html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    @yield('css')
    <style>
        .member_left .member_list_mode:last-child>li:last-child{visibility: hidden}
    </style>
</head>
<body style="background-color: rgb(244, 244, 244);">
@include(themePath('.','web').'web.include.partials.top')
@component(themePath('.','web').'web.include.partials.top_title', ['title_name' => '帮助中心'])@endcomponent
<div class="clearfix mt25 mb25">
    <div class="w1200">
        <div class="member_left">
            @foreach(getSidebar() as $k1=>$v1)
                @if(!empty($v1['_child']))
                <div class="member_list_mode">
                    <h1 class=""><i class="iconfont icon-svgorder"></i>{{$v1['cat_name']}}</h1>
                    <ul class="member_left_list">
                        @foreach($v1['_child'] as $k2=>$v2)
                            <li class="ovhwp" title="{{$v2['title']}}"><a @if($id == $v2['id']) class="green" @endif href="/{{$v2['id']}}/helpCenter.html">{{$v2['title']}}</a></li>
                        @endforeach
                        <li class="its">
                            <div class="bottom"></div>
                            <div class="line"></div>
                        </li>
                    </ul>
                </div>

                @endif
            @endforeach
        </div>

        <div class="member_right">
            <div><h1><i class="iconfont icon-align-left" style="margin:auto; align-items: center;"></i>@yield('title')</h1></div>
            @yield('content')
        </div>

</div>

</div>

<div class="clearfix whitebg ovh mt40" style="font-size: 0;">
</div>
@include(themePath('.','web').'web.include.partials.footer_service')
@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')
@yield('js')
<script>

    $(function () {
        let its = $(".its").last();
        its[0].style.visibility='hidden';
    });
</script>
</body>
</html>
