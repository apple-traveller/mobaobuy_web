<!doctype html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    <link rel="stylesheet" type="text/css" href="/css/index.css" />
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/layui/css/layui.css')}}" />
    <script src="{{asset(themePath('/').'plugs/layui/layui.js')}}" ></script>
    @yield('css')
    @yield('js')
</head>
<body style="background-color: rgb(244, 244, 244);">
    @include(themePath('.','web').'web.include.partials.top')
    @include(themePath('.','web').'web.include.partials.goods_header')
    <div class="clearfix">
        @yield('content')
    </div>

    @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
    @yield('bottom_js')
</body>
</html>
