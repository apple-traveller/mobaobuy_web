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
	<form method="post" action="/updatePwd" enctype="multipart/form-data">
	 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
	请输入密码<input type="password" name="password"><br>
	请输入新密码<input type="password" name="newPassword"><br>
	请再次输入新密码<input type="password" name="newPassword_confirmation"><br>
	<input type="submit" value="提交">
	</form>
</body>
</html>