@extends(themePath('.')."seller.include.layouts.master")
@section('body')
<div class="warpper">
    <div class="title"><a href="/seller/invoice/list?currentPage={{$currentPage}}" class="s-back">返回</a>发票管理</div>
    <div class="content">
        <div class="flexilist order_info">
            <form method="post" action="order.php?act=operate" name="listForm" onsubmit="return check()">
                <div class="common-content">
                    <!--开票基本信息-->
                    <div class="step">
                        <div class="step_title"><i class="ui-step"></i><h3>基本信息</h3></div>
                        <div class="section">
                            <dl>
                                <dt>发票类型：
                                @if($invoiceInfo['invoice_type'] == 1)
                                    <dd>普票</dd>
                                @elseif($invoiceInfo['invoice_type'] == 2)
                                    <dd>专票</dd>
                                    @endif
                                    </dt>
                            </dl>
                            <dl>
                                <dt>公司抬头：{{$invoiceInfo['company_name']}}</dt>

                                <dt>税号：{{$invoiceInfo['tax_id']}}</dt>

                            </dl>
                            <dl>
                                <dt>开户银行：{{$invoiceInfo['bank_of_deposit']}}</dt>

                                <dt>银行账号：{{$invoiceInfo['bank_account']}}</dt>

                            </dl>
                            <dl>
                                <dt>开票地址：{{$invoiceInfo['company_address']}}</dt>

                                <dt>开票电话：{{$invoiceInfo['company_telephone']}}</dt>
                            </dl>
                            <dl>
                                <dt></dt>

                                <dt></dt>
                            </dl>
                        </div>
                    </div>

                    <!--收货人信息-->
                    <div class="step">
                        <div class="step_title"><i class="ui-step"></i><h3>收货人信息</h3></div>
                        <div class="section">
                            <dl>
                                <dt>收货人：{{$invoiceInfo['consignee']}}</dt>

                                <dt>手机号码：{{$invoiceInfo['mobile_phone']}}</dt>

                            </dl>

                            <dl>
                                <dt>收货地址：{{$invoiceInfo['address_str']}}</dt>

                                <dt>邮政编码：{{$invoiceInfo['zipcode']}}</dt>
                            </dl>
                            <dl>
                                <dt></dt>
                                <dt></dt>
                            </dl>
                            <dl>
                                <dt></dt>
                                <dt></dt>
                            </dl>
                            <dl>
                                <dt></dt>
                                <dt></dt>
                            </dl>
                        </div>
                    </div>
                    <div class="step" style="background: #fff;padding: 10px 20px;">
                        <div class="step_title"><h3>订单物流</h3></div>
                        <div class="section" style="height: 100px;">
                                <dl>
                                    <dt>物流公司：{{$invoiceInfo['shipping_name']}}</dt>

                                    <dt>物流单号：{{$invoiceInfo['shipping_billno']}}</dt>

                                </dl>

                                <dl>
                                    <dt></dt>
                                    <dt></dt>
                                </dl>
                                <dl>
                                    <dt></dt>
                                    <dt></dt>
                                </dl>
                                <dl>
                                    <dt></dt>
                                    <dt></dt>
                                </dl>
                                <dl>
                                    <dt></dt>
                                    <dt></dt>
                                </dl>

                        </div>

                    <!--商品信息-->
                    <div class="step">
                        <div class="step_title"><i class="ui-step"></i><h3>商品信息</h3></div>

                        <div class="step_info">
                            <div class="order_goods_fr">
                                <table class="table" border="0" cellpadding="0" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th class="first ml-20">订单流水号</th>
                                        <th>商品名称</th>
                                        <th>价格</th>
                                        <th>开票数量</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($orderInfo))
                                    @foreach($orderInfo as $v)
                                    <tr>
                                        <td class="first ml-20">{{$v['order_sn']}}</td>
                                        <td>{{$v['goods_name']}}</td>
                                        <td>{{$v['goods_price']}}</td>
                                        <td>{{$v['invoice_num']}}</td>
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
                                    <div class="order_operation_btn" style="margin-top: 0px">
                                        @if($invoiceInfo['status'] == 1)
                                            <input name="pay" type="button" value="审核并填写快递信息" class="btn btn25 red_btn" onclick="conf({{ $invoiceInfo['id'] }})">
                                            <input name="cancel" type="button" value="取消" class="btn btn25 red_btn" onclick="cancelOne( {{ $invoiceInfo['id'] }})">
                                        @elseif($invoiceInfo['status'] == 2)
                                            <input name="cancel" type="button" value="已开票，无法进行其他操作" class="btn btn25 red_btn">
                                        @elseif($invoiceInfo['status'] == 0)
                                            <input name="cancel" type="button" value="已取消，无法进行其他操作" class="btn btn25 red_btn">
                                        @endif
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
                'id': "{{$invoiceInfo['id']}}",
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
    function conf(id)
    {
        layui.use(['layer'], function(){
            let layer = layui.layer;
            let index =
                layer.open({
                    type: 2,
                    title: "审核",
                    id: "link",
                    shade: 0,
                    resize: false,
                    area: ['600px', '300px'],
                    maxmin: true,
                    content: '/seller/invoice/choseExpress?invoice_id='+id,
                    success: function(layero){
                        layer.setTop(layero); //重点2
                    },
                    end:function () {
                        window.location.reload();
                    }
                });
        });
    }
    //取消订单
    function cancelOne(id)
    {
        layui.use('layer', function(){
            let layer = layui.layer;
            layer.confirm('是否取消开票?', {icon: 3, title:'提示'}, function(index){
                $.ajax({
                    url:'/seller/invoice/cancelInvoice',
                    data: {
                        'invoice_id':id,
                    },
                    type: 'post',
                    success: function (res) {
                        if (res.code == 1) {
                            layer.msg(res.msg, {icon: 1,time:600});
                            window.location.reload();
                        } else {
                            layer.msg(res.msg, {icon: 5,time:3000});
                            window.location.reload();
                        }
                    }
                });

            });
        });
    }
</script>
@stop
