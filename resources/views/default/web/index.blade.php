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
    <script src="http://libs.baidu.com/jquery/1.9.1/jquery.js"></script>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
首页
@if(session('_web_user_id'))
<div>
    <select id="selectCompany" onchange="selectCompany();">
        @if(!session('_web_user')['is_firm'])
            <option @if(session('_curr_deputy_user')['is_self']) selected @endif value="0">个人</option>
            @foreach(session('_web_user')['firms'] as $v)
            <option @if(session('_curr_deputy_user')['firm_id'] == $v['firm_id']) selected @endif value="{{$v['firm_id']}}">{{$v['firm_name']}}</option>
            @endforeach
        @else
            <option value="0">{{session('_web_user')['nick_name']}}</option>
        @endif
    </select>
  </div>
@endif
<ul>
    @if(session('_web_user_id'))
    <li><a href="/member">会员中心</a></li>
    <li><a href="/logout">退出</a></li>
    @else
    <li><a href="{{route('login')}}">登录</a></li>
    <li><a href="{{route('register')}}">注册</a></li>
    @endif

        <li><a href="/goodsQuote">报价列表</a></li>
        <li><a href="/goodsList">商品列表</a></li>
</ul>

</body>
</html>
<script type="text/javascript">

    //选择公司
    function selectCompany(){
        var selectCompanyId = $('#selectCompany').val();
        Ajax.call("{{url('changeDeputy')}}", {user_id:selectCompanyId},function(result){
            window.location.reload();
        },"POST", "JSON");
    }
</script>