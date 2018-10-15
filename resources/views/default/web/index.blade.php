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
    <li><a href="/member">会员中心</a></li>
    <li><a href="/logout">退出</a></li>
</ul>
<div style="width:1620px;margin:0 auto;height:200px;text-align:center;">
    <ul style="display: inline-block;overflow: auto;">
        @foreach($articleCat as $k=>$v)
        <li style="float: left;list-style: none;display: inline;width:100px;height:200px;">{{$v['cat_name']}}
            @if(isset($v['child']))
            <ul style="text-align:center;display: inline;">
                @foreach($v['child'] as $vv)
                <li style="list-style: none;width:120px;text-align:center;"><a href="/article/{{$vv['id']}}">{{ $vv['title'] }}</a></li>
                @endforeach
            </ul>
            @else
            @endif
        </li>
        @endforeach
    </ul>
</div>
</body>
</html>