@extends(themePath('.')."seller.include.layouts.master")
@section('body')
    <div class="warpper">
        <div class="title"><a href="/seller/delivery/list?currentPage={{$currentPage}}" class="s-back">返回</a>订单 - 发货单详情</div>
        <div class="content">
            <div class="flexilist order_info">
                <form name="listForm" onsubmit="return check()">
                    <div class="common-content">
                        <!--订单基本信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>基本信息</h3></div>
                            <div class="section">
                                <dl>
                                    <dt>发货单号：</dt>
                                    <dd>{{$delivery['delivery_sn']}}</dd>
                                    <dt>订单号：</dt>
                                    <dd>{{$delivery['order_sn']}}</dd>
                                </dl>
                                <dl>
                                    <dt>下单时间：</dt>
                                    <dd>{{$delivery['order_add_time']}}</dd>
                                    <dt>购货人：</dt>
                                    <dd>{{$delivery['user_name']}}</dd>
                                </dl>
                                <dl>
                                    <dt>发货时间：</dt>
                                    <dd>
                                        @if($delivery['status']==0)未发货
                                        @else {{$delivery['update_time']}}
                                        @endif
                                    </dd>
                                    <dt>配送方式：</dt>
                                    <dd>{{$delivery['shipping_name']}} </dd>
                                </dl>
                                <dl>
                                    <dt>配送费用：</dt>
                                    <dd>
                                        {{$delivery['shipping_fee']}}
                                    </dd>
                                    <dt>快递单号：</dt>
                                    <dd>
                                        <div class="editSpanInput" ectype="editSpanInput">
                                            <span onclick="listTable.edit(this,'{{url('/seller/delivery/modifyShippingBillno')}}','{{$delivery['id']}}')">{{$delivery['shipping_billno']}}</span>
                                            <i class="icon icon-edit"></i>
                                        </div>

                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <!--收货人信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>收货人信息</h3></div>
                            <div class="section">
                                <dl>
                                    <dt>收货人：</dt>
                                    <dd>{{$delivery['consignee']}}</dd>
                                    <dt>手机号码：</dt>
                                    <dd>{{$delivery['mobile_phone']}}</dd>
                                </dl>

                                <dl style="width:25%">
                                    <dt>收货地址：</dt>
                                    <dd>[{{$region}}] 街道：{{$delivery['street']}};地址：{{$delivery['address']}}</dd>
                                    <dt>邮政编码：</dt>
                                    <dd>{{$delivery['zipcode']}}</dd>
                                </dl>
                                <dl style="width:25%">
                                    <dt>买家留言：</dt>
                                    <dd>{{$delivery['postscript']}}</dd>
                                    <dt>&nbsp;</dt>
                                    <dd>&nbsp;</dd>
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
                                            <th width="30%" class="first ml-20">商品名称</th>
                                            <th width="15%">商品编码</th>
                                            <th width="20%">价格</th>
                                            <th width="10%">发货数量</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($delivery_goods))
                                        @foreach($delivery_goods as $vo)
                                        <tr>
                                            <td class="first ml-20">{{$vo['goods_name']}}</td>
                                            <td>{{$vo['goods_sn']}}</td>
                                            <td>{{$vo['goods_price']}}</td>
                                            <td>{{$vo['send_number']}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <!--操作信息-->
                        <div class="step order_total">
                            <div class="step_title"><i class="ui-step"></i><h3>发货操作信息</h3></div>
                            <div class="step_info">
                                <div class="order_operation order_operation100">
                                    <div class="item">
                                        <div class="label">当前可执行操作：</div>
                                        <div class="value">
                                            <input  data-content="1" type="button" value="发货" class="btn btn25 red_btn delivery_status">
                                        </div>
                                    </div>
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
                $.post('/seller/delivery/updateStatus', {
                    'id': "{{$delivery['id']}}",
                    'status': status,
                }, function (res) {
                    if (res.code == 200) {
                        layer.msg(res.msg, {
                            icon: 6,
                            time: 1000 //2秒关闭（如果不配置，默认是3秒）
                        }, function () {
                            window.location.href="/seller/delivery/list";
                        });

                    } else {
                        alert(res.msg);
                    }
                }, "json");
            });
        });
    </script>
@stop
