@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/orderinfo/list?currpage={{$currpage}}" class="s-back">返回</a>订单 - 订单信息</div>
        <div class="content">
            <div class="flexilist order_info">
                <div class="stepflex">
                    <dl class="first cur">
                        <dt></dt>
                        <dd class="s-text">提交订单<br><em class="ftx-03">{{$orderInfo['add_time']}}</em></dd>
                    </dl>

                    <dl @if($orderInfo['order_status']==3) class="cur" @endif>
                        <dt></dt>
                        <dd class="s-text">审核订单<br>
                            <em class="ftx-03">
                                @if($orderInfo['order_status']==0)已作废
                                @elseif($orderInfo['order_status']==1)待企业审核
                                @elseif($orderInfo['order_status']==2)待商家确认
                                @else已确认
                                @endif
                            </em>
                        </dd>
                    </dl>

                    <dl @if($orderInfo['pay_status']==1) class="cur" @endif>
                        <dt></dt>
                        <dd class="s-text">支付订单<br>
                            <em class="ftx-03">
                                @if($orderInfo['pay_status']==0)待付款
                                @elseif($orderInfo['pay_status']==1)已付款
                                @else部分付款
                                @endif
                            </em>
                        </dd>
                    </dl>
                    <dl @if($orderInfo['shipping_status']==1) class="cur" @endif>
                        <dt></dt>
                        <dd class="s-text">商家发货<br>
                            <em class="ftx-03">
                                @if($orderInfo['shipping_status']==0)待发货
                                @elseif($orderInfo['shipping_status']==1)已发货
                                @elseif($orderInfo['shipping_status']==2)部分发货
                                @endif
                            </em>
                        </dd>
                    </dl>
                    <dl @if($orderInfo['confirm_take_time']!=null) class="cur" @endif class="last ">
                        <dt></dt>
                        <dd class="s-text">确认收货<br>
                            <em class="ftx-03">
                                @if($orderInfo['confirm_take_time']!=null)
                                    {{$orderInfo['confirm_take_time']}}
                                @endif
                            </em>
                        </dd>
                    </dl>
                </div>
                <form action="" method="post" name="theForm">
                    <div class="common-content">
                        <!--订单基本信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>基本信息</h3></div>
                            <div class="section">
                                <dl>
                                    <dt>订单号：</dt>
                                    <dd>{{$orderInfo['order_sn']}}</dd>
                                    <dt>订单来源：</dt>
                                    <dd>{{$orderInfo['froms']}}</dd>
                                </dl>
                                <dl>
                                    <dt>购货人： <div class="div_a"><span class="viewMessage" style="color:blue;cursor:pointer;">留言</span></div></dt>
                                    <dd>{{$user['nick_name']}}</dd>
                                    <dt>订单状态：</dt>
                                    <dd>
                                        <!--审核状态-->
                                        @if($orderInfo['order_status']==0)已作废
                                        @elseif($orderInfo['order_status']==1)待企业审核
                                        @elseif($orderInfo['order_status']==2)待商家确认
                                        @else已确认
                                        @endif
                                        <!--付款状态-->
                                        @if($orderInfo['pay_status']==0)待付款
                                        @elseif($orderInfo['pay_status']==1)已付款
                                        @else部分付款
                                        @endif
                                        <!--发货状态-->
                                        @if($orderInfo['shipping_status']==0)待发货
                                        @elseif($orderInfo['shipping_status']==1)已发货
                                        @elseif($orderInfo['shipping_status']==2)部分发货
                                        @endif
                                    </dd>
                                </dl>

                                <dl>
                                    <dt>下单时间：</dt>
                                    <dd>{{$orderInfo['add_time']}}</dd>
                                    <dt>付款时间：</dt>
                                    <dd>@if(empty($orderInfo['pay_time']))未付款@else {{$orderInfo['pay_time']}} @endif</dd>
                                </dl>
                                <dl>
                                    <dt>发货时间：</dt>
                                    <dd>@if(empty($orderInfo['shipping_time']))未发货@else {{$orderInfo['shipping_time']}} @endif</dd>
                                    <dt>发货单号：</dt>
                                    <dd>@if(empty($orderInfo['shipping_time']))未发货@else
                                            <div class="editSpanInput" ectype="editSpanInput">
                                                <span onclick="listTable.edit(this,'{{url('/admin/orderinfo/modify3')}}','{{$orderInfo['id']}}')">{{$orderInfo['shipping_time']}}</span>
                                                <span>天</span>
                                                <i class="icon icon-edit"></i>
                                            </div>
                                        @endif</dd>
                                </dl>
                                <dl>
                                    <dt>自动确认收货时间：</dt>
                                    <dd>
                                        <div class="editSpanInput" ectype="editSpanInput">
                                            <span onclick="listTable.edit(this,'{{url('/admin/orderinfo/modify2')}}','{{$orderInfo['id']}}')">{{$orderInfo['auto_delivery_time']}}</span>
                                            <span>天</span>
                                            <i class="icon icon-edit"></i>
                                        </div>
                                    </dd>
                                    <dt>&nbsp;</dt>
                                    <dd>&nbsp;</dd>
                                </dl>
                            </div>
                        </div>

                        <!--收货人信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>收货人信息<a href="/admin/orderinfo/modifyConsignee?id={{$orderInfo['id']}}&currpage={{$currpage}}"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="section">
                                <dl>
                                    <dt>收货人：</dt>
                                    <dd>{{$orderInfo['consignee']}}</dd>
                                    <dt>手机号码：</dt>
                                    <dd>{{$orderInfo['mobile_phone']}}</dd>
                                </dl>
                                <dl style="width:50%">
                                    <dt>收货地址：</dt>
                                    <dd>[{{$region}}] 街道：{{$orderInfo['street']}};地址：{{$orderInfo['address']}}</dd>
                                    <dt>邮政编码：</dt>
                                    <dd>{{$orderInfo['zipcode']}}</dd>
                                </dl>
                            </div>
                        </div>
                        <!-- 门店信息 -->
                        <!--订单其他信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>其他信息<a href="/admin/orderinfo/modifyInvoice?invoice_id={{$orderInfo['invoice_id']}}&currpage={{$currpage}}&id={{$orderInfo['id']}}"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="section">
                                <dl>
                                    <dt>发票抬头:</dt>
                                    <dd>@if(!empty($user_invoices['company_name'])) {{$user_invoices['company_name']}} @else 无 @endif</dd>
                                    <dt>税号:：</dt>
                                    <dd>@if(!empty($user_invoices['tax_id'])) {{$user_invoices['tax_id']}} @else 无 @endif</dd>
                                </dl>

                                <dl>
                                    <dt>开票地址:</dt>
                                    <dd>{{$user_invoices['company_address']}}</dd>
                                    <dt>开票电话：</dt>
                                    <dd>{{$user_invoices['company_telephone']}}</dd>
                                </dl>

                                <dl>
                                    <dt>收票地址:</dt>
                                    <dd>{{$user_invoices['consignee_address']}}</dd>
                                    <dt>收票电话：</dt>
                                    <dd>{{$user_invoices['consignee_mobile_phone']}}</dd>
                                </dl>

                                <dl>
                                    <dt>收票人:</dt>
                                    <dd>{{$user_invoices['consignee_name']}}</dd>
                                    <dt></dt>
                                    <dd></dd>
                                </dl>

                                <dl style="width:30.6%">
                                    <dt>卖家留言：</dt>
                                    <dd>@if(empty($orderInfo['to_buyer'])) 无 @else {{$orderInfo['to_buyer']}} @endif</dd>
                                    <dt>买家留言：</dt>
                                    <dd>@if(empty($orderInfo['postscript'])) 无 @else {{$orderInfo['postscript']}} @endif</dd>
                                </dl>
                            </div>
                        </div>

                        <!--商品信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>商品信息<a href="/admin/orderinfo/modifyOrderGoods?id={{$orderInfo['id']}}&currpage={{$currpage}}"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="step_info">
                                <div class="order_goods_fr">
                                    <table class="table" border="0" cellpadding="0" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th width="15%" class="first">商品名称 [ 品牌 ]</th>
                                            <th width="10%">所属店铺</th>
                                            <th width="15%">产品编码</th>
                                            <th width="10%">价格</th>
                                            <th width="10%">购买数量</th>
                                            <th width="10%">已发货数量</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order_goods as $vo)
                                        <tr>
                                            <td>{{$vo['goods_name']}}[{{$vo['brand_name']}}]</td>
                                            <td>{{$vo['shop_name']}}</td>
                                            <td>{{$vo['goods_sn']}}</td>
                                            <td>{{$vo['goods_price']}}</td>
                                            <td>{{$vo['goods_number']}}</td>
                                            <td>{{$vo['send_number']}}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="12">
                                                <div class="order_total_fr">
                                                    <strong>合计：</strong>
                                                    <span class="red"><em>¥</em>{{$orderInfo['goods_amount']}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!--费用信息-->
                        <div class="step order_total">
                            <div class="step_title"><i class="ui-step"></i><h3>费用信息<a href="/admin/orderinfo/modifyFee?id={{$orderInfo['id']}}&currpage={{$currpage}}"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="section">
                                <dl>
                                    <dt>商品总金额：</dt>
                                    <dd><em>¥</em>{{$orderInfo['goods_amount']}}</dd>
                                </dl>

                                <dl>
                                    <dt>配送费用：</dt>
                                    <dd>+ <em>¥</em>{{$orderInfo['shipping_fee']}}</dd>
                                </dl>

                                <dl>
                                    <dt>折扣：</dt>
                                    <dd>- <em>¥</em>{{$orderInfo['discount']}}</dd>
                                    <dt></dt>
                                    <dd></dd>
                                </dl>
                                <dl>
                                    <dt>已付款金额：</dt>
                                    <dd>- <em>¥</em>{{$orderInfo['money_paid']}}</dd>
                                    <dt></dt>
                                    <dd></dd>
                                </dl>
                                <dl>
                                    <dt>订单总金额：</dt>
                                    <dd class="red"><em>¥</em>{{$orderInfo['order_amount']}}</dd>
                                    <dt>应付款金额：</dt>
                                    <dd class="red"><em>¥</em>{{$orderInfo['order_amount']-$orderInfo['money_paid']}}</dd>
                                </dl>
                            </div>
                        </div>

                        <!--操作信息-->
                        <div class="step order_total">
                            <div class="step_title"><i class="ui-step"></i><h3>操作信息</h3></div>
                            <div class="step_info">
                                <div class="order_operation order_operation100">
                                    <div class="item">
                                        <div class="label">操作备注：</div>
                                        <div class="value">
                                            <div class="bf100 fl"><textarea placeholder="请详细填写操作日志" name="action_note" class="textarea action_note"></textarea></div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="label">订单状态：</div>
                                        <div class="value">
                                            <input @if($orderInfo['order_status']==0) class="btn btn25 blue_btn order_status" @else class="btn btn25 red_btn order_status" @endif  type="button" data-id="0" value="已作废" >
                                            <input @if($orderInfo['order_status']==1) class="btn btn25 blue_btn order_status" @else class="btn btn25 red_btn order_status" @endif   type="button" data-id="1" value="待企业审核" >
                                            <input @if($orderInfo['order_status']==2) class="btn btn25 blue_btn order_status" @else class="btn btn25 red_btn order_status" @endif   type="button" data-id="2" value="待商家确认" >
                                            <input @if($orderInfo['order_status']==3) class="btn btn25 blue_btn order_status" @else class="btn btn25 red_btn order_status" @endif   type="button" data-id="3" value="已确认" >
                                            <span style="color: #00bbc8; margin-left: 20px;">点击按钮直接修改状态</span>
                                        </div>

                                    </div>

                                    <div class="item">
                                        <div class="label">支付状态：</div>
                                        <div class="value">
                                              <input @if($orderInfo['pay_status']==0) class="btn btn25 blue_btn pay_status" @else class="btn btn25 red_btn pay_status" @endif  type="button" data-id="0" value="待付款" >
                                              <input @if($orderInfo['pay_status']==1) class="btn btn25 blue_btn pay_status" @else class="btn btn25 red_btn pay_status" @endif  type="button" data-id="1" value="已付款" >
                                              <input @if($orderInfo['pay_status']==2) class="btn btn25 blue_btn pay_status" @else class="btn btn25 red_btn pay_status" @endif  type="button" data-id="2" value="部分付款" >
                                             <span style="color: #00bbc8; margin-left: 20px;">点击按钮直接修改状态</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="operation_record">
                                    <table cellpadding="0" cellspacing="0">
                                        <thead>
                                        <tr><th width="5%">&nbsp;</th>
                                            <th width="15%">操作者</th>
                                            <th width="15%">操作时间</th>
                                            <th width="15%">订单状态</th>
                                            <th width="15%">付款状态</th>
                                            <th width="15%">发货状态</th>
                                            <th width="20%">备注</th>
                                        </tr></thead>
                                        <tbody>
                                        @foreach($orderLogs as $vo)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{$vo['action_user']}}</td>
                                            <td>{{$vo['log_time']}}</td>
                                            <td>
                                                @if($vo['order_status']==0)已作废
                                                @elseif($vo['order_status']==1)待企业审核
                                                @elseif($vo['order_status']==2)待商家确认
                                                @else已确认
                                                @endif
                                            </td>
                                            <td>
                                                @if($vo['pay_status']==0)待付款
                                                @elseif($vo['pay_status']==1)已付款
                                                @else部分付款
                                                @endif
                                            </td>
                                            <td>
                                                @if($orderInfo['shipping_status']==0)待发货
                                                @elseif($orderInfo['shipping_status']==1)已发货
                                                @elseif($orderInfo['shipping_status']==2)部分发货
                                                @endif
                                            </td>
                                            <td>{{$vo['action_note']}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>

        layui.use(['layer'], function() {
            var layer = layui.layer;
            var index = 0;

            $(".viewMessage").click(function(){
                index = layer.open({
                    type: 1,
                    title: '卖家留言',
                    area: ['350px', '220px'],
                    content: '<div class="label_value">' +
                    '<textarea style="margin: 10px;" name="postscript" cols="50" rows="4"  class="textarea to_buyer">'+"{{$orderInfo['to_buyer']}}"+'</textarea>' +
                    '<button style="margin-left:150px;" class="button messageButton">确定</button></div>'
                });
            });

            $(document).delegate(".messageButton","click",function(){
                var id = "{{$orderInfo['id']}}";
                var to_buyer = $(".to_buyer").val();
                $.post('/admin/orderinfo/modify',{'id':id,'to_buyer':to_buyer},function(res){
                    if(res.code==1){
                        console.log(res.msg);
                        window.location.reload();
                    }else{
                        alert(res.msg);
                    }
                },"json");
                layer.close(index);
            });
            //修改订单状态
            $(".order_status").click(function(){
                var order_status = $(this).attr("data-id");
                var action_note = $(".action_note").val();
                $.post('/admin/orderinfo/modifyStatus',{'id':"{{$orderInfo['id']}}",'action_note':action_note,'order_status':order_status},function(res){
                    if(res.code==200){
                        layer.msg(res.msg, {
                            icon: 6,
                            time: 1000 //2秒关闭（如果不配置，默认是3秒）
                        }, function(){
                            window.location.reload();
                        });

                    }else{
                        alert(res.msg);
                    }
                },"json");
            });


            //修改支付状态
            $(".pay_status").click(function(){
                var pay_status = $(this).attr("data-id");
                var action_note = $(".action_note").val();
                $.post('/admin/orderinfo/modifyStatus',{'id':"{{$orderInfo['id']}}",'action_note':action_note,'pay_status':pay_status},function(res){
                    if(res.code==200){
                        layer.msg(res.msg, {
                            icon: 6,
                            time: 1000 //2秒关闭（如果不配置，默认是3秒）
                        }, function(){
                            window.location.reload();
                        });

                    }else{
                        alert(res.msg);
                    }
                },"json");
            });
        });
    </script>
@stop
