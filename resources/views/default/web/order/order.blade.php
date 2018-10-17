<!doctype html>
<html lang="en">
<head>
	<title>订单列表 - @yield('title')</title>
	@include(themePath('.','web').'web.include.partials.base')
	<style>
		.member_right{width: 968px;box-sizing: border-box; min-height: 842px;height: auto;}
		.whitebg{background: #FFFFFF;}
		.fl{float:left;}
		.ml15{margin-left:15px;}
		.br1{border: 1px solid #DEDEDE;}
		.pr {position:relative; }.pa{position: absolute;}
		.member_right_title_icon{background: url(../img/member_title_icon.png)no-repeat 0px 6px;}
		.mt25{margin-top:25px;}
		.ml30{margin-left:30px;}
		.pl20{padding-left:20px;}
		.fs16{font-size:16px;}
		.reward_table{width: 905px;margin: 0 auto;margin-top: 20px;margin-bottom: 70px;}
		.order_list_stute{height: 37px;line-height: 35px;background-color: #F7F7F7;}
		.order_list_stute li{height: 37px;line-height: 35px;width: 77px;text-align: center;float: left;color: #666;cursor: pointer;}
		.order_list_stute li:first-child{height: 37px;line-height: 35px;background: none;}
		.order_list_stute li:last-child{height: 37px;line-height: 35px;}
		.order_list_stute .border_curr{border-bottom: 2px solid #75b335;color: #75b335;box-sizing: border-box;}
		.mt10{margin-top:10px;}
		.ovh{overflow: hidden;}
		.border_text{width: 184px;height: 34px;padding: 6px;box-sizing: border-box;border: 1px solid #DEDEDE;}
		.ml10{margin-left:10px;}
		.product-orader-tabs{width: 100%;border: 1px solid #DEDEDE; height: 40px;line-height: 40px;box-sizing: border-box;}
		.product-orader-tabs .order_time{padding: 7px 0;margin: 0;}
		.product-orader-tabs tbody tr td {line-height: 26px;border-right: 1px solid #dedede;}
		.mr10{margin-right:10px;}
		.date_btn{width: 90px;height: 34px;line-height: 34px;background-color: #75b335;border-radius: 2px;cursor: pointer;}
		.br0{border: 0px;}
		.white,a.white,a.white:hover{color:#fff; text-decoration:none;}
		.graybg {background: #f7f7f7;}
		.mt10{margin-top:10px;}
		.gray,a.gray,a.gray:hover{color:#aaa;}
		.product_list li:first-child{background: none;}
		.product_list li{background: none;}
		.product-orader-tabs .order_time{padding: 7px 0;margin: 0;}
		.product-orader-tabs tbody tr td {line-height: 26px;border-right: 1px solid #dedede;}
		.product-orader-tabs{width: 100%;border: 1px solid #DEDEDE; height: 40px;line-height: 40px;box-sizing: border-box;}
		.tr-td {background: #f5f5f5;line-height: 35px;height: 35px;}
		.pl20{padding-left:20px;}
		.pr20{padding-right:20px;}
		.pl10{padding-left:10px;}
		.fr{float:right;}
		.pt15{padding-top:15px;}
		.pb10{padding-bottom:10px;}
		.tac{text-align:center !important;}
		.p10{padding:10px;}
		.orange,a.orange,a.orange:hover{color:#ff6600;}
		.tooltip{position: relative; cursor: pointer;z-index: 2;}
		.tooltip .prompt-01{position: absolute;z-index: 1;width: 400px;right: 75px;top: -22px;padding: 9px 9px 0;display: none;cursor: auto;}
		.tooltip .prompt-01 .pc{min-height: 235px;}
		.ml5{margin-left:5px;}
		.cirred{float:left;width: 7px;height: 7px;border-radius: 25px;background-color: #e5383c;}
		.tooltip .prompt-01{position: absolute;z-index: 1;width: 400px;right: 75px;top: -22px;padding: 9px 9px 0;display: none;cursor: auto;}
		.prompt-01 {position: absolute;width: 122px;border: 1px solid #ddd;background: #fff;
			-webkit-box-shadow: 0 0 2px 2px #eee;-moz-box-shadow: 0 0 2px 2px #eee;box-shadow: 0 0 2px 2px #eee;
			-webkit-border-radius: 1px;-moz-border-radius: 1px;border-radius: 1px;}
		.tooltip .prompt-01 .pc{min-height: 235px;}
		.prompt-01 .pc{background: #fff;padding: 0;color: #333;text-align: left;overflow: hidden;}
		.prompt-01 .p-tit{margin: -10px 0 0 -10px;height: 40px;line-height: 40px;padding: 0 0 0 20px;font-weight: 700;border-bottom: 1px solid #e3e3e3;}
		.prompt-01 .logistics-cont {position: relative;margin-left: 15px;max-height: 410px;overflow-y: auto;padding-left: 5px;margin-bottom: 20px;line-height: 20px;}
		.prompt-01 .logistics-cont li.first {color: #e4393c;}
		.prompt-01 .logistics-cont li.first .node-icon {background-position: 0 -115px;}
		.prompt-01 .logistics-cont li {line-height: 21px;position: relative;overflow: visible;width: 340px;color: #666;padding: 15px 0 0 15px;border-left: 1px solid #e3e3e3;background: none;}
		.prompt-01 .logistics-cont .node-icon {display: block;position: absolute;
			top: 21px;left: -4px;width: 8px;height: 8px;overflow: hidden;background: url(//misc.360buyimg.com/user/myjd-2015/css/i/order-icon20150916.png) -17px -115px no-repeat;vertical-align: middle;zoom: 1;}
		.prompt-01 .p-arrow {position: absolute;background: url(//misc.360buyimg.com/user/myjd-2015/widget/common/i/arrow-gray.png) no-repeat;}
		.prompt-01 .p-arrow-left {right: -8px;top: 25px;width: 8px;height: 16px;background-position: -7px 0;}
		.tooltip .prompt-01 .pc{min-height: 235px;}
		.prompt-01 .pc{background: #fff;padding: 0;color: #333;text-align: left;overflow: hidden;}
		.confirm_product{box-sizing:border-box;width: 88px;margin:0 auto;margin-top:5px;height: 30px;line-height:30px;border-radius:3px;color: #fff;cursor: pointer;}
		.confirm_product_red{background-color: #e5383c;}.confirm_product_green{background-color: #75b335;}
		.pt5{padding-top:5px;}
		.reward_table_bottom{position:absolute;bottom: 5px;right: 27px;}
		.reward_table_bottom ul.pagination {display: inline-block;padding: 0;margin: 0;}
		.reward_table_bottom ul.pagination li {height: 20px;line-height: 20px;display: inline;}
		.reward_table_bottom ul.pagination li a {color: #ccc;float: left;padding: 4px 16px;text-decoration: none;transition: background-color .3s;
			border: 1px solid #ddd;margin: 0 4px;}
		.reward_table_bottom ul.pagination li a.active {color: #75b335;border: 1px solid #75b335;}
		.reward_table_bottom ul.pagination li a:hover:not(.active) {color: #75b335;border: 1px solid #75b335;}
	</style>
</head>
<body style="background-color: rgb(244, 244, 244);">
@include(themePath('.','web').'web.include.partials.top')
@component(themePath('.','web').'web.include.partials.top_title', ['title_name' => '会员中心'])@endcomponent

<div class="clearfix mt25 mb25">
	<div class="w1200">
		<div class="member_left">
			@if(session('_curr_deputy_user')['is_self'] && session('_curr_deputy_user')['is_firm'])
				{{--只有企业管理员才能进行企业管理--}}
				<div class="member_list_mode">
					<h1 class="">企业管理</h1>
					<ul class="member_left_list">
						<li><a href="/createFirmUser">职员管理</a></li>
						<li><a href="/firmUserAuthList">审核设置</a></li>
						<li><div class="bottom"></div><div class="line"></div></li>
					</ul>
				</div>
			@endif

			@if(session('_curr_deputy_user')['is_firm'] && (session('_curr_deputy_user')['is_self'] || session('_curr_deputy_user')['can_stock_in'] || session('_curr_deputy_user')['can_stock_out']))
				{{--只有企业才能进行库存管理--}}
				<div class="member_list_mode">
					<h1 class="">库存管理</h1>
					<ul class="member_left_list">
						@if(session('_curr_deputy_user')['is_self'] || session('_curr_deputy_user')['can_stock_in'])
							<li><a href="/stockIn">入库管理</a></li>
						@endif
						@if(session('_curr_deputy_user')['is_self'] || session('_curr_deputy_user')['can_stock_out'])
							<li><a href="/stockOut">出库管理</a></li>
						@endif
						<li><a href="/stockNum">库存查询</a></li>
						<li><div class="bottom"></div><div class="line"></div></li>
					</ul>
				</div>
			@endif
			<div class="member_list_mode">
				<h1 class="">订单管理</h1>
				<ul class="member_left_list">
					<li><a href="/cart">购物车</a></li>
					<li class="curr"><a href="/order">我的订单</a></li>
					<li><div class="bottom"></div><div class="line"></div></li>
				</ul>
			</div>
			<div class="member_list_mode">
				<h1 class="">账号管理</h1>
				<ul class="member_left_list">
					<li>用户信息</li>
					<li><a href="/updateUserInfo">实名认证</a></li>
					<li><a href="/forgotPwd">修改密码</a></li>
					<li><a href="/paypwd">支付密码</a></li>
					<li><a href="/collectGoodsList">我的收藏</a></li>
					<li><a href="/addressList">收货地址</a></li>
					<li><a href="/invoices">发票维护</a></li>
					<li><div class="bottom"></div><div class="line"></div></li>
				</ul>
			</div>
			<div class="member_list_mode">
				<h1 class="">活动中心</h1>
				<ul class="member_left_list">
					<li>限时抢购</li>
					<li></li>
				</ul>
			</div>
		</div>



		<div class="member_right whitebg fl ml15 br1 pr">
			<!--标题-->
			<h1 class="member_right_title_icon mt25 ml30 pl20 fs16">全部订单列表</h1>
			<div class="reward_table ">
				<!--订单状态标题-->
				<ul class="order_list_stute">
					<li class="border_curr or">全部订单</li>
					<li>待审核</li><li>待确认</li>
					<li>待付款</li><li>待发货</li>
					<li>已完成</li><li>已取消</li>
				</ul>

				<div class="mt10 ovh">
					<div class="fl"><input type="text" class="border_text" placeholder="商品名称"/></div>
					<div class="fl"><input type="text" class="border_text ml15" placeholder="订单单号"/></div>
					<div class="fl ml10">
						<input type="text" class="border_text" onClick="WdatePicker()"/><span class="ml10 mr10">至</span><input type="text" class="border_text" onClick="WdatePicker()"/>
						<button class="date_btn br0 white ml15">查询</button>
					</div>
				</div>

				<table class="product-orader-tabs graybg mt10 gray">
					<thead>
					<tr>
						<th style="width: 310px;">商品信息</th>
						<th style="width: 242px;">订单金额</th>
						<th style="width: 192px;">物流跟踪</th>
						<th>状态</th>
					</tr>
					</thead>
				</table>

				{{--@foreach($orderList as $v)--}}
				{{--<tr>--}}
				{{--<input type="hidden" name="" value="{{encrypt($v->id)}}">--}}
				{{--<td>{{$v->order_sn}}</td>--}}
				{{--<td>{{$v->shop_name}}</td>--}}
				{{--<td>{{$v->order_amount}}</td>--}}
				{{--<td></td>--}}
				{{--<td><a href="/orderDetails/{{encrypt($v->id)}}">详情</a></td>--}}
				{{--<td>@if($v->order_status == 1)待企业审核 <span style="cursor: pointer;color:blue;" onclick="egis(this);">审核通过</span> <span style="cursor: pointer;color:blue;" onclick="cancel(this)">作废</span> @elseif($v->order_status == 2)待商家确认 @elseif($v->order_status == 3)已确认 <a href="pay">去付款</a>@elseif($v->order_status == 0)已作废 @endif</td>--}}
				{{--</tr>--}}
				{{--@endforeach--}}
				<ul class="product_list">
					<li style="display: block;">
						<div class="product-orader-list ">
							@if($orderList)
								@foreach($orderList['orderInfo'] as $v)
							<table class="product-orader-tabs mt10">
								<tr class="tr-td" >
									<td colspan="5" class="order_time">
										<span class="pl20"><b class="gray" style="font-weight: 100;color: #666;">订单单号：</b></span>
										<a style="color: #666;" href="/user/orderdetail/17800" >{{$v->order_sn}}</a>
										<span class="gray pr20 pl10 fr">下单时间：{{$v->add_time}}</span>
									</td>
								</tr>
								<tr>
									<td style="width: 310px;border-bottom: 1px solid #DEDEDE;">
										<div>
											<p class="pl10 pt15" style="color: #666;">维生素 C</p>
											<p class="pl10 pb10">
												<span style="color: #999;">单价：￥16700.00 </span>
												<span class="pl10" style="color: #999;">数量：2.00kg</span>
											</p>
										</div>


									</td>

									<td style="width: 242px;">
										<div >
											<p class="pl10 pt15 tac" style="color: #666;">应付款：￥{{$v->order_amount}}</p>
											<p class="pl10 pb10 tac">
												<span style="color: #999;">已付款：￥{{$v->money_paid}}</span>
											</p>
										</div>
									</td>
									<td style="width: 192px;">
										<div class="p10">
											<p class="pl10 tac orange">等待确认</p>
											<div class="tooltip" style="width: 68px; height:23px;margin: 0 auto;">
												<div class="fl" style="padding-top: 4px;"><img src="img/Track_icon.png"/></div>
												<div class="fl ml5">跟踪 </div>
												<div class="cirred mt10 ml5"></div>
												<!--物流信息-->
												<div class="prompt-01" style="top: -10px; display: none;">
													<div class="pc">
														<div class="p-tit">订单跟踪 <span class="gray fr" style="font-weight: 100; font-size: 12px; ">订单号：2018092000004</span></div>
														<div class="logistics-cont" id="tracker18981932793">
															<ul>
																<li class="first">
																	<i class="node-icon"></i> 后台客服人员已经确认审核订单
																	<div class="ftx-13">2018-09-21 09:24:03</div>
																</li>
																<li>
																	<i class="node-icon"></i>您提交了订单，请等待供应商确认
																	<div class="ftx-13">2018-09-20 18:45:38</div>
																</li>
																<li>
																	<i class="node-icon"></i>
																	<a href="/user/orderdetail/17801" class="gray" target="_blank">查看更多</a>
																</li>
															</ul>
														</div>
													</div>
													<div class="p-arrow p-arrow-left" style="top: 12px;"></div>
												</div>
											</div>

											<div style="width: 100%;text-align: center;overflow: hidden;">订单详情</div>

										</div>
									</td>
									<td style="border-right:1px solid #DEDEDE;" >
										<div class="confirm_product tac confirm_product_red">确认订单</div>
										<p class="tac pt5 gray">申请售后</p>
									</td>
								</tr>
								<tr>
									<td>
										<div>
											<p class="pl10 pt15" style="color: #666;">维生素 C</p>
											<p class="pl10 pb10">
												<span style="color: #999;">单价：￥16700.00 </span>
												<span class="pl10" style="color: #999;">数量：2.00kg</span>
											</p>
										</div>
									</td>
									<td></td><td></td><td></td>
								</tr>
							</table>
								@endforeach
								@else
								暂时没有订单
								@endif



							<table class="product-orader-tabs mt10">
								<tr class="tr-td" >
									<td colspan="5" class="order_time">
										<span class="pl20"><b class="gray" style="font-weight: 100;color: #666;">订单单号：</b></span>
										<a style="color: #666;" href="/user/orderdetail/17800" >2018092000003</a>
										<span class="gray pr20 pl10 fr">下单时间：2018-09-20 18:45:38</span>
									</td>
								</tr>
								<tr>
									<td style="width: 310px;">
										<div style=" border-bottom: 1px solid #DEDEDE;">
											<p class="pl10 pt15" style="color: #666;">维生素 C</p>
											<p class="pl10 pb10">
												<span style="color: #999;">单价：￥16700.00 </span>
												<span class="pl10" style="color: #999;">数量：2.00kg</span>
											</p>
										</div>


									</td>
									<td style="width: 242px;">
										<div>
											<p class="pl10 pt15 tac" style="color: #666;">应付款：￥100.00</p>
											<p class="pl10 pb10 tac">
												<span style="color: #999;">已付款：￥0.00</span>
											</p>
										</div>
									</td>
									<td style="width: 192px;">
										<div class="p10">
											<p class="pl10 tac orange">等待确认</p>
											<div class="tooltip" style="width: 68px; height:23px;margin: 0 auto;">
												<div class="fl" style="padding-top: 4px;"><img src="img/Track_icon.png"/></div>
												<div class="fl ml5">跟踪 </div>
												<div class="cirred mt10 ml5"></div>
												<!--物流信息-->
												<div class="prompt-01" style="top: -10px; display: none;">
													<div class="pc">
														<div class="p-tit">订单跟踪 <span class="gray fr" style="font-weight: 100; font-size: 12px; ">订单号：2018092000004</span></div>
														<div class="logistics-cont" id="tracker18981932793">
															<ul>
																<li class="first">
																	<i class="node-icon"></i> 后台客服人员已经确认审核订单
																	<div class="ftx-13">2018-09-21 09:24:03</div>
																</li>
																<li>
																	<i class="node-icon"></i>您提交了订单，请等待供应商确认
																	<div class="ftx-13">2018-09-20 18:45:38</div>
																</li>
																<li>
																	<i class="node-icon"></i>
																	<a href="/user/orderdetail/17801" class="gray" target="_blank">查看更多</a>
																</li>
															</ul>
														</div>
													</div>
													<div class="p-arrow p-arrow-left" style="top: 12px;"></div>
												</div>
											</div>

											<div style="width: 100%;text-align: center;overflow: hidden;">订单详情</div>

										</div>
									</td>
									<td style="border-right:1px solid #DEDEDE;" >
										<div class="remain_time"><span class="pl15">剩余23时52分</span></div>
										<div class="confirm_product tac confirm_product_red pay_frame_btn">付款</div>
										<p class="tac pt5 gray">取消订单</p>
									</td>
								</tr>
								<tr>
									<td>
										<div>
											<p class="pl10 pt15" style="color: #666;">维生素 C</p>
											<p class="pl10 pb10">
												<span style="color: #999;">单价：￥16700.00 </span>
												<span class="pl10" style="color: #999;">数量：2.00kg</span>
											</p>
										</div>
									</td>
									<td></td><td></td><td></td>
								</tr>

							</table>



							<!--页码-->
							<div class="reward_table_bottom">
								<ul class="pagination">
									<li><a href="#">首页</a></li>
									<li><a href="#">上一页</a></li>
									<li><a href="#">1</a></li>
									<li><a class="active" href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">下一页</a></li>
									<li><a href="#">尾页</a></li>
								</ul>
							</div>

						</div>
					</li>
					<!--待审核-->
					<li style="display: none;">
						<div class="product-orader-list ">
							<table class="product-orader-tabs mt10">
								<tr class="tr-td" >
									<td colspan="5" class="order_time">
										<span class="pl20"><b class="gray" style="font-weight: 100;color: #666;">订单单号：</b></span>
										<a style="color: #666;" href="/user/orderdetail/17800" >2018092000003</a>
										<span class="gray pr20 pl10 fr">下单时间：2018-09-20 18:45:38</span>
									</td>
								</tr>
								<tr>
									<td style="width: 310px; border-bottom: 1px solid #DEDEDE;">
										<div>
											<p class="pl10 pt15" style="color: #666;">维生素 C</p>
											<p class="pl10 pb10">
												<span style="color: #999;">单价：￥16700.00 </span>
												<span class="pl10" style="color: #999;">数量：2.00kg</span>
											</p>
										</div>


									</td>
									<td style="width: 242px;">
										<div >
											<p class="pl10 pt15 tac" style="color: #666;">应付款：￥100.00</p>
											<p class="pl10 pb10 tac">
												<span style="color: #999;">已付款：￥0.00</span>
											</p>
										</div>
									</td>
									<td style="width: 192px;">
										<div class="p10">
											<p class="pl10 tac orange">等待确认</p>
											<div class="tooltip" style="width: 68px; height:23px;margin: 0 auto;">
												<div class="fl" style="padding-top: 4px;"><img src="img/Track_icon.png"/></div>
												<div class="fl ml5">跟踪 </div>
												<div class="cirred mt10 ml5"></div>
												<!--物流信息-->
												<div class="prompt-01" style="top: -10px; display: none;">
													<div class="pc">
														<div class="p-tit">订单跟踪 <span class="gray fr" style="font-weight: 100; font-size: 12px; ">订单号：2018092000004</span></div>
														<div class="logistics-cont" id="tracker18981932793">
															<ul>
																<li class="first">
																	<i class="node-icon"></i> 后台客服人员已经确认审核订单
																	<div class="ftx-13">2018-09-21 09:24:03</div>
																</li>
																<li>
																	<i class="node-icon"></i>您提交了订单，请等待供应商确认
																	<div class="ftx-13">2018-09-20 18:45:38</div>
																</li>
																<li>
																	<i class="node-icon"></i>
																	<a href="/user/orderdetail/17801" class="gray" target="_blank">查看更多</a>
																</li>
															</ul>
														</div>
													</div>
													<div class="p-arrow p-arrow-left" style="top: 12px;"></div>
												</div>
											</div>

											<div style="width: 100%;text-align: center;overflow: hidden;">订单详情</div>

										</div>
									</td>
									<td style="border-right:1px solid #DEDEDE;" >
										<div class="confirm_product tac code_greenbg exam_frame_btn">审核订单</div>
										<p class="tac pt5 gray">取消订单</p>
									</td>
								</tr>

							</table>





							<!--页码-->
							<div class="reward_table_bottom">
								<ul class="pagination">
									<li><a href="#">首页</a></li>
									<li><a href="#">上一页</a></li>
									<li><a href="#">1</a></li>
									<li><a class="active" href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">下一页</a></li>
									<li><a href="#">尾页</a></li>
								</ul>
							</div>

						</div>
					</li>
				</ul>




			</div>

		</div>
		<!--右部分_end-->
	</div>
</div>
	</div>
</div>
@yield('content')

@include(themePath('.','web').'web.include.partials.footer_service')
@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')
</body>
</html>
<script type="text/javascript">
    function egis(obj){
        var id = $(obj).parent().siblings('input[type=hidden]').val();
        $.ajax({
            url: "/egis",
            dataType: "json",
            data: {
                'id':id
            },
            type: "POST",
            success: function (data) {
                if(data.code){
                    window.location.reload();
                }else{
                    console.log(data.code);
                    alert('出错,请重试')
                }
            }
        })
    }

    function cancel(obj){
        var id = $(obj).parent().siblings('input[type=hidden]').val();
        $.ajax({
            url: "/cancel",
            dataType: "json",
            data: {
                'id':id
            },
            type: "POST",
            success: function (data) {
                if(data.code){
                    window.location.reload();
                }else{
                    console.log(data.code);
                    alert('出错,请重试')
                }
            }
        })
    }
</script>
