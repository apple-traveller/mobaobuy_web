<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	报价列表

	<div style="">
		@if(!empty($goodsQuote))
			@foreach($goodsQuote as $v)
				<div style="border:1px solid black;">
					<input type="hidden" name="id" value="{{encrypt($v->id)}}">
					<input type="hidden" name="shop_id" value="{{encrypt($v->shop_id)}}">
					店铺名称:<div class="shop_name">{{$v->shop_name}}</div>
					<p>产品名称:{{$v->goods_name}}</p><p>库存数量:{{$v->goods_number}}</p>
					<p class="shop_price">售价:{{$v->shop_price}}</p><p>截至时间：{{$v->expiry_time}}</p>
					<input type="button" name="" onclick="addCart(this)" value="加入购物车">
				</div>
			
			@endforeach
		@else
		为空
		@endif
	</div>
</body>
</html>
<script type="text/javascript">
	// shop_goods_quote_id 购物车中报价表id 
	function addCart(obj){
		var id = $(obj).prevAll('input[name=id]').val();
		$.ajax({
			 url: "/cart",
            dataType: "json",
            data: {
               'id':id
            },
            type: "POST",
            success: function (data) {
                if (data.code){
                    alert('添加购物车成功');
                } else {
                    alert('添加购物车失败');
                }
            }
		})
	}
</script>