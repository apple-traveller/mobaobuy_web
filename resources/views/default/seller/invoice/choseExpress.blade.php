@extends(themePath('.')."seller.include.layouts.master")
    @section('content')
    <div style="width: 580px;height: 230px">
        <div style="width: 580px;height: 230px">
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/seller/invoice/verifyInvoice" method="post" enctype="multipart/form-data" name="theForm" id="address_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;width: 407px">


                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;快递公司：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;margin-right:10px;" name="shipping_id" id="shipping_id">
                                        <option value="">请选择快递公司</option>
                                        @foreach($shipPings as $vo)
                                            <option value="{{$vo['id']}}">{{$vo['shipping_name']}}</option>
                                        @endforeach
                                    </select>
                                    <input id="shipping_name" type="hidden" name="shipping_name" value="">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;运单号：</div>
                                <div class="label_value">
                                    <input type="text" name="shipping_billno" class="text" value="" maxlength="40" autocomplete="off" id="shipping_billno">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>
                            <input type="hidden" name="invoice_id" value="{{$invoice_id}}">
                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
                                    <input type="button" value="确定" class="button" id="submitBtn">
                                    <input type="reset" value="重置" class="button button_reset">
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    @endsection
@section('script')
    <script>
        layui.use(['layer','table'], function() {
            var layer = layui.layer;
            var table = layui.table;

            $(document).ready(function(){
                var shipping_name = $("#shipping_id").find("option:selected").text();
                $("#shipping_name").val(shipping_name);
            });

            table.render({
                id: 'idTest'
            });

            var checkStatus = table.checkStatus('idTest'); //test即为基础参数id对应的值
            $("#article_form").submit(function(e){
                var data = table.checkStatus('idTest');
                $(".send_number_delivery").val(JSON.stringify(data.data));
            });

            $("#shipping_id").on("change",function(){
                var shipping_name = $(this).find("option:selected").text();
                $("#shipping_name").val(shipping_name);
            });


        });


        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                   let data =   $('form').serializeArray();
                   $.ajax({
                       url: '/seller/invoice/verifyInvoice',
                       data: data,
                       type: 'post',
                       success:function (res) {
                           if (res.msg == 1) {
                               layer.msg(res.msg);
                               let index = parent.layer.getFrameIndex(window.name);
                               // setTimeout(parent.layer.close(index),2000);
                           } else {
                               layer.msg(res.msg);
                               let index = parent.layer.getFrameIndex(window.name);
                               // setTimeout(parent.layer.close(index),2000);
                           }
                       }
                   });
            });

            $('#article_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                ignore : [],
                rules:{
                    shipping_id :{
                        required : true,
                        number:true
                    },
                    shipping_billno:{
                        required : true,
                    },
                },
                messages:{
                    shipping_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字'
                    },
                    shipping_billno :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    }
                }
            });
        });
    </script>
    @endsection
