<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	收获地址
	<table>
		<tr>
			<th>收货人</th>
			<th>国家</th>
			<th>省</th>
			<th>市</th>
			<th>县</th>
			<th>街道</th>
			<th>详细地址</th>
			<th>邮编</th>
			<th>电话或手机</th>
			<th>地址别名</th>
		</tr>
		
		@foreach($addressInfo as $in)
			<tr>
				<th>{{$in['consignee']}}</th>
				<th>{{$in['country']}}</th>
				<th>{{$in['province']}}</th>
				<th>{{$in['city']}}</th>
				<th>{{$in['district']}}</th>
				<th>{{$in['street']}}</th>
				<th>{{$in['address']}}</th>
				<th>{{$in['zipcode']}}</th>
				<th>{{$in['mobile_phone']}}</th>
				<th>{{$in['address_name']}}</th>
			</tr>
		@endforeach
		
		
		
	</table>
	<ul>
		<li><a href="/createAddressList">新增</a></li>
		<li><a href="/editAddressList">编辑</a></li>
	</ul>
</body>
</html>