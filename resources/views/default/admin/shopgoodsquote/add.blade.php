@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/shopgoodsquote/list" class="s-back">返回</a>店铺 - 添加产品报价</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/shopgoodsquote/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择店铺：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="shop_id" id="shop_id">
                                        <option value="">请选择店铺</option>
                                        @foreach($shops as $vo)
                                        <option  value="{{$vo['id']}}">{{$vo['shop_name']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择产品：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" class="cat_id" >
                                        <option value="0">请选择分类</option>
                                        @foreach($goodsCatTree as $vo)
                                            <option  value="{{$vo['id']}}">|<?php echo str_repeat('-->',$vo['level']).$vo['cat_name'];?></option>
                                        @endforeach
                                    </select>
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;margin-left: 20px;" class="goods_id" name="goods_id" id="goods_id">
                                        <option value="">请选择产品</option>
                                        @foreach($goods as $vo)
                                            <option  value="{{$vo['id']}}">{{$vo['goods_name']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form_prompt"></div>
                                    <div class="notic">分类用于辅助选择产品</div>
                                </div>

                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;产品库存数量：</div>
                                <div class="label_value">
                                    <input type="text" name="goods_number" class="text" value="" maxlength="40" autocomplete="off" id="goods_number">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货地：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_place" class="text" value="" maxlength="40" autocomplete="off" id="delivery_place">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;截止时间：</div>
                                <div class="label_value">
                                    <input type="text" name="expiry_time" id="expiry_time" class="layui-input text" maxlength="40" >
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;店铺售价：</div>
                                <div class="label_value">
                                    <input type="text" name="shop_price" class="text" value="" maxlength="40" autocomplete="off" id="shop_price">
                                    <div class="form_prompt"></div>
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

    <script type="text/javascript">

        //时间选择器
        layui.use('laydate', function(){
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#expiry_time' //指定元素
                ,type: 'datetime'
            });
        });


        $(".cat_id").change(function(res){
            $(".goods_id").children('option').remove();
            var cat_id = $(this).val();
            $.post('/admin/shopgoods/getGoods',{'cat_id':cat_id},function(res){
                if(res.code==200){
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        $(".goods_id").append('<option value="'+data[i]['id']+'">'+data[i]['goods_name']+'</option>');
                    }
                }else{
                    $(".goods_id").append('<option value="">该分类下没有产品</option>');
                }
            },"json");
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
                    shop_id:{
                        required : true,
                    },
                    shop_price :{
                        required : true,
                    },
                    goods_number :{
                        required : true,
                        number:true
                    },
                    goods_id:{
                        required : true,
                    },
                    delivery_place:{
                        required:true,
                    },
                    expiry_time:{
                        required:true,
                    }
                },
                messages:{
                    shop_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    shop_price:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    goods_number :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字',
                    },
                    goods_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    delivery_place :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    expiry_time :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },

                }
            });
        });
    </script>


@stop