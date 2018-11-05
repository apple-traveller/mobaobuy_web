@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">订单 - 编辑订单</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>标识“<em>*</em>”的选项为必填项，其余为选填项。</li>
                    <li>添加订单流程为：选择商城已有会员-选择商品加入订单-确认订单金额-填写收货信息-添加配送方式-选择支付方式-添加发票-查看费用信息-完成。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form name="theForm" action="/admin/orderinfo/saveInvoice" method="post" id="consignee" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <div class="step_title pb5">
                                <i class="ui-step"></i>
                                <h3 class="fl">请编辑开票信息</h3>
                            </div>


                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>公司抬头：</div>
                                    <div class="label_value">
                                        <input type="text" name="company_name" value="{{$invoiceInfo['company_name']}}" id="company_name" class="text" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>税号：</div>
                                    <div class="label_value">
                                        <input type="text" name="tax_id" id="tax_id" value="{{$invoiceInfo['tax_id']}}" class="text" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>开户银行：</div>
                                    <div class="label_value">
                                        <input type="text" name="bank_of_deposit" id="bank_of_deposit" value="{{$invoiceInfo['bank_of_deposit']}}" class="text" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>银行账号：</div>
                                    <div class="label_value">
                                        <input type="text" name="bank_account" id="bank_account" value="{{$invoiceInfo['bank_account']}}" class="text" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>开票地址：</div>
                                    <div class="label_value">
                                        <input type="text" name="company_address" id="company_address" value="{{$invoiceInfo['company_address']}}" class="text" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>开票电话：</div>
                                    <div class="label_value">
                                        <input type="text" name="company_telephone" id="company_telephone" value="{{$invoiceInfo['company_telephone']}}" class="text" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>收票人：</div>
                                <div class="label_value">
                                    <input type="text" name="consignee_name" id="consignee_name" value="{{$invoiceInfo['consignee_name']}}" class="text" autocomplete="off">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>收票人电话：</div>
                                <div class="label_value">
                                    <input type="text" name="consignee_mobile_phone" id="consignee_mobile_phone" value="{{$invoiceInfo['consignee_mobile_phone']}}" class="text" autocomplete="off">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>



                                <input type="hidden" name="id" value="{{$invoiceInfo['id']}}">
                                <input type="hidden" name="currpage" value="{{$currpage}}">
                                <input type="hidden" name="order_id" value="{{$id}}">


                            </div>

                        <div style="margin-top:-42px;margin-right:166px;" class="goods_btn">
                            <input type="button" value="取消" class="btn btn35 btn_blue" onclick="location.href='/admin/orderinfo/detail?id={{$id}}&currpage={{$currpage}}&order_status={{$order_status}}'">
                            <input  type="submit" class="btn btn35 blue_btn" value=" 确定 " id="submitBtn">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop
