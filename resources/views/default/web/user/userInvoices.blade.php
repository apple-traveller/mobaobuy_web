<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	会员发票列表
	<table>
		<tr>
			<th>公司抬头</th>
			<th>税号</th>
			<th>开户银行</th>
			<th>银行账号</th>
			<th>开票地址</th>
			<th>开票电话</th>
		</tr>
		
		@foreach($invoicesInfo as $in)
			<tr>
				<th>{{$in['company_name']}}</th>
				<th>{{$in['tax_id']}}</th>
				<th>{{$in['bank_of_deposit']}}</th>
				<th>{{$in['bank_account']}}</th>
				<th>{{$in['company_address']}}</th>
				<th>{{$in['company_telephone']}}</th>
			</tr>
		@endforeach
		
		
		
	</table>
	<ul>
		<li><a href="/createInvoices">新增</a></li>
		<li><a href="/editInvoices">编辑</a></li>
	</ul>
</body>
</html>