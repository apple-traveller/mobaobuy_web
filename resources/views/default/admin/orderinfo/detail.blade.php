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
                                    <dt>购货人： <div class="div_a"><a href="javascript:;" ectype="orderDialog" data-dialog="userinfo">信息</a><i class="shu"></i><a href="user_msg.php?act=add&amp;order_id=4&amp;user_id=62">留言</a></div></dt>
                                    <dd>{{$user['nick_name']}}</dd>
                                    <dt>订单状态：</dt>
                                    <dd>
                                        @if($orderInfo['pay_status']==0)待付款
                                        @elseif($orderInfo['pay_status']==1)已付款
                                        @else部分付款
                                        @endif

                                        @if($orderInfo['shipping_status']==0)待发货
                                        @elseif($orderInfo['shipping_status']==1)已发货
                                        @elseif($orderInfo['shipping_status']==2)部分发货
                                        @endif
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>支付方式：<a href="order.php?act=edit&amp;order_id=4&amp;step=payment"><i class="icon icon-edit"></i></a></dt>
                                    <dd>银行汇款/转帐</dd>
                                    <dt>配送方式：<a href="order.php?act=edit&amp;order_id=4&amp;step=shipping"><i class="icon icon-edit"></i></a></dt>
                                    <dd>
                                        <font id="shipping_name">申通快递</font>                                        <a href="order.php?act=info&amp;order_id=4&amp;shipping_print=1" target="_blank">打印快递单</a>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>下单时间：</dt>
                                    <dd>2018-09-25 16:13:11</dd>
                                    <dt>付款时间：</dt>
                                    <dd>未付款</dd>
                                </dl>
                                <dl>
                                    <dt>发货时间：</dt>
                                    <dd>未发货</dd>
                                    <dt>发货单号：<a href="order.php?act=edit&amp;order_id=4&amp;step=shipping"><i class="icon icon-edit"></i></a></dt>
                                    <dd>
                                        未发货                                                                        </dd>
                                </dl>
                                <dl>
                                    <dt>自动确认收货时间：</dt>
                                    <dd>
                                        <div class="editSpanInput" ectype="editSpanInput">
                                            <span onclick="listTable.edit(this, 'edit_auto_delivery_time', 4)">15</span>
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
                            <div class="step_title"><i class="ui-step"></i><h3>收货人信息<a href="order.php?act=edit&amp;order_id=4&amp;step=consignee"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="section">
                                <dl>
                                    <dt>收货人：</dt>
                                    <dd>测试地址一</dd>
                                    <dt>电子邮件：</dt>
                                    <dd>无</dd>
                                </dl>
                                <dl>
                                    <dt>手机号码：</dt>
                                    <dd>18616704223</dd>
                                    <dt>电话号码：</dt>
                                    <dd>无</dd>
                                </dl>
                                <dl>
                                    <dt>送货时间：</dt>
                                    <dd>无</dd>
                                    <dt>地址别名：</dt>
                                    <dd>无</dd>
                                </dl>
                                <dl style="width:50%">
                                    <dt>收货地址：</dt>
                                    <dd>[上海  上海  长宁区  ] aaaa</dd>
                                    <dt>邮政编码：</dt>
                                    <dd>无</dd>
                                </dl>
                            </div>
                        </div>
                        <!-- 门店信息 -->
                        <!--订单其他信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>其他信息<a href="order.php?act=edit&amp;order_id=4&amp;step=other"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="section">
                                <dl>
                                    <dt>发票抬头：(个人普通发票)</dt>
                                    <dd>个人</dd>
                                    <dt>发票内容：</dt>
                                    <dd>明细</dd>
                                </dl>
                                <dl>
                                    <dt>缺货处理：</dt>
                                    <dd>等待所有商品备齐后再发</dd>
                                    <dt>识别码：</dt>
                                    <dd>无</dd>
                                </dl>

                                <dl style="width:66.6%">
                                    <dt>卖家留言：</dt>
                                    <dd>无</dd>
                                    <dt>买家留言：</dt>
                                    <dd>无</dd>
                                </dl>
                            </div>
                        </div>

                        <!--商品信息-->
                        <div class="step">
                            <div class="step_title"><i class="ui-step"></i><h3>商品信息<a href="order.php?act=edit&amp;order_id=4&amp;step=goods"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="step_info">
                                <div class="order_goods_fr">
                                    <table class="table" border="0" cellpadding="0" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th width="25%" class="first">商品名称 [ 品牌 ]</th>
                                            <th width="8%">仓库名称</th>
                                            <th width="7%">货号</th>
                                            <th width="7%">条形码</th>
                                            <th width="7%">货品号</th>
                                            <th width="6%">价格</th>
                                            <th width="5%">商品赠送积分</th>
                                            <th width="5%">数量</th>
                                            <th width="8%">属性</th>
                                            <th width="5%">库存</th>
                                            <th width="8%">小计</th>
                                            <th width="7%">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="order_goods_div">
                                                    <div class="img">
                                                        <a href="../seckill.php?act=view&amp;id=55" target="_blank"><img src="http://192.168.40.14:3731/images/201703/thumb_img/0_thumb_G_1490205156678.jpg" width="72" height="72"></a>
                                                    </div>
                                                    <div class="name ml10">
                                                        <a href="../seckill.php?id=55&amp;act=view" target="_blank">闽豹家用工具套装 五金工具箱 电工木工德国维修工具组套修理组合 质量稳定 坚固耐用 彩套包装 可团购定制</a>

                                                    </div>
                                                </div>
                                            </td>
                                            <td>上海仓库</td>
                                            <td>ECS000829</td>
                                            <td></td>
                                            <td></td>
                                            <td><em>¥</em>534.00</td>
                                            <td>0</td>
                                            <td>1</td>
                                            <td></td>
                                            <td>1000</td>
                                            <td>
                                                <em>¥</em>534.00                                                                                                    </td>
                                            <td>

                                                <!--生成发货单-->
                                                <input name="part_ship" type="button" value="生成发货单" class="btn btn25 blue_btn" data-rec_id="4">

                                                <!--发货状态-->
                                                <p class="red">已发0件</p>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="12">
                                                <div class="order_total_fr">
                                                    <strong>合计：</strong>
                                                    <span class="red"><em>¥</em>534.00</span>
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
                            <div class="step_title"><i class="ui-step"></i><h3>费用信息<a href="order.php?act=edit&amp;order_id=4&amp;step=money"><i class="icon icon-edit"></i></a></h3></div>
                            <div class="section">
                                <dl>
                                    <dt>商品总金额：</dt>
                                    <dd><em>¥</em>534.00</dd>
                                    <dt>使用余额：</dt>
                                    <dd>- <em>¥</em>0.00</dd>
                                </dl>
                                <dl>
                                    <dt>发票税额：</dt>
                                    <dd>+ <em>¥</em>0.00</dd>
                                    <dt>使用积分：</dt>
                                    <dd>- <em>¥</em>0.00</dd>
                                </dl>
                                <dl>
                                    <dt>配送费用：</dt>
                                    <dd>+ <em>¥</em>3.00</dd>
                                    <dt>使用红包：</dt>
                                    <dd>- <em>¥</em>0.00</dd>
                                </dl>
                                <dl>
                                    <dt>支付费用：</dt>
                                    <dd>+ <em>¥</em>0.00</dd>
                                    <dt>使用优惠券：</dt>
                                    <dd>- <em>¥</em>0.00</dd>
                                </dl>
                                <dl>
                                    <dt>折扣：</dt>
                                    <dd>- <em>¥</em>0.00</dd>
                                    <dt>使用储值卡：</dt>
                                    <dd>- <em>¥</em>0.00</dd>
                                </dl>
                                <dl>
                                    <dt></dt>
                                    <dd></dd>

                                    <dt>已付款金额：</dt>
                                    <dd>- <em>¥</em>0.00</dd>
                                </dl>
                                <dl>
                                    <dt>订单总金额：</dt>
                                    <dd class="red"><em>¥</em>537.00</dd>
                                    <dt>应付款金额：</dt>
                                    <dd class="red"><em>¥</em>537.00</dd>
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
                                            <div class="bf100 fl"><textarea name="action_note" class="textarea"></textarea></div>
                                            <div class="order_operation_btn">

                                                <input name="pay" type="submit" value="付款" class="btn btn25 red_btn">











                                                <input name="cancel" type="submit" value="取消" class="btn btn25 red_btn">


                                                <input name="invalid" type="submit" value="无效" class="btn btn25 red_btn">




                                                <input name="after_service" type="submit" value="售后" class="btn btn25 red_btn">                                                                                                                                                <input name="order_id" type="hidden" value="4">
                                                <!--门店列表 start-->
                                                <!--门店列表 end-->
                                                <input type="button" value="打印订单" class="btn btn25 blue_btn" onclick="javascript:window.open('tp_api.php?act=order_print&amp;order_id=4')">
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
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>admin</td>
                                            <td>2018-10-09 08:46:28</td>
                                            <td>已确认</td>
                                            <td>未付款</td>
                                            <td>未发货</td>
                                            <td>23</td>
                                        </tr>
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
@stop
