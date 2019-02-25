<!doctype html>
<html lang="en">
<head>
    <title>购物车 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
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
		.shop_good{width: 300px;}.shop_price{width: 150px;}.shop_num{width: 170px;}.shop_add{width: 160px;}.shop_sub{width: 155px;}
		.shop_oper{width: 120px; }
		.shop_list{width:1138px;margin:0 auto;overflow: hidden;}
		.shop_list li {line-height: 115px;border-bottom: 1px solid #DEDEDE;overflow: hidden;}
		.shop_list li:last-child{border-bottom:none;}
		.mr5{margin-right:5px;}
		.mt10{margin-top:10px;}
		.shop_good_title{width: 323px;}
		.shop_price_t{width: 150px;}
		.orange,a.orange,a.orange:hover{color:#ff6600;}
		.tac{text-align:center !important;}
		.shop_num_t{width: 170px;}
		.shop_nienb{width: 138px;height: 40px;border: 1px solid #DEDEDE;border-radius:3px;margin-top: 37px;}
		.shop_num_reduce {cursor:pointer;float: left;display: block;width: 40px; height: 40px;text-align: center;line-height: 40px;color: #444;}
		.num_nim:hover{background-color: #eeeeee;}
		.shop_num_amount {float: left;width: 58px;height: 40px;line-height: 25px;border: none;color: #343434;
					text-align: center;background-color: #fff;z-index: 2;left: 48px;}
		.shop_num_plus {float: left;display: block; width: 40px;height: 40px;text-align: center;line-height: 40px;color: #444;
				cursor: pointer;}
		.num_nim:hover{background-color: #eeeeee;}
		.shop_price_d{width: 155px;}
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
    	//数字千分位
    	function formatNum(num){
			var num = parseFloat(num);
    		num = num.toFixed(2)+"";//保留两位小数
			return num.replace(/(\d{1,3})(?=(\d{3})+(?:$|\.))/g,'$1,');

		}  
    	//购物车选中的数据
    	var check_arr = new Array();
    	$(function(){
    		//购物车数据总条数
    		var accountTotal = $('#accountTotal').text();
    		var MaxNum;
			var NumNew=1;
			$(document).delegate('.shop_num_plus','click',function(){
				var thisMul = $(this).attr('data-id');//规格
				MaxNum = $(this).parent().parent().siblings('.shop_price').attr('goods_number');//可售
				var ipts=$(this).siblings('input.Bidders_record_text');
				var iptsVal=ipts.attr('value');//点击加号后input的值
				var id = $(this).attr('id');//数据库cart自增id
				var thisDom = $(this);

				if(Number(ipts.val())+Number(thisMul)>Number(MaxNum)){
                    layer.msg('{{trans('home.error_max_num_tips')}}', {icon: 5});
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
	                     // console.log(res);
	                    if(res.code){
	                        thisDom.parent().parent().nextAll('.shop_price_d').html('￥'+formatNum(res['data']['account']));
	                    }else{
                            layer.msg('{{trans('home.add_error')}}', {icon: 5});
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
				if (Number(ipts.val())-Number(thisMul)<Number(thisMul)) {
                    layer.msg('{{trans('home.error_min_num_tips')}}', {icon: 5});
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
	                        thisDom.parent().parent().nextAll('.shop_price_d').html('￥'+formatNum(res['data']['account']));
	                    }else{
                            layer.msg('{{trans('home.reduce_error')}}', {icon: 5});
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
				var thisDom = $(this);
				//数量
				var goodsNumber = $(this).val();
				//当前购物车数据id
				var id = $(this).attr('id');
                	if( (/(^[1-9]\d*$)/.test(goodsNumber)) && goodsNumber>0){
                		// (/^(\+|-)?\d+$/.test( goodsNumber ))
            			$.ajax({
            				'type':'post',
			                'data':{'id':id,'goodsNumber':goodsNumber},
			                'url':'{{url('/checkListenCartInput')}}',
			                success:function(res){
			                    if(res.code){
			                    	thisDom.parent().parent().nextAll('.shop_price_d').html('￥'+formatNum(res['data']['account']));
			                    }else{
			                        layer.msg('{{trans('home.error_tips_num')}}');
			                        window.location.reload();
			                    }
		               		}
            			})
		        	}else{
		            	layer.msg('{{trans('home.error_tips_num')}}');
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
            var id = $(obj).attr('id');
            $.msg.confirm("{{trans('home.is_delete')}}？",
				function(){
                    $.ajax({
                        'type':'post',
                        'data':{'id':id},
                        'url':'{{url('/delCart')}}',
                        success:function(res){
                            // var result = JSON.parse(res);
                            if(res.code){
                                //todo 删除成功最好不刷新页面
                                // alert('删除成功');
                                window.location.reload();
                            }else{
                                $.msg.alert('{{trans('home.delete_error')}}');
                                window.location.reload();
                            }
                        }
                    })
				},
				function(){

				}
			)
    	}

    	//清空购物车
    	function clearCart(){
            $.msg.confirm("{{trans('home.is_empty_cart')}}？",
                function(){
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
                                $.msg.alert('{{trans('home.empty_cart_error')}}');
                            }
                        }
                    })
                },
                function(){

                }
            )
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
				$.msg.error('{{trans('home.choose_goods')}}');return;
			}
		}

		//去结算  先判断用户是否实名通过.
		function toBalance(){
			 var userId = "{{session('_web_user_id')}}";
			 if(userId > 0){
			 	 $.ajax({
			 		url: "/isReal",
					dataType: "json",
					data: {
					'userId':userId
					},
					async:false, 
					type: "POST",
					success: function (data) {
						if(data.code == 0){
							 layer.confirm('{{trans('home.no_real_name_msg')}}。', {
			                    btn: ['{{trans('home.go_real_name')}}','{{trans('home.see_others')}}'] //按钮
			                }, function(){
			                    window.location.href='/account/userRealInfo';
			                }, function(){

			                });
			                return;
						}else{
							toBalances();
						}
					}
				 })
				 
			 }else{
			 	$.msg.error('{{trans('home.user_info_error')}}');
			 	window.location.href='/login';
			 }
		}
			
          function toBalances(){
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
					    // console.log(data);
						if(data.code){
							window.location.href='/confirmOrder';
						}else{
                            $.msg.error(data.msg);
						}
					}
				})
			}else{
                $.msg.error('{{trans('home.choose_goods')}}');return;
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
					<div class="my_cart progress_text_curr">{{trans('home.header_cart')}}</div>
					<div class="order_information">{{trans('home.improving_order_info')}}</div>
					<div class="order_submit">{{trans('home.sub_order_success')}}</div>
				</div>
			</div>
		</div>
	</div>
	@if(count($cartInfo['cartInfo']))
		<div class="w1200 whitebg" style="margin-top: 20px;">
			<ul class="shop_title">
				<li class="check_all curr"><label class="check_box"><input class="check_box mr5 mt25 check_all fl" name="" type="checkbox" value="" id="check_all" onclick="check_all()"/><span class="fl ">{{trans('home.check_all')}}</span></label></li>
				<li class="shop_good">{{trans('home.goods_name')}}</li>
				<li class="shop_price">{{trans('home.price')}}</li>
				{{--<li class="shop_price">可售数量</li>--}}
				<li class="shop_num">{{trans('home.num')}}</li>
				<li class="shop_add">{{trans('home.delivery_area')}}</li>
				<li class="shop_sub">{{trans('home.subtotal')}}</li>
				<li class="shop_oper">{{trans('home.operation')}}</li>
			</ul>
			@foreach($cartInfo['cartInfo'] as $k=>$v)
			<ul class="shop_list">
				<li class="check_all">
					<span class="check_tick fl" style="margin: 33px 0px;">
						<label class="check_box"><input class="check_box mr5 mt10 check_all fl" name="" type="checkbox" value="{{$v['id']}}"/> </label>
					</span>
					<a class="shop_good_title fl tac" style="line-height: 20px;margin-top: 45px;" href="/goodsAttributeDetails/{{encrypt($v['goods_id'])}}">{{getLangData($v,'goods_name')}}</a>
					<span class="shop_price_t green fl tac">￥{{$v['goods_price']}}/{{$cartInfo['goodsInfo'][$k]['unit_name']}}</span>
					<span class="shop_price fl tac" style="display: none;" @if(count($cartInfo['quoteInfo'])) goods_number="{{$cartInfo['quoteInfo'][$k]['goods_number']}}" @else goods_number="0" @endif>@if(count($cartInfo['quoteInfo'])) {{$cartInfo['quoteInfo'][$k]['goods_number']}}{{$cartInfo['goodsInfo'][$k]['unit_name']}} @else @endif </span>
					<div class="shop_num_t fl">
						<div class="shop_nienb">
							<a class="shop_num_reduce num_nim" id="{{$v['id']}}" data-id="{{$cartInfo['goodsInfo'][$k]['packing_spec']}}">-</a>
							<input type="text" class="shop_num_amount Bidders_record_text goods_numberListen" id="{{$v['id']}}" value="{{$v['goods_number']}}"/>
							<a class="shop_num_plus num_nim" id="{{$v['id']}}" data-id="{{$cartInfo['goodsInfo'][$k]['packing_spec']}}">+</a>
						</div>
					</div>
				    
				    <span class="shop_add fl tac">{{$cartInfo['quoteInfo'][$k]['delivery_place']}}</span>
				    <span class="shop_price_d fl tac">{{amount_format($cartInfo['quoteInfo'][$k]['account'],2)}}</span>
				    <span class="shop_oper fl"><a class="shop_oper_icon shop_oper_bg" id="{{encrypt($v['id'])}}" onclick="del(this)"></a></span>
				</li>
			</ul>
			@endforeach
		</div>
		<div class="sumbit_cart whitebg ovh mb30">
			<span class="fl ml30 cp" onclick="clearCart();">{{trans('home.empty_cart')}}</span>
			<span class="fl ml40 cp">
				<a href="/goodsList">{{trans('home.continue_shopping')}}</a>
			</span>
			<span class="fl ml40">{{trans('home.self_quote_prefix')}}<font class="orange" id="accountTotal">@if($cartInfo['cartInfo']) {{count($cartInfo['cartInfo'])}} @else 0 @endif</font>{{trans('home.items_suffix')}}，{{trans('home.selected_prefix')}}<font class="orange" id="checkedSel"> 0 </font>{{trans('home.selected_suffix')}}</span>
			<div class="sumbit_cart_btn" onclick="toBalance()">{{trans('home.settlement')}}</div>
		</div>
	@else
		<div class="w1200 whitebg" style="margin-top: 20px;">
			<div style="height: 300px;text-align: center;">
				<div style="padding-top: 130px">
					<span style="font-size: 16px">{{trans('home.cart_is_empty')}}</span>
					<a type="button" href="/goodsList" style="height: 20px;background-color: #75b335;color:#fff;padding: 4px;border-radius: 4px;">{{trans('home.go_shopping')}}</a>
				</div>

			</div>
		</div>
	@endif

    <div class="clearfix whitebg ovh mt40" style="font-size: 0;"></div>
    @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
</body>
</html>


