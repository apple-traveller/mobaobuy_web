<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','') @if(trim($__env->yieldContent('title'))) - @endif {{config('website.app_name')}}</title>
    <link rel="stylesheet" href="{{ asset(themePath('/').'plugs/awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset(themePath('/').'plugs/bootstrap/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset(themePath('/').'plugs/layui/css/layui.css') }}"/>
    <link rel="stylesheet" href="{{ asset(themePath('/').'css/console.css') }}">
    <link rel="stylesheet" href="{{ asset(themePath('/').'css/animate.css') }}">
    @yield('style')
    <script>window.ROOT_URL='{{asset(themePath(''))}}';</script>
    <script src="{{ asset(themePath('/').'plugs/require/require.js')}}" data-main="{{ asset(themePath('/').'js/init.js')}}"></script>

</head>
@yield('bodyTag')
<body>
@yield('body')
@yield('script')
</body>
</html>