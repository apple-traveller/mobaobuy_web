@extends(themePath('.')."seller.include.layouts.master")
@section('styles')
    <style>
        [class^="icon-"], [class*=" icon-"] {
            line-height: 23px;
        }
        .ui-area .area-warp {
            width: 278px !important;
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

    <script src="{{asset(themePath('/').'plugs/zTree_v3/js/jquery.ztree.core.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/create_cat_tree.js')}}" ></script>
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/zTree_v3/css/zTreeStyle/zTreeStyle.css')}}" />
    <div class="menuContent" style="display:none; position: absolute;">
        <ul id="setCatTree" class="ztree treeSelect" style="margin-top:0;border: 1px solid #617775;background:#f0f6e4;width: 309px;height: 360px;overflow-y: scroll;overflow-x: auto;"></ul>
    </div>

    <div class="warpper">
        <div class="title"><a href="/admin/activity/consign?currentPage={{$currentPage}}" class="s-back">返回</a>修改清仓特卖</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/activity/consign/save" method="post" enctype="multipart/form-data" name="theForm" id="consign_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商家：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" value="{{$consign_info['shop_id']}}" name="shop_id" id="shop_id" >
                                        <option value="">请选择商家</option>
                                    </select>
                                    <input type="hidden" name="shop_name" id="shop_name" value="{{$consign_info['shop_name']}}">
                                    <div style="margin-left: 10px;" class="form_prompt"></div>
                                </div>
                            </div>
                            {{--<input type="hidden" value="自售" name="store_name"  id="store_name_val"  />--}}
                            {{--<input type="hidden" value="0" name="shop_store_id"  id="store_id" />--}}
                            {{--<input type="hidden" value="3" name="type"  id="store_id" />--}}
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商品分类：</div>
                                <div class="label_value">
                                    <input type="hidden" name="cat_id" id="cat_id" value="{{$consign_info['cat_id']}}"/>
                                    <input type="text" name="cat_id_LABELS"  autocomplete="off" value="{{$consign_info['cat_name']}}" treeId="" id="cat_name" treeDataUrl="/admin/goodscategory/getCategoryTree" size="40"  class="text" title="">
                                    <div style="margin-left: 10px;" class="notic">商品分类用于辅助选择商品</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商品：</div>
                                <div class="label_value">
                                    <input type="text" data-goodsname="{{$good['goods_name']}}" data-packing-spac="{{$good['packing_spec']}}" value="{{$good['goods_name']}}" autocomplete="off" id="goods_name" size="40"  class="text">
                                    <input type="hidden" value="{{$good['id']}}" name="goods_id"  id="goods_id">
                                    <div class="form_prompt"></div>
                                    <ul class="query_goods_name" style="overflow:auto;display:none;height:200px;position: absolute;top: 141px; background: #fff;padding-left:20px;width: 300px; z-index: 2; box-shadow: 1px 1px 1px 1px #dedede;">
                                    </ul>
                                </div>
                            </div>


                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;商品库存数量：</div>
                                <div class="label_value">
                                    <input type="text" name="goods_number" class="text" value="{{$consign_info['goods_number']}}" maxlength="40" autocomplete="off" id="goods_number">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货地：</div>
                                <input type="text" readonly="readonly" id="area1" name="delivery_place" value="{{ $consign_info['delivery_place'] }}" style="display: none"/>
                                <input type="text" readonly="readonly" id="area2" name="place_id" value="{{ $consign_info['place_id'] }}" style="display: none"/>
                                <div class="ui-area fl" data-value-name="area1" data-value-id="area2"  data-init-name="{{ $consign_info['delivery_place'] }}" style="width: 321px;height:33px;" id="test">
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;生产日期：</div>
                                <div class="label_value">
                                    <input type="text" name="production_date" class="text" value="{{ $consign_info['production_date'] }}" maxlength="40" autocomplete="off" id="production_date">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                                {{--<input type="hidden" name="currentPage" value="{{$currentPage}}">--}}
                            <input type="hidden" name="id" value="{{$consign_info['id']}}">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;店铺售价：</div>
                                <div class="label_value">
                                    <input type="text" name="shop_price" class="text" value="{{$consign_info['shop_price']}}" maxlength="40" autocomplete="off" id="shop_price">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;业务员：</div>
                                <div class="label_value">
                                    <input type="text" name="salesman" id="salesman" class=" text" value="{{ $consign_info['salesman'] }}" maxlength="10" autocomplete="off">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;手机号：</div>
                                <div class="label_value">
                                    <input type="text" name="contact_info" id="contact_info"  value="{{ $consign_info['contact_info'] }}" class=" text" maxlength="40" autocomplete="off" >
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;QQ：</div>
                                <div class="label_value">
                                    <input type="text" name="QQ" id="qq" class=" text" value="{{ $consign_info['QQ'] }}" maxlength="40" autocomplete="off" >
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



        $(function(){
            //获取商家信息
            getShopList('{{$consign_info['shop_id']}}');
            //表单验证
            $("#submitBtn").click(function(){
                if($("#consign_form").valid()){
                    $("#consign_form").submit();
                }
            });


            $('#consign_form').validate({
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
                    production_date:{
                        required:true,
                    },
                    salesman:{
                        required:true,
                    },
                    contact_info:{
                        required:true,
                    },
                    qq:{
                        required:true,
                    },
                    store_name:{
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
                    goods_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    delivery_place :{
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
                    qq :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    store_name :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },

                }
            });
        });

        document.onclick=function(event){
            $(".query_goods_name").hide();
            $(".query_cat_name").hide();
        }

        //选择商家
        $("#shop_id").change(function(){
            var shop_name = $(this).find("option:selected").text();
            $("#shop_name").val(shop_name);
        });
        $("#cat_name").focus(function(){
            showWinZtreeSelector(this);
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
                            $(".query_goods_name").append('<li data-packing-spac="'+data[i].packing_spec+'" data-packing-unit= "'+data[i].packing_unit+'" data-unit_name= "'+data[i].unit_name+'" data-goods-id="'+data[i].id+'" class="created_goods_name" style="cursor:pointer;">'+data[i].goods_full_name+'</li>');
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
                        $(".query_goods_name").append('<li data-packing-spac="'+data[i].packing_spec+'" data-packing-unit= "'+data[i].packing_unit+'" data-unit_name= "'+data[i].unit_name+'" data-goods-id="'+data[i].id+'" class="created_goods_name" style="cursor:pointer;">'+data[i].goods_full_name+'</li>');
                    }
                }
            },"json");
        });

        //点击将li标签里面的值填入input框内
        $(document).delegate(".created_goods_name","click",function(){
            $("#goods_name").siblings("div").filter(".notic").remove();
            var goods_name = $(this).text();
            var goods_id = $(this).attr("data-goods-id");
            var packing_spac = $(this).attr("data-packing-spac");
            let packing_unit = $(this).attr('data-packing-unit');
            let unit_name = $(this).data('unit_name');
            $("#goods_name").val(goods_name);
            $("#goods_id").val(goods_id);
            $("#goods_name").attr("data-packing-spac",packing_spac);
            $("#goods_name").attr("data-goodsname",goods_name);
            $("#min_limit").val(packing_spac);
            $("#num").val(packing_spac);
            $("#num").attr("disabled",false);
            $("#goods_name").after('<div style="margin-left: 10px;color:red;" class="notic">包装规格为：'+packing_spac+unit_name+'/'+packing_unit+'</div>');
        });

        $("#goods_name").blur(function(){
            let _goods_name = $(this).attr("data-goodsname");
            $(this).val(_goods_name);
        });
        layui.use(['layer'], function() {
            $("#goods_number").blur(function () {
                let spac = parseInt($("#goods_name").attr("data-packing-spac"));
                let goods_number = $(this).val();
                if (spac == 0) {
                    layer.msg("请先选择商品", {icon: 5, time: 1000});
                    return false;
                }
                if (goods_number =="" || goods_number ==0) {
                    console.log('123');
                    $(this).val(spac);
                    return false;
                }
                $(this).val(Math.ceil(goods_number/spac) * spac);
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
    </script>


@stop
