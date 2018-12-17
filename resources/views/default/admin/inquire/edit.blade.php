@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <script src="{{asset(themePath('/').'plugs/zTree_v3/js/jquery.ztree.core.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/create_cat_tree.js')}}" ></script>
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/zTree_v3/css/zTreeStyle/zTreeStyle.css')}}" />
    <div class="menuContent" style="display:none; position: absolute;">
        <ul id="setCatTree" class="ztree treeSelect" style="margin-top:0;border: 1px solid #617775;background:#f0f6e4;width: 309px;height: 360px;overflow-y: scroll;overflow-x: auto;"></ul>
    </div>

    <div class="warpper">
        <div class="title"><a href="/admin/inquire/index?currpage={{$currpage}}" class="s-back">返回</a>求购 - 编辑求购信息</div>
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
                    <form action="/admin/inquire/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <div class="item">
                                <div class="label">&nbsp;选择商品分类：</div>
                                <div class="label_value">
                                    <input type="hidden" name="cat_id" id="cat_id"/>
                                    <input type="text" name="cat_id_LABELS"  autocomplete="off" treeId="" id="cat_name" treeDataUrl="/admin/goodscategory/getCategoryTree" size="40"  class="text" title="">
                                    <div style="" class="notic">商品分类用于辅助选择商品</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商品：</div>
                                <div class="label_value">
                                    <input type="text" data-goodsname="" data-packing-spec="0" value="{{$inquire['goods_name']}}"  autocomplete="off" id="goods_name" size="40"  class="text">
                                    <input type="hidden" value="{{$inquire['goods_id']}}" name="goods_id"  id="goods_id">
                                    <div class="form_prompt"></div>
                                    <div style="margin-left: 10px;color:red;" class="notic">包装规格为：{{$goods['packing_spec']}} {{$goods['unit_name']}}/{{$goods['packing_unit']}}</div>
                                    <ul class="query_goods_name" style="overflow:auto;display:none;height:200px;position: absolute;top: 101px; background: #fff;padding-left:20px;width: 300px; z-index: 2; box-shadow: 1px 1px 1px 1px #dedede;">
                                    </ul>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;数量(<span style="color:#909090;" class="unit-name">{{$inquire['unit_name']}}</span>)：</div>
                                <div class="label_value">
                                    <input type="text" name="num" class="text" value="{{$inquire['num']}}" maxlength="40" autocomplete="off" id="num">
                                    <div class="form_prompt"></div>
                                    <div style="" class="notic">包装规格的整数倍，向下取整</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;意向价格(<span style="color:#909090;" >元</span>)：</div>
                                <div class="label_value">
                                    <input type="text" name="price" class="text" value="{{$inquire['price']}}" maxlength="40" autocomplete="off" id="price">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货地：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_area" class="text" value="{{$inquire['delivery_area']}}" maxlength="40" autocomplete="off" id="delivery_area">
                                    <div style="margin-left: 10px" class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货时间：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_time" class="text" value="{{$inquire['delivery_time']}}" maxlength="40" autocomplete="off" id="delivery_time">
                                    <div style="margin-left: 10px" class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;联系人：</div>
                                <div class="label_value">
                                    <input type="text" name="contacts" class="text" value="{{$inquire['contacts']}}" maxlength="40" autocomplete="off" id="contacts">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;手机号：</div>
                                <div class="label_value">
                                    <input type="text" name="contacts_mobile" class="text" value="{{$inquire['contacts_mobile']}}" maxlength="40" autocomplete="off" id="contacts_mobile">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;qq：</div>
                                <div class="label_value">
                                    <input type="text" name="qq" class="text" value="{{$inquire['qq']}}" maxlength="40" autocomplete="off" id="qq">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <input type="hidden" name="id" value="{{$inquire['id']}}">
                            <input type="hidden" name="currpage" value="{{$currpage}}">

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

        layui.use(['layer'], function(){
            var layer = layui.layer;

            $("#num").blur(function(){
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
                    num :{
                        required : true,
                        number:true
                    },
                    goods_id:{
                        required : true,
                    },
                    price:{
                        required:true,
                    },
                    delivery_area:{
                        required:true,
                    },
                    contacts:{
                        required:true,
                    },
                    contacts_mobile:{
                       required:true,
                    },
                },
                messages:{
                    num :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字',
                    },
                    goods_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    price :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    delivery_area :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    contacts:{
                        required :'<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    contacts_mobile:{
                       required :'<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                }
            });

            document.onclick=function(event){
                $(".query_goods_name").hide();
            }

            //获取树形分类
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
                $("#num").val("");
                $("#goods_name").after('<div style="margin-left: 10px;color:red;" class="notic">包装规格为：'+packing_spec+unit_name+'/'+packing_unit+'</div>');

                $('#goods_number').val(packing_spec);
            });

            $("#goods_name").blur(function(){
                let _goods_name = $(this).attr("data-goodsname");
                $(this).val(_goods_name);
            });
        });
    </script>


@stop
