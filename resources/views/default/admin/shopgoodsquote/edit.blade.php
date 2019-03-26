@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    @include('partials.base_header')
    <script src="{{asset(themePath('/').'js/jquery.validation.min.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/jquery.cookie.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/dsc_admin2.0.js')}}" ></script>
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/layui/css/layui.css')}}" />
    <link rel="stylesheet" type="text/css" href="/ui/area/1.0.0/area.css" />
    <script type="text/javascript" src="/ui/area/1.0.0/area.js"></script>

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
        <div class="title"><a href="/admin/shopgoodsquote/list?currpage={{$currpage}}" class="s-back">返回</a>店铺 - 修改商品报价</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>标识“*”的选项为必填项，其余为选填项。</li>
                    <li>库存数量必须是商品规格的整数倍,不允许修改，如果添加报价时库存数量输入错误，请删除报价重新发布。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/shopgoodsquote/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商家：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="shop_id" id="shop_id" value="{{$goodsQuote['shop_id']}}">
                                        <option value="">请选择商家</option>
                                    </select>
                                    <input type="hidden" name="shop_name" id="shop_name" value="{{$goodsQuote['shop_name']}}">
                                    <div style="margin-left: 10px;" class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择店铺：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="shop_store_id" id="store_id" value="{{$goodsQuote['shop_store_id']}}">
                                        <option value="0">自售</option>
                                    </select>
                                    <input type="hidden" name="store_name" id="store_name" value="{{$goodsQuote['shop_store_id'] == 0 ? '自售' : $goodsQuote['store_name']}}">
                                    <div style="margin-left: 10px;" class="form_prompt"></div>

                                    {{--<input type="text"  store-id="{{$goodsQuote['shop_store_id']}}" value="{{$goodsQuote['store_name'] == $goodsQuote['shop_name'] ? '自售' : $goodsQuote['store_name']}}" autocomplete="off" id="store_name" size="40"  class="text">--}}
                                    {{--<input type="hidden" name="store_name" value="{{$goodsQuote['store_name'] == $goodsQuote['shop_name'] ? '自售' : $goodsQuote['store_name']}}" id="store_name_val" />--}}
                                    {{--<input type="hidden" name="shop_store_id" value="{{$goodsQuote['shop_store_id']}}" id="store_id" />--}}
                                    {{--<ul class="query_store_name" style="overflow:auto;display:none;height:200px;position: absolute; z-index: 2; top: 102px; background: #fff;width: 320px; box-shadow: 0px -1px 1px 2px #dedede;">--}}
                                    {{--</ul>--}}
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;业务员姓名：</div>
                                <div class="label_value">
                                    <select  style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="salesman" id="salesman" >
                                        @foreach($salesmans as $vo)
                                        <option @if($goodsQuote['salesman']==$vo['name']) selected  @endif value="{{$vo['name']}}">{{$vo['name']}}</option>
                                        @endforeach
                                    </select>
                                    <div style="margin-left:10px;" class="form_prompt"></div>
                                    <div style="margin-left:10px;" class="notic">选择业务员</div>
                                </div>
                            </div>


                            <div class="item">
                                <div class="label">&nbsp;选择商品分类：</div>
                                <div class="label_value">
                                    <input type="hidden" name="cat_id" id="cat_id" value="{{$goodsQuote['cat_id']}}"/>
                                    <input type="text" name="cat_id_LABELS"  autocomplete="off" treeId="" value="{{$goodsQuote['cat_name']}}" id="cat_name" treeDataUrl="/admin/goodscategory/getCategoryTree" size="40"  class="text" title="">
                                    <div style="" class="notic">商品分类用于辅助选择商品</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商品：</div>
                                <div class="label_value">
                                    <input type="text" data-goodsname="" data-packing-spec="0" value="{{$goodsQuote['goods_name']}}"  autocomplete="off" id="goods_name" size="40"  class="text">
                                    <div style="margin-left: 10px;color:red;" class="notic">包装规格为：{{$goodsQuote['packing_spec'].$goodsQuote['unit_name'].'/'.$goodsQuote['packing_unit'] }}</div>
                                    <input type="hidden" value="{{$goodsQuote['goods_id']}}" name="goods_id"  id="goods_id">
                                    <div class="form_prompt"></div>
                                    <ul class="query_goods_name" style="overflow:auto;display:none;height:200px;position: absolute;top: 219px; background: #fff;padding-left:20px;width: 300px; z-index: 2; box-shadow: 1px 1px 1px 1px #dedede;">
                                    </ul>
                                </div>
                            </div>

                            {{--<div class="item">--}}
                                {{--<div class="label"><span class="require-field">*</span>&nbsp;商品库存数量(<span style="color:#909090;" class="unit-name">KG</span>)：</div>--}}
                                {{--<div class="label_value">--}}
                                    {{--<input type="text" name="goods_number"  disabled="disabled" data-packing_spec="{{$goodsQuote['packing_spec']}}"  class="text" value="{{$goodsQuote['goods_number']}}" maxlength="40" autocomplete="off" id="goods_number">--}}
                                    {{--<span style="margin-left: 10px;color:red;font-size: 12px;">库存数量必须是商品规格的整数倍</span>--}}
                                    {{--<div class="form_prompt"></div>--}}
                                    {{--<div style="" class="notic">包装规格的整数倍，向下取整</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货地：</div>
                                <div class="label_value">
                                    <input type="hidden" name="place_id" id="place_id" value="{{$goodsQuote['place_id']}}"/>
                                    <input type="text" value="{{$goodsQuote['delivery_place']}}" old="{{$goodsQuote['delivery_place']}}" name="place_id_LABELS"  autocomplete="off" treeId="" id="delivery_place" treeDataUrl="/admin/region/getRegionTree" size="40"  class="text" title="">

                                    {{--<input type="text" readonly="readonly" id="area1" name="delivery_place" value="{{$goodsQuote['delivery_place']}}" style="display: none"/>--}}
                                    {{--<input type="text" readonly="readonly" id="area2" name="place_id" value="{{$goodsQuote['place_id']}}" style="display: none"/>--}}
                                    {{--<div class="ui-area fl" data-value-name="area1" data-value-id="area2" data-init-name="{{$goodsQuote['delivery_place']}}" style="width: 321px;height:33px;" id="test">--}}
                                    {{--</div>--}}
                                    {{--<div class="form_prompt"></div>--}}
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;生产日期：</div>
                                <div class="label_value">
                                    <input type="text" name="production_date" class="text" value="{{$goodsQuote['production_date']}}" maxlength="40" autocomplete="off" id="production_date">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <input type="hidden" name="currpage" value="{{$currpage}}">
                            <input type="hidden" name="id" value="{{$goodsQuote['id']}}">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;店铺售价(<span style="color:#909090;" >元</span>)：</div>
                                <div class="label_value">
                                    <input type="text" name="shop_price" class="text" value="{{$goodsQuote['shop_price']}}" maxlength="40" autocomplete="off" id="shop_price">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>


                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货方式：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="delivery_method" id="delivery_method" >
                                        <option @if($goodsQuote['delivery_method'] == "自提") selected="selected" @endif value="自提">自提(Self delivery)</option>
                                        <option @if($goodsQuote['delivery_method'] != "自提") selected="selected" @endif value="配送">配送(Delivery)</option>
                                    </select>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货时间：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_time" class="text" value="{{$goodsQuote['delivery_time']}}" maxlength="40" autocomplete="off" id="delivery_time">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;英文交货时间：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_time_en" class="text" @if(!empty($goodsQuote['delivery_time_en'])) value="{{$goodsQuote['delivery_time_en']}}" @else value="spot goods" @endif maxlength="40" autocomplete="off" id="delivery_time_en">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;商品最小采购数量(<span style="color:#909090;" class="unit-name">KG</span>)：</div>
                                <div class="label_value">
                                    <input type="text" name="min_limit" data-packing_spec="{{$goodsQuote['packing_spec']}}"  class="text" value="{{$goodsQuote['min_limit']}}" maxlength="40" autocomplete="off" id="min_limit">
                                    {{--<span style="margin-left: 10px;color:red;font-size: 12px;">库存数量必须是商品规格的整数倍</span>--}}
                                    <div class="form_prompt"></div>
                                    <div style="" class="notic">包装规格的整数倍，向下取整</div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;货源：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="goods_source" id="goods_source" >
                                        <option value="0" @if($goodsQuote['goods_source'] == 0) selected="selected" @endif>现货</option>
                                        <option value="1" @if($goodsQuote['goods_source'] == 1) selected="selected" @endif>紧张</option>
                                        <option value="2" @if($goodsQuote['goods_source'] == 2) selected="selected" @endif>厂家直发</option>
                                        <option value="3" @if($goodsQuote['goods_source'] == 3) selected="selected" @endif>少量</option>
                                    </select>
                                    <div style="margin-left: 10px;" class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field"></span>&nbsp;地域：</div>
                                <div class="label_value">
                                    <input type="text" name="effective_area" class="text" value="{{$goodsQuote['effective_area']}}" maxlength="40" autocomplete="off" id="effective_area">
                                    <div class="form_prompt"></div>
                                    <div style="" class="notic">多个地区用英文分号（;）隔开</div>
                                </div>
                            </div>
                            <div class="item bor_top_das pt20">
                                <div class="label">价格：</div>
                                <div id="price-div" class="label_value">
                                    <table class="table_item">
                                        <tbody>
                                        @if(!empty($goodsQuote['prices']))
                                            @foreach($goodsQuote['prices'] as $k=>$v)
                                            <tr>
                                                <td>
                                                    <label class="fl lh">最小数量：</label><input name="prices[{{$k}}][min_num]" type="text" class="text text_2 mr10 w100 valid" value="{{$v['min_num']}}" autocomplete="off" aria-invalid="false">
                                                    <label class="fl lh">价格：</label><input name="prices[{{$k}}][price]" type="text" class="text text_2 mr10 w100 valid" value="{{$v['price']}}" autocomplete="off" aria-invalid="false">
                                                    <input type="hidden" name="prices[{{$k}}][id]" value="{{$v['id']}}"/>
                                                    @if($k == 0)
                                                        <input type="button" class="button valid" value="添加" onclick="addPrice()" aria-invalid="false">
                                                    @else
                                                        <input type="button" class="button red_button" value="删除" onclick="dropPrice(this)">
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>
                                                    <label class="fl lh">最小数量：</label><input name="prices[0][min_num]" type="text" class="text text_2 mr10 w100 valid" value="0" autocomplete="off" aria-invalid="false">
                                                    <label class="fl lh">价格：</label><input name="prices[0][price]" type="text" class="text text_2 mr10 w100 valid" value="0" autocomplete="off" aria-invalid="false">
                                                    <input type="button" class="button valid" value="添加" onclick="addPrice()" aria-invalid="false">
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
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

        layui.use(['layer'], function(){
            var layer = layui.layer;

            $("#goods_number").blur(function(){
                var goods_number = $(this).val();
                var packing_spec = $(this).data("packing_spec");
                var goods_id = $("#goods_id").val();
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
            $("#min_limit").blur(function(){
                var min_limit = $(this).val();
                var packing_spec = $(this).data("packing_spec");
                var goods_id = $("#goods_id").val();
                console.log(goods_id);
                if(!goods_id){
                    layer.alert("请先选择商品");
                    $(this).val("");
                    return ;
                }
                if(!min_limit){
                    $(this).val(packing_spec);
                    return ;
                }
                if(min_limit<=packing_spec){
                    $(this).val(packing_spec);
                    return ;
                }
                $(this).val(Math.floor(min_limit/packing_spec)*packing_spec);
            });

        });
        $(function(){
            getShopList('{{$goodsQuote['shop_id'] or 0}}');
            getStoreList('{{$goodsQuote['shop_id'] or 0}}','{{$goodsQuote['shop_store_id'] or 0}}');
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
                    delivery_time:{
                        required:true,
                    },
                    delivery_time_en:{
                        required:true,
                    },
                    delivery_method:{
                        required:true,
                    },
                    salesman:{
                        required:true,
                    },
                    goods_source:{
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
                    delivery_time:{
                        required :'<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    delivery_time_en:{
                        required :'<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    delivery_method:{
                        required :'<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    salesman:{
                        required :'<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    goods_source:{
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
//                $("#store_name_val").val('');
                $("#store_id").val('');
                $("#store_id").empty();
                $("#store_id").append('<option value="0">自售</option>');
                getStoreList(0,0);
                getSalemanList();
            });
            //选择店铺
            $("#store_id").change(function(){
                var store_name = $(this).find("option:selected").text();
                $("#store_name").val(store_name);
            });


            //店铺 点击将li标签里面的值填入input框内
            $(document).delegate(".created_store_name","click",function(){
                //$("#company_name").siblings("div").filter(".notic").remove();
                var store_name = $(this).text();
                var store_id = $(this).attr("data-store-id");
                $("#store_name").val(store_name);
//                $("#store_name_val").val(store_name);
                $("#store_id").val(store_id);
                $(".query_store_name").hide();
            });

            //获取树形分类
            $("#cat_name").focus(function(){
                showWinZtreeSelector(this,'setCatTree');
            });
            $("#delivery_place").focus(function(){
                showWinZtreeSelector(this,'setAreaTree');
            });
            //
            $("#delivery_place").change(function(){
                var _name = $(this).attr('old');
                $(this).val(_name);
            });
            // 商品 获取焦点请求所有的商品数据
            $("#goods_name").click(function(){
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
                                $(".query_goods_name").append('<li  data-unit-name="'+data[i].unit_name+'" data-min_limit="'+data[i].min_limit+'" data-packing-spec="'+data[i].packing_spec+'" data-packing-unit= "'+data[i].packing_unit+'" data-goods-id="'+data[i].id+'" class="created_goods_name" style="cursor:pointer;">'+data[i].goods_full_name+'</li>');
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
                            $(".query_goods_name").append('<li data-unit-name="'+data[i].unit_name+'" data-min_limit="'+data[i].min_limit+'" data-packing-spec="'+data[i].packing_spec+'" data-packing-unit= "'+data[i].packing_unit+'" data-goods-id="'+data[i].id+'" class="created_goods_name" style="cursor:pointer;">'+data[i].goods_full_name+'</li>');
                        }
                    }
                },"json");
            });

            //点击将li标签里面的值填入input框内
            $(document).delegate(".created_goods_name","click",function(){
                $("#goods_name").siblings("div").filter(".notic").remove();
                var goods_name = $(this).text();
                var goods_id = $(this).attr("data-goods-id");
                var packing_spec = $(this).attr("data-packing-spec");
                var packing_unit = $(this).attr('data-packing-unit');
                var unit_name = $(this).attr('data-unit-name');
                var min_limit = $(this).attr('data-min_limit');
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
                $('#min_limit').val(packing_spec);
                $('.unit-name').text(unit_name);
            });

            $("#goods_name").blur(function(){
                let _goods_name = $(this).attr("data-goodsname");
                $(this).val(_goods_name);
            });
        });

        // 商家 请求所有的商家数据
        function getShopList(_id){
            $.ajax({
                url: "/admin/shop/ajax_list",
                dataType: "json",
                data:{},
                type:"POST",
                success:function(res){
                    if(res.code==1){
                        let data = res.data;
                        for(let i=0;i<data.length;i++){
                            if(_id == data[i].id){
                                $("#shop_id").append('<option value="'+data[i].id+'" selected>'+data[i].company_name+'</option>');
                            }else{
                                $("#shop_id").append('<option value="'+data[i].id+'">'+data[i].company_name+'</option>');
                            }

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
        function getStoreList(_shop_id,_id){
            if(_shop_id == 0){
                _shop_id = $('#shop_id').val();
            }
            $.ajax({
                url: "/admin/shop/store/list",
                dataType: "json",
                data:{shop_id:_shop_id},
                type:"POST",
                success:function(res){
                    if(res.code==1){
                        let data = res.data;
                        for(let i=0;i<data.length;i++){
                            if(_id == data[i].id){
                                $("#store_id").append('<option value="'+data[i].id+'" selected>'+data[i].store_name+'</option>');
                            }else{
                                $("#store_id").append('<option value="'+data[i].id+'">'+data[i].store_name+'</option>');
                            }

                        }
                    }
                }
            })
        }
        //
        function addPrice(){
            var _count = $(".table_item tbody tr").length;//这个就是子元素的个数
            var _html = '';
            _html += '<tr><td>' +
                '<label class="fl lh">最小数量：</label><input name="prices['+_count+'][min_num]" type="text" class="text text_2 mr10 w100" value="0" autocomplete="off">' +
                '<label class="fl lh">价格：</label><input name="prices['+_count+'][price]" type="text" class="text text_2 mr10 w100" value="0" autocomplete="off">' +
                '<input type="button" class="button red_button" value="删除" onclick="dropPrice(this)"></td></tr>';
            $('.table_item tbody').append(_html);
        }
        //
        function dropPrice(obj){
            $(obj).parent().parent().remove();
        }
    </script>


@stop
