@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '我的地址')
@section('css')
	<link rel="stylesheet" type="text/css" href="{{asset('ui/area/1.0.0/area.css')}}" />

	<style>
		.tac{text-align:center !important;}
		.block_bg{display:none;height: 100%;left: 0;position: fixed; top: 0;width: 100%;background: #000;opacity: 0.8;z-index:2;}
		/*会员中心-我的发票-页面*/
		.invoice_method{display:none;z-index: 2;width:800px;  left:50%; top:50%;margin-top:-275px;position:fixed;margin-left:-250px;}
		/*会员中心-收货地址*/
		.address_border{width: 905px; margin: 0 auto;}
		.Receive_address{overflow: hidden;margin-left: -15px;}
		.Receive_address li{margin-top:15px;;float:left;width: 290px;height: 130px;position: relative;border: 1px solid #DEDEDE;margin-left: 15px;box-sizing: border-box;}
		.Receive_address li:hover{border: 1px solid #75b335;}
		.Receive_address li:last-child:hover{border: 1px solid #DEDEDE;}
		.Receive_address li.curr{border: 1px solid #75b335;background: url(/default/img/addr_curr.png)no-repeat;}
		.address_name{margin-left: 24px;margin-right: 20px;}
		.address_info{margin-left: 24px;margin-right: 20px; height:40px}
		.pay_method{display:none;z-index: 2;width:584px;  left:50%; top:50%;margin-top:-275px;position:fixed;margin-left:-250px;}

		.ovh{overflow: hidden;}
		.mr15{margin-right:15px;}
		.mt40{margin-top:40px;}
		.pay_title{height: 50px;line-height: 50px;}
		.news_addr{width: 65px;margin: 30px auto;}
		.addr_list li{height: 40px;line-height: 40px;}
		.addr_list li .pay_text{width: 343px;}
		.addr_list li .add_left{width: 75px;text-align: right;color: #666;}
		.pay_text {
			width: 330px;
			height: 40px;
			line-height: 40px;
			margin-left: 20px;
			border: 1px solid #e6e6e6;
			padding: 8px;
			box-sizing: border-box;
		}
		.code_greenbg{background-color: #75b335;}
		.cccbg{background: #CCCCCC;}
		.form-inline{margin-left: 20px;}
		.form-inline .form-group:focus{box-shadow: none;}
		.form-inline .form-group .form-control{width: 108px;height: 40px;line-height: 40px;border-radius: 0px;border: 1px solid #dedede;
			box-shadow: none;padding: 6px 12px;font-size: 14px;    background-color: #fff;background-image: none;}


		@media (min-width: 768px) {
			.form-inline .form-group {
				display: inline-block;
				margin-bottom: 0;
				vertical-align: middle;
			}

			.sr-only {
				position: absolute;
				width: 1px;
				height: 1px;
				padding: 0;
				margin: -1px;
				overflow: hidden;
				clip: rect(0, 0, 0, 0);
				border: 0;
			}

			.form-group label {
				display: inline-block;
				max-width: 100%;
				margin-bottom: 5px;
				font-weight: bold;
			}
		}
			.address_button{width: 300px;margin: 20px auto;}
			.add_btn{cursor:pointer;float:left;border:none;color:#fff;width: 154px;height: 44px;line-height: 44px;display: block;border-radius: 3px;}
			.default_address label { /*flex布局让子元素水平垂直居中*/display: flex;align-items: center;width: 200px;margin-left: 154px;}

			.default_address input[type=checkbox],input[type=radio] {
				margin:initial;-webkit-appearance: none;appearance: none;outline: none;
				width: 16px; height: 16px;cursor: pointer;vertical-align: center;background: #fff;border: 1px solid #ccc;position: relative;}

			.default_address input[type=checkbox]:checked::after {
				content: "\2713";display: block;position: absolute;top: -1px;
				left: -1px;right: 0;bottom: 0;width: 12px;height: 16px;line-height: 17px;padding-left: 4px;
				color: #fff;background-color: #75b334;font-size: 13px;}
			.frame_close{width: 15px;height: 15px;line-height:0;
				display: block;outline: medium none;
				transition: All 0.6s ease-in-out;
				-webkit-transition: All 0.6s ease-in-out;
				-moz-transition: All 0.6s ease-in-out;
				-o-transition: All 0.6s ease-in-out;}
			@media (min-width: 768px) {
				form-inline .form-group {
					display: inline-block;
					margin-bottom: 0;
					vertical-align: middle;
				}

				.sr-only {
					position: absolute;
					width: 1px;
					height: 1px;
					padding: 0;
					margin: -1px;
					overflow: hidden;
					clip: rect(0, 0, 0, 0);
					border: 0;
				}

				.form-group label {
					display: inline-block;
					max-width: 100%;
					margin-bottom: 5px;
					font-weight: bold;
				}
			}
				.ui-area .tit {
					padding: 0 10px;
					border: 1px solid #d2d2d2;
					height: 40px;
					line-height: 40px;
					cursor: pointer;
				}
				.ui-area .area-warp {
					position: absolute;
					border: 1px solid #d2d2d2;
					width: 300px;
					padding: 10px 23px 15px 18px;
					top: 42px;
					left: 0;
					z-index: 10;
					display: none;
					background: #fff;
				}

		.address_default_edit{margin-right: 25px;}
		.checked_btn{cursor:pointer;}


		@media (min-width: 768px).form-inline .form-group {display: inline-block;margin-bottom: 0;vertical-align: middle;}
		.sr-only {position: absolute;width: 1px;height: 1px;padding: 0;margin: -1px;overflow: hidden;clip: rect(0, 0, 0, 0); border: 0;}
		.form-group label {display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: bold;}

		.address_button{width: 300px;margin: 20px auto;}
		.add_btn{cursor:pointer;float:left;border:none;color:#fff;width: 154px;height: 44px;line-height: 44px;display: block;border-radius: 3px;}
		.default_address label { /*flex布局让子元素水平垂直居中*/display: flex;align-items: center;width: 200px;margin-left: 154px;}

		.default_address input[type=checkbox],input[type=radio] {
			margin:initial;-webkit-appearance: none;appearance: none;outline: none;
			width: 16px; height: 16px;cursor: pointer;vertical-align: center;background: #fff;border: 1px solid #ccc;position: relative;}

		.default_address input[type=checkbox]:checked::after {
			content: "\2713";display: block;position: absolute;top: -1px;
			left: -1px;right: 0;bottom: 0;width: 12px;height: 16px;line-height: 17px;padding-left: 4px;
			color: #fff;background-color: #75b334;font-size: 13px;}
		.frame_close{width: 15px;height: 15px;line-height:0;
			display: block;outline: medium none;
			transition: All 0.6s ease-in-out;
			-webkit-transition: All 0.6s ease-in-out;
			-moz-transition: All 0.6s ease-in-out;
			-o-transition: All 0.6s ease-in-out;}
		@media (min-width: 768px).form-inline .form-group {display: inline-block;margin-bottom: 0;vertical-align: middle;}
			.sr-only {position: absolute;width: 1px;height: 1px;padding: 0;margin: -1px;overflow: hidden;clip: rect(0, 0, 0, 0); border: 0;}
			.form-group label {display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: bold;}

			.ui-area .tit {
				padding: 0 10px;
				border: 1px solid #d2d2d2;
				height: 40px;
				line-height: 40px;
				cursor: pointer;
			}
			.ui-area .area-warp {
				position: absolute;
				border: 1px solid #d2d2d2;
				width: 300px;
				padding: 10px 23px 15px 18px;
				top: 42px;
				left: 0;
				z-index: 10;
				display: none;
				background: #fff;
			}



	</style>
@endsection
@section('content')

	<!--标题-->
	<div class="address_border">
		<ul class="Receive_address">
			@foreach($addressList as $k=>$v)
			<li class="@if($v['is_default']==1) curr @else checked_btn @endif" data-id="{{$v['id']}}">
				<div class="address_name mt10"><span>{{ $v['consignee'] }}</span><div class="fr red"><a class="edit_address" data_id ={{ $v['id'] }}>修改</a><a class="ml10 del_address " data_id = {{ $v['id'] }}>删除</a></div></div>
				<div class="address_info mt5"><span>{{ $v['address_names']}}-{{ $v['address'] }}</span></div>
				<div class="address_name mt5"><span>{{ $v['mobile_phone'] }}</span></div>
				<div class="address_default">
					<div class="address_default_edit" align="right">
						@if($v['is_default'] == 1)
							<span class=" cp " style="color: #74b334">默认</span>
						@else
							<span class=" cp " >设置默认</span>
						@endif
					</div>
				</div>
			</li>
			@endforeach
			<li>
				<a class="tac mt40 db news_addr" style="text-decoration: none;">
					<div class="tac mt30"><img src="{{asset(themePath('/').'img/add_adr.png')}}"/></div>
					<p class="fs16 gray">新增地址</p>
				</a>
			</li>
		</ul>
		<div></div>
	</div>

@endsection
@section('js')
	<script type="text/javascript">
        $(function(){
			//	删除
            $('.del_address').click(function(){
                let io = $(this);
                let id = $(this).attr('data_id');
                $.msg.confirm("确认删除么？",
					function(index, layero){
						$.ajax({
							url:'/deleteAddress',
							data:{id:id},
							type:'POST',
							success:function (res) {
								if (res.code == 1){
									$.msg.alert(res.msg);
									io.parents(".Receive_address li").remove();
								} else {
									$.msg.alert(res.msg);
									return false;
								}
							}
						});
                	},
					function(index){
                	}
                );
//                layer.confirm('确认删除么？', {
//                    btn: ['确认','取消']
//                }, function(index, layero){
//                    $.ajax({
//                        url:'/deleteAddress',
//                        data:{id:id},
//                        type:'POST',
//                        success:function (res) {
//                            if (res.code == 1){
//                                $.msg.alert(res.msg);
//                               io.parents(".Receive_address li").remove();
//                            } else {
//                                $.msg.alert(res.msg);
//                                return false;
//                            }
//                        }
//                    });
//                }, function(index){
//                });
            })
			//	编辑
			$(".edit_address").click(function () {
                let address_id = $(this).attr('data_id');
                layer.open({
					title:'用户地址',
                    type: 2,
                    area: ['600px', '500px'],
                    maxmin: true,
                    content: '/editAddressList?id='+address_id,
                    zIndex: layer.zIndex
                });
            });
            /**
             * 修改默认地址
             */
            $(".checked_btn").click(function () {
                let address_id = $(this).attr('data-id');
                $.ajax({
                    url:'/updateDefaultAddress',
                    data:{'address_id':address_id},
                    type:"POST",
                    success:function (res) {
                        if (res.code == 1){
                            setTimeout(window.location.reload(),1000);
                        }else{
                            $.msg.error(res.msg);
                        }
                    }
                });
            });
			//	增加
            $('.add_address').click(function(){

            });
            // $('.Receive_address li:last-child').unbind('click');
				// // 新增地址、
            $('.news_addr').click(function(){

                var Rlength=$('.Receive_address li').length;
                if (Rlength>10){
                    $.msg.alert('最多输入十个地址信息');
                    return false;
                } else {
                    layer.open({
                        title:'用户地址',
                        type: 2,
                        area: ['600px', '500px'],
                        maxmin: true,
                        content: '/editAddressList',
                        zIndex: layer.zIndex
                    });

                }
            });

			//  关闭地址
            $('.frame_close,.cancel').click(function(){
                document.getElementById("address_form").reset()
                $('.block_bg,#addr_frame').hide();
            })
        })
	</script>
@endsection
