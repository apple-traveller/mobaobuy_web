<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type="text/css">
        /*body{ text-align:center} */
    </style>
</head>
<body>
首页
<ul>
    @if(session('_web_user_id'))
    <li><a href="/member">会员中心</a></li>
    <li><a href="/logout">退出</a></li>
    @else
    <li><a href="{{route('login')}}">登录</a></li>
    <li><a href="{{route('register')}}">注册</a></li>
    @endif
</ul>

</body>
</html>