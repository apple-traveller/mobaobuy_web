@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    @include('partials.base_header')
    <script src="{{asset(themePath('/').'js/jquery.validation.min.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/jquery.cookie.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/dsc_admin2.0.js')}}" ></script>
    <link rel="stylesheet" type="text/css" href="/ui/area/1.0.0/area.css" />
    <script type="text/javascript" src="/ui/area/1.0.0/area.js"></script>
    <div class="warpper">
        <div class="title"><a href="/admin/shopgoodsquote/list" class="s-back">返回</a>店铺 - 添加商品报价</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>标识“*”的选项为必填项，其余为选填项。</li>
                </ul>
            </div>
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
                                    <div style="margin-left: 10px" class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;业务员姓名：</div>
                                <div class="label_value">
                                    <input type="text" name="salesman" class="text" value="" maxlength="40" autocomplete="off" id="salesman">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;业务员电话号码：</div>
                                <div class="label_value">
                                    <input type="text" name="contact_info" class="text" value="" maxlength="40" autocomplete="off" id="contact_info">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;QQ号：</div>
                                <div class="label_value">
                                    <input type="text" name="QQ" class="text" value="" maxlength="40" autocomplete="off" id="QQ">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;商品分类：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;"  class="cat_id" >
                                        <option value="0">请选择分类</option>
                                        @foreach($goodsCatTree as $vo)
                                            <option  value="{{$vo['id']}}">|<?php echo str_repeat('-->',$vo['level']).$vo['cat_name'];?></option>
                                        @endforeach
                                    </select>
                                    <div class="form_prompt"></div>
                                    <div style="margin-left: 10px" class="notic">分类用于辅助选择商品</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商品：</div>
                                <div class="label_value">
                                    <select  style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" class="goods_id" name="goods_id" id="goods_id">
                                        <option value="">请选择商品</option>
                                        @foreach($goods as $vo)
                                            <option data-extra="{{$vo['packing_spec']}}" value="{{$vo['id']}}">{{$vo['goods_name']}}</option>
                                        @endforeach
                                    </select>
                                    <div style="margin-left: 10px" class="form_prompt"></div>

                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;商品库存数量：</div>
                                <div class="label_value">
                                    <input type="text" name="goods_number" class="text" value="" maxlength="40" autocomplete="off" id="goods_number">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货地：</div>
                                <div class="label_value">
                                    <input type="text" readonly="readonly" id="area1" name="delivery_place" value="" style="display: none"/>
                                    <input type="text" readonly="readonly" id="area2" name="place_id" value="" style="display: none"/>
                                    <div class="ui-area fl" data-value-name="area1" data-value-id="area2" data-init-name="" style="width: 321px;height:33px;" id="test">
                                    </div>
                                    <div style="margin-left: 10px" class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;生产日期：</div>
                                <div class="label_value">
                                    <input type="text" name="production_date" class="text" value="" maxlength="40" autocomplete="off" id="production_date">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;截止时间：</div>
                                <div class="label_value">
                                    <input type="text" name="expiry_time" class="text" value="" maxlength="40" autocomplete="off" id="expiry_time">
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

        layui.use(['laydate'], function() {
            var laydate = layui.laydate;
            var index;

            laydate.render({
                elem: '#expiry_time' //指定元素
                , type: 'datetime'
            });

        });
        $(".cat_id").change(function(){
            $(".goods_id").children('option').remove();
            var cat_id = $(this).val();
            $.post('/admin/shopgoodsquote/getGoods',{'cat_id':cat_id},function(res){
                if(res.code==200){
                    var data = res.data;
                    $(".goods_id").append('<option value="">请选择商品</option>');
                    for(var i=0;i<data.length;i++){
                        $(".goods_id").append('<option data-extra="'+data[i]['packing_spec']+'" value="'+data[i]['id' ]+'">'+data[i]['goods_name']+'</option>');
                    }
                }else{
                    $(".goods_id").append('<option value="">该分类下没有商品</option>');
                }
            },"json");
        });

        $("#goods_id").change(function(){
            var packing_spec = $(this).find("option:selected").attr("data-extra");
            $(this).siblings("span").remove();
            $(this).after('<span id="packing_spec" data="'+packing_spec+'" style="margin-left: 20px;color:red;">产品规格为：'+packing_spec+'</span>');
            $("#goods_number").after('<span style="margin-left: 10px;color:red;">库存数量只能是产品规格的整数倍</span>');
        });

        layui.use(['layer'], function(){
            var layer = layui.layer;

            $("#goods_number").blur(function(){
                var goods_number = $(this).val();
                var packing_spec = $("#packing_spec").attr("data");
                var goods_id = $("#goods_id").val();
                console.log(goods_id);
                if(!goods_id){
                    alert("请先选择商品");
                    $(this).val("");
                    return ;
                }
                if(!goods_number){
                    $(this).val(packing_spec);
                    return ;
                }
                $(this).val(Math.ceil(goods_number/packing_spec)*packing_spec);
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
                    },
                    production_date:{
                        required:true,
                    },
                    contact_info:{
                        required:true,
                    },
                    salesman:{
                        required:true,
                    },
                    QQ:{
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
                    production_date :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    contact_info :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    salesman:{
                        required :'<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    QQ:{
                        required :'<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                }
            });
        });
    </script>


@stop
