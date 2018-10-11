<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	@if($articleInfo)
	<div>
		<p>标题:{{$articleInfo['title']}}</p>
		<p>作者：{{$articleInfo['title']}}</p>
		<p>创建时间：{{$articleInfo['add_time']}}</p>
		<p>点击次数：{{$articleInfo['click']}}</p>
		<p>{{$articleInfo['content']}}</p>
	</div>
	@else
	不存在的文章
	@endif
</body>
</html>