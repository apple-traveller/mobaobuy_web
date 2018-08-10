<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>用户注册</h1>
<form action="/userRegister" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
手机号<input type="text" name="user_name" placeholder="请输入手机号"><br>
昵　称<input type="text" name="nick_name" placeholder=""><br>
邮　箱<input type="text" name="email"><br>
密　码<input type="password" name="password"><br>
确认密码<input type="password" name="password_confirmation">
<input type="submit" value="注册">
</form>
</body>
</html>