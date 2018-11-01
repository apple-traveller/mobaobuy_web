@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/promote/list?currpage={{$currpage}}" class="s-back">返回</a>优惠活动 - 编辑活动</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx。</li>
                    <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx。</li>
                    <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-content">
                    <div class="mian-info">
                        <form action="/admin/promote/save" method="post" name="form" id="navigator_form" novalidate="novalidate">
                            <div class="switch_info">
                                <input type="hidden" name="id" value="{{$promote['id']}}"/>
                                <input type="hidden" name="add_time" value="{{$promote['add_time']}}"/>
                                <input type="hidden" name="currpage" value="{{$currpage}}"/>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>店铺：</div>
                                    <div class="label_value">
                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="shop_id" id="shop_id" >
                                            <option value="">请选择店铺</option>
                                            @foreach($shops as $vo)
                                            <option @if($promote['shop_id']==$vo['id']) selected @endif value="{{$vo['id']}}">{{$vo['shop_name']}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="shop_name" value="{{$promote['shop_name']}}" id="shop_name">
                                        <div style="margin-left: 10px;" class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>开始时间：</div>
                                    <div class="label_value">
                                        <input type="text" name="begin_time" value="{{$promote['begin_time']}}" id="begin_time" size="40"  class="text">
                                        <div class="notic"></div>
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>结束时间：</div>
                                    <div class="label_value">
                                        <input type="text" name="end_time" value="{{$promote['end_time']}}" id="end_time" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;选择商品分类：</div>
                                    <div class="label_value">
                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" class="cat_id" id="cat_id" >
                                            <option value="0">请选择分类</option>
                                            @foreach($goodsCatTree as $vo)
                                                <option  value="{{$vo['id']}}">|<?php echo str_repeat('-->',$vo['level']).$vo['cat_name'];?></option>
                                            @endforeach
                                        </select>
                                        <div class="form_prompt"></div>
                                        <div style="margin-left: 10px;" class="notic">商品分类用于辅助选择商品</div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;选择商品：</div>
                                    <div class="label_value">
                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" class="goods_id" name="goods_id" id="goods_id">
                                            <option value="">请选择商品</option>
                                            @foreach($goods as $vo)
                                                <option @if($promote['goods_id']==$vo['id']) selected @endif  value="{{$vo['id']}}">{{$vo['goods_name']}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="goods_name" value="{{$promote['goods_name']}}"  id="goods_name">
                                        <div style="margin-left: 10px;" class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>促销价格：</div>
                                    <div class="label_value">
                                        <input type="text" name="price" value="{{$promote['price']}}" id="price" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>促销总数量：</div>
                                    <div class="label_value">
                                        <input type="text" name="num" value="{{$promote['num']}}" id="num" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>当前可售数量：</div>
                                    <div class="label_value">
                                        <input type="text" name="available_quantity" value="{{$promote['available_quantity']}}" id="available_quantity" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>最小起售数量：</div>
                                    <div class="label_value">
                                        <input type="text" name="min_limit" value="{{$promote['min_limit']}}" id="min_limit" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>最大限购数量：</div>
                                    <div class="label_value">
                                        <input type="text" name="max_limit" value="{{$promote['max_limit']}}" id="max_limit" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                        <div class="notic">0-不限</div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label">&nbsp;</div>
                                    <div class="label_value info_btn">
                                        <input type="submit" class="button"  value=" 确定 " id="submitBtn">
                                        <input type="reset"  class="button button_reset" value=" 重置 " >
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            var shop_name = $("#shop_id").find("option:selected").text();
            $("#shop_name").val(shop_name);

            var goods_name = $("#goods_id").find("option:selected").text();
            $("#goods_name").val(goods_name);
        });
        $("#shop_id").change(function(){
            var shop_name = $(this).find("option:selected").text();
            $("#shop_name").val(shop_name);
        });

        $("#goods_id").change(function(){
            var goods_name = $(this).find("option:selected").text();
            $("#goods_name").val(goods_name);
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
                    $(".goods_id").append('<option value="">该分类下没有商品</option>');
                }
            },"json");
        });


        layui.use(['laydate','layer'], function() {
            var laydate = layui.laydate;
            var layer = layui.layer;
            var index;

            laydate.render({
                elem: '#begin_time' //指定元素
                , type: 'datetime'
            });

            laydate.render({
                elem: '#end_time' //指定元素
                , type: 'datetime'
            });

        });

        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#navigator_form").valid()){
                    $("#navigator_form").submit();
                }
            });

            $('#navigator_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                rules:{
                    shop_id :{
                        required : true,
                    },
                    begin_time :{
                        required : true
                    },
                    end_time:{
                        required : true,
                    },
                    cat_id :{
                        required : true,
                    },
                    goods_id :{
                        required : true,
                    },
                    price :{
                        required : true,
                    },
                    num :{
                        required : true,
                    },
                    available_quantity :{
                        required : true,
                    },
                    min_limit :{
                        required : true,
                    },
                    max_limit :{
                        required : true,
                    }
                },
                messages:{
                    shop_id:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    begin_time :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    end_time :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                    cat_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                    goods_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                    price :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                    num :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                    available_quantity :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                    min_limit :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                    max_limit :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                }
            });
        });
    </script>

@stop
