<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<script src="http://code.jquery.com/jquery-1.4.1.min.js"></script>
<body>
	我的订单
	<table border="1">
		<tr>
		<th>订单号</th>
		<th>店铺名称</th>
		<th>订单金额</th>
		<th>物流跟踪</th>
		<th>详情</th>
		<th>订单状态</th>
		</tr>
		@foreach($orderList as $v)
		
		<tr>
		<input type="hidden" name="" value="{{encrypt($v->id)}}">
		<td>{{$v->order_sn}}</td>
		<td>{{$v->shop_name}}</td>
		<td>{{$v->order_amount}}</td>
		<td></td>
		<td><a href="/orderDetails/{{encrypt($v->id)}}">详情</a></td>
		<td>@if($v->order_status == 1)待企业审核 <span style="cursor: pointer;color:blue;" onclick="egis(this);">审核通过</span> <span style="cursor: pointer;color:blue;" onclick="cancel(this)">作废</span> @elseif($v->order_status == 2)待商家确认 @elseif($v->order_status == 3)已确认 <a href="pay">去付款</a>@elseif($v->order_status == 0)已作废 @endif</td>
		</tr>
		@endforeach
	</table>
</body>
</html>
<script type="text/javascript">
	function egis(obj){
		var id = $(obj).parent().siblings('input[type=hidden]').val();
		$.ajax({
			url: "/egis",
			dataType: "json",
			data: {
				'id':id
			},
			type: "POST",
			success: function (data) {
				if(data.code){
					window.location.reload();
				}else{
					console.log(data.code);
					alert('出错,请重试')
				}
			}
		})
	}

	function cancel(obj){
		var id = $(obj).parent().siblings('input[type=hidden]').val();
		$.ajax({
			url: "/cancel",
			dataType: "json",
			data: {
				'id':id
			},
			type: "POST",
			success: function (data) {
				if(data.code){
					window.location.reload();
				}else{
					console.log(data.code);
					alert('出错,请重试')
				}
			}
		})
	}
</script>