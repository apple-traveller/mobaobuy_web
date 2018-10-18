<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<script src="http://code.jquery.com/jquery-1.4.1.min.js"></script>
<body>
	<table border="1">
		<!-- <tr>
		<th>订单号</th>
		<th>店铺名称</th>
		<th>订单金额</th>
		<th>物流跟踪</th>
		<th>详情</th>
		<th>订单状态</th>
		</tr> -->

		<tr>
		<th>商品名称</th>
		<th>商品编码</th>
		<th>商品数量</th>
		<th>商品单价</th>
		</tr>
		@foreach($orderGoodsInfo as $v)
		<tr>
			<td>{{ $v['goods_name']}}</td>
			<td>{{ $v['goods_sn'] }}</td>
			<td>{{ $v['goods_number'] }}</td>
			<td>{{ $v['goods_price'] }}</td>
		</tr>
		@endforeach
	</table>
</body>
</html>
<script type="text/javascript">
	
	
</script>