@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/invoice/list?currpage={{$currpage}}&status={{$status}}" class="s-back">返回</a>发票 - 发票详情详情</div>
        <div class="content">
            <div class="explanation" id="explanation">

                <div class="ex_tit">
                    <i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span>
                </div>

                <ul>
                    <li>该页面展示发票申请。</li>
                    <li>审核通过后填写快递信息邮寄给用户。</li>
                </ul>

            </div>
            <div class="flexilist order_info">
                <form method="post" action="order.php?act=operate" name="listForm" onsubmit="return check()">
                    <div class="common-content">
                        <!--开票基本信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>基本信息</h3></div>
                            <div class="section">

                                <dl>
                                    <dt>发票类型:<span style="color:#62b3ff">
                                        @if($invoiceInfo['is_firm'] == 0)
                                            个人
                                        @elseif($invoiceInfo['invoice_type'] == 1)
                                            普票
                                        @else
                                            专票
                                        @endif</span></dt>
                                </dl>

                                <dl>
                                    <dt style="width:300px;">公司抬头:<span style="color:#62b3ff">{{$invoiceInfo['company_name']}}</span></dt>
                                    <dt>税号:<span style="color:#62b3ff">{{$invoiceInfo['tax_id']}}</span></dt>
                                </dl>
                                <dl style="margin-left: 20px;">
                                    <dt>开户银行:<span style="color:#62b3ff">{{$invoiceInfo['bank_of_deposit']}}</span></dt>
                                    <dt>银行账号:<span style="color:#62b3ff">{{$invoiceInfo['bank_account']}}</span></dt>
                                </dl>
                                <dl>
                                    <dt>开票地址:<span style="color:#62b3ff">{{$invoiceInfo['company_address']}}</span></dt>
                                    <dt>开票电话:<span style="color:#62b3ff">{{$invoiceInfo['company_telephone']}}</span></dt>
                                </dl>
                            </div>
                        </div>

                        <!--收货人信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>收货人信息</h3></div>
                            <div class="section">
                                <dl>
                                    <dt>收货人:<span style="color:#62b3ff">{{$invoiceInfo['consignee']}}</span></dt>
                                    <dt>手机号码:<span style="color:#62b3ff">{{$invoiceInfo['mobile_phone']}}</span></dt>
                                </dl>

                                <dl style="width:40%">
                                    <dt>收货地址:<span style="color:#62b3ff">{{$invoiceInfo['address_str']}}详细地址：@if(empty($invoiceInfo['address'])) 无 @else {{$invoiceInfo['address']}} @endif</span></dt>
                                    <dt>邮政编码:<span style="color:#62b3ff">{{$invoiceInfo['zipcode']}}</span></dt>
                                </dl>
                            </div>
                        </div>

                        <!--商品信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>商品信息</h3></div>

                            <div class="step_info">
                                <div class="order_goods_fr">
                                    <table  class="table" border="0" cellpadding="0" cellspacing="0">
                                        <thead>
                                        <tr style="text-align: center;">
                                            <th>订单流水号</th>
                                            <th>商品名称</th>
                                            <th>价格</th>
                                            <th>开票数量</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($orderInfo))
                                            @foreach($orderInfo as $v)
                                                <tr>
                                                    <td><span style="color:#62b3ff">{{$v['order_sn']}}</span></td>
                                                    <td><span style="color:#62b3ff">{{$v['goods_name']}}</span></td>
                                                    <td><span style="color:#62b3ff">{{$v['goods_price']}}</span></td>
                                                    <td><span style="color:#62b3ff">{{$v['invoice_num']}}</span></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td style="margin-left: 20px;color:red;" colspan="4">无商品信息</td>
                                            </tr>
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
                                        <div class="label">选择快递公司：</div>
                                        <div class="label_value">
                                            <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;margin-right:10px;" name="shipping_id" id="shipping_id">
                                                <option value="">请选择快递公司</option>
                                                @foreach($shippings as $vo)
                                                    <option @if($vo['id']==$invoiceInfo['shipping_id']) selected @endif value="{{$vo['id']}}">{{$vo['shipping_name']}}</option>
                                                @endforeach
                                            </select>
                                            <input id="shipping_name" type="hidden" name="shipping_name" value="">
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="label">运单号：</div>
                                        <div class="label_value">
                                            <input style="width: 299px;" type="text" id="shipping_billno" name="shipping_billno" class="text" autocomplete="off" value="{{$invoiceInfo['shipping_billno']}}">
                                        </div>
                                    </div>

                                    <div class="item">
                                        <div class="label"><span class="require-field">*</span>&nbsp;审核状态：</div>
                                        <div class="label_value font14">
                                            <div data-status="0" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($invoiceInfo['status']==0) @else layui-btn-primary @endif '>已取消</div>
                                            <div data-status="1" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($invoiceInfo['status']==1) @else layui-btn-primary @endif '>待开票</div>
                                            <div data-status="2" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($invoiceInfo['status']==2) @else layui-btn-primary @endif '>开票</div>
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

            $(".review_status").click(function () {

                var shipping_id = $("#shipping_id").val();
                var shipping_name = $("#shipping_name").val();
                var shipping_billno = $("#shipping_billno").val();
                var status = $(this).attr("data-status");
                if(shipping_id=="" && status==2){
                    layer.msg("请选择快递公司",{icon: 1,time: 2000});
                    return ;
                }
                if(shipping_billno=="" && status==2){
                    layer.msg("运单号不能为空",{icon: 1,time: 2000});
                    return ;
                }
                var postData = {
                    "id": "{{$invoiceInfo['id']}}",
                    "shipping_id": shipping_id,
                    "shipping_name": shipping_name,
                    "shipping_billno": shipping_billno,
                    "status": status,
                };
                $.post('/admin/invoice/save', postData, function (res) {
                    if (res.code == 1){
                        layer.msg(res.msg,{
                            icon: 1,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        },function(){
                            window.location.href="/admin/invoice/detail?id={{$invoiceInfo['id']}}&currpage={{$currpage}}&status={{$status}}";
                        });
                    } else {
                        layer.msg(res.msg);
                    }
                }, "json");
            });



            $(document).ready(function(){
                var shipping_name = $("#shipping_id").find("option:selected").text();
                $("#shipping_name").val(shipping_name);
            });

            $("#shipping_id").on("change",function(){
                var shipping_name = $(this).find("option:selected").text();
                $("#shipping_name").val(shipping_name);
            });

        });
    </script>
@stop
