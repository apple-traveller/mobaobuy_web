<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
</head>
<script src="{{asset(themePath('/').'js/jquery-1.9.1.min.js')}}" ></script>
{{--<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>--}}
<body>
<h1>商户登陆</h1>
<form action="/seller/login" method="post" id="user_login">
    @csrf
    用户名<input type="text" name="user_name" id="user_name" placeholder="请输入用户名" value=""><br>
    密　码<input type="password" name="password" id="password" value=""><br>
    <input type="button" value="登陆" onclick="submitForm()">
    <a href="/seller/register.html">注册</a>
</form>
</body>
<script>
    function submitForm() {
        let user_name = $('#user_name').val();
        let password = window.btoa($('#password').val());
        // $('#password').val(password);
        $.ajax({
            url: '/seller/login',
            data: {
                user_name: user_name,
                password: password
            },
            type: 'POST',
            success: function (res) {
                if (res.code == 1){
                    window.location.href="{{url('/seller')}}";
                } else {
                    $('#password').val('');
                    alert(res.msg);
                }
            }
        });
    }
</script>
</html>
