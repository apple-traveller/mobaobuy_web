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
		<select id="provinceId" onchange="provinceChange()">
			<option value="0">请选择省份</option>
			@foreach($addressInfo as $add)
				<option value="{{ $add['region_id'] }}">{{ $add['region_name'] }}</option>
			@endforeach
		</select>

		<select id="cityId" onchange="cityChange()">
			<option></option>
		</select>

		<select id="countyId">
			
		</select>
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
                	var result = JSON.parse(res);
                	 console.log(result);return;
                	// if(result.status){
                	// 	$('#city').html();
                	// }else{
                		
                	// }
                }
		})
	}

	function cityChange(){
		var cityId = $('#cityId').val();
		$.ajax({
			 headers:{ 'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                'type':'post',
                'data':{'city_id':cityId},
                'url':'{{url('/getCounty')}}',
                success:function(res){
                	var result = JSON.parse(res);
                	if(result.status){
                		$('').html();
                	}else{
                		
                	}
                }
		})
	}
</script>