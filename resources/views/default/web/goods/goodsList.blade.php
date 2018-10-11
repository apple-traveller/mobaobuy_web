<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<style type="text/css">
	ul{
		clear:both;
		
	}
	li{
		float:left;
		list-style: none;
	}
	.goods{
		float:left;
		width:150px;
		margin:0 auto;
	}
</style>
<body>
	<div style="width:1100px;height:300px;margin:0 auto;">
		@if($goodsList)
			@foreach($goodsList as $v)
				<div class="goods"><p>{{ $v->goods_name}}</p> <img style="width:80px;height: 80px;" src="{{$v->goods_thumb}}"><p style="color:red;">{{$v->market_price}}</p><input type="button" name="" value="加入购物车"></div>
			@endforeach
		@else
		@endif
		{{$goodsList->links()}}
	</div>
</body>
</html>