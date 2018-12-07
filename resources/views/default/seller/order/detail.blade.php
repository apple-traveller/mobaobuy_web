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

                    <dl @if($orderInfo['order_status']==3 || $orderInfo['order_status'] == 4 || $orderInfo['order_status'] == 5 || $orderInfo['order_status'] == 0) class="cur" @endif>
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
                    <dl @if($orderInfo['shipping_status']==3) class="cur" @endif>
                        <dt></dt>
                        <dd class="s-text">商家发货<br>
                            <em class="ftx-03">
                                @if($orderInfo['shipping_status']==0)待发货
                                @elseif($orderInfo['shipping_status']==3)已发货
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
                                                <select name="modules" lay-verify="required" style="width: 100px;padding: 2px 0" @if($orderInfo['order_status']>=3) disabled @endif>
                                                    <option value="1" @if($orderInfo['pay_type']==1) selected @endif>先款后货</option>
                                                    <option value="2" @if($orderInfo['pay_type']==2) selected @endif>货到付款</option>
                                                </select>

                                        </dt>

                                </dl>
                                <dl>
                                    <dt>交货时间：
                                        <div class="" ectype="editSpanInput" style="float: right;margin-right: 10px">
                                            <span id="deliveryPeriod">{{$orderInfo['delivery_period']}} </span>
                                            <i class="icon icon-edit" @if($orderInfo['order_status']==2)onclick="listTable.edit($('#deliveryPeriod')[0],'{{url('/seller/order/updateDeliveryPeriod')}}','{{$orderInfo['id']}}')"@endif></i>
                                        </div>
                                    </dt>

                                    <dt>自动确认收货时间：
                                        <div class="" ectype="editSpanInput" style="float: right;margin-right: 10px">
                                            <span id="receive_num">{{$orderInfo['auto_delivery_time']}}</span>
                                            <span>天</span>
                                            <i class="icon icon-edit" @if($orderInfo!=4)onclick="listTable.edit($('#receive_num')[0],'{{url('/seller/order/modifyReceiveDate')}}','{{$orderInfo['id']}}')" @endif></i>
                                        </div>
                                    </dt>
                                </dl>
                                <dl>
                                    <dt>
                                        <div style="height: 40px;">
                                            付款凭证:
                                            @if(!empty($orderInfo['pay_voucher']))
                                                <button type="button" onclick="payImg('{{ getFileUrl($orderInfo['pay_voucher']) }}')" class="layui-btn mt3" style="height: 29px;line-height: 30px;margin-bottom: 5px">查看</button>
                                            @else
                                                <span>暂无</span>
                                            @endif
                                        </div>
                                    </dt>
                                </dl>
                                <dl>
                                    @if($orderInfo['extension_code']=='wholesale' && $orderInfo['extension_id']==4)
                                    <dt>
                                        <div style="height: 40px;">
                                            定金凭证:
                                            @if(!empty($orderInfo['deposit_pay_voucher']))
                                                <button type="button" onclick="depositImg('{{ getFileUrl($orderInfo['deposit_pay_voucher']) }}')" class="layui-btn mt3" style="height: 29px;line-height: 30px;margin-bottom: 5px">查看</button>
                                            @else
                                                <span>暂无</span>
                                            @endif
                                        </div>
                                    </dt>
                                        @else
                                        <dt></dt>
                                    @endif
                                </dl>
                                <dl>
                                    <dt>
                                        <div style="height: 40px;">
                                            合同:
                                            @if(!empty($orderInfo['contract']))
                                                <button type="button" onclick="contractImg('{{ getFileUrl($orderInfo['contract']) }}')" class="layui-btn mt3" style="height: 29px;line-height: 30px;margin-bottom: 5px">查看</button>
                                            @else
                                                <span>暂无</span>
                                            @endif
                                        </div>
                                    </dt>
                                </dl>
                                <dl>
                                    <dt></dt>
                                </dl>
                                <dl>
                                    <dt></dt>
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
                                <dl>
                                    <dt>收货地址：{{$region}} {{$orderInfo['address']}}</dt>
                                    <dt>邮政编码：@if($orderInfo['zipcode']!="null" && !isset($orderInfo['zipcode']) && !empty($orderInfo['zipcode'])) {{$orderInfo['zipcode']}} @else @endif</dt>
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
                            <div class="step_title"><h3>订单物流信息</h3></div>
                            <div class="section" style="height: 100px;">
                                @if(empty($delivery_list))
                                    <dl>
                                        <dt style="width: 528%">暂无信息</dt>
                                    </dl>
                                @else
                                @foreach($delivery_list as $v)
                                    <dl>
                                        <dt>物流公司：{{$v['shipping_name']}}</dt>

                                        <dt>物流单号：{{$v['shipping_billno']}}</dt>

                                    </dl>
                                    @endforeach
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
                                    @endif
                            </div>
                        </div>
                        <!-- 门店信息 -->
                        <!--订单其他信息-->
                        <div class="step" style="background: #fff;padding: 10px 20px;">
                            <div class="step_title"><i class="ui-step"></i><h3>其他信息</h3></div>
                            <div class="section">
                                {{--<dl>--}}
                                    {{--<dt>发票抬头：--}}{{--@if(!empty($user_invoices)) {{ $user_invoices['shop_name'] }}@else 无 @endif--}}{{--</dt>--}}
                                    {{--<dt>税号：@if(!empty($user_invoices)) {{$user_invoices['tax_id']}} @else 无 @endif</dt>--}}
                                {{--</dl>--}}

                                {{--<dl>--}}
                                    {{--<dt>开票地址：@if(!empty($user_invoices)) {{$user_invoices['company_address']}} @else 无 @endif</dt>--}}

                                    {{--<dt>开票电话：@if(!empty($user_invoices)) {{$user_invoices['company_telephone']}} @else 无 @endif</dt>--}}

                                {{--</dl>--}}

                                {{--<dl>--}}
                                    {{--<dt>收票地址：@if(!empty($user_invoices)) {{$user_invoices['consignee_address']}} @else 无 @endif</dt>--}}

                                    {{--<dt>收票电话：@if(!empty($user_invoices)){{$user_invoices['consignee_mobile_phone']}} @else 无 @endif</dt>--}}

                                {{--</dl>--}}

                                {{--<dl>--}}
                                    {{--<dt>收票人：@if(!empty($user_invoices)) {{$user_invoices['consignee_name']}} @else 无 @endif</dt>--}}
                                    {{--<dt></dt>--}}
                                {{--</dl>--}}

                                <dl style="width:30.6%">
                                    <dt style="width: 320%">卖家留言：@if(empty($orderInfo)) 无 @else {{$orderInfo['to_buyer']}} @endif<span class="viewMessage" style="color:blue;cursor:pointer;">留言</span></dt>
                                    <dt style="width: 320%">买家留言：@if(empty($orderInfo)) 无 @else {{$orderInfo['postscript']}} @endif</dt>
                                </dl>
                            </div>
                        </div>
                    </div>

                        <!--商品信息-->
                        <div class="step" style="background: #fff;padding: 10px 20px;">
                            <div class="step_title">
                                <i class="ui-step">

                                </i>
                                <h3>商品信息 @if($orderInfo['order_status']==2)
                                    <a href="/seller/order/modifyGoodsInfo?id={{$orderInfo['id']}}&currentPage={{$currentPage}}">
                                        <i class="icon icon-edit"></i>
                                    </a>
                                             @else
                                    @endif
                                </h3>
                            </div>
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
                                                <td style="padding-left: 9px;height: 45px">{{$vo['goods_full_name']}}</td>
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
                            <div class="step_title"><i class="ui-step"></i>
                                <h3>费用信息 @if($orderInfo['order_status']==2)
                                    <a href="/seller/order/modifyFree?id={{$orderInfo['id']}}&currentPage={{$currentPage}}">
                                        <i class="icon icon-edit">
                                        </i>
                                    </a>
                                         @else
                                    @endif
                                </h3>
                            </div>
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
                                    <dt>定金：+ <em>¥</em>{{$orderInfo['deposit']}}</dt>
                                    <dt>已付款金额：- <em>¥</em>{{$orderInfo['money_paid']}}</dt>
                                </dl>
                                <dl>
                                    <dt class="red">订单总金额: {{number_format($orderInfo['goods_amount']+$orderInfo['shipping_fee']+$orderInfo['deposit']-$orderInfo['discount'],2)}}</dt>
                                    <dt class="red">应付款金额: <em>¥</em>{{number_format($orderInfo['goods_amount']+$orderInfo['shipping_fee']-$orderInfo['discount']+$orderInfo['deposit']-$orderInfo['money_paid'],2)}}</dt>
                                </dl>
                            </div>
                        </div>

                        <!--操作信息-->
                        <div class="step order_total">
                            <div class="step_title"><i class="ui-step"></i><h3>操作信息</h3></div>
                            <div class="step_info">
                                @if($orderInfo['order_status']!=4)
                                <div class="order_operation order_operation100">
                                    <div class="item">
                                        <div class="label">操作备注：</div>
                                        <div class="value">
                                            <div class="bf100 fl mb5"><textarea name="action_note" class="textarea" id="action_note"></textarea></div>
                                            <div class="order_operation_btn" style="margin-top: 0">
                                                // 取消的订单没有操作选项
                                                @if($orderInfo['order_status']!=0)
                                                    @if($orderInfo['order_status'] == 2)
                                                        <input name="pay" type="button" value="确定" class="btn btn25 red_btn" onclick="conf({{ $orderInfo['id'] }})">
                                                        <input name="cancel" type="button" value="取消" class="btn btn25 red_btn" onclick="cancelOne( {{ $orderInfo['id'] }})">

                                                        // 确认收到定金
                                                        @if($orderInfo['deposit_status'] == 0)
                                                            <input type="button" value="确认收到定金" class="btn btn25 blue_btn" onclick="receiveDep({{ $orderInfo['id'] }})">
                                                        @elseif($orderInfo['deposit_status'] == 1 && $orderInfo['deposit']==0)

                                                        @else
                                                            <input type="button" value="已收到定金" class="btn btn25 gray_btn">
                                                        @endif
                                                    @endif

                                                    // 确认收款
                                                    @if($orderInfo['order_status']==3)
                                                        @if( $orderInfo['pay_status'] == 0 || $orderInfo['pay_status'] == 2)
                                                            <input type="button" value="确认收款" class="btn btn25 blue_btn" onclick="receiveM({{ $orderInfo['id'] }})">
                                                        @else
                                                            <input type="button" value="已收款" class="btn btn25 gray_btn">
                                                        @endif
                                                            <input name="cancel" type="button" value="取消" class="btn btn25 red_btn" onclick="cancelOne( {{ $orderInfo['id'] }})">
                                                @endif

                                                // 发货

                                                @if($orderInfo['pay_type'] == 1)
                                                    @if($orderInfo['order_status'] == 3 && $orderInfo['pay_status']==1 && $orderInfo['shipping_status']==0 || $orderInfo['shipping_status']==2)
                                                        <a href="javascript:void(0);" onclick="shipping()"> <input type="button" value="生成发货单" class="btn btn25 red_btn"></a>
                                                    @endif

                                                @elseif($orderInfo['pay_type'] == 2)
                                                    @if($orderInfo['order_status'] == 3 && $orderInfo['shipping_status']==0 || $orderInfo['shipping_status']==2)
                                                        <a href="javascript:void(0);" onclick="shipping()"> <input type="button" value="生成发货单" class="btn btn25 red_btn"></a>
                                                    @endif
                                                @endif
                                                    @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
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
                                        @if(!empty($orderLogs))
                                        @foreach($orderLogs as $v)
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>{{$v['action_user']}}</td>
                                                <td>{{$v['log_time']}}</td>
                                                <td>
                                                    @if($v['order_status']==0)已取消
                                                    @elseif($v['order_status']==1)待企业审核
                                                    @elseif($v['order_status']==2)待商家确认
                                                    @else已确认
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($v['pay_status']==0)待付款
                                                    @elseif($v['pay_status']==1)已付款
                                                    @else部分付款
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($v['shipping_status']==0)待发货
                                                    @elseif($v['shipping_status']==1)已发货
                                                    @elseif($v['shipping_status']==2)部分发货
                                                    @endif
                                                </td>
                                                <td>{{$v['action_note']}}</td>
                                            </tr>
                                        @endforeach
                                            @else
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                </form>
                    </div>
        </div>
            </div>
    <script>

        layui.use(['layer'], function() {
            let layer = layui.layer;
            let index = 0;
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
                let id = "{{$orderInfo['id']}}";
                let to_buyer = $(".to_buyer").val();
                $.post('/seller/order/toBuyerModify',{'id':id,'to_buyer':to_buyer},function(res){
                    if(res.code==1){
                        window.location.reload();
                    }else{
                        layer.alert(res.msg);
                    }
                },"json");
                layer.close(index);
            });
        });
        function payImg(pay_img) {
            //示范一个公告层
           layer.open({
                type: 1
                ,
                title: '凭证', //不显示标题栏
                // ,
                // closeBtn: true
                // ,
                shade: 0.8
                ,
                maxmin:true
                ,
                area:['700px','600px'],
                id: 'PayImg' //设定一个id，防止重复弹出
                ,
                moveType: 1 //拖拽模式，0或者1
                ,
                content: '<div style="padding: 20px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;"><img src="'+pay_img+'" alt=""> </div>'
                ,
                yes: function () {
                    layer.closeAll();
                }
            });
        }
        function depositImg(deposit_img) {
            layer.open({
                type: 1
                ,
                title: '凭证'
                ,
                shade: 0.8
                ,
                maxmin:true
                ,
                area:['700px','600px'],
                id: 'PayImg' //设定一个id，防止重复弹出
                ,
                moveType: 1 //拖拽模式，0或者1
                ,
                content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;"><img src="'+deposit_img+'" alt=""> </div>'
                ,
                yes: function () {
                    layer.closeAll();
                }
            });
        }

        function contractImg(contractImg) {
            layer.open({
                type: 1
                ,
                title: '凭证'
                ,
                shade: 0.8
                ,
                maxmin:true
                ,
                area:['700px','600px'],
                id: 'PayImg' //设定一个id，防止重复弹出
                ,
                moveType: 1 //拖拽模式，0或者1
                ,
                content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;"><img src="'+contractImg+'" alt=""> </div>'
                ,
                yes: function () {
                    layer.closeAll();
                }
            });
        }
        // 确认订单
        function conf(id)
        {
            layui.use(['layer','upload'], function(){
                let layer = layui.layer;
                let upload = layui.upload;
                index = layer.open({
                    type: 1,
                    title: '确认订单',
                    btn:['确定','取消'],
                    // area: ['350px', '220px'],
                    content: '<div class="layui-upload">' +
                        '<button type="button" class="layui-btn" id="test1" style="margin-left: 129px;margin-top: 9px;">上传合同</button>' +
                        '  <div class="layui-upload-list">' +
                        '    <img class="layui-upload-img" id="demo1" data-img="" style="width: 360px;height: 250px">' +
                        '    <p id="demoText"></p>' +
                        '  </div>' +
                        '</div>',
                    yes: function(index, layero){
                       let img = $('#demo1').data('img');
                       let action_note = $("#action_note").val();
                       if (img===''){
                           return layer.msg('未上传合同，无法确定');
                       } else {
                           layer.close(index);
                           $.ajax({
                               url:'/seller/order/updateOrderStatus',
                               data: {
                                   'id':id,
                                   'action_note': action_note,
                                   'order_status': 3,
                                   'contract': img
                               },
                               type: 'post',
                               success: function (res) {
                                   if (res.code === 1){
                                       layer.alert(res.msg, {icon: 1,time:600});
                                   } else {
                                       layer.alert(res.msg, {icon: 5,time:2000});
                                   }
                                   window.location.reload();
                               }
                           });

                       }
                    }

                });
                var uploadInst = upload.render({
                    elem: '#test1'
                    , url: '/uploadImg'
                    ,data:{
                        'upload_type':'img',
                        'upload_path':'order/contract'
                    }
                    , before: function (obj) {
                        //预读本地文件示例，不支持ie8
                        obj.preview(function (index, file, result) {
                            $('#demo1').attr('src', result); //图片链接（base64）
                        });
                    }
                    , done: function (res) {
                        //如果上传失败
                        if (res.code !== 1) {
                            return layer.msg('上传失败');
                        } else {  //上传成功
                            $('#demo1').data('img', res.data.path);
                        }
                    }
                    , error: function () {
                        //演示失败状态，并实现重传
                        var demoText = $('#demoText');
                        demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                        demoText.find('.demo-reload').on('click', function () {
                            uploadInst.upload();
                        });
                    }
                });



                // layer.confirm('确认订单?', {icon: 3, title:'提示'}, function(index){
                //     let action_note = $("#action_note").val();
                //     $.ajax({
                //         url:'/seller/order/updateOrderStatus',
                //         data: {
                //             'id':id,
                //             'action_note':action_note,
                //             'order_status': 3,
                //         },
                //         type: 'post',
                //         success: function (res) {
                //             if (res.code == 1){
                //                 layer.alert(res.msg, {icon: 1,time:600});
                //             } else {
                //                 layer.alert(res.msg, {icon: 5,time:2000});
                //             }
                //         }
                //     });
                //     layer.close(index);
                //     parent.location.reload();
                // });
            });
            // layui.use('layer', function(){
            //     let index = parent.layer.getFrameIndex(window.name);
            //     parent.layer.iframeAuto(index);
            //     let layer = layui.layer;
            //     layer.prompt({
            //         title: '确认订单,并输入交货日期',
            //     }, function(value, index, elem){
            //
            //
            //         let action_note = $("#action_note").val();
            //         $.ajax({
            //             url:'/seller/order/updateOrderStatus',
            //             data: {
            //                 'id':id,
            //                 'action_note':action_note,
            //                 'order_status': 3,
            //                 'delivery_period':value
            //             },
            //             type: 'post',
            //             success: function (res) {
            //                 if (res.code == 1){
            //                     layer.msg(res.msg, {icon: 1,time:2000});
            //                 } else {
            //                     layer.msg(res.msg, {icon: 5,time:2000});
            //                 }
            //                 setTimeout( window.location.href="/seller/order/list?id="+id,3000)
            //             }
            //         });
            //
            //         layer.close(index);
            //     });
            // });
        }

        //取消订单
        function cancelOne(id)
        {
            layui.use('layer', function(){
                let layer = layui.layer;
                layer.confirm('确认取消订单?', {icon: 3, title:'提示'}, function(index){
                    let action_note = $("#action_note").val();
                    $.ajax({
                        url:'/seller/order/updateOrderStatus',
                        data: {
                            'id':id,
                            'action_note':action_note,
                            'order_status': 0
                        },
                        type: 'post',
                        success: function (res) {
                            if (res.code == 1){
                                layer.alert(res.msg, {icon: 1,time:600});
                            } else {
                                layer.alert(res.msg, {icon: 5,time:2000});
                            }
                        }
                    });
                    layer.close(index);
                    parent.location.reload();
                });
            });
            // layui.use('layer', function(){
            //     let index = parent.layer.getFrameIndex(window.name);
            //     parent.layer.iframeAuto(index);
            //     let layer = layui.layer;
            //     layer.prompt({
            //         title: '确认取消订单,并输入原因',
            //     }, function(value, index){
            //
            //         $.ajax({
            //             url:'/seller/order/updateOrderStatus',
            //             data: {
            //                 'id':id,
            //                 'order_status': 0,
            //                 'to_buyer':value
            //             },
            //             type: 'post',
            //             success: function (res) {
            //                 if (res.code == 1){
            //                     layer.msg(res.msg, {icon: 1,time:2000});
            //                 } else {
            //                     layer.msg(res.msg, {icon: 5,time:2000});
            //                 }
            //                 setTimeout( window.location.href="/seller/order/list?id="+id,3000)
            //             }
            //         });
            //
            //         layer.close(index);
            //     });
            // });
        }
        // 收款
        function receiveM(id) {
            layui.use('layer', function(){
                let layer = layui.layer;
                layer.confirm('确认收到付款?', {icon: 3, title:'提示'}, function(index){
                    let action_note = $("#action_note").val();
                    $.ajax({
                        url:'/seller/order/updateOrderStatus',
                        data: {
                            'id':id,
                            'pay_status': 1,
                            'action_note':action_note
                        },
                        type: 'post',
                        success: function (res) {
                            if (res.code == 1){
                                layer.alert(res.msg, {icon: 1,time:600});
                            } else {
                                layer.alert(res.msg, {icon: 5,time:2000});
                            }
                        }
                    });
                    layer.close(index);
                    parent.location.reload();
                });
            });
                // layui.use('layer', function(){
                //     let index = parent.layer.getFrameIndex(window.name);
                //     let action_note = $("#action_note").val();
                //     parent.layer.iframeAuto(index);
                //     let layer = layui.layer;
                //     layer.prompt({
                //         title: '确认收到付款?，请填写金额',
                //     }, function(value, index, elem){
                //         let num = /^\d+(\.{0,1}\d+){0,1}$/;
                //         if (!num.test(value)){
                //             layer.alert('请填写正数');
                //             return false;
                //         }
                //         $.ajax({
                //             url:'/seller/order/updateOrderStatus',
                //             data: {
                //                 'id':id,
                //                 'pay_number': value,
                //                 'action_note':action_note
                //             },
                //             type: 'post',
                //             success: function (res) {
                //                 if (res.code == 1){
                //                     layer.alert(res.msg, {icon: 1,time:2000});
                //                 } else {
                //                     layer.alert(res.msg, {icon: 5,time:2000});
                //                 }
                //                 setTimeout( window.location.href="/seller/order/list?id="+id,3000);
                //             }
                //         });
                //         layer.close(index);
                //         parent.location.reload();
                //     });
                // });
        }

        // 确认收到定金
        function receiveDep(id) {
            layui.use('layer', function(){
                let layer = layui.layer;
                layer.confirm('确认收到定金?', {icon: 3, title:'提示'}, function(index){
                    let action_note = $("#action_note").val();
                    $.ajax({
                        url:'/seller/order/updateOrderStatus',
                        data: {
                            'id':id,
                            'deposit_status': 1,
                            'action_note':action_note
                        },
                        type: 'post',
                        success: function (res) {
                            if (res.code == 1){
                                layer.alert(res.msg, {icon: 1,time:600});
                            } else {
                                layer.alert(res.msg, {icon: 5,time:2000});
                            }
                        }
                    });
                    layer.close(index);
                    parent.location.reload();
                });
            });
        }
        function shipping() {
            let pay_type = "{{$orderInfo['pay_status']}}";
            layui.use('layer', function(){
                let layer = layui.layer;
                if (pay_type!=1){
                    layer.confirm('没有收到全款，是否发货?', {icon: 3, title:'提示'}, function(index){
                       window.location.href="/seller/order/delivery?order_id={{$orderInfo['id']}}&currentPage={{$currentPage}}";
                    });
                } else {
                    window.location.href="/seller/order/delivery?order_id={{$orderInfo['id']}}&currentPage={{$currentPage}}";
                }
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
                        layer.alert(res.msg);
                    } else {
                        layer.alert(res.msg);
                    }
                    window.location.reload();
                }

            })
        });
    </script>
@stop
