<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="/middle" method="post">
	<div>
		请选择公司
		<input type="radio" name="firm_id" value="0">个人用户</input>
		@foreach($firmInfo as $v)
		<input type="radio" name="firm_id" value="{{$v['id']}}">{{$v['nick_name']}}</input>
		@endforeach
	</div>
	<input type="submit" value="确认">
	</form>
</body>
</html>