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
			@foreach($addressInfo as $k=>$v)
			<li class="#curr">
				<div class="address_name mt20"><span>{{ $v['consignee'] }}</span><div class="fr red"><a class="edit_address" data_id ={{ $v['id'] }}>修改</a><a class="ml10 del_address " data_id = {{ $v['id'] }}>删除</a></div></div>
				<div class="address_name mt5"><span>{{ $v['country'] }}-{{ $v['province'] }}-{{ $v['district'] }}{{ $v['address'] }}</span></div>
				<div class="address_name mt5"><span>{{ $v['mobile_phone'] }}</span></div>
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

	<!--遮罩-->
	<div class="block_bg"></div>

	<div class="pay_method whitebg" id="addr_frame">
		<div class="pay_title f4bg"><span class="fl pl30 gray fs16">新增收货地址</span><a class="fr frame_close mr15 mt15"><img src="img/close.png" width="15" height="15"></a></div>
		<form id="address_form">
		<ul class="addr_list ml30 mt25">
			<li>
				<div class=" mt10 ml30">
					<span class="add_left fl">收货地址:</span>
					<input type="text" readonly="readonly" name="str_address" id="area2" style="display: none">
					<input type="text" readonly="readonly" name="id" style="display: none">
					<div class="ui-area fl" data-value-name="area1" data-value-id="area2" data-init-name="" style="width: 343px;margin-left: 20px" id="test">
					</div>
				</div>
			</li>
			<li><div class="ovh mt10 ml30"><span class="add_left fl">详细地址:</span><input type="text" class="pay_text" name="address"/></div></li>
			<li><div class="ovh mt10 ml30"><span class="add_left fl">邮政编码:</span><input type="text" class="pay_text"  name="zipcode"/></div></li>
			<li><div class="ovh mt10 ml30"><span class="add_left fl">收货人姓名:</span><input type="text" class="pay_text" name="consignee"/></div></li>
			<li><div class="ovh mt10 ml30"><span class="add_left fl">手机号码:</span><input type="text" class="pay_text"  name="mobile_phone"/></div></li>
		</ul>
		<div class="ovh mb30 mt20" style="margin-left: 154px;">
			<button type="button" class="add_btn code_greenbg add_address">保 存</button><button type="button" class="add_btn cccbg ml35 cancel">取 消</button>
		</div>
		</form>
	</div>

@endsection
@section('js')
	<script type="text/javascript">
        $(function(){
            $('.Receive_address li').click(function(){
                $(this).addClass('curr').siblings().removeClass('curr')
            })
			//	删除
            $('.del_address').click(function(){
                let id = $(this).attr('data_id');
               	$.ajax({
					url:'/deleteAddress',
					data:{id:id},
					type:'POST',
					success:function (res) {
						if (res.code == 1){
                            $.msg.alert(res.msg);
						} else {
						    $.msg.alert(res.msg);
						    return false;
						}
                    }
				});
                $(this).parents(".Receive_address li").remove();
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
                // $.ajax({
                //     url:'/createInvoices',
					// type:'GET',
					// data:{'id':address_id},
					// success:function (res) {
                //         if (res.code == 1){
                //             var data = res.data.data.form;
                //             console.log(res.data.data.address_names);
					// 		$("#test").attr('data-init-name',res.data.data.address_names);
                //             for(var k in data){
                //                 let test = $("input[ name= "+k+" ]").val(data[k]);
                //             }
                //             $('.block_bg,#addr_frame').show();
                //         }
                //     }
                // });
            });
			//	增加
            $('.add_address').click(function(){
                console.log('s');

				// let input = $("#address_form").serialize();
				// $.ajax({
				// 	url:'/createAddressList',
				// 	data: input,
				// 	type: 'POST',
				// 	success:function (res) {
				// 		if (res.code == 1){
                 //            $('.block_bg,#addr_frame').hide();
                 //            $.msg.alert(res.msg);
				// 		    setTimeout(window.location.reload(),2000);
				// 		} else {
                 //            $('.block_bg,#addr_frame').hide();
                 //            $.msg.alert(res.msg);
                 //            document.getElementById("address_form").reset()
				// 		}
                 //    }
				// });

            });
            // $('.Receive_address li:last-child').unbind('click');
				// // 新增地址、
            $('.news_addr').click(function(){
                layer.open({
                    title:'用户地址',
                    type: 2,
                    area: ['600px', '500px'],
                    maxmin: true,
                    content: '/editAddressList?id=',
                    zIndex: layer.zIndex
                });

                // var Rlength=$('.Receive_address li').length;
                // if (Rlength>10){
                 //    $.msg.alert('最多输入十个地址');
                 //    return false;
                // } else {
                 //    $('.block_bg,#addr_frame').toggle();
				// }
            });
            // //  修改-弹窗
            // $('.edit_address').click(function(){
            //     $('.block_bg,#addr_frame').toggle();
            // })
			//  关闭地址
            $('.frame_close,.cancel').click(function(){
                document.getElementById("address_form").reset()
                $('.block_bg,#addr_frame').hide();
            })
        })


	</script>
@endsection
