@extends(themePath('.')."seller.include.layouts.master")
@section('body')
    <div class="warpper">
        <div class="title"><a href="/seller/order/list?currentPage={{$currentPage}}" class="s-back">返回</a>订单 - 订单信息</div>
        <div class="content">
            <div class="flexilist order_info">
                <div class="stepflex">
                    <dl class="first cur">
                        <dt></dt>
                        <dd class="s-text">提交订单<br><em class="ftx-03">{{$orderInfo['add_time']}}</em></dd>
                    </dl>

                    <dl @if($orderInfo['order_status']==3 || $orderInfo['order_status'] == 2 || $orderInfo['order_status'] == 0) class="cur" @endif>
                        <dt></dt>
                        <dd class="s-text">审核订单<br>
                            <em class="ftx-03">
                                @if($orderInfo['order_status']==0)已作废
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
                                    <dt>购货人： </dt>
                                    <dd>@if(isset($user['nick_name'])) {{ $user['nick_name'] }} @elseif(isset($user['real_name'])) {{ $user['real_name'] }} @endif</dd>
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
                                    <dt>付款方式</dt>
                                    <dd>@if($orderInfo['pay_type']==1) 先款后货 @elseif($orderInfo['pay_type']==2) 先货后款 @endif</dd>
                                </dl>
                                <dl>
                                    <dt>交货时间</dt>
                                    <dd>{{ $orderInfo['delivery_period'] }}</dd>
                                    <dt>自动确认收货时间：</dt>
                                    <dd>
                                        <div class="editSpanInput" ectype="editSpanInput">
                                            <span onclick="listTable.edit(this,'{{url('/seller/order/modifyReceiveDate')}}','{{$orderInfo['id']}}')">{{$orderInfo['auto_delivery_time']}}</span>
                                            <span>天</span>
                                            <i class="icon icon-edit"></i>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <!--收货人信息-->
                        <div class="step">
                            <div class="step_title"><h3>收货人信息</h3></div>
                            <div class="section">
                                <dl>
                                    <dt>收货人：</dt>
                                    <dd>{{$orderInfo['consignee']}}</dd>
                                    <dt>手机号码：</dt>
                                    <dd>{{$orderInfo['mobile_phone']}}</dd>
                                </dl>
                                <dl style="width:50%">
                                    <dt>收货地址：</dt>
                                    <dd>[{{$region}}] 详细地址：{{$orderInfo['address']}}</dd>
                                    <dt>邮政编码：</dt>
                                    <dd>{{$orderInfo['zipcode']}}</dd>
                                </dl>
                            </div>
                        </div>
                        <!-- 门店信息 -->
                        <!--订单其他信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>其他信息<a href="/seller/order/modifyInvoice?invoice_id={{$orderInfo['invoice_id']}}&currentPage={{$currentPage}}&id={{$orderInfo['id']}}"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="section">
                                <dl>
                                    <dt>发票抬头:</dt>
                                    <dd>
                                        {{--@if(!empty($user_invoices)) {{ $user_invoices['shop_name'] }}@else 无 @endif--}}
                                    </dd>
                                    <dt>税号:：</dt>
                                    <dd>@if(!empty($user_invoices)) {{$user_invoices['tax_id']}} @else 无 @endif</dd>
                                </dl>

                                <dl>
                                    <dt>开票地址:</dt>
                                    <dd>@if(!empty($user_invoices)) {{$user_invoices['company_address']}} @else 无 @endif</dd>
                                    <dt>开票电话：</dt>
                                    <dd>@if(!empty($user_invoices)) {{$user_invoices['company_telephone']}} @else 无 @endif</dd>
                                </dl>

                                <dl>
                                    <dt>收票地址:</dt>
                                    <dd>@if(!empty($user_invoices)) {{$user_invoices['consignee_address']}} @else 无 @endif</dd>
                                    <dt>收票电话：</dt>
                                    <dd>@if(!empty($user_invoices)){{$user_invoices['consignee_mobile_phone']}} @else 无 @endif</dd>
                                </dl>

                                <dl>
                                    <dt>收票人:</dt>
                                    <dd>@if(!empty($user_invoices)) {{$user_invoices['consignee_name']}} @else 无 @endif</dd>
                                    <dt></dt>
                                    <dd></dd>
                                </dl>

                                <dl style="width:30.6%">
                                    <dt style="width: 240%">卖家留言：<div class="div_a"><span class="viewMessage" style="color:blue;cursor:pointer;">留言</span></div></dt>
                                    <dd style="width: 240%">@if(empty($orderInfo)) 无 @else {{$orderInfo['to_buyer']}} @endif</dd>
                                    <dt style="width: 240%">买家留言：</dt>
                                    <dd style="width: 240%">@if(empty($orderInfo)) 无 @else {{$orderInfo['postscript']}} @endif</dd>
                                </dl>
                            </div>
                        </div>

                        <!--商品信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>商品信息<a href="/seller/order/modifyGoodsInfo?id={{$orderInfo['id']}}&currentPage={{$currentPage}}"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="step_info">
                                <div class="order_goods_fr">
                                    <table class="table" border="0" cellpadding="0" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th width="15%" class="first" style="padding-left: 9px">商品名称 [ 品牌 ]</th>
                                            <th width="15%">商品编码</th>
                                            <th width="10%">价格</th>
                                            <th width="10%">购买数量</th>
                                            <th width="10%">已发货数量</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order_goods as $vo)
                                            <tr>
                                                <td style="padding-left: 9px">{{$vo['goods_name']}}[{{$vo['brand_name']}}]</td>
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
                                        <tr>
                                            <td colspan="6">
                                                <div class="order_total_fr">
                                                    <div class="layui-btn layui-btn-sm order_delivery" data-status="{{$orderInfo['shipping_status']}}" style="margin-right: 30px;"><a href="/seller/order/delivery?order_id={{$orderInfo['id']}}&currentPage={{$currentPage}}">生成发货单</a></div>
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
                            <div class="step_title"><i class="ui-step"></i><h3>费用信息<a href="/seller/order/modifyFree?id={{$orderInfo['id']}}&currentPage={{$currentPage}}"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="section">
                                <dl>
                                    <dt>商品总金额：</dt>
                                    <dd><em>¥</em>{{$orderInfo['goods_amount']}}</dd>
                                    <dt>使用余额：</dt>
                                    <dd>- <em>¥</em>0.00</dd>
                                </dl>

                                <dl>
                                    <dt>配送费用：</dt>
                                    <dd>+ <em>¥</em>{{$orderInfo['shipping_fee']}}</dd>
                                    <dt>使用红包：</dt>
                                    <dd>- <em>¥</em>0.00</dd>
                                </dl>

                                <dl>
                                    <dt>折扣：</dt>
                                    <dd>- <em>¥</em>{{$orderInfo['discount']}}</dd>
                                    <dt>使用储值卡：</dt>
                                    <dd>- <em>¥</em>0.00</dd>
                                </dl>
                                <dl>
                                    <dt></dt>
                                    <dd></dd>

                                    <dt>已付款金额：</dt>
                                    <dd>- <em>¥</em>{{$orderInfo['money_paid']}}</dd>
                                </dl>
                                <dl>
                                    <dt>订单总金额：</dt>
                                    <dd class="red"><em>¥</em>{{number_format($orderInfo['goods_amount']+$orderInfo['shipping_fee']-$orderInfo['discount'],2)}}</dd>
                                    <dt>应付款金额：</dt>
                                    <dd class="red"><em>¥</em>{{number_format($orderInfo['goods_amount']+$orderInfo['shipping_fee']-$orderInfo['discount']-$orderInfo['money_paid'],2)}}</dd>
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
                                            <div class="bf100 fl"><textarea name="action_note" class="textarea" id="action_note"></textarea></div>
                                            <div class="order_operation_btn">
                                                @if($orderInfo['order_status'] == 2)
                                                <input name="pay" type="button" value="确定" class="btn btn25 red_btn" onclick="conf({{ $orderInfo['id'] }})">
                                                <input name="cancel" type="button" value="作废" class="btn btn25 red_btn" onclick="cancelOne( {{ $orderInfo['id'] }})">
                                                @elseif($orderInfo['order_status'] == 1)
                                                    <input type="button" value="待买家审核" class="btn btn25 red_btn">
                                                @else

                                                <input name="order_id" type="hidden" value="4">
                                                @if($orderInfo['pay_status'] == 0 || $orderInfo['pay_status'] == 2) <input type="button" value="确认收款" class="btn btn25 blue_btn" onclick="receiveM({{ $orderInfo['id'] }})"> @else <input type="button" value="已收款" class="btn btn25 gray_btn"> @endif
                                                @endif
                                            </div>
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
                    '<textarea style="margin: 10px;" name="postscript" cols="50" rows="4"  class="textarea to_buyer">'+'{{ $orderInfo['to_buyer'] }}'+'</textarea>' +
                    '<button style="margin-left:150px;" class="button messageButton">确定</button></div>'
                });
            });

            $(document).delegate(".messageButton","click",function(){
                var id = "{{$orderInfo['id']}}";
                var to_buyer = $(".to_buyer").val();
                $.post('/seller/order/toBuyerModify',{'id':id,'to_buyer':to_buyer},function(res){
                    if(res.code==1){
                        console.log(res.msg);
                        window.location.reload();
                    }else{
                        alert(res.msg);
                    }
                },"json");
                layer.close(index);
            });
        });
        // 确认订单
        function conf(id)
        {
            layui.use('layer', function(){
                let layer = layui.layer;
                layer.confirm('是否确认订单?', {icon: 3, title:'提示'}, function(index){
                    let action_note = $("#action_note").val();
                    $.ajax({
                        url:'/seller/order/updateOrderStatus',
                        data: {
                            'id':id,
                            'action_note':action_note,
                            'order_status': 3
                        },
                        type: 'post',
                        success: function (res) {
                            if (res.code == 1){
                                layer.msg(res.msg, {icon: 1,time:2000});
                            } else {
                                layer.msg(res.msg, {icon: 5,time:2000});
                            }
                            setTimeout( window.location.href="/seller/order/list?id="+id,3000)
                        }
                    });

                    layer.close(index);
                });
            });
        }

        //作废订单
        function cancelOne(id)
        {
            layui.use('layer', function(){
                let layer = layui.layer;
                layer.confirm('是否作废订单?', {icon: 3, title:'提示'}, function(index){
                    let to_buyer = $("input[ name='to_buyer' ]").val();
                    $.ajax({
                        url:'/seller/order/updateOrderStatus',
                        data: {
                            'id':66,
                            'to_buyer':to_buyer,
                            'order_status': 0
                        },
                        type: 'post',
                        success: function (res) {
                            if (res.code == 1){
                                layer.msg(res.msg, {icon: 1,time:600});
                                window.location.href="/seller/order/list?id="+id;
                            } else {
                                layer.msg(res.msg, {icon: 5,time:3000});
                                window.location.href="/seller/order/list?id="+id;
                            }
                        }
                    });

                });
            });
        }
        function receiveM(id) {
            layui.use('layer', function(){
                let layer = layui.layer;
                layer.confirm('确认收到付款?', {icon: 3, title:'提示'}, function(index){
                    let action_note = $("#action_note").val();
                    $.ajax({
                        url:'/seller/order/updateOrderStatus',
                        data: {
                            'id':id,
                            'action_note':action_note,
                            'pay_status': 1
                        },
                        type: 'post',
                        success: function (res) {
                            if (res.code == 1){
                                layer.msg(res.msg, {icon: 1,time:600});
                            } else {
                                layer.msg(res.msg, {icon: 5,time:2000});
                            }
                        }
                    });
                    layer.close(index);
                });
            });
        }
    </script>
@stop
