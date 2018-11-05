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
                    <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx。</li>
                    <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx。</li>
                    <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="/admin/invoice/save" name="theForm" id="user_update" novalidate="novalidate">

                            <div class="item">
                                <div class="label">&nbsp;买家店铺名称：</div>
                                <div class="label_value font14">{{$invoice['shop_name']}}</div>
                            </div>


                            <div class="item">
                                <div class="label">&nbsp;买家联系方式：</div>
                                <div class="label_value font14">{{$invoice['member_phone']}}</div>
                            </div>


                            <div class="item">
                                <div class="label">&nbsp;发票总金额：</div>
                                <div class="label_value font14">{{$invoice['invoice_amount']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;发票号：</div>
                                <div class="label_value font14">{{$invoice['invoice_numbers']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;商品信息：</div>
                                <div class="label_value font14">
                                    <div  class="layui-btn viewContent">点击查看</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;快递名称：</div>
                                <div class="label_value font14">{{$invoice['shipping_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;运单号：</div>
                                <div class="label_value font14">{{$invoice['shipping_billno']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;收票人：</div>
                                <div class="label_value font14">{{$invoice['consignee']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;收票地址：</div>
                                <div class="label_value font14">{{$invoice['address_str']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;邮政编码：</div>
                                <div class="label_value font14">{{$invoice['zipcode']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;联系电话：</div>
                                <div class="label_value font14">{{$invoice['mobile_phone']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;发票类型：</div>
                                <div class="label_value font14">
                                    @if($invoice['invoice_type']==1)
                                    @else 普票
                                    @endif 专票
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;公司抬头：</div>
                                <div class="label_value font14">{{$invoice['company_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;税号：</div>
                                <div class="label_value font14">{{$invoice['tax_id']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;开户银行：</div>
                                <div class="label_value font14">{{$invoice['bank_of_deposit']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;银行账号：</div>
                                <div class="label_value font14">{{$invoice['bank_account']}}</div>
                            </div>


                            <div class="item">
                                <div class="label">&nbsp;开票地址：</div>
                                <div class="label_value font14">{{$invoice['company_address']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;开票电话：</div>
                                <div class="label_value font14">{{$invoice['company_telephone']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;创建时间：</div>
                                <div class="label_value font14">{{$invoice['created_at']}}</div>
                            </div>



                            <div class="item">
                                <div class="label">&nbsp;申请状态：</div>
                                <div class="label_value font14">
                                    <div data-status="2" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($invoice['status']==2) @else layui-btn-primary @endif '>已开票</div>
                                    <div data-status="1" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($invoice['status']==1) @else layui-btn-primary @endif '>待开票</div>
                                    <div data-status="0" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($invoice['status']==0) @else layui-btn-primary @endif '>已取消</div>
                                    <span style="margin-left: 20px;color:red;" class="notice">点击修改申请状态</span>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        layui.use(['layer'], function() {
            var layer = layui.layer;

            $(".review_status").click(function () {
                var review_content = $.trim($("#review_content").val());

                var postData = {
                    "id": "{{$invoice['id']}}",
                    "status": $(this).attr("data-status"),
                };
                $.post('/admin/invoice/save', postData, function (res) {
                    if (res.code == 1){
                        layer.msg(res.msg,{
                            icon: 1,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        },function(){
                            window.location.href="/admin/invoice/detail?id={{$invoice['id']}}&currpage={{$currpage}}&status={{$status}}";
                        });
                    } else {
                        layer.msg(res.msg);
                    }
                }, "json");
            });

            $(".viewContent").click(function(){
                index = layer.open({
                    type: 2,
                    title: '商品详情',
                    area: ['900px', '500px'],
                    content: "{{url('/admin/invoice/goods/list')}}?invoice_id={{$invoice['id']}}&currpage={{$currpage}}&status={{$status}}"
                });
            });

        });
    </script>
@stop
