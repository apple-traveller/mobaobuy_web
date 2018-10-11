<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<style type="text/css">
	ul{}
	li{
		list-style: none;
		float:left;
	}
</style>
<script src="http://code.jquery.com/jquery-1.4.1.min.js"></script>
<body>
	
	
	我的购物车
	<div style="float:right;"><input type="button" name="" value="清空购物车" onclick="clearCart()"></div>
	<div>
		
	<table border="1" style="width:1100px;">
		<tr>
			<th>操作</th>
			<th>店铺名称</th>
		<th>商品名称</th>
		<th>单价</th>
		<th>购买数量</th>
		</tr>
		
		@foreach($cartInfo as $v)
		<tr class="cartDetails">
		<td><input type="checkbox" name="goods" value="{{encrypt($v->id)}}" onclick="checkListen()"></td>
		<td>{{$v->shop_name}}</td>
		<td>{{$v->goods_name}}</td>
		<td>{{$v->goods_price}}</td>
		<td>{{$v->goods_number}}</td>
		</tr>
		@endforeach

	</table>
			<div>总金额:</div>
			<div style="float: right;margin-right: 20%"><input type="button" name="" onclick="addCart()" value="去结算"></div>
			{{$cartInfo->links()}}
	</div>
</body>
</html>
<script type="text/javascript">
	//清空购物车
	function clearCart(){
		$.ajax({
			url: "/clearCart",
            dataType: "json",
            data: {
               
            },
            type: "POST",
            success: function (data) {
               if(data.code){
               		alert('清空购物车成功');
               }else{
               		alert('清空购物车失败');
               }
            }
		})
	}

	//确认订单
	function addCart(){
		var arr = Array();
		// var cartId = $('input[name=goods]:checked').val();
		$('.cartDetails input[name=goods]:checked').each(function(){
			arr.push($(this).val());
		})
		if(arr.length>0){
			$.ajax({
				url: "/toBalance",
				dataType: "json",
				data: {
				'cartId':arr
				},
				type: "POST",
				success: function (data) {
					if(data.code){
						window.location.href='/confirmOrder';
					}else{
						alert('出错,请重试')
					}
				}
			})
		}else{
			alert('请选择商品');return;
		}
		
	}

	function checkListen(){
		var arr = new Array();
		$('.cartDetails input[name=goods]:checked').each(function(){
			arr.push($(this).val());
		})
		console.log(arr);
		return;
		if(arr.length>0){
			$.ajax({
				url: "/checkListen",
				dataType: "json",
				data: {
				'cartId':arr
				},
				type: "POST",
				success: function (data) {

				}
			})
		}else{
			alert('请选择商品');return;
		}
	}
</script>