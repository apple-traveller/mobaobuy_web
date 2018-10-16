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
	<div style="margin-top:50px;height:80px;">
	选择开票地址
		<div>
			@if($invoicesInfo)
			@foreach($invoicesInfo as $v)
				<div class="selectInvoicesInfo" style="float:left;width:160px;border:solid 1px;" onclick="selectInvoicesInfo(this)">
					<input type="hidden" name="hiddenId" value="{{encrypt($v['id'])}}">
					<div>{{$v['company_name']}}</div>
					<div>{{$v['bank_of_deposit']}}</div>
					<div>{{$v['bank_account']}}</div>
				</div>
			@endforeach
			@else
			为空
			@endif
		</div>
	</div>
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
	var selectInvoices = '';
	//提交订单
	function createOrder(){
		if(selectedAdd == '' || selectInvoices == ''){
			alert('收货地址或发票信息不能为空');
			return;
		}
		$.ajax({
			url: "/createOrder",
			dataType: "json",
			data: {
				'address':selectedAdd,
				'invoices':selectInvoices
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

	//选中发票
	function selectInvoicesInfo(obj){
		selectInvoices = $(obj).children('input[type=hidden]').val();
		$(obj).css('color','red');
		$(obj).siblings('.selectInvoicesInfo').css('color','');
	}
</script>