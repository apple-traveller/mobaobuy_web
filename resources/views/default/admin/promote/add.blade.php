@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div  class="warpper">
        <div class="title"><a href="/admin/promote/list" class="s-back">返回</a>优惠活动 - 添加活动</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>标识“*”的选项为必填项，其余为选填项。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-content">
                    <div class="mian-info">
                        <form action="/admin/promote/save" method="post" name="form" id="navigator_form" novalidate="novalidate">
                            <div class="switch_info">

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;店铺：</div>
                                    <div class="label_value">
                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="shop_id" id="shop_id" >
                                            <option value="">请选择店铺</option>
                                            @foreach($shops as $vo)
                                            <option value="{{$vo['id']}}">{{$vo['shop_name']}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="shop_name" id="shop_name">
                                        <div style="margin-left: 10px;" class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;开始时间：</div>
                                    <div class="label_value">
                                        <input type="text" name="begin_time" autocomplete="off" value="" id="begin_time" size="40"  class="text">
                                        <div class="notic"></div>
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp; 结束时间：</div>
                                    <div class="label_value">
                                        <input type="text" name="end_time" autocomplete="off" value="" id="end_time" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp; 选择商品分类：</div>
                                    <div class="label_value">
                                        <input type="text" cat-id=""  autocomplete="off" value="" id="cat_name" size="40"  class="text">
                                        <div style="margin-left: 10px;" class="notic">商品分类用于辅助选择商品</div>
                                        <ul class="query_cat_name" style="overflow:auto;display:none;height:200px;position: absolute;top: 180px; background: #fff;width: 320px; box-shadow: 1px 1px 1px 1px #dedede;">

                                        </ul>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp; 选择商品：</div>
                                    <div class="label_value">
                                        <input type="text" data-packing-spac="0"  autocomplete="off"  name="goods_name" id="goods_name" size="40"  class="text">
                                        <input type="hidden" name="goods_id"  id="goods_id">
                                        <ul class="query_goods_name" style="overflow:auto;display:none;height:200px;position: absolute;top: 220px; background: #fff;width: 320px; box-shadow: 1px 1px 1px 1px #dedede;">

                                        </ul>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp; 促销价格：</div>
                                    <div class="label_value">
                                        <input type="text" name="price"  autocomplete="off" value="" id="price" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp; 促销总数量：</div>
                                    <div class="label_value">
                                        <input type="text" name="num"  autocomplete="off" value="" id="num" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                        <div class="notic">商品包装规格的整数倍，如填的不为整数倍，按照向上取整处理。</div>
                                    </div>
                                </div>


                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp; 最小起售数量：</div>
                                    <div class="label_value">
                                        <input type="text" name="min_limit"  autocomplete="off" value="" id="min_limit" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp; 最大限购数量：</div>
                                    <div class="label_value">
                                        <input type="text" name="max_limit"  autocomplete="off" value="" id="max_limit" size="40"  class="text">
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

            document.onclick=function(event){
                $(".query_cat_name").hide();
                $(".query_goods_name").hide();
            }
        });
        //选择店铺
        $("#shop_id").change(function(){
            var shop_name = $(this).find("option:selected").text();
            $("#shop_name").val(shop_name);
        });

        //商品分类获取焦点请求所有的分类数据
        $("#cat_name").focus(function(){
            $(".query_cat_name").children().filter("li").remove();
            $.ajax({
                url: "/admin/promote/getGoodsCat",
                dataType: "json",
                data:{},
                type:"POST",
                success:function(res){
                    if(res.code==200){
                        $(".query_cat_name").show();
                        var data = res.data;
                        for(var i=0;i<data.length;i++){
                            $(".query_cat_name").append('<li data-cat-id="'+data[i].id+'" class="created_cat_name" style="cursor:pointer;">'+data[i].cat_name+'</li>');
                        }
                    }
                }
            })
        });

        //点击将li标签里面的值填入input框内
        $(document).delegate(".created_cat_name","click",function(){
            var cat_name = $(this).text();
            var cat_id = $(this).attr("data-cat-id");
            $("#cat_name").val(cat_name);
            $("#cat_name").attr("cat-id",cat_id);
        });

        //根据分类里面输入的文字实时查询分类数据
        $("#cat_name").bind("input propertychange",function(res){
            var cat_name = $(this).val();
            $(".query_cat_name").children().filter("li").remove();
            $.post('/admin/promote/getGoodsCat',{'cat_name':cat_name},function(res){
                if(res.code==200){
                    $(".query_cat_name").show();
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        $(".query_cat_name").append('<li data-cat-id="'+data[i].id+'" class="created_cat_name" style="cursor:pointer;">'+data[i].cat_name+'</li>');
                    }
                }
            },"json");
        });

        //商品获取焦点请求所有的商品数据
        $("#goods_name").focus(function(){
            $(".query_goods_name").children().filter("li").remove();
            var cat_id = $("#cat_name").attr("cat-id");
            $.ajax({
                url: "/admin/promote/getGood",
                dataType: "json",
                data:{"cat_id":cat_id},
                type:"POST",
                success:function(res){
                    if(res.code==200){
                        $(".query_goods_name").show();
                        var data = res.data;
                        for(var i=0;i<data.length;i++){
                            $(".query_goods_name").append('<li data-packing-spac="'+data[i].packing_spec+'" data-goods-id="'+data[i].id+'" class="created_goods_name" style="cursor:pointer;">'+data[i].goods_name+'</li>');
                        }
                    }else{
                        $(".query_goods_name").show();
                        $(".query_goods_name").append('<li  style="cursor:pointer;">该分类下没有查询到商品</li>');
                    }
                }
            })
        });


        //点击将li标签里面的值填入input框内
        $(document).delegate(".created_goods_name","click",function(){
            $("#goods_name").siblings("div").filter(".notic").remove();
            var goods_name = $(this).text();
            var goods_id = $(this).attr("data-goods-id");
            var packing_spac = $(this).attr("data-packing-spac");
            $("#goods_name").val(goods_name);
            $("#goods_id").val(goods_id);
            $("#goods_name").attr("data-packing-spac",packing_spac);
            $("#num").attr("disabled",false);
            $("#goods_name").after('<div style="margin-left: 10px;color:red;" class="notic">包装规格为：'+packing_spac+'</div>');
        });


        //根据分类里面输入的文字实时查询商品数据
        $("#goods_name").bind("input propertychange",function(res){
            var cat_id = $("#cat_name").attr("cat-id");
            var goods_name = $("#goods_name").val();
            $(".query_goods_name").children().filter("li").remove();
            $.post('/admin/promote/getGood',{"cat_id":cat_id,"goods_name":goods_name},function(res){
                if(res.code==200){
                    $(".query_goods_name").show();
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        $(".query_goods_name").append('<li data-packing-spac="'+data[i].packing_spec+'" data-goods-id="'+data[i].id+'" class="created_goods_name" style="cursor:pointer;">'+data[i].goods_name+'</li>');
                    }
                }else{
                    $(".query_goods_name").show();
                    $(".query_goods_name").append('<li  style="cursor:pointer;">该分类下没有查询到商品</li>');
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

            //促销商品总数量
            $("#num").focus(function(){
                var packing_spec = $("#goods_name").attr("data-packing-spac");
                if(packing_spec==0){
                    layer.msg("请先选择商品", {icon: 5,time:1000});
                    $(this).attr("disabled","disabled");
                }

                $("#num").blur(function(){
                    var packing_spec = parseInt($("#goods_name").attr("data-packing-spac"));
                    var num = parseInt($(this).val());
                    if(!num){
                        $(this).val(packing_spec);
                        $("#min_limit").attr("disabled",false);//取消最小数量的限制
                        return ;
                    }
                    if(num%packing_spec!=0){
                        if(num<=packing_spec){
                            $(this).val(packing_spec);
                        }else{
                            $(this).val(Math.ceil(num/packing_spec)*packing_spec);
                        }
                    }else{
                        $(this).val(Math.ceil(num/packing_spec)*packing_spec);
                    }
                    $("#min_limit").attr("disabled",false);//取消最小数量的限制
                });

            });

            //最小起售数量
            $("#min_limit").focus(function(){
                var packing_spec = parseInt($("#goods_name").attr("data-packing-spac"));
                var num = parseInt($("#num").val());
                if(!num){
                    layer.msg("请先填写促销总数量", {icon: 5,time:1000});
                    $(this).attr("disabled","disabled");
                    return ;
                }

                $("#min_limit").blur(function(){
                    var min_limit = parseInt($(this).val());
                    if(!min_limit){
                        $(this).val(packing_spec);
                        return ;
                    }
                    console.log(min_limit+":"+num);
                    if(min_limit>num){
                        layer.msg("不能大于促销总数量", {icon: 5,time:1000});
                        $(this).val(packing_spec);
                    }else{
                        $(this).val(Math.ceil(min_limit/packing_spec)*packing_spec);
                    }
                    $("#max_limit").attr("disabled",false);//取消最大限购数量的限制
                });
            });

            //最大限购数量
            $("#max_limit").focus(function(){
                var min_limit = parseInt($("#min_limit").val());
                var packing_spec = parseInt($("#goods_name").attr("data-packing-spac"));
                var num = parseInt($("#num").val());
                if(!min_limit){
                    layer.msg("请先填写最小起售数量", {icon: 5,time:1000});
                    $(this).attr("disabled","disabled");
                    return ;
                }

                $("#max_limit").blur(function(){
                    var max_limit = parseInt($(this).val());
                    if(!max_limit){
                        $(this).val(min_limit);
                        return ;
                    }
                    if(max_limit>num){
                        layer.msg("不能大于促销总数量", {icon: 5,time:1000});
                        $(this).val(min_limit);
                    }else{
                        $(this).val(Math.ceil(max_limit/packing_spec)*packing_spec);
                    }
                });
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
                    goods_name :{
                        required : true,
                    },
                    price :{
                        required : true,
                    },
                    num :{
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
                    goods_name :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                    price :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                    num :{
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
