<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	@if(count($errors)>0)
    <div class="alert alert-warning" role="alert">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif
	<form method="post" action="/forgotPwd">
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	手机验证码<input type="text" name="mobile_code"><button>获取手机验证码</button><br>
	请输入新密码<input type="password" name="newPassword"><br>
	请再次输入新密码<input type="password" name="newPassword_confirmation"><br>
	<input type="submit" name="" value="提交">
	</form>
</body>
</html>