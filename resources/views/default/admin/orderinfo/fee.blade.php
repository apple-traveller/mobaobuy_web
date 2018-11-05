@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">订单 - 编辑订单</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li></li>
                    <li></li>
                </ul>
            </div>
            <div class="flexilist mt30">
                <div class="common-content">
                    <form name="theForm" action="/admin/orderinfo/saveFee" method="post">
                        <div class="step order_total">
                            <div class="step_title pb5">
                                <i class="ui-step"></i>
                                <h3 class="fl">费用信息</h3>
                            </div>
                            <div class="section" style="overflow:inherit">
                                <dl>
                                    <dt>商品总金额：</dt>
                                    <dd>
                                        &nbsp;&nbsp;<em>¥</em>{{$feeInfo['goods_amount']}}
                                    </dd>
                                </dl>
                                <input type="hidden" name="id" value="{{$id}}">
                                <input type="hidden" name="currpage" value="{{$currpage}}">
                                <input type="hidden" name="order_status" value="{{$order_status}}">
                                <dl>
                                    <dt>配送费用：</dt>
                                    <dd>
                                        <input name="shipping_fee" class="text w80 fn" type="text" value="{{$feeInfo['shipping_fee']}}" autocomplete="off" size="15">
                                    </dd>
                                </dl>

                                <dl>
                                    <dt>折扣：</dt>
                                    <dd>- <input name="discount" type="text" class="text w80 fn" id="discount" value="{{$feeInfo['discount']}}" size="15" autocomplete="off"></dd>
                                </dl>

                                <dl>
                                    <dt>已支付费用：</dt>
                                    <dd>&nbsp;&nbsp;{{$feeInfo['money_paid']}}</dd>
                                </dl>


                                <dl>
                                    <dt>订单总金额：</dt>
                                    <dd class="red">
                                        <em>¥</em>{{$feeInfo['order_amount']}}
                                    </dd>
                                    <dt> 应付款金额： </dt>
                                    <dd class="red">
                                        = <em>¥</em>{{$feeInfo['order_amount']-$feeInfo['money_paid']}}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="goods_btn">
                            <input type="submit"  class="btn btn35 blue_btn" value="完成">
                            <input type="button" value="取消" class="btn btn35 btn_blue" onclick="location.href='/admin/orderinfo/detail?id={{$id}}&currpage={{$currpage}}&order_status={{$order_status}}'">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@stop
