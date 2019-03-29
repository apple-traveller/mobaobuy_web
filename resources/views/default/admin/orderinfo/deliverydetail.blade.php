@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/orderinfo/delivery/list?currpage={{$currpage}}" class="s-back">返回</a>订单 - 发货单详情</div>
        <div class="content">
            <div class="flexilist order_info">
                <form method="post" action="order.php?act=operate" name="listForm" onsubmit="return check()">
                    <div class="common-content">
                        <!--订单基本信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>基本信息</h3></div>
                            <div class="section">
                                <dl>
                                    <dt>发货单号:<span style="color:#62b3ff">{{$delivery['delivery_sn']}}</span></dt>
                                    <dt>订单号:<span style="color:#62b3ff">{{$delivery['order_sn']}}</span></dt>
                                </dl>
                                <dl>
                                    <dt>下单时间:<span style="color:#62b3ff">{{$delivery['order_add_time']}}</span></dt>
                                    <dt>购货人:<span style="color:#62b3ff">{{$delivery['user_name']}}</span></dt>
                                </dl>
                                <dl>
                                    <dt>发货时间:购货人:<span style="color:#62b3ff">
                                        @if($delivery['status']==0)未发货
                                        @else {{$delivery['update_time']}}
                                            @endif</span>
                                    </dt>

                                    <dt>配送方式:购货人:<span style="color:#62b3ff">
                                            {{$delivery['shipping_name']}}</span>
                                    </dt>
                                </dl>
                                <dl >
                                    <dt>配送费用:<span style="color:#62b3ff">￥{{$delivery['shipping_fee']}}</span></dt>
                                    <dt style="width:300px;"><span style="float:left;">快递单号:</span>
                                        <div style="color:#62b3ff" class="editSpanInput" ectype="editSpanInput">
                                            <span  onclick="listTable.edit(this,'{{url('/admin/orderinfo/delivery/modifyShippingBillno')}}','{{$delivery['id']}}')">{{$delivery['shipping_billno']}}</span>
                                            <i class="icon icon-edit"></i>
                                        </div>
                                    </dt>
                                </dl>
                            </div>
                        </div>

                        <!--收货人信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>收货人信息</h3></div>
                            <div class="section">
                                <dl>
                                    <dt>收货人:<span style="color:#62b3ff">{{$delivery['consignee']}}</span></dt>
                                    <dt>手机号码:<span style="color:#62b3ff">{{$delivery['mobile_phone']}}</span></dt>
                                </dl>

                                <dl style="width:50%">
                                    <dt>收货地址:<span style="color:#62b3ff">{{$region}}街道：@if(empty($delivery['street']))空@else{{$delivery['street']}}@endif;详细地址：{{$delivery['address']}}</span></dt>
                                    <dt>邮政编码:<span style="color:#62b3ff">{{$delivery['zipcode']}}</span></dt>
                                </dl>
                                <dl style="width:25%">
                                    <dt>买家留言:<span style="color:#62b3ff">{{$delivery['postscript']}}</span></dt>
                                </dl>
                            </div>
                        </div>

                        <!--商品信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>商品信息</h3></div>

                            <div class="step_info">
                                <div class="order_goods_fr">
                                    <table class="table" border="0" cellpadding="0" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th width="30%" class="first">商品名称</th>
                                            <th width="15%">商品编码</th>
                                            <th width="15%">所属店铺</th>
                                            <th width="20%">价格</th>
                                            <th width="10%">发货数量</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($delivery_goods as $vo)
                                        <tr >
                                            <td style="color:#62b3ff">{{$vo['goods_name']}}</td>
                                            <td style="color:#62b3ff">{{$vo['goods_sn']}}</td>
                                            <td style="color:#62b3ff">{{$delivery['shop_name']}}</td>
                                            <td style="color:#62b3ff">￥{{$vo['goods_price']}}</td>
                                            <td style="color:#62b3ff">{{$vo['send_number']}}</td>
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

            $(".delivery_status").click(function () {
                var status = $(this).attr("data-content");
                $.post('/admin/orderinfo/delivery/modifyDeliveryStatus', {
                    'id': "{{$delivery['id']}}",
                    'status': status,
                }, function (res) {
                    if (res.code == 200) {
                        layer.msg(res.msg, {
                            icon: 6,
                            time: 1000 //2秒关闭（如果不配置，默认是3秒）
                        }, function () {
                            window.location.href="/admin/orderinfo/delivery/list?order_sn={{$delivery['order_sn']}}";
                        });

                    } else {
                        alert(res.msg);
                    }
                }, "json");
            });
        });
    </script>
@stop
