<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<script src="http://code.jquery.com/jquery-1.4.1.min.js"></script>
<body>
	收获地址
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	<form method="post" action='/createAddressList'>
		<!-- <select id="country" onchange="" name="country">
			<option value="1">中国</option>
		</select> -->
		<select id="provinceId" onchange="provinceChange()" name="province">
			<option value="0">请选择省份</option>
			@foreach($addressInfo as $add)
				<option value="{{ $add['region_id'] }}">{{ $add['region_name'] }}</option>
			@endforeach
		</select>

		<select id="cityId" onchange="cityChange()" name="city">
			
		</select>

		<select id="countyId"" name="district">
			
		</select><br>
		详细地址:<textarea rows="2" cols="40" placeholder="请输入详细地址信息，如道路、门牌号、小区、楼栋号、单元等信息" name="address"></textarea><br><br>
		邮编:<input type="text" name="zipcode"><br>
		收货人姓名:<input type="text" name="consignee"><br>
		手机号码:<input type="text" name="mobile_phone"><br>
		<input type="submit" name="" value="保存">
	</form>
</body>
</html>
<script type="text/javascript">
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