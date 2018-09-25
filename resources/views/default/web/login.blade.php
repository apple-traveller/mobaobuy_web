<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="http://code.jquery.com/jquery-1.4.1.min.js"></script>
</head>
<body>
<h1>用户登陆</h1>
<form action="/login" method="post">
手机号<input type="text" id="user_name" name="user_name" placeholder="请输入手机号"><br>
密　码<input type="password" id="password" name="password"><br>
<input type="button" id="sub-btn" value="登陆">
<a href="{{route('register')}}" >注册</a>
</form>
</body>
</html>

<script>
    $('#sub-btn').click(function ()  {
        $.ajax({
            url: "{{url('login')}}",
            data: {
                user_name: $("#user_name").val(),
                password: window.btoa($("#password").val()),
            },
            type: "POST",
            success: function (data) {
                console.log(data);
                if (data.code == 1) {
                    window.location.href="{{url('/')}}";
                }else{
                    $("#password").val('');
                    alert(data.msg);
                }
            }
        });
    });
</script>