<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<style type="text/css">
	.pagination{
		width:80px;
	}
	.page-item{
		float:left;
		list-style: none;
	}
</style>
<body>
	出库记录
	<form action="/stockIn" method="get">
		 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<input type="text" name="goods_name">
		<input type="date" name="start_time">
		<input type="date" name="end_time">
		<input type="submit" name="" value="查询">
		
	</form>
	@if($firmstock)
		@foreach ($firmstock as $user)
			{{ $user['goods_name'] }}
		@endforeach
		
	@else
	@endif
	
	<div class="page-wrap">
			
					{{$firmstock->links()}}
			
		</div>
		
	
				
</body>
</html>