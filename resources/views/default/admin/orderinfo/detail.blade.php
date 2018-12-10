@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/orderinfo/list?currpage={{$currpage}}&order_status={{$order_status}}" class="s-back">返回</a>订单 - 订单信息</div>
        <div class="content">
            <div class="flexilist order_info">
                <div class="stepflex">
                    <dl class="first cur">
                        <dt></dt>
                        <dd class="s-text">提交订单<br><em class="ftx-03">{{$orderInfo['add_time']}}</em></dd>
                    </dl>

                    <dl @if($orderInfo['order_status']==3||$orderInfo['order_status']==4 ||$orderInfo['order_status']==5) class="cur" @endif>
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
                    <dl @if($orderInfo['shipping_status']==1||$orderInfo['shipping_status']==2||$orderInfo['shipping_status']==3) class="cur" @endif>
                        <dt></dt>
                        <dd class="s-text">商家发货<br>
                            <em class="ftx-03">
                                @if($orderInfo['shipping_status']==0)待发货
                                @elseif($orderInfo['shipping_status']==1)已发货
                                @elseif($orderInfo['shipping_status']==2)部分发货
                                @else 已确认收货
                                @endif
                            </em>
                        </dd>
                    </dl>
                    <dl @if($orderInfo['shipping_status']==3) class="cur" @endif class="last ">
                        <dt></dt>
                        <dd class="s-text">确认收货<br>
                            <em class="ftx-03">
                               {{$orderInfo['confirm_take_time']}}
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
                                    <dt>订单号：<span style="color:#62b3ff">{{$orderInfo['order_sn']}}</span></dt>
                                    <dt>订单来源：<span style="color:#62b3ff">{{$orderInfo['froms']}}</span></dt>
                                </dl>
                                <dl>
                                    <dt>购货人：<span style="color:#62b3ff">{{$user['nick_name']}}</span></dt>
                                    <dt>订单状态：<span style="color:#62b3ff">@if($orderInfo['order_status']==0)已作废
                                        @elseif($orderInfo['order_status']==1)待企业审核
                                        @elseif($orderInfo['order_status']==2)待商家确认
                                        @elseif($orderInfo['order_status']==3)已确认
                                        @elseif($orderInfo['order_status']==4)已完成
                                        @elseif($orderInfo['order_status']==5)待开票
                                            @endif</span>
                                    </dt>


                                </dl>

                                <dl>
                                    <dt>店铺：<span style="color:#62b3ff">{{$orderInfo['shop_name']}}</span></dt>
                                    <dt>下单时间：<span style="color:#62b3ff">{{$orderInfo['add_time']}}</span></dt>
                                </dl>
                                <dl>
                                    <dt>付款状态：<span style="color:#62b3ff">@if($orderInfo['pay_status']==0)待付款
                                            @elseif($orderInfo['pay_status']==1)已付款
                                            @else部分付款
                                            @endif
                                        </span>
                                    </dt>
                                    <dt>付款时间：<span style="color:#62b3ff">@if(empty($orderInfo['pay_time']))待付款@else {{$orderInfo['pay_time']}} @endif</span></dt>
                                </dl>
                                <dl>
                                    <dt>发货状态：<span style="color:#62b3ff">@if($orderInfo['shipping_status']==0)待发货
                                            @elseif($orderInfo['shipping_status']==1)已发货
                                            @elseif($orderInfo['shipping_status']==2)部分发货
                                            @else已确认收货
                                            @endif</span>
                                    </dt>
                                    <dt>发货时间：<span style="color:#62b3ff">@if(empty($orderInfo['shipping_time']))待发货@else {{$orderInfo['shipping_time']}} @endif</span></dt>
                                </dl>
                            </div>
                            <div class="section">

                                <dl>
                                    <dt><span style="float:left;">自动确认收货时间：</span>
                                        <span style="color:#62b3ff"><div class="editSpanInput" ectype="editSpanInput">
                                            <span onclick="listTable.edit(this,'{{url('/admin/orderinfo/modifyAutoDeliveryTime')}}','{{$orderInfo['id']}}')">{{$orderInfo['auto_delivery_time']}}</span>
                                            <span>天</span>
                                            <i class="icon icon-edit"></i>
                                        </div>
                                        </span>
                                    </dt>
                                </dl>
                            </div>
                        </div>

                        <!--收货人信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>收货人信息<a href="/admin/orderinfo/modifyConsignee?id={{$orderInfo['id']}}&currpage={{$currpage}}&order_status={{$order_status}}"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="section">
                                <dl>
                                    <dt>收货人：<span style="color:#62b3ff">{{$orderInfo['consignee']}}</span></dt>
                                    <dt>手机号码：<span style="color:#62b3ff">{{$orderInfo['mobile_phone']}}</span></dt>
                                </dl>
                                <dl style="width:50%">
                                    <dt>收货地址：<span style="color:#62b3ff">{{$region}}&nbsp;&nbsp;&nbsp;&nbsp;{{$orderInfo['address']}}</span></dt>
                                    <dt>邮政编码：<span style="color:#62b3ff">@if(empty($orderInfo['zipcode'])) 无 @else{{$orderInfo['zipcode']}} @endif</span></dt>
                                </dl>
                            </div>
                        </div>
                        <!-- 门店信息 -->
                        <!--订单其他信息-->
                        <div class="step">
                            <div class="step_title">
                                <i class="ui-step"></i><h3>其他信息
                                   {{-- <a href="/admin/orderinfo/modifyInvoice?invoice_id={{$orderInfo['invoice_id']}}&currpage={{$currpage}}&id={{$orderInfo['id']}}">
                                        <i class="icon icon-edit"></i>
                                    </a>--}}
                                </h3>
                            </div>
                            <div class="section">
                                <dl>
                                    <dt>发票抬头:<span style="color:#62b3ff">@if(!empty($user_real['company_name'])) {{$user_real['company_name']}} @else 无 @endif</span></dt>

                                    <dt>税号:<span style="color:#62b3ff">@if(!empty($user_real['tax_id'])) {{$user_real['tax_id']}} @else 无 @endif</span></dt>
                                </dl>

                                <dl>
                                    <dt>开票地址:<span style="color:#62b3ff">@if(!empty($user_real['company_address'])) {{$user_real['company_address']}} @else 无 @endif</span></dt>

                                    <dt>开票电话:<span style="color:#62b3ff">@if(!empty($user_real['company_telephone'])) {{$user_real['company_telephone']}} @else 无 @endif</span></dt>
                                </dl>

                                <dl>
                                    <dt>开户银行:<span style="color:#62b3ff">@if(!empty($user_real['bank_of_deposit'])) {{$user_real['bank_of_deposit']}} @else 无 @endif</span></dt>

                                    <dt>银行账号:<span style="color:#62b3ff">@if(!empty($user_real['bank_account'])) {{$user_real['bank_account']}} @else 无 @endif</span></dt>
                                </dl>

                                <dl>
                                    <dt>卖家留言:<div class="div_a"><span class="viewMessage" style="color:red;cursor:pointer;">留言</span><span style="color:#62b3ff">@if(empty($orderInfo['to_buyer'])) 无 @else {{$orderInfo['to_buyer']}} @endif</span></div></dt>

                                    <dt>买家留言:<span style="color:#62b3ff">@if(empty($orderInfo['postscript'])) 无 @else {{$orderInfo['postscript']}} @endif</span></dt>
                                </dl>


                            </div>
                        </div>

                        <!--商品信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>商品信息<a class="edit-order-goods" href="/admin/orderinfo/modifyOrderGoods?id={{$orderInfo['id']}}&currpage={{$currpage}}&shop_name={{$orderInfo['shop_name']}}&order_status={{$order_status}}"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="step_info">
                                <div class="order_goods_fr">
                                    <table class="table" border="0" cellpadding="0" cellspacing="0">
                                        <thead>
                                        <tr >
                                            <th style="text-align: center;" width="15%" class="first">商品名称 [ 品牌 ]</th>
                                            <th style="text-align: center;" width="10%">商品编码</th>
                                            <th style="text-align: center;" width="15%">店铺</th>
                                            <th style="text-align: center;" width="10%">价格</th>
                                            <th style="text-align: center;" width="10%">购买数量</th>
                                            <th style="text-align: center;" width="10%">已发货数量</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order_goods as $vo)
                                        <tr>
                                            <td style="color:#62b3ff;text-align: center;">{{$vo['goods_name']}}</td>
                                            <td style="color:#62b3ff;text-align: center;">{{$vo['goods_sn']}}</td>
                                            <td style="color:#62b3ff;text-align: center;">{{$orderInfo['shop_name']}}</td>
                                            <td style="color:#62b3ff;text-align: center;">{{$vo['goods_price']}}</td>
                                            <td style="color:#62b3ff;text-align: center;">{{$vo['goods_number']}}</td>
                                            <td style="color:#62b3ff;text-align: center;">{{$vo['send_number']}}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="6">
                                                <div class="order_total_fr">
                                                    <strong>合计：</strong>
                                                    <span class="red"><em>¥</em>{{$orderInfo['goods_amount']}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @if($orderInfo['shipping_status']==0 || $orderInfo['shipping_status']==2)
                                        <tr>
                                            <td colspan="6">
                                                <div class="order_total_fr">
                                                    <div class="layui-btn layui-btn-sm order_delivery" data-status="{{$orderInfo['shipping_status']}}" style="margin-right: 30px;"><a href="/admin/orderinfo/delivery?order_id={{$orderInfo['id']}}&currpage={{$currpage}}">生成发货单</a></div>
                                                </div>
                                            </td>
                                        </tr>
                                        @else

                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!--费用信息-->
                        <div class="step order_total">
                            <div class="step_title"><i class="ui-step"></i><h3>费用信息<a class="edit-order-goods" href="/admin/orderinfo/modifyFee?id={{$orderInfo['id']}}&currpage={{$currpage}}&order_status={{$order_status}}"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="section">

                                <dl>
                                    <dt style="width:200px;">商品总金额:<span style="color:#62b3ff"><em>¥</em>{{number_format($orderInfo['goods_amount'],2,".","")}}</span></dt>
                                </dl>

                                <dl style="margin-left: 20px;">
                                    <dt style="width:200px;">配送费用:<span style="color:#62b3ff">+ <em>¥</em>{{$orderInfo['shipping_fee']}}</span></dt>
                                </dl>

                                <dl>
                                    <dt style="width:200px;">折扣:<span style="color:#62b3ff">- <em>¥</em>{{$orderInfo['discount']}}</span></dt>
                                </dl>

                                <dl>
                                    <dt style="width:200px;">已付款金额:<span style="color:#62b3ff">- <em>¥</em>{{$orderInfo['money_paid']}}</span></dt>
                                </dl>

                                <dl>
                                    <dt style="width:200px;">应付款金额:<span style="color:red;"><em>¥</em>{{number_format($orderInfo['order_amount']-$orderInfo['money_paid'],2,".","")}}</span></dt>
                                    <dt style="width:200px;">订单总金额:<span style="color:red;"><em>¥</em>{{$orderInfo['order_amount']}}</span></dt>
                                </dl>

                            </div>
                        </div>

                        <!--支付信息-->
                        <div class="step order_total">
                            <div class="step_title"><i class="ui-step"></i><h3>用户支付凭证信息</h3></div>
                            <div class="section">

                                <dl>
                                    <dt style="width:300px;">付款凭证:
                                        @if(!empty($orderInfo['pay_voucher']))
                                        <span style="color:#62b3ff"><div style="color:#62b3ff;margin-left:10px;"    content="{{getFileUrl($orderInfo['pay_voucher'])}}" class="layui-btn layui-btn-sm viewImg">点击查看</div>
                                        </span>
                                        @else
                                            未上传
                                        @endif
                                    </dt>
                                    <dl style="width:300px;margin-left: 20px;">确认收款:
                                        @if($orderInfo['pay_status']==1)
                                            已收款
                                        @else
                                            <input   style="margin-left:10px;" class="btn btn25 red_btn pay_status" type="button" content="{{$orderInfo['pay_voucher']}}" data-id="1"  value="确认收款" >
                                        @endif
                                    </dl>
                                </dl>

                                @if($orderInfo['extension_code']=="wholesale")
                                <dl style="margin-left: 20px;">
                                    <dt style="width:300px;">定金付款凭证:
                                        @if(!empty($orderInfo['deposit_pay_voucher']))
                                        <span style="color:#62b3ff"><div style="color:#62b3ff;margin-left:10px;"  content="{{getFileUrl($orderInfo['deposit_pay_voucher'])}}" class="layui-btn layui-btn-sm viewImg">点击查看</div>
                                        </span>
                                        @else
                                            未上传
                                        @endif
                                    </dt>
                                    <dl style="width:300px;margin-left: 20px;">确认收款:
                                        @if($orderInfo['deposit_status']==1)
                                            已收款
                                        @else
                                            <input   style="margin-left:10px;" class="btn btn25 red_btn pay_status_deposit" type="button" content="{{$orderInfo['deposit_pay_voucher']}}" data-id="1"  value="确认收款" >
                                        @endif
                                    </dl>
                                </dl>
                                @endif


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
                                            <div class="bf100 fl"><textarea placeholder="请详细填写操作日志" id="action_note" name="action_note" class="textarea action_note"></textarea></div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="label">订单状态：</div>
                                        <div class="value">
                                            <input  class="btn btn25 red_btn order_status"    type="button" data-id="0" value="取消" >
                                            @if($orderInfo['firm_id']!=0 &&$orderInfo['order_status']==1)
                                            <input  class="btn btn25 red_btn order_status"  @if($orderInfo['order_status']>2) style="display:none;" @endif  type="button" data-id="2" value="企业审核" >
                                            @else
                                            @endif
                                            <input  class="btn btn25 red_btn order_status"  @if($orderInfo['order_status']>=3) style="display:none;" @endif  type="button" data-id="3" value="商家确认" >
                                            <input  class="btn btn25 red_btn order_status"  @if($orderInfo['order_status']>=4 ) style="display:none;" @endif  type="button" data-id="4" value="收货" >
                                            <input  class="btn btn25 red_btn order_status"    type="button" data-id="-1" value="删除" >
                                            <span style="color: #00bbc8; margin-left: 20px;">点击按钮直接修改状态，请谨慎修改</span>
                                            <input type="hidden"  name="order_contract" id="order_contract" value="">
                                        </div>
                                        @if(!empty($order_contact))
                                    <div class="item">
                                        <div class="label">订单合同：</div>
                                        <div >
                                            <input content="{{getFileUrl($order_contact['contract'])}}"  class="btn btn25 view_order_contract"    type="button"  value="查看合同" >
                                            <input content=""  class="btn btn25 edit_order_contract"    type="button"  value="编辑合同,重新上传" >
                                        </div>
                                    </div>
                                        @else

                                        @endif
                                    </div>
                                    <div class="item">
                                        <div class="label">发货状态：</div>
                                        <div class="value">
                                            @if($orderInfo['shipping_status']==1)
                                                已发货
                                            @elseif($orderInfo['shipping_status']==3)
                                                已收货
                                            @elseif($orderInfo['shipping_status']==2)
                                                <div class="btn btn25 red_btn order_delivery"  data-status="{{$orderInfo['shipping_status']}}" ><a style="color:white;" href="/admin/orderinfo/delivery?order_id={{$orderInfo['id']}}&currpage={{$currpage}}">部分发货，去发货</a></div>
                                            @else
                                                <div class="btn btn25 red_btn order_delivery"  data-status="{{$orderInfo['shipping_status']}}" ><a style="color:white;" href="/admin/orderinfo/delivery?order_id={{$orderInfo['id']}}&currpage={{$currpage}}">未发货，去发货</a></div>
                                            @endif
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
                                                @elseif($vo['order_status']==3)已确认
                                                @elseif($vo['order_status']==4)已完成
                                                @else待开票
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
                                                @else已确认收货
                                                @endif
                                            </td>
                                            <td>{{$vo['action_note']}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <!--页码-->
                                    <div style="text-align: center;" class="news_pages">
                                        <ul id="page" class="pagination">

                                        </ul>
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
        paginate();
        function paginate(){
            layui.use(['laypage'], function() {
                var laypage = layui.laypage;
                laypage.render({
                    elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                    , count: "{{$orderLogsTotal}}" //数据总数，从服务端得到
                    , limit: "10"   //每页显示的条数
                    , curr: "{{$orderLogsCurrpage}}"  //当前页
                    , theme: "#62b3ff" //样式
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/orderinfo/detail?orderlog_currpage="+obj.curr+"&id={{$orderInfo['id']}}&currpage={{$currpage}}&order_status={{$order_status}}";
                        }
                    }
                });
            });
        }

        layui.use(['upload','layer'], function() {
            var layer = layui.layer;
            var upload = layui.upload;
            var index = 0;

            //查看订单合同
            $(".view_order_contract").click(function(){
                var content = $(this).attr('content');
                index = layer.open({
                    type: 1,
                    title: '详情',
                    area: ['800px', '600px'],
                    content: '<img style="height:550px;width:100%;" src="'+content+'">'
                });
            });

            //订单合同重新上传
            $(".edit_order_contract").click(function(){
                //上传合同
                index2 = layer.open({
                    type: 1,
                    title: '上传订单合同',
                    area: ['300px', '200px'],
                    content: '<div class="label_value item">' +
                    '<button style="margin-top:25px;margin-left:50px;" type="button" class="layui-btn upload-file" data-type="" data-path="order_contract" ><i class="layui-icon">&#xe681;</i>上传合同</button>' +
                    '<img  style="margin-left:10px;margin-top:25px;width:60px;height:60px;display:none;" class="layui-upload-img"><br/>'+
                    '<button style="margin-left:50px;margin-top:10px;" class="button messageButton_ordercontract">确定</button></div>'
                });
                $(document).delegate(".messageButton_ordercontract","click",function(){
                    var order_id = "{{$orderInfo['id']}}";
                    var contract = $("#order_contract").val();

                    //上传成功，继续修改订单状态
                    $.post('/admin/orderinfo/editOrderContract',{'order_id':order_id,'contract':contract},function(res){
                        //console.log(res.data);return false;
                        if(res.code==200){
                            layer.msg(res.msg, {
                                icon: 6,
                                time: 1000 //2秒关闭（如果不配置，默认是3秒）
                            }, function(){
                                window.location.reload();
                            });

                        }else{
                            layer.msg(res.msg, {
                                icon: 5,
                                time: 1000 //2秒关闭（如果不配置，默认是3秒）
                            });
                        }
                    },"json");
                    layer.close(index2);
                });
                //文件上传
                upload.render({
                    elem: '.upload-file' //绑定元素
                    ,url: "/uploadImg" //上传接口
                    ,accept:'file'
                    ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                        this.data={'upload_type':this.item.attr('data-type'),'upload_path':this.item.attr('data-path')};
                    }
                    ,done: function(res){
                        //上传完毕回调
                        if(1 == res.code){
                            var item = this.item;
                            item.siblings('img').show().attr('src', res.data.url);
                            $("#order_contract").val(res.data.path);
                        }else{
                            layer.msg(res.msg, {time:2000});
                        }
                    }
                });
            });

            //留言
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

            //查看付款凭证
            $(".viewImg").click(function(){
                var content = $(this).attr('content');

                if(content==""){
                    layer.msg('未上传', {
                        icon: 5,
                        time: 2000
                    });
                    return false;
                }
                layer.open({
                    type: 1,
                    title: '详情',
                    area: ['700px', '500px'],
                    content: '<img src="'+content+'">'
                });
            });

            //修改支付状态
            $(".pay_status").click(function(){
                var pay_status = $(this).attr("data-id");
                var content = $(this).attr("content");
                var order_status = "{{$orderInfo['order_status']}}";
                if(order_status<=2){
                    layer.msg("商家还未确认", {
                        icon: 5,
                        time: 1000 //2秒关闭（如果不配置，默认是3秒）
                    });
                    return ;
                }
                if(content==""){
                    layer.confirm('未上传凭证，请谨慎修改?', {icon: 3, title:'确定'}, function(index){
                        $.post('/admin/orderinfo/modifyPayStatus',{'id':"{{$orderInfo['id']}}",'pay_status':pay_status},function(res){
                            if(res.code==200){
                                layer.msg(res.msg, {
                                    icon: 6,
                                    time: 2000
                                }, function(){
                                    window.location.reload();
                                });
                            }else{
                                alert(res.msg);
                            }
                        },"json");
                    });

                    return false;
                }
                $.post('/admin/orderinfo/modifyPayStatus',{'id':"{{$orderInfo['id']}}",'pay_status':pay_status},function(res){
                    if(res.code==200){
                        layer.msg(res.msg, {
                            icon: 6,
                            time: 2000
                        }, function(){
                            window.location.reload();
                        });
                    }else{
                        alert(res.msg);
                    }
                },"json");
            });

            //修改定金状态
            $(".pay_status_deposit").click(function(){
                var deposit_status = $(this).attr("data-id");
                var content = $(this).attr("content");
                if(content==""){
                    layer.confirm('未上传凭证，请谨慎修改?', {icon: 3, title:'确定'}, function(index){
                        $.post('/admin/orderinfo/modifyPayStatus',{'id':"{{$orderInfo['id']}}",'deposit_status':deposit_status},function(res){
                            if(res.code==200){
                                layer.msg(res.msg, {
                                    icon: 6,
                                    time: 2000
                                }, function(){
                                    window.location.reload();
                                });
                            }else{
                                alert(res.msg);
                            }
                        },"json");
                    });

                    return false;
                }
                $.post('/admin/orderinfo/modifyPayStatus',{'id':"{{$orderInfo['id']}}",'deposit_status':deposit_status},function(res){
                    if(res.code==200){
                        layer.msg(res.msg, {
                            icon: 6,
                            time: 2000
                        }, function(){
                            window.location.reload();
                        });
                    }else{
                        alert(res.msg);
                    }
                },"json");
            });

            //编辑商品信息判断
            $(".edit-order-goods").click(function(){
                let pay_status ="{{$orderInfo['pay_status']}}";
                if(pay_status==1){
                    layer.msg("订单已付款不能修改", {
                        icon: 5,
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    });
                    return false;
                }
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
                var content = $("#action_note").val();
                var action_note = $(".action_note").val();
                var order_status = $(this).attr("data-id");
                var old_order_status = "{{$orderInfo['order_status']}}";
                var pay_status = "{{$orderInfo['pay_status']}}";
                var shipping_status = "{{$orderInfo['shipping_status']}}";
                if(shipping_status==3){
                    layer.msg("买家已收货", {
                        icon: 5,
                        time: 1000 //2秒关闭（如果不配置，默认是3秒）
                    });
                    return ;
                }
                if(pay_status==1 && (order_status==0 || order_status==2 ||order_status==3)){
                    layer.msg("买家已付款", {
                        icon: 5,
                        time: 1000 //2秒关闭（如果不配置，默认是3秒）
                    });
                    return ;
                }
                if(pay_status!=1 && order_status==4){
                    layer.msg("买家还未付款", {
                        icon: 5,
                        time: 1000 //2秒关闭（如果不配置，默认是3秒）
                    });
                    return ;
                }

                if(content==""){
                    layer.msg("备注不能为空", {
                        icon: 5,
                        time: 1000 //2秒关闭（如果不配置，默认是3秒）
                    });
                    return ;
                }

                if(old_order_status == 2){//待商家确认
                    if(order_status ==3){
                        //上传合同
                        index = layer.open({
                            type: 1,
                            title: '上传订单合同',
                            area: ['300px', '200px'],
                            content: '<div class="label_value item">' +
                            '<button style="margin-top:25px;margin-left:50px;" type="button" class="layui-btn upload-file" data-type="" data-path="order_contract" ><i class="layui-icon">&#xe681;</i>上传合同</button>' +
                            '<img  style="margin-left:10px;margin-top:25px;width:60px;height:60px;display:none;" class="layui-upload-img"><br/>'+
                            '<button style="margin-left:50px;margin-top:10px;" class="button messageButton_ordercontract">确定</button></div>'
                        });

                        $(document).delegate(".messageButton_ordercontract","click",function(){
                            var order_id = "{{$orderInfo['id']}}";
                            var contract = $("#order_contract").val();
                            if( contract == ""){
                                layer.msg("请先上传合同", {
                                    icon: 5,
                                    time: 1000 //2秒关闭（如果不配置，默认是3秒）
                                });
                                return false;
                            }

                            //上传成功，继续修改订单状态
                            $.post('/admin/orderinfo/modifyOrderStatus',{'id':order_id,'action_note':action_note, 'order_status':order_status, 'contract':contract},function(res){
                                //console.log(res.data);return false;
                                if(res.code==200){
                                    layer.msg(res.msg, {
                                        icon: 6,
                                        time: 1000 //2秒关闭（如果不配置，默认是3秒）
                                    }, function(){
                                        window.location.reload();
                                    });

                                }else{
                                    layer.msg(res.msg, {
                                        icon: 5,
                                        time: 1000 //2秒关闭（如果不配置，默认是3秒）
                                    });
                                }
                            },"json");
                            layer.close(index);

                        });

                        //文件上传
                        upload.render({
                            elem: '.upload-file' //绑定元素
                            ,url: "/uploadImg" //上传接口
                            ,accept:'file'
                            ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                                this.data={'upload_type':this.item.attr('data-type'),'upload_path':this.item.attr('data-path')};
                            }
                            ,done: function(res){
                                //上传完毕回调
                                if(1 == res.code){
                                    var item = this.item;
                                    item.siblings('img').show().attr('src', res.data.url);
                                    $("#order_contract").val(res.data.path);
                                }else{
                                    layer.msg(res.msg, {time:2000});
                                }
                            }
                        });
                        return false;
                    }
                }

                if(order_status==-1 || order_status==0){
                    let confirm_msg = "";
                    if(order_status==-1){
                        confirm_msg = "确认删除？";
                    }
                    if(order_status==0){
                        confirm_msg = "确认取消？";
                    }
                    layer.confirm(confirm_msg, {icon: 3, title:'提示'}, function(index3){
                        //do something
                        $.post('/admin/orderinfo/modifyOrderStatus',{'id':"{{$orderInfo['id']}}",'action_note':action_note,'order_status':order_status},function(res){
                            //console.log(res.data);return false;
                            if(res.code==200){
                                layer.msg(res.msg, {
                                    icon: 6,
                                    time: 1000 //2秒关闭（如果不配置，默认是3秒）
                                }, function(){
                                    window.location.reload();
                                });

                            }else{
                                layer.msg(res.msg, {
                                    icon: 5,
                                    time: 1000 //2秒关闭（如果不配置，默认是3秒）
                                });
                            }
                        },"json");
                                console.log('123');
                        layer.close(index3);
                        return false;
                    });
                }else{
                    $.post('/admin/orderinfo/modifyOrderStatus',{'id':"{{$orderInfo['id']}}",'action_note':action_note,'order_status':order_status},function(res){
                        //console.log(res.data);return false;
                        if(res.code==200){
                            layer.msg(res.msg, {
                                icon: 6,
                                time: 1000 //2秒关闭（如果不配置，默认是3秒）
                            }, function(){
                                window.location.reload();
                            });

                        }else{
                            layer.msg(res.msg, {
                                icon: 5,
                                time: 1000 //2秒关闭（如果不配置，默认是3秒）
                            });
                        }
                    },"json");
                }

            });




            $(".order_delivery").click(function(){
                var shipping_status = $(this).attr('data-status');
                var pay_status = "{{$orderInfo['pay_status']}}";
                var order_status = "{{$orderInfo['order_status']}}";

                if(order_status<3){
                    layer.msg("商家未确认", {
                        icon: 5,
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    });
                    return false;
                }

                if(pay_status!=1){
                    layer.msg("买家未付款", {
                        icon: 5,
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    });
                    return false;
                }

                if(shipping_status==1){
                    layer.msg("已发货", {
                        icon: 6,
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    });

                   $(this).children("a").attr('href',"#");
                }
            });


        });
    </script>
@stop
