@extends(themePath('.')."seller.include.layouts.master")
@section('styles')

@endsection
@section('body')
    @include('partials.base_header')
    <script src="{{asset(themePath('/').'js/jquery.validation.min.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/jquery.cookie.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/dsc_admin2.0.js')}}" ></script>
    <style>
        [class^="icon-"], [class*=" icon-"] {
            line-height: 23px;
        }
        .ui-area .tit{
            height:28px;
            line-height: 28px;
        }
        .ui-area .area-warp {
            width: 278px !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/layui/css/layui.css')}}" />

    <script src="{{asset(themePath('/').'plugs/zTree_v3/js/jquery.ztree.core.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/create_cat_tree.js')}}" ></script>
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/zTree_v3/css/zTreeStyle/zTreeStyle.css')}}" />
    <div class="menuContent" style="display:none; position: absolute;">
        <ul id="setCatTree" class="ztree treeSelect" style="margin-top:0;border: 1px solid #617775;background:#f0f6e4;width: 309px;height: 360px;overflow-y: scroll;overflow-x: auto;"></ul>
    </div>
    <div class="menuContent" style="display:none; position: absolute;">
        <ul id="setAreaTree" class="ztree treeSelect" style="margin-top:0;border: 1px solid #617775;background:#f0f6e4;width: 309px;height: 360px;overflow-y: scroll;overflow-x: auto;"></ul>
    </div>
    <div class="warpper">
        <div class="title"><a href="/seller/quote/list" class="s-back">返回</a>店铺 - 添加商品报价</div>
        <div class="content">
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/seller/quote/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">


                        <div class="switch_info" style="display: block;">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择店铺：</div>
                                <div class="label_value">
                                    {{--<input type="text" autocomplete="off" size="40" id="store_name" value="{{old('store_name')}}" class="text" />--}}
                                    <select class="query_store_name" id="store_name" style="height:30px;border:1px solid #dbdbdb;line-height:30px;float: left;padding-right:10px;">

                                    </select>
                                    <input type="hidden" value="@if(old('store_name')){{old('store_name')}}@else自售@endif" name="store_name"  id="store_name_val"  />
                                    <input type="hidden" value="@if(old('store_id')){{old('store_id')}} @else 0 @endif" name="store_id"  id="store_id" />
                                    <div style="margin-left: 10px;" class="notic">请从下拉框中选择店铺</div>

                                    <div class="form_prompt"></div>
                                    {{--<ul class="query_store_name" style="overflow:auto;display:none;height:200px;position: absolute;top: 61px; background: #fff;padding-left:20px;width: 300px; z-index: 2; box-shadow: 1px 1px 1px 1px #dedede;">--}}
                                    {{--</ul>--}}
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;选择商品分类：</div>
                                <div class="label_value">
                                    <input type="hidden" name="cat_id" id="cat_id"/>
                                    <input type="text" name="cat_id_LABELS"  autocomplete="off" value="{{old('cat_name')}}" treeId="" id="cat_name" treeDataUrl="/seller/goods/getGoodsCat" size="40"  class="text" title="">
                                    <div style="margin-left: 0px;" class="notic">商品分类用于辅助选择商品</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商品：</div>
                                <div class="label_value">
                                    <input type="text" data-packing-spac="0" value=""  autocomplete="off" id="goods_name" size="40"  class="text">
                                    <input type="hidden" value="{{old('goods_id')}}" name="goods_id"  data-name="" id="goods_id" >
                                    <div class="form_prompt"></div>
                                    <ul class="query_goods_name" style="overflow:auto;display:none;height:200px;position: absolute;top: 141px; background: #fff;padding-left:20px;width: 300px; z-index: 2; box-shadow: 1px 1px 1px 1px #dedede;">
                                    </ul>
                                </div>
                            </div>

                            {{--<div class="item">--}}
                                {{--<div class="label"><span class="require-field">*</span>&nbsp;商品库存数量：</div>--}}
                                {{--<div class="label_value">--}}
                                    {{--<input type="text" name="goods_number" class="text" value="{{old('goods_number')}}" maxlength="40" autocomplete="off" id="goods_number">--}}
                                    {{--<div class="form_prompt"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;商品最小采购数量：</div>
                                <div class="label_value">
                                    <input type="text" name="min_limit" class="text" value="{{old('min_limit')}}" maxlength="40" autocomplete="off" id="min_limit">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货方式：</div>
                                <div class="label_value">
                                    {{--<input type="text" name="delivery_method" class="text" value="{{old('delivery_method')}}" maxlength="40" autocomplete="off" id="delivery_method">--}}
                                    <select name="delivery_method" id="" style="line-height: 25px;height: 28px;padding: 0 10px;border: 1px solid #d2d2d2;outline: 0;">
                                        <option value="自提" @if(old('delivery_method')=='自提') selected @endif >自提(Self delivery)</option>
                                        <option value="现货" @if(old('delivery_method')=='现货') selected @endif >配送(Delivery)</option>
                                    </select>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货时间：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_time" class="text" value="{{old('delivery_time')?old('delivery_time'):'现货'}}" maxlength="40" autocomplete="off" id="delivery_time">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;英文交货时间：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_time_en" class="text" value="{{old('delivery_time_en')?old('delivery_time_en'):'spot goods'}}" maxlength="40" autocomplete="off" id="delivery_time_en">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;选择交货地：</div>
                                <div class="label_value">
                                    <input type="hidden" name="place_id" id="place_id" />
                                    <input type="text" name="place_id_LABELS" old="" autocomplete="off" value="{{old('delivery_place')}}" treeId="" id="delivery_place" treeDataUrl="/seller/quote/getAddressTree" size="40"  class="text" title="">
                                    <div class="form_prompt"></div>

                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;生产日期：</div>
                                <div class="label_value">
                                    <input type="text" name="production_date" class="text" value="{{old('production_date')}}" maxlength="40" autocomplete="off" id="production_date">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;店铺售价：</div>
                                <div class="label_value">
                                    <input type="text" name="shop_price" class="text" value="{{old('shop_price')}}" maxlength="40" autocomplete="off" id="shop_price">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;业务员：</div>
                                <div class="label_value">
                                    {{--<input type="text" name="salesman" value="{{old('salesman')}}" id="salesman" class=" text" maxlength="10" autocomplete="off">--}}
                                    <select name="salesman_id" id="salesman_id" style="line-height: 25px;height: 28px;padding: 0 10px;border: 1px solid #d2d2d2;outline: 0;">
                                        @foreach($salesman as $v)
                                            <option value="{{$v['id']}}" @if(old('salesman')==$v['name']) selected @endif >{{$v['name']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;货源：</div>
                                <div class="label_value">
                                    {{--<input type="text" name="salesman" value="{{old('salesman')}}" id="salesman" class=" text" maxlength="10" autocomplete="off">--}}
                                    <select name="salesman_id" id="salesman_id" style="line-height: 25px;height: 28px;padding: 0 10px;border: 1px solid #d2d2d2;outline: 0;">
                                        <option value="0" @if(old('goods_source')==0) selected="selected" @endif >现货</option>
                                        <option value="1" @if(old('goods_source')==1) selected="selected" @endif >紧张</option>
                                        <option value="2" @if(old('goods_source')==2) selected="selected" @endif >厂家直发</option>
                                        <option value="3" @if(old('goods_source')==3) selected="selected" @endif >少量</option>
                                    </select>
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
        $(function(){
            //表单验证
            let salesman_id = $("#salesman_id").find("option:selected").text();
            if (salesman_id===null||salesman_id===''){
                layer.confirm('没有业务员，是否前去维护?', {icon: 3, title:'提示'}, function(index){
                    addTab('业务员','/seller/salesman/list','S042');
                    parent.location.reload();
                    layer.close(index);
                },function () {
                    history.back();
                });
            }
            $("#submitBtn").click(function(){
                if($("#article_form").valid()){
                    let salesman_id = $("#salesman_id").find("option:selected").text();
                    if (salesman_id===null||salesman_id===''){
                        layer.confirm('没有业务员，是否前去维护?', {icon: 3, title:'提示'}, function(index){
                            addTab('业务员','/seller/salesman/list','S042');
                            parent.location.reload();
                            layer.close(index);
                        },function () {
                            history.back();
                        });
                    }

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
                    min_limit:{
                        required : true,
                        number:true
                    },
                    goods_id:{
                        required : true,
                    },
                    place_id_LABELS:{
                        required:true,
                    },
                    production_date:{
                        required:true,
                    },
                    salesman:{
                        required:true,
                    },
                    contact_info:{
                        required:true,
                    },
                    store_name:{
                        required:true,
                    },
                    delivery_method:{
                        required:true,
                    },
                    delivery_time:{
                        required:true,
                    },
                },
                messages:{
                    shop_price:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    goods_number :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字',
                    },
                    min_limit :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字',
                    },
                    goods_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    place_id_LABELS :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    production_date :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    salesman :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    contact_info :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    QQ :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    store_name :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    delivery_method :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    delivery_time :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                }
            });
            $("#cat_name").focus(function(){
                showWinZtreeSelector(this,'setCatTree');
            });
            $("#delivery_place").focus(function(){
                showWinZtreeSelector(this,'setAreaTree');
            });
        });

        document.onclick=function(event){
            $(".query_cat_name").hide();
            $(".query_goods_name").hide();
            // $(".query_store_name").hide();
        }

        // 商品 获取焦点请求所有的商品数据
        $("#goods_name").click(function(){
            $(".query_goods_name").children().filter("li").remove();
            var cat_id = $("#cat_id").val();
            $.ajax({
                url: "/seller/goods/getGood",
                dataType: "json",
                data:{
                    "cat_id":cat_id,
                    // "goods_name":input_v
                },
                type:"POST",
                success:function(res){
                    if(res.code==200){
                        $(".query_goods_name").show();
                        var data = res.data;
                        for(var i=0;i<data.length;i++){
                            $(".query_goods_name").append('<li data-packing-spac="'+data[i].packing_spec+'" data-min_limit="'+data[i].min_limit+'" data-packing_unit= "'+data[i].packing_unit+'" data-unit_name= "'+data[i].unit_name+'" data-goods-id="'+data[i].id+'" class="created_goods_name" style="cursor:pointer;">'+data[i].goods_full_name+'</li>');
                        }
                    }else{
                        $(".query_goods_name").show();
                        $(".query_goods_name").append('<li  style="cursor:pointer;">该分类下没有查询到商品</li>');
                    }
                }
            })
        });

        // 输入商品名字查询
        $("#goods_name").bind("input propertychange", function () {
            let input_v = $(this).val();
            if (input_v===''){
                return false;
            }
            // $(".query_goods_name").children().filter("li").remove();
            var cat_id = $("#cat_id").val();
            $.ajax({
                url: "/seller/goods/getGood",
                dataType: "json",
                data:{
                    "cat_id":cat_id,
                    "goods_name":input_v
                },
                type:"POST",
                success:function(res){
                    $(".query_goods_name").children().filter("li").remove();
                    if(res.code==200){
                        $(".query_goods_name").show();
                        var data = res.data;
                        for(var i=0;i<data.length;i++){
                            $(".query_goods_name").append('<li data-packing-spac="'+data[i].packing_spec+'" data-min_limit="'+data[i].min_limit+'" data-packing_unit= "'+data[i].packing_unit+'" data-unit_name= "'+data[i].unit_name+'" data-goods-id="'+data[i].id+'" class="created_goods_name" style="cursor:pointer;">'+data[i].goods_full_name+'</li>');
                        }
                    }else{
                        $(".query_goods_name").show();
                        $(".query_goods_name").append('<li  style="cursor:pointer;">该分类下没有查询到商品</li>');
                    }
                }
            })
        });

        $("#store_name").focus(function(){
            $(".query_store_name").children().filter("option").remove();
            $.ajax({
                url: "/seller/store/list",
                dataType: "json",
                data:{},
                type:"POST",
                async:false,
                success:function(res){
                    if(res.code==1){
                        $(".query_store_name").show();
                        var data = res.data;
                        $(".query_store_name").append('<option data-store-id="0" data-store-name="自售" class="created_store_name" style="cursor:pointer;" selected>自售</option>');

                        for(var i=0;i<data.length;i++){
                            $(".query_store_name").append('<option data-store-id="'+data[i].id+'" data-store-name="'+data[i].store_name+'" class="created_store_name" style="cursor:pointer;">'+data[i].store_name+'</option>');
                        }
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
            var packing_unit = $(this).data('packing_unit');
            var unit_name = $(this).data('unit_name');
            var min_limit = $(this).data('min_limit');
            $("#goods_name").val(goods_name);
            $("#goods_id").val(goods_id);
            $("#goods_name").attr("data-packing-spac",packing_spac);
            $("#goods_name").attr("data-name",goods_name);
            $("#num").attr("disabled",false);
            $("#goods_name").after('<div style="margin-left: 10px;color:red;" class="notic">包装规格为：'+packing_spac+unit_name+'/'+packing_unit+'</div>');
            $("#goods_number").val(packing_spac);
            $("#min_limit").val(min_limit);
        });

        $("#goods_name").blur(function () {
            let goods_name = $(this).attr('data-name');
            $(this).val(goods_name);
        });

        $("#store_name").change(function () {
            var store_name = $("#store_name option:selected").attr("data-store-name");
            var store_id = $("#store_name option:selected").attr("data-store-id");
            $("#store_name").val(store_name);
            $("#store_name_val").val(store_name);
            $("#store_id").val(store_id);
        });


        $("#goods_number").change(function () {
            let spac = Number($("#goods_name").attr("data-packing-spac"));
            let goods_number = Number($(this).val());
            if (Number(spac) > Number(goods_number)){
                $(this).val(spac);
            } else {
                if (goods_number%spac>0){
                    $(this).val(goods_number-goods_number%spac);
                } else {
                    $(this).val(goods_number);
                }
            }
        });
        $("#min_limit").change(function () {
            let spac = Number($("#goods_name").attr("data-packing-spac"));
            let min_limit = Number($(this).val());
            if (Number(spac) > Number(min_limit)){
                $(this).val(spac);
            } else {
                if (min_limit%spac>0){
                    $(this).val(min_limit-min_limit%spac);
                } else {
                    $(this).val(min_limit);
                }
            }
        });

        $("#delivery_place").change(function(){
            let _name = $(this).attr('old');
            $(this).val(_name);
        });
        // 重置是清空地址选项
        $(".button_reset").click(function () {
            $("#area1").val('');
            $("#area2").val('');
            $(".tit span").html('');
        });
    </script>


@stop
