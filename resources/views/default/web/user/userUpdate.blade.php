<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	
	<h2>完善用户信息</h2>
	@if(count($errors)>0)
    <div class="alert alert-warning" role="alert">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
	@endif
	<form method="post" action="/updateUserInfo" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	昵称<input type="text" name="nick_name"><br> 
	邮箱<input type="text" name="email"><br>
	正式姓名<input type="text" name="real_name"><br>
	性别:保密<input   type="radio"   value="0"    name="sex"   checked="checked"/>
	男<input   type="radio"   value="1"    name="sex" />
	女<input   type="radio"   value="2"    name="sex" /><br>
	用户头像<input type="file" name="avatar"><br>
	身份证正面<input type="file" name="front_of_id_card"><br>
	身份证反面<input type="file" name="reverse_of_id_card"><br>
	<input type="submit" name="" value="提交">
	</form>
</body>
</html>