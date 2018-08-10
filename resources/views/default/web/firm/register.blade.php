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
<h1>企业注册</h1>
<form action="/firmRegister" method="post" enctype="multipart/form-data">
    {{--{{ csrf_field() }}--}}
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
企业全称<input type="text" name="firm_name" placeholder="请输入手机号"><br>
昵　称<input type="text" name="user_name" placeholder=""><br>
负责人手机<input type="text" name="contactPhone"><br>
负责人姓名<input type="text" name="contactName"><br>
营业执照<input type="file" name="attorney_letter_fileImg"><br>
密　码<input type="password" name="password"><br>
确认密码<input type="password" name="password_confirmation">
<input type="submit" value="注册">
</form>
</body>
</html>