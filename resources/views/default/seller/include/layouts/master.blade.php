<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title','en-this')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>秣宝商城</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="{{getFileUrl(getConfig('shop_ico', asset('images/favicon.ico')))}}" />

    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/main.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/iconfont.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/font-awesome.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/purebox.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'js/jquery-ui/jquery-ui.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'js/spectrum-master/spectrum.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'js/perfect-scrollbar/perfect-scrollbar.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'js/calendar/calendar.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'layui/css/layui.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/layui/css/layui.css')}}" />
    @yield('styles')
</head>
<body class="layui-layout-body">
@yield('iframe')
    <script src="{{asset(themePath('/').'js/jquery-1.9.1.min.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/jquery.json.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/transport_jquery.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/utils.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/perfect-scrollbar/perfect-scrollbar.min.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/calendar/calendar.min.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/jquery.form.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/jquery.nyroModal.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/jquery.validation.min.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/jquery.cookie.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/lib_ecmobanFunc.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/jquery-ui/jquery-ui.min.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/common.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/listtable.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/listtable_pb.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/dsc_admin2.0.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/jquery.bgColorSelector.js')}}" ></script>
    <script src="{{asset(themePath('/').'layui/layui.js')}}" ></script>
    <script src="{{asset(themePath('/').'layui/index.js')}}" ></script>
    @yield('script')
</body>

</html>



