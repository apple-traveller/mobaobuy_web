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
		收票地址-国家<!-- <input type="text" name="country"><br> -->
		<select name="country">
			<option value="1">中国</option>
		</select>
		<select id="provinceId" onchange="provinceChange()" name="province">
			<option value="0">请选择省份</option>
			@foreach($addressInfo as $v)
				<option value="{{$v['region_id']}}">{{$v['region_name']}}</option>
			@endforeach
		</select>
		收票地址-市
		<select id="cityId" onchange="cityChange()" name="city">
			
		</select>
		收票地址-县
		<select id="countyId"" name="district">
			
		</select><br>
		<!-- 收票地址-省<input type="text" name="province"><br>
		收票地址-市<input type="text" name="city"><br>
		收票地址-县<input type="text" name="district"><br>
		收票地址-街道<input type="text" name="street"><br> -->
		收票地址-详细地址<textarea name="consignee_address" id="" cols="28" rows="3"></textarea>
		<input type="submit" name="" value="提交">
	</form>
</body>
</html>
<script type="text/javascript">
	$(function(){
	
			$('form').submit(function(){
				 event.preventDefault();
				$.ajax({
					type:'post',
					url:'/createInvoices',
					data:$('form').serialize(),
					success:function(res){
						console.log(111);
						console.log(res);
						if(res.code){
							alert('发票添加成功');
							window.location.reload();
						}
					}
				})
			})
		
		
	})

	function provinceChange(){
		var regionId = $('#provinceId').val();
		$.ajax({
			 headers:{ 'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                'type':'post',
                'data':{'region_id':regionId},
                'url':'{{url('/getCity')}}',
                success:function(res){
                	  console.log(res);
                	 var result = JSON.parse(res);
                	   console.log(result);
                	//return;
                	if(result.status){
                		var str = '';
                		var htmlStr = '';
                		for(var i = 0;i<result['info']['city'].length;i++){
                				str += '<option value="'+result['info']['city'][i]['region_id']+'">'+result['info']['city'][i]['region_name']+'</option>';
                		}
                		for(var i = 0;i<result['info']['county'].length;i++){
                				htmlStr += '<option value="'+result['info']['county'][i]['region_id']+'">'+result['info']['county'][i]['region_name']+'</option>';
                		}
                		$('#cityId').html(str);
                		$('#countyId').html(htmlStr);
                	}else{
                		alert('出错了，请重试');
                	}
                }
		})
	}

	function cityChange(){
		var cityId = $('#cityId').val();
		$.ajax({
			 headers:{ 'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                'type':'post',
                'data':{'cityId':cityId},
                'url':'{{url('/getCounty')}}',
                success:function(res){
                	var result = JSON.parse(res);
                	if(result['status']){
                		var str = '';
                		for(var i = 0;i<result['info'].length;i++){
                				str += '<option value="'+result['info'][i]['region_id']+'">'+result['info'][i]['region_name']+'</option>';
                		}
                		$('#countyId').html(str);
                	}else{
                		alert('出错了，请重试');
                	}
                }
		})
	}

</script>