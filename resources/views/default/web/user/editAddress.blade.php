@include(themePath('.','web').'web.include.partials.base')
	<link rel="stylesheet" type="text/css" href="{{asset('ui/area/1.0.0/area.css')}}" />
	<script src="{{asset('ui/area/1.0.0/area.js')}}"></script>
	<style>
		.Receive_address li{margin-top:15px;;float:left;width: 290px;height: 130px;position: relative;border: 1px solid #DEDEDE;margin-left: 15px;box-sizing: border-box;}
		.Receive_address li:hover{border: 1px solid #75b335;}
		.Receive_address li:last-child:hover{border: 1px solid #DEDEDE;}
		.Receive_address li.curr{border: 1px solid #75b335;background: url(/default/img/addr_curr.png)no-repeat;}
		.address_name{margin-left: 24px;margin-right: 20px;}
		.pay_method{width:584px;}

		.ovh{overflow: hidden;}
		.mr15{margin-right:15px;}
		.mt40{margin-top:40px;}
		.pay_title{height: 50px;line-height: 50px;}
		.news_addr{width: 65px;margin: 30px auto;}
		.addr_list>li{height: 40px;line-height: 40px;}
		.addr_list>li .pay_text{width: 343px;}
		.addr_list>li .add_left{width: 75px;text-align: right;color: #666;}
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
			/*.default_address label { !*flex布局让子元素水平垂直居中*!display: flex;align-items: center;width: 200px;margin-left: 154px;}*/

			/*.default_address input[type=checkbox],input[type=radio] {*/
				/*margin:initial;-webkit-appearance: none;appearance: none;outline: none;*/
				/*width: 16px; height: 16px;cursor: pointer;vertical-align: center;background: #fff;border: 1px solid #ccc;position: relative;}*/

			/*.default_address input[type=checkbox]:checked::after {*/
				/*content: "\2713";display: block;position: absolute;top: -1px;*/
				/*left: -1px;right: 0;bottom: 0;width: 12px;height: 16px;line-height: 17px;padding-left: 4px;*/
				/*color: #fff;background-color: #75b334;font-size: 13px;}*/
			.frame_close{width: 15px;height: 15px;line-height:0;
				display: block;outline: medium none;
				transition: All 0.6s ease-in-out;
				-webkit-transition: All 0.6s ease-in-out;
				-moz-transition: All 0.6s ease-in-out;
				-o-transition: All 0.6s ease-in-out;}
			@media (min-width: 768px).form-inline .form-group {display: inline-block;margin-bottom: 0;vertical-align: middle;}
				.sr-only {position: absolute;width: 1px;height: 1px;padding: 0;margin: -1px;overflow: hidden;clip: rect(0, 0, 0, 0); border: 0;}
				.form-group label {display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: bold;}

				.ui-area .tit{
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

	<div class="pay_method whitebg " id="addr_frame">
		<form  method="post" id="address_form">
			<ul class="addr_list ml30 mt25">
				<li><div class="ovh mt10 ml30"><span class="add_left fl">收货人姓名:</span><input type="text" class="pay_text" value="@if(!empty($data)){{ $data['consignee'] }}@endif" name="consignee"/></div></li>
				<li><div class="ovh mt10 ml30"><span class="add_left fl">手机号码:</span><input type="text" class="pay_text"  value="@if(!empty($data)){{ $data['mobile_phone'] }}@endif" name="mobile_phone"/></div></li>
				<li>
					<div class=" mt10 ml30">
						<span class="add_left fl">收货地址:</span>
						<input type="hidden" name="str_address" id="area2" value="@if(!empty($data)) {{ $data['str_address'] }} @endif">
						<input type="hidden" name="id" value="@if(!empty($data)) {{ $data['id'] }} @endif "/>
						<div class="ui-area fl" data-value-name="area1" data-value-id="area2" data-init-name="@if(!empty($data)) {{ $data['address_names'] }} @endif" style="width: 343px;margin-left: 20px" id="test">
						</div>
					</div>
				</li>
				<li><div class="ovh mt10 ml30"><span class="add_left fl">详细地址:</span><input type="text" class="pay_text"  value="@if(!empty($data)){{ $data['address'] }}@endif" name="address"/></div></li>
				<li><div class="ovh mt10 ml30"><span class="add_left fl">邮政编码:</span><input type="text" class="pay_text"  value="@if(!empty($data)){{ $data['zipcode'] }}@endif" name="zipcode"/></div></li>

				<li>
					<div class="ovh mt10 ml30">
						<span class="add_left fl">是否默认:</span>
						<div>

							<input name="default_address" class="" style="margin-left: 20px;" type="radio" value="Y" @if(!empty($default_id) && $default_id == 1) checked @endif/>是
							<input name="default_address" class="" type="radio" value="N" @if(empty($default_id)) checked @endif/>否

						</div>

					</div>
				</li>
			</ul>

		</form>
		<div class="ovh mb30 mt20 whitebg" style="margin-left: 154px;">
			<button type="submit" class="add_btn code_greenbg add_address">保 存</button><button type="button" class="add_btn cccbg ml35 cancel">取 消</button>
		</div>
	</div>

	<script type="text/javascript">
        $(function(){
			//	增加
            $('.add_address').click(function(){
                let _str_address = $("input[name='str_address']").val();
                let _id = $("input[name='id']").val();
                let _address = $("input[name='address']").val();
                let _zipcode = $("input[name='zipcode']").val();
                let _consignee = $("input[name='consignee']").val();
                let _mobile = $("input[name='mobile_phone']").val();
                let _default = $("input[name='default_address']:checked").val();
                if(!_str_address){
                    $.msg.error('请选择地址');return;
				}
                if(!_address){
                    $.msg.error('请输入详细地址');return;
                }
//                if(!_zipcode){
//                    $.msg.error('请输入邮政编码');return;
//                }
                if(!_consignee){
                    $.msg.error('请输入收货人姓名');return;
                }
                if(!_mobile){
                    $.msg.error('请输入手机号码');return;
                }
//                if(!Utils.isPhone(_mobile)){
//                    $.msg.error('请输入正确的手机号');return;
//				}
				$.ajax({
					url:'/createAddressList',
					data: {
					    id:_id,
                        str_address:_str_address,
                        address:_address,
                        zipcode:_zipcode,
                        consignee:_consignee,
                        mobile:_mobile,
                        default_address:_default,
					},
					type: 'POST',
					success:function (res) {
						if (res.code == 1){
                            $.msg.alert(res.msg);
                            setTimeout( parent.location.reload(),2000);
						} else {
                            $.msg.error(res.msg);
						}
                    }
				});

			});
            $('.frame_close,.cancel').click(function(){
                parent.location.reload(); //刷新父亲对象（用于框架）
            })
        })
	</script>

