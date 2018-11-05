<!doctype html>
<html lang="en">
<head>
    <title>购物车 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    @yield('css')
    <style type="text/css">
    	.fr{float:right;}
    	.fs14{font-size:14px;}
    	.order_progress{width: 351px;margin-top: 45px;margin-bottom: 45px;}
    	.cart_progress{width: 303px;margin:0 auto;height: 33px;}
		.cart_progress_01{background: url(../img/cart_icon01.png)no-repeat;}
		.cart_progress_02{background: url(../img/cart_icon02.png)no-repeat;}
		.cart_progress_03{background: url(../img/cart_icon03.png)no-repeat;}
		.progress_text{color: #999;margin-top: 5px;}
		.progress_text_curr{color: #75b335;}
		.my_cart{float: left;margin-left: 5px;}
		.order_information{float: left;margin-left: 58px;}
		.order_submit{float: left;margin-left: 50px;}
		.w1200{width: 1200px;margin: 0 auto;}
		.whitebg{background: #FFFFFF;}
		.shop_title{width:1138px;margin:0 auto;clear: both; display: block; overflow: hidden; line-height: 70px; border-bottom: 1px solid #DEDEDE;}
		.shop_title li{float: left; text-align: center;}
		input[type='checkbox']{width: 20px;height: 20px;background-color: #fff;-webkit-appearance:none;border: 1px solid #c9c9c9;border-radius: 2px;outline: none;}
		.check_box input[type=checkbox]:checked{background: url(../img/interface-tickdone.png)no-repeat center;}
		.mr5{margin-right:5px;}
		.mt25{margin-top:25px;}
		.fl{float:left;}
		.shop_good{width: 300px;}.shop_price{width: 130px;}.shop_num{width: 150px;}.shop_add{width: 130px;}.shop_sub{width: 125px;}
		.shop_price{width: 130px;}.shop_num{width: 150px;}.shop_add{width: 130px;}.shop_sub{width: 125px;}
		.shop_oper{width: 120px; }
		.shop_list{width:1138px;margin:0 auto;overflow: hidden;}
		.shop_list li {line-height: 115px;border-bottom: 1px solid #DEDEDE;overflow: hidden;}
		.shop_list li:last-child{border-bottom:none;}
		.mr5{margin-right:5px;}
		.mt10{margin-top:10px;}
		.shop_good_title{width: 323px;}
		.shop_price_t{width: 130px;}
		.orange,a.orange,a.orange:hover{color:#ff6600;}
		.tac{text-align:center !important;}
		.shop_num_t{width: 150px;}
		.shop_nienb{width: 138px;height: 40px;border: 1px solid #DEDEDE;border-radius:3px;margin-top: 37px;}
		.shop_num_reduce {cursor:pointer;float: left;display: block;width: 40px; height: 40px;text-align: center;line-height: 40px;color: #444;}
		.num_nim:hover{background-color: #eeeeee;}
		.shop_num_amount {float: left;width: 58px;height: 40px;line-height: 25px;border: none;color: #343434;
					text-align: center;background-color: #fff;z-index: 2;left: 48px;}
		.shop_num_plus {float: left;display: block; width: 40px;height: 40px;text-align: center;line-height: 40px;color: #444;
				cursor: pointer;}
		.num_nim:hover{background-color: #eeeeee;}
		.shop_price_d{width: 125px;}
		.shop_oper_icon{width: 20px;height: 20px;margin:47px auto;display: block;}
		.shop_oper_bg{background: url(../img/cart_rash.png)no-repeat 0px 0px;}
		.shop_oper_bg:hover{background: url(../img/cart_rash.png)no-repeat 0px -82px;}
		.sumbit_cart{width:1200px;margin:0 auto;margin-top:20px;line-height: 50px;color: #999;}	
		.sumbit_cart_btn{width: 200px;float: right;line-height: 50px;background-color: #75b335;color: #fff;font-size: 16px;text-align: center;cursor:pointer;}
		.ovh{overflow: hidden;}
		.ml30{margin-left:30px;}
		.cp{cursor:pointer;}
		.ml40{margin-left: 60px;}
		.logo {
		    width: 170px;
		    height: 55px;
		    margin-top: 20px;
		    float: left;
		    background: url(../img/mobao_logo.png)no-repeat;
		    background-size: 100% 100%;
		}
    </style>
    <script type="text/javascript">
    	//购物车选中的数据
    	var check_arr = new Array();  
    	$(function(){
    		//购物车数据总条数
    		var accountTotal = $('#accountTotal').text();
    		var MaxNum;
			var NumNew=1;
			$(document).delegate('.shop_num_plus','click',function(){
				var thisMul = $(this).attr('data-id');//规格
				MaxNum = $(this).parent().parent().siblings('.shop_price').text();
				var ipts=$(this).siblings('input.Bidders_record_text');
				var iptsVal=ipts.attr('value');
				var id = $(this).attr('id');
				var thisDom = $(this);
				if(Number(ipts.val())+Number(thisMul)>Number(MaxNum)){
					// ipts.val(Number(MaxNum));
                    layer.msg('不能大于可售', {icon: 5});
					return;
				}else{
					NumNew=Number(ipts.val())+Number(thisMul);
					ipts.val(Number(NumNew));
				}
				
				$.ajax({
	                'type':'post',
	                'data':{'id':id},
	                'url':'{{url('/addCartGoodsNum')}}',
	                success:function(res){
	                    // var result = JSON.parse(res);
	                    if(res.code){
	                        thisDom.parent().parent().nextAll('.shop_price_d').html(number_format(res['data'],2));
	                    }else{
                            layer.msg('增加失败请重试', {icon: 5});
	                        window.location.reload();
	                    }
               		}
     			})

			});

			$(document).delegate('.shop_num_reduce','click',function(){
				var thisMul = $(this).attr('data-id');
				var ipts=$(this).siblings('input.Bidders_record_text');
				var iptsVal=ipts.attr('value');
				var id = $(this).attr('id');
				var thisDom = $(this);
				if (Number(ipts.val())-Number(thisMul)<1) {
                    layer.msg('已经是最低的购买数量了', {icon: 5});
					return;
				}else{
					
					NumNew=Number(ipts.val())-Number(thisMul);
					ipts.val(Number(NumNew));
				}
				$.ajax({
	                'type':'post',
	                'data':{'id':id},
	                'url':'{{url('/reduceCartGoodsNum')}}',
	                success:function(res){
	                    // var result = JSON.parse(res);
	                    if(res.code){
	                        thisDom.parent().parent().nextAll('.shop_price_d').html(number_format(res['data'],2));
	                    }else{
                            layer.msg('减少失败请重试', {icon: 5});
	                        window.location.reload();
	                    }
               		}
     			})

			})

			//单选框
			$('.shop_list .check_all span label input').change(function(){
				check_arr = [];
				$('.shop_list .check_all span label input:checked').each(function(){
					check_arr.push($(this).val());
				});
				$('#checkedSel').html(check_arr.length);
				if(check_arr.length == accountTotal){
					$('#check_all').prop('checked',true);
					check_all();
				}else{
					$('#check_all').prop('checked',false);
				}
				
			})

			//数量输入检测
			$(document).find('input:text').blur(function(){  
				//数量
				var goodsNumber = $(this).val();
				//当前购物车数据id
				var id = $(this).attr('id');
                	if((/^(\+|-)?\d+$/.test( goodsNumber ))&&goodsNumber>0){
            			$.ajax({
            				'type':'post',
			                'data':{'id':id,'goodsNumber':goodsNumber},
			                'url':'{{url('/checkListenCartInput')}}',
			                success:function(res){
			                    if(res.code){
			                    }else{
			                        layer.msg('输入的数量有误');
			                        window.location.reload();
			                    }
		               		}
            			})
		        	}else{
		            	layer.msg('输入的数量有误');
			             window.location.reload();
		        	}
            });
		})

		//全选
		function check_all(){
			$('#check_all').change(function(){
				check_arr = [];
				if($(this).is(':checked')){
					$('.shop_list .check_all span label input:checkbox').prop('checked',true);
					$('.shop_list .check_all span label input:checkbox').each(function(){
						check_arr.push($(this).val());
					})
					$('#checkedSel').html(check_arr.length);
				}else{
					check_arr = [];
					$('.shop_list .check_all span label input:checkbox').prop('checked',false);
					$('#checkedSel').html(0);
				}
			})
		}


    	//删除购物车某商品
    	function del(obj){
    		var flag = confirm("是否删除?");
            var id = $(obj).attr('id');
            if(flag===true){
                 $.ajax({
	                'type':'post',
	                'data':{'id':id},
	                'url':'{{url('/delCart')}}',
	                success:function(res){
	                    // var result = JSON.parse(res);
	                    if(res.code){
	                        //todo 删除成功不刷新页面
	                        // alert('删除成功');
	                        window.location.reload();
	                    }else{
	                        alert('删除失败');
	                        window.location.reload();
	                    }
               		}
     			})
            }   
    	}

    	//清空购物车
    	function clearCart(){
    		var flag = confirm("是否清空购物车?");
    		if(flag===true){
    			$.ajax({
				url: "/clearCart",
	            dataType: "json",
	            data: {
	               
	            },
	            type: "POST",
	            success: function (data) {
	               if(data.code){
//	               		$.msg.alert('清空购物车成功');
	               		window.location.reload();
	               }else{
	               		alert('清空购物车失败');
	               }
	            }
				})
    		}
		}

		
		//checkbox框
		function checkListen(){
			var arr = new Array();
			$('.shop_list .check_all span label input:checkbox').each(function(){
				arr.push($(this).val());
			});
			
			if(arr.length>0){
				$.ajax({
					url: "/checkListen",
					dataType: "json",
					data: {
					'cartId':arr
					},
					type: "POST",
					success: function (data) {

					}
				})
			}else{
				alert('请选择商品');return;
			}
		}

		//去结算
		function toBalance(){
		    //todo  重新获取 check_arr的值
            check_arr = [];
            $('.shop_list .check_all span label input:checked').each(function(){
                check_arr.push($(this).val());
            });
			if(check_arr.length>0){
				$.ajax({
					url: "/toBalance",
					dataType: "json",
					data: {
					'cartId':check_arr
					},
					type: "POST",
					success: function (data) {
						if(data.code){
							window.location.href='/confirmOrder';
						}else{
							layer.msg('出错,请重试')
						}
					}
				})
			}else{
                layer.msg('请选择商品');return;
			}
		}

		
    </script>
</head>
<body style="background-color: rgb(244, 244, 244);">
    @include(themePath('.','web').'web.include.partials.top')
   
    <div class="clearfix whitebg mb30">
		<div class="w1200">
			<a class="logo" style="margin-top: 45px;" href="/"></a>
			<div class="fr fs14 order_progress" >
				<div class="cart_progress cart_progress_01"></div>
				<div class="progress_text">
					<div class="my_cart progress_text_curr">我的购物车</div>
					<div class="order_information">订单信息完善</div>
					<div class="order_submit">成功提交订单</div>
				</div>
			</div>
		</div>
	</div>


	<div class="w1200 whitebg" style="margin-top: 20px;">
		
		<ul class="shop_title">
			<li class="check_all curr"><label class="check_box"><input class="check_box mr5 mt25 check_all fl" name="" type="checkbox" value="" id="check_all" onclick="check_all()"/><span class="fl ">全选</span></label></li>
			<li class="shop_good">商品</li><li class="shop_price">单价</li><li class="shop_price">可售（kg）</li>
			<li class="shop_num">购买数量（kg）</li><li class="shop_add">发货地址</li><li class="shop_sub">小计</li><li class="shop_oper">操作</li>
		</ul>
		@if(count($cartInfo['cartInfo']))
			@foreach($cartInfo['cartInfo'] as $k=>$v)
			<ul class="shop_list">
				<li class="check_all">
					<span class="check_tick fl" style="margin: 33px 0px;">
						<label class="check_box"><input class="check_box mr5 mt10 check_all fl" name="" type="checkbox" value="{{$v->id}}"/> </label>
					</span>
					<a class="shop_good_title fl tac" style="line-height: 20px;margin-top: 45px;">{{$v->goods_name}}</a>
					<span class="shop_price_t orange fl tac">￥{{$v->goods_price}}元</span>
					<span class="shop_price fl tac">@if(count($cartInfo['quoteInfo'])) {{$cartInfo['quoteInfo'][$k]['goods_number']}} @else @endif </span>
					<div class="shop_num_t fl">
						<div class="shop_nienb">
							<a class="shop_num_reduce num_nim" id="{{$v->id}}" data-id="{{$cartInfo['goodsInfo'][$k]['packing_spec']}}">-</a>
							<input type="text" class="shop_num_amount Bidders_record_text" id="{{$v->id}}" class="goods_numberListen" value="{{$v->goods_number}}"/>
							<a class="shop_num_plus num_nim" id="{{$v->id}}" data-id="{{$cartInfo['goodsInfo'][$k]['packing_spec']}}">+</a>
						</div>
					</div>
				    
				    <span class="shop_add fl tac">{{$cartInfo['quoteInfo'][$k]['delivery_place']}}</span>
				    <span class="shop_price_d fl tac">￥{{$cartInfo['quoteInfo'][$k]['account']}}</span>
				    <span class="shop_oper fl"><a class="shop_oper_icon shop_oper_bg" id="{{$v->id}}" onclick="del(this)"></a></span>
				</li>
			</ul>
			@endforeach
		@else
			购物车没有任何商品
			<!-- <div class="sumbit_cart_btn">去购物</div> -->
			<a type="button" href="/goodsList" style="height: 20px;background-color: #75b335;color:#fff;">去购物</a>
		@endif
	</div>
	
		
	<div class="sumbit_cart whitebg ovh mb30">
			<span class="fl ml30 cp" onclick="clearCart();">清空购物车</span><span class="fl ml40 cp"><a href="/goodsList">继续购买</a></span><span class="fl ml40">共<font class="orange" id="accountTotal">@if($cartInfo['cartInfo']) {{count($cartInfo['cartInfo'])}} @else 0 @endif</font>件商品，已选择<font class="orange" id="checkedSel">0</font>件</span>
			<div class="sumbit_cart_btn" onclick="toBalance()">去结算</div>
		</div>

	<div class="clearfix whitebg ovh mt40" style="font-size: 0;">
     @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
    @yield('js')
</body>
</html>


