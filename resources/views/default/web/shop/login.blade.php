<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
</head>
<body>
<h1>商户登陆</h1>
<form action="/shop/login" method="post">
    @csrf
    用户名<input type="text" name="user_name" placeholder="请输入用户名"><br>
    密　码<input type="password" name="password"><br>
    <input type="submit" value="登陆">
    <a href="/shop/register.html">注册</a>
</form>
</body>
</html>
