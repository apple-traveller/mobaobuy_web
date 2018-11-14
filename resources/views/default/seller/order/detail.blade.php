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

                    <dl @if($orderInfo['order_status']==5 ||$orderInfo['order_status']==3 || $orderInfo['order_status'] == 2 || $orderInfo['order_status'] == 0) class="cur" @endif>
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
                        <div class="step" style="background: #fff;padding: 10px 20px;">
                            <div class="step_title"><i class="ui-step"></i><h3>基本信息</h3></div>
                            <div class="section">
                                <dl>
                                    <dt>订单号：{{$orderInfo['order_sn']}}</dt>

                                    <dt>订单来源：{{$orderInfo['froms']}}</dt>

                                </dl>

                                <dl>
                                    <dt>购货人：@if(isset($user['nick_name'])) {{ $user['nick_name'] }} @elseif(isset($user['real_name'])) {{ $user['real_name'] }} @endif</dt>

                                    <dt>订单状态： <!--审核状态-->
                                        @if($orderInfo['order_status']==0)已作废
                                        @elseif($orderInfo['order_status']==1)待企业审核
                                        @elseif($orderInfo['order_status']==2)待商家确认
                                        @else已确认
                                        @endif</dt>

                                </dl>

                                <dl>
                                    <dt>下单时间：{{$orderInfo['add_time']}}</dt>

                                    <dt>付款时间：@if(empty($orderInfo['pay_time']))未付款@else {{$orderInfo['pay_time']}} @endif</dt>

                                </dl>
                                <dl>
                                    <dt>发货时间：@if(empty($orderInfo['shipping_time']))未发货@else {{$orderInfo['shipping_time']}} @endif</dt>

                                    {{--<dt>付款方式：@if($orderInfo['pay_type']==1) 先款后货 @elseif($orderInfo['pay_type']==2) 货到付款 @endif</dt>--}}
                                    <dt>付款方式：
                                                <select name="modules" lay-verify="required" style="width: 200px;padding: 2px 0" @if($orderInfo['order_status']>=3) disabled @endif>
                                                    <option value="1" @if($orderInfo['pay_type']==1) selected @endif>先款后货</option>
                                                    <option value="2" @if($orderInfo['pay_type']==2) selected @endif>货到付款</option>
                                                </select>

                                        </dt>

                                </dl>
                                <dl>
                                    <dt>交货时间：{{ $orderInfo['delivery_period'] }}</dt>

                                    <dt>自动确认收货时间：
                                        <div class="" ectype="editSpanInput" style="float: right;margin-right: 95px">
                                            <span id="receive_num">{{$orderInfo['auto_delivery_time']}}</span>
                                            <span>天</span>
                                            <i class="icon icon-edit" onclick="listTable.edit($('#receive_num')[0],'{{url('/seller/order/modifyReceiveDate')}}','{{$orderInfo['id']}}')"></i>
                                        </div>
                                    </dt>
                                </dl>
                            </div>
                        </div>

                        <!--收货人信息-->
                        <div class="step" style="background: #fff;padding: 10px 20px;">
                            <div class="step_title"><h3>收货人信息</h3></div>
                            <div class="section">
                                <dl>
                                    <dt>收货人：{{$orderInfo['consignee']}}</dt>

                                    <dt>手机号码：{{$orderInfo['mobile_phone']}}</dt>

                                </dl>
                                <dl style="width:50%">
                                    <dt>收货地址：[{{$region}}] 详细地址：{{$orderInfo['address']}}</dt>

                                    <dt>邮政编码：{{$orderInfo['zipcode']}}</dt>

                                </dl>
                            </div>
                        </div>
                        <!-- 门店信息 -->
                        <!--订单其他信息-->
                        <div class="step" style="background: #fff;padding: 10px 20px;">
                            <div class="step_title"><i class="ui-step"></i><h3>其他信息<a href="/seller/order/modifyInvoice?invoice_id={{$orderInfo['invoice_id']}}&currentPage={{$currentPage}}&id={{$orderInfo['id']}}"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="section">
                                <dl>
                                    <dt>发票抬头：{{--@if(!empty($user_invoices)) {{ $user_invoices['shop_name'] }}@else 无 @endif--}}</dt>
                                    <dt>税号：@if(!empty($user_invoices)) {{$user_invoices['tax_id']}} @else 无 @endif</dt>
                                </dl>

                                <dl>
                                    <dt>开票地址：@if(!empty($user_invoices)) {{$user_invoices['company_address']}} @else 无 @endif</dt>

                                    <dt>开票电话：@if(!empty($user_invoices)) {{$user_invoices['company_telephone']}} @else 无 @endif</dt>

                                </dl>

                                <dl>
                                    <dt>收票地址：@if(!empty($user_invoices)) {{$user_invoices['consignee_address']}} @else 无 @endif</dt>

                                    <dt>收票电话：@if(!empty($user_invoices)){{$user_invoices['consignee_mobile_phone']}} @else 无 @endif</dt>

                                </dl>

                                <dl>
                                    <dt>收票人：@if(!empty($user_invoices)) {{$user_invoices['consignee_name']}} @else 无 @endif</dt>
                                    <dt></dt>
                                </dl>

                                <dl style="width:30.6%">
                                    <dt style="width: 252%">卖家留言：@if(empty($orderInfo)) 无 @else {{$orderInfo['to_buyer']}} @endif<div class="div_a"><span class="viewMessage" style="color:blue;cursor:pointer;">留言</span></div></dt>
                                    <dt style="width: 252%">买家留言：@if(empty($orderInfo)) 无 @else {{$orderInfo['postscript']}} @endif</dt>
                                </dl>
                            </div>
                        </div>

                        <!--商品信息-->
                        <div class="step" style="background: #fff;padding: 10px 20px;">
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
                                            <tr style="height: 45px">
                                                <td style="padding-left: 9px;height: 45px">{{$vo['goods_name']}}[{{$vo['brand_name']}}]</td>
                                                <td style="padding-left: 9px;height: 45px">{{$vo['goods_sn']}}</td>
                                                <td style="padding-left: 9px;height: 45px">{{$vo['goods_price']}}</td>
                                                <td style="padding-left: 9px;height: 45px">{{$vo['goods_number']}}</td>
                                                <td style="padding-left: 9px;height: 45px">{{$vo['send_number']}}</td>
                                            </tr>
                                        @endforeach
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
                                    <dt>商品总金额：<em>¥</em>{{$orderInfo['goods_amount']}}</dt>
                                    <dt>使用余额：- <em>¥</em>0.00</dt>

                                </dl>

                                <dl>
                                    <dt>配送费用：+ <em>¥</em>{{$orderInfo['shipping_fee']}}</dt>
                                    <dt>使用红包：- <em>¥</em>0.00</dt>

                                </dl>

                                <dl>
                                    <dt>折扣：- <em>¥</em>{{$orderInfo['discount']}}</dt>

                                    <dt>使用储值卡：- <em>¥</em>0.00</dt>

                                </dl>
                                <dl>
                                    <dt></dt>


                                    <dt>已付款金额：- <em>¥</em>{{$orderInfo['money_paid']}}</dt>
                                </dl>
                                <dl>
                                    <dt class="red">订单总金额: {{number_format($orderInfo['goods_amount']+$orderInfo['shipping_fee']-$orderInfo['discount'],2)}}</dt>
                                    <dt class="red">应付款金额: <em>¥</em>{{number_format($orderInfo['goods_amount']+$orderInfo['shipping_fee']-$orderInfo['discount']-$orderInfo['money_paid'],2)}}</dt>
                                </dl>
                            </div>
                        </div>
                        <div style="margin-left: 40px">
                            付款凭证:
                            @if(!empty($oorderInfo['pay_voucher']))
                                <button type="button" onclick="payImg()" class="layui-btn mt3">查看</button>
                            @else
                                <div><p style="line-height: 38px">暂无</p></div>
                            @endif
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
                                                    @if($orderInfo['order_status']>=3)
                                                    <a href="/seller/order/delivery?order_id={{$orderInfo['id']}}&currentPage={{$currentPage}}"> <input type="button" value="生成发货单" class="btn btn25 red_btn"></a>

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
        function payImg() {
            //示范一个公告层
           layer.open({
                type: 1
                ,
                title: false //不显示标题栏
                ,
                closeBtn: false
                ,
                area: '300px;'
                ,
                shade: 0.8
                ,
                id: 'PayImg' //设定一个id，防止重复弹出
                ,
                btn: ['关闭']
                ,
                btnAlign: 'c'
                ,
                moveType: 1 //拖拽模式，0或者1
                ,
                content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;"><img src="{{ getFileUrl($orderInfo['pay_voucher']) }}" alt=""> </div>'
                ,
                yes: function (layero) {
                    layer.closeAll();
                }
            });
        }
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
                layer.confirm('是否取消订单?', {icon: 3, title:'提示'}, function(index){
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

        //修改支付方式
        $("select[name='modules']").change(function () {
            let order_id = "{{ $orderInfo['id'] }}";
            let type = this.value;
            $.ajax({
                url:'/seller/order/updatePayType',
                data:{
                    'order_id':order_id,
                    'type':type
                },
                type:'POST',
                success:function (res) {
                    if (res.code==1){
                        layer.msg(res.msg);
                    } else {
                        layer.msg(res.msg);
                    }
                }
            })
        });
    </script>
@stop
