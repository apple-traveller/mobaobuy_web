<!doctype html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')" />
    <meta name="keywords" content="@yield('keywords')" />
    @include(themePath('.','web').'web.include.partials.base')
    @yield('css')
</head>
<body style="background-color: rgb(244, 244, 244);">
    @yield('top_ad')
    @include(themePath('.','web').'web.include.partials.top')
    @include(themePath('.','web').'web.include.partials.top_search')

    @yield('content')

    @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
    <script type="text/javascript" src="{{asset('/plugs/jquery/jquery.soChange-min.js')}}"></script>
    @yield('js')
    @yield('bottom_js')
</body>
</html>
