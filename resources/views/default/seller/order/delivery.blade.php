@extends(themePath('.')."seller.include.layouts.master")
@section('body')

    <div class="warpper">
        <div class="title"><a href="/seller/order/detail?id={{$id}}&currentPage={{$currentPage}}" class="s-back">返回</a>发货单 - 添加发货单</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/seller/order/saveDelivery" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">


                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;快递公司：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;margin-right:10px;" name="shipping_id" id="shipping_id">
                                        <option value="">请选择快递公司</option>
                                        @foreach($shippings as $vo)
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
                            <input type="hidden" name="order_id" value="{{$id}}">
                            <input class="send_number_delivery" type="hidden" name="send_number_delivery">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商品信息：</div>
                                <div class="label_value">
                                    <div class="list-div" id="listDiv">

                                        <table class="layui-table" lay-data="{ url:'/seller/order/orderGoods', page:false, id:'idTest',method:'post',where:{'order_id':'{{$id}}'}}" lay-filter="test">
                                            <thead>
                                            <tr>
                                                <th lay-data="{type:'checkbox',LAY_CHECKED:true}"></th>
                                                <th lay-data="{field:'goods_name'}">商品名称</th>

                                                <th lay-data="{field:'goods_sn'}">商品编码</th>
                                                <th lay-data="{field:'goods_price'}">价格</th>
                                                <th lay-data="{field:'goods_number'}">购买数量</th>
                                                <th lay-data="{field:'send_number'}">已发货数量</th>
                                                <th class="send_name" lay-data="{field:'send_number_delivery',edit: 'text',style:'background-color: #183cb53b; opacity: 0.6;'}">编辑发货数量</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
                                    <input type="submit" value="确定" class="button" id="submitBtn">
                                    <input type="reset" value="重置" class="button button_reset">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                if($("#article_form").valid()){
                    $("#article_form").submit();
                }
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
                    },
                }
            });
        });
    </script>
@stop
