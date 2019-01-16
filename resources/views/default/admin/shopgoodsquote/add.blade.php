@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    @include('partials.base_header')
    <script src="{{asset(themePath('/').'js/jquery.validation.min.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/jquery.cookie.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/dsc_admin2.0.js')}}" ></script>
    <link rel="stylesheet" type="text/css" href="/ui/area/1.0.0/area.css" />
    <script type="text/javascript" src="/ui/area/1.0.0/area.js"></script>

    <script src="{{asset(themePath('/').'plugs/zTree_v3/js/jquery.ztree.core.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/create_cat_tree.js')}}" ></script>
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/zTree_v3/css/zTreeStyle/zTreeStyle.css')}}" />
    <div class="menuContent" style="display:none; position: absolute;">
        <ul id="setCatTree" class="ztree treeSelect" style="margin-top:0;border: 1px solid #617775;background:#f0f6e4;width: 309px;height: 360px;overflow-y: scroll;overflow-x: auto;"></ul>
        {{--<ul id="setAreaTree" class="ztree treeSelect" style="margin-top:0;border: 1px solid #617775;background:#f0f6e4;width: 309px;height: 360px;overflow-y: scroll;overflow-x: auto;"></ul>--}}
    </div>
    <div class="menuContent" style="display:none; position: absolute;">
        {{--<ul id="setCatTree" class="ztree treeSelect" style="margin-top:0;border: 1px solid #617775;background:#f0f6e4;width: 309px;height: 360px;overflow-y: scroll;overflow-x: auto;"></ul>--}}
        <ul id="setAreaTree" class="ztree treeSelect" style="margin-top:0;border: 1px solid #617775;background:#f0f6e4;width: 309px;height: 360px;overflow-y: scroll;overflow-x: auto;"></ul>
    </div>

    <div class="warpper">
        <div class="title"><a href="/admin/shopgoodsquote/list" class="s-back">返回</a>店铺 - 添加商品报价</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>标识“*”的选项为必填项，其余为选填项。</li>
                    <li>库存数量必须是商品规格的整数倍,如果输入值非整数倍则自动向下取整。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/shopgoodsquote/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商家：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="shop_id" id="shop_id" >
                                        <option value="">请选择商家</option>
                                    </select>
                                    <input type="hidden" name="shop_name" id="shop_name">
                                    <div style="margin-left: 10px;" class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择店铺：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="shop_store_id" id="store_id" >
                                        <option value="0">自售</option>
                                    </select>
                                    <input type="hidden" name="store_name" id="store_name" value="自售">
                                    <div style="margin-left: 10px;" class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;业务员姓名：</div>
                                <div class="label_value">
                                    <select  style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="salesman" id="salesman" >

                                    </select>
                                    <div style="margin-left:10px;" class="form_prompt"></div>
                                    <div style="margin-left:10px;" class="notic">请选择业务员</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;选择商品分类：</div>
                                <div class="label_value">

                                    <input type="hidden" name="cat_id" id="cat_id"/>
                                    <input type="text" name="cat_id_LABELS"  autocomplete="off" treeId="" old="" id="cat_name" treeDataUrl="/admin/goodscategory/getCategoryTree" size="40"  class="text" title="">
                                    <div style="" class="notic">商品分类用于辅助选择商品</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商品：</div>
                                <div class="label_value">
                                    <input type="text" data-goodsname="" data-packing-spec="0" value=""  autocomplete="off" id="goods_name" size="40"  class="text">
                                    <input type="hidden" value="{{old('goods_id')}}" name="goods_id"  id="goods_id">
                                    <div class="form_prompt"></div>
                                    <ul class="query_goods_name" style="overflow:auto;display:none;height:200px;position: absolute;top: 219px; background: #fff;padding-left:20px;width: 300px; z-index: 2; box-shadow: 1px 1px 1px 1px #dedede;">
                                    </ul>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;商品库存数量(<span style="color:#909090;" class="unit-name">KG</span>)：</div>
                                <div class="label_value">
                                    <input type="text" name="goods_number" class="text" value="" maxlength="40" autocomplete="off" id="goods_number">
                                    <div class="form_prompt"></div>
                                    <div style="" class="notic">包装规格的整数倍，向下取整</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货地：</div>
                                <div class="label_value">
                                    <input type="hidden" name="place_id" id="place_id"/>
                                    <input type="text" name="place_id_LABELS" old="" autocomplete="off" treeId="" id="delivery_place" treeDataUrl="/admin/region/getRegionTree" size="40"  class="text" title="">
                                    {{--<input type="text" readonly="readonly" id="area1" name="delivery_place" value="" style="display: none"/>--}}
                                    {{--<input type="text" readonly="readonly" id="area2" name="place_id" value="" style="display: none"/>--}}
                                    {{--<div class="ui-area fl" data-value-name="area1" data-value-id="area2" data-init-name="" style="width: 321px;height:33px;" id="test">--}}
                                    {{--</div>--}}
                                    {{--<div style="margin-left: 10px" class="form_prompt"></div>--}}
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
                                <div class="label"><span class="require-field">*</span>&nbsp;店铺售价(<span style="color:#909090;" >元</span>)：</div>
                                <div class="label_value">
                                    <input type="text" name="shop_price" class="text" value="" maxlength="40" autocomplete="off" id="shop_price">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货方式：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="delivery_method" id="delivery_method" >
                                        <option value="自提">自提</option>
                                        <option value="配送">配送</option>
                                    </select>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货时间：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_time" class="text" value="现货" maxlength="40" autocomplete="off" id="delivery_time">
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

        layui.use(['layer','laydate'], function(){
            var layer = layui.layer;
            var laydate = layui.laydate;

            laydate.render({
                elem: '#expiry_time' //指定元素
                , type: 'datetime'
            });

            $("#goods_number").blur(function(){
                var goods_number = Number($(this).val());
                var packing_spec = Number($('#goods_name').attr("data-packing-spec"));
                var goods_id = Number($("#goods_id").val());

                console.log(goods_number);
                console.log(packing_spec);
                console.log(goods_id);
                if(!goods_id){
                    layer.alert("请先选择商品");
                    $(this).val("");
                    return ;
                }
                if(!goods_number){
                    $(this).val(packing_spec);
                    return ;
                }
                if(goods_number<=packing_spec){
                    $(this).val(packing_spec);
                    return ;
                }
                $(this).val(Math.floor(goods_number/packing_spec)*packing_spec);
            });
        });
        $(function(){
            getShopList();
            getSalemanList();
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
                    production_date:{
                        required:true,
                    },
                    salesman:{
                        required:true,
                    },
                    delivery_time:{
                       required:true,
                    },
                    delivery_method:{
                        required:true,
                    },

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
                    production_date :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    salesman:{
                        required :'<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    delivery_time:{
                       required :'<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    delivery_method:{
                        required :'<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    }
                }
            });

            document.onclick=function(event){
                $(".query_store_name").hide();
                $(".query_goods_name").hide();
            }
            //选择商家
            $("#shop_id").change(function(){
                var shop_name = $(this).find("option:selected").text();
                $("#shop_name").val(shop_name);
                $("#store_name").val('自售');
                $("#store_id").val('');
                $("#store_id").empty();
                $("#store_id").append('<option value="0">自售</option>');
                getStoreList();
                getSalemanList();
            });
            //选择店铺
            $("#store_id").change(function(){
                var store_name = $(this).find("option:selected").text();
                $("#store_name").val(store_name);
            });


            //获取树形分类
            $("#cat_name").focus(function(){
                showWinZtreeSelector(this,'setCatTree');
            });
            $("#delivery_place").focus(function(){
                showWinZtreeSelector(this,'setAreaTree');
            });
            $("#delivery_place").change(function(){
                var _name = $(this).attr('old');
                $(this).val(_name);
            });
            // 商品 获取焦点请求所有的商品数据
            $("#goods_name").focus(function(){
                $(".query_goods_name").children().filter("li").remove();
                var cat_id = $("#cat_id").val();
                $.ajax({
                    url: "/admin/promote/getGood",
                    dataType: "json",
                    data:{"cat_id":cat_id},
                    type:"POST",
                    success:function(res){
                        if(res.code==1){
                            $(".query_goods_name").show();
                            var data = res.data;
                            for(var i=0;i<data.length;i++){
                                $(".query_goods_name").append('<li data-unit-name="'+data[i].unit_name+'" data-packing-spec="'+data[i].packing_spec+'" data-packing-unit= "'+data[i].packing_unit+'" data-goods-id="'+data[i].id+'" class="created_goods_name" style="cursor:pointer;">'+data[i].goods_full_name+'</li>');
                            }
                        }else{
                            $(".query_goods_name").show();
                            $(".query_goods_name").append('<li  style="cursor:pointer;">该分类下没有查询到商品</li>');
                        }
                    }
                })
            });

            //根据company里面输入的文字实时查询分类数据
            $("#goods_name").bind("input propertychange",function(res){
                var goods_name = $(this).val();
                var cat_id = $("#cat_id").val();
                $(".query_goods_name").children().filter("li").remove();
                $.post('/admin/promote/getGood',{'cat_id':cat_id,'goods_name':goods_name},function(res){
                    if(res.code==1){
                        $(".query_goods_name").show();
                        var data = res.data;
                        console.log(data);
                        for(var i=0;i<data.length;i++){
                            $(".query_goods_name").append('<li data-unit-name="'+data[i].unit_name+'" data-packing-spec="'+data[i].packing_spec+'" data-packing-unit= "'+data[i].packing_unit+'" data-goods-id="'+data[i].id+'" class="created_goods_name" style="cursor:pointer;">'+data[i].goods_full_name+'</li>');
                        }
                    }
                },"json");
            });

            //点击将li标签里面的值填入input框内
            $(document).delegate(".created_goods_name","click",function(){
                $("#goods_name").siblings("div").filter(".notic").remove();
                $("#goods_name").siblings("div").filter(".form_prompt").remove();
                var goods_name = $(this).text();
                var goods_id = $(this).attr("data-goods-id");
                var packing_spec = $(this).attr("data-packing-spec");
                let packing_unit = $(this).attr('data-packing-unit');
                let unit_name = $(this).attr('data-unit-name');
                $(".unit-name").text(unit_name);
                $("#goods_name").val(goods_name);
                $("#goods_id").val(goods_id);
                $("#goods_name").attr("data-packing-spec",packing_spec);
                $("#goods_name").attr("data-goodsname",goods_name);
                $("#min_limit").val(packing_spec);
                $("#num").val(packing_spec);
                $("#num").attr("disabled",false);
                $("#goods_name").after('<div style="margin-left: 10px;color:red;" class="notic">包装规格为：'+packing_spec+unit_name+'/'+packing_unit+'</div>');

                $('#goods_number').val(packing_spec);
            });

            $("#goods_name").blur(function(){
                let _goods_name = $(this).attr("data-goodsname");
                $(this).val(_goods_name);
            });
        });
        // 商家 请求所有的商家数据
        function getShopList(){
            $.ajax({
                url: "/admin/shop/ajax_list",
                dataType: "json",
                data:{},
                type:"POST",
                success:function(res){
                    if(res.code==1){
                        let data = res.data;
                        for(let i=0;i<data.length;i++){
                            $("#shop_id").append('<option value="'+data[i].id+'">'+data[i].company_name+'</option>');
                        }
                    }
                }
            })
        }

        //获取所有的商家业务员数据
        function getSalemanList(){
            let shop_id = $("#shop_id").val();
            $.ajax({
                url: "/admin/salesman/getSalemanByShopId",
                dataType: "json",
                data:{shop_id:shop_id},
                type:"POST",
                success:function(res){
                    if(res.code==200){
                        $("#salesman").children().remove();
                        $("#salesman").append('<option value="">请选择业务员</option>');
                        let data = res.data;
                        for(let i=0;i<data.length;i++){
                            $("#salesman").append('<option value="'+data[i].name+'">'+data[i].name+'</option>');
                        }
                    }else{
                        $("#salesman").children().remove();
                        $("#salesman").append('<option value="">无业务员信息</option>');
                    }
                }
            })
        }

        // 店铺 请求所有的店铺数据
        function getStoreList(){
            let _shop_id = $('#shop_id').val();
            $.ajax({
                url: "/admin/shop/store/list",
                dataType: "json",
                data:{shop_id:_shop_id},
                type:"POST",
                success:function(res){
                    if(res.code==1){
                        let data = res.data;
                        for(let i=0;i<data.length;i++){
                            $("#store_id").append('<option value="'+data[i].id+'">'+data[i].store_name+'</option>');
                        }
                    }
                }
            })
        }
    </script>


@stop
