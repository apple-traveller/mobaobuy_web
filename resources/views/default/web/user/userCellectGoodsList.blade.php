<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	商品收藏列表<br>
	<div>
		商品名称<br>
		<ul>
		@if($collectGoods)
			@foreach($collectGoods as $v)
				<li>{{ $v->id }}</li>
				<li>{{ $v->goods_name }}</li>
			@endforeach
		@else
				收藏为空
		@endif
		</ul>
	</div>
</body>
</html>