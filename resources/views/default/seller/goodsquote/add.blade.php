@extends(themePath('.')."seller.include.layouts.master")
@section('styles')
    <style>
        [class^="icon-"], [class*=" icon-"] {
            line-height: 23px;
        }
    </style>
@endsection
@section('body')
    @include('partials.base_header')
    <script src="{{asset(themePath('/').'js/jquery.validation.min.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/jquery.cookie.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/dsc_admin2.0.js')}}" ></script>
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/layui/css/layui.css')}}" />
    <link rel="stylesheet" type="text/css" href="/ui/area/1.0.0/area.css" />
    <script type="text/javascript" src="/ui/area/1.0.0/area.js"></script>
    <div class="warpper">
        <div class="title"><a href="/seller/quote/list" class="s-back">返回</a>店铺 - 添加商品报价</div>
        <div class="content">
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/seller/quote/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商品：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" class="cat_id" >
                                        <option value="0">请选择分类</option>
                                        @foreach($goodsCatTree as $vo)
                                            <option  value="{{$vo['id']}}">|<?php echo str_repeat('-->',$vo['level']).$vo['cat_name'];?></option>
                                        @endforeach
                                    </select>
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;margin-left: 20px;" class="goods_id" name="goods_id" id="goods_id">
                                        <option value="">请选择商品</option>
                                        @foreach($goods as $vo)
                                            <option  value="{{$vo['id']}}">{{$vo['goods_name']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form_prompt"></div>
                                    <div class="notic">分类用于辅助选择商品</div>
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
                                    <div class="ui-area fl" data-value-name="area1" data-value-id="area2"  data-init-name="" style="width: 321px;height:33px;" id="test">
                                    </div>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;生产日期：</div>
                                <div class="label_value">
                                    <input type="text" name="production_date" id="production_date" class="layui-input text" maxlength="40" >
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
                                <div class="label"><span class="require-field">*</span>&nbsp;业务员：</div>
                                <div class="label_value">
                                    <input type="text" name="salesman" id="salesman" class=" text" maxlength="10" autocomplete="off">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;联系方式：</div>
                                <div class="label_value">
                                    <input type="text" name="contact_info" id="contact_info" class=" text" maxlength="40" autocomplete="off" >
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
        $(".cat_id").change(function(res){
            $(".goods_id").children('option').remove();
            var cat_id = $(this).val();
            $.post('/seller/goods/getGoods',{'cat_id':cat_id},function(res){
                if(res.code==200){
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        if (i==0){
                            $(".goods_id").append('<option selected value="'+data[i]['id']+'" data-num="'+data[i]['packing_spec']+'">'+data[i]['goods_name']+'</option>');
                            $("#min_limit").val(data[i]['packing_spec']);
                        } else {
                            $(".goods_id").append('<option value="'+data[i]['id']+'" data-num="'+data[i]['packing_spec']+'">'+data[i]['goods_name']+'</option>');
                            $("#min_limit").val(data[i]['packing_spec']);
                        }
                    }
                }else{
                    $(".goods_id").append('<option value="">该分类下没有商品</option>');
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
