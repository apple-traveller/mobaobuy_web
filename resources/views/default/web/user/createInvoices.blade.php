<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<script src="http://code.jquery.com/jquery-1.4.1.min.js"></script>
<body>
	<form method="post" action="/cr">
		公司抬头<input type="text" name="company_name"><br>
		税号<input type="text" name="tax_id"><br>
		开户银行<input type="text" name="bank_of_deposit"><br>
		银行账号<input type="text" name="bank_account"><br>
		开票地址<input type="text" name="company_address"><br>
		开票电话<input type="text" name="company_telephone"><br>
		收票人<input type="text" name="consignee_name"><br>
		收票人电话<input type="text" name="consignee_mobile_phone"><br>
		收票地址-国家<input type="text" name="country"><br>
		收票地址-省<input type="text" name="province"><br>
		收票地址-市<input type="text" name="city"><br>
		收票地址-县<input type="text" name="district"><br>
		收票地址-街道<input type="text" name="street"><br>
		收票地址-详细地址<input type="text" name="consignee_address">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<input type="submit" name="" value="提交">
	</form>
</body>
</html>
<script type="text/javascript">
	$(function(){
		var isCommitted = false;
		if(isCommitted == false){
			$('form').submit(function(){
				 event.preventDefault();
				$.ajax({
					headers:{ 'X-CSRF-TOKEN': $('input[name="_token"]').val()},
					type:'post',
					url:'/createInvoices',
					data:$('form').serialize(),
					success:function(res){
						var result = JSON.parse(res);
						if(result.status){
							alert('发票添加成功');
							isCommitted = true;
							console.log(isCommitted);
							return true;
						}
						
					}

				})
			})
		}else{
			return false;
		}
		
	})
</script>