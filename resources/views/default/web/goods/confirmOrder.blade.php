<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>订单确认页面</title>
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
	<div>
		选择收获地址
		<div>
			@foreach($addressInfo as $v)
				<div class="selectAddress" style="float:left;width:160px;border:solid 1px;" onclick="selectAddress(this)">
					<input type="hidden" name="hiddenId" value="{{encrypt($v['id'])}}">
					<div>{{$v['consignee']}}</div>
					<div>{{$v['mobile_phone']}}</div>
					<div>{{$v['address']}}</div>
				</div>
			@endforeach
		</div>
	</div>
	<!-- encrypt( -->
	<br>
	<table border="1" style="width:1100px;clear:both;">
		<tr>
			<th>商品名称</th>
			<th>单价</th>
			<th>购买数量</th>
		</tr>
		@if(Session::get('cartSession'))
			@foreach(Session::get('cartSession') as $v)
			<tr class="cartDetails">
			<td>{{$v['goods_name']}}</td>
			<td>{{$v['goods_price']}}</td>
			<td>{{$v['goods_number']}}</td>
			</tr>
			@endforeach
		@else
		为空
		@endif

	</table>
	<div><input type="button" name="" value="提交订单" onclick="createOrder()"></div>
</body>
</html>
<script type="text/javascript">
	var selectedAdd = '';
	//提交订单
	function createOrder(){
		// var addressInfo = $('.selectAddress input').attr('style').indexOf('color');
		// var addressInfo = $('.selectAddress').css('color');
		// .children('input').val();
		// $('.selectAddress').each(function(){
		// 	var a = $(this).css('color');
		// 	console.log(a);
		// 	return;
		// })
		
		$.ajax({
			url: "/createOrder",
			dataType: "json",
			data: {
				'address':selectedAdd
			},
			type: "POST",
			success: function (data) {
				if(data.code){
					window.location.href='/waitConfirm';
				}else{
					console.log(data.code);
					alert('出错,请重试')
				}
			}
		})
	}

	//选中地址
	function selectAddress(obj){
		selectedAdd =  $(obj).children('input[type=hidden]').val();
		$(obj).css('color','red');
		$(obj).siblings('.selectAddress').css('color','');
	}
</script>