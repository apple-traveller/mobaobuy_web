@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    @include('vendor.ueditor.assets')
    <style>
        .mian-info .item .label {width: 15%;}
    </style>
    <div class="warpper">
        <div class="title"><a href="/admin/goods/list" class="s-back">返回</a>商品 - 添加商品</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>添加商品。</li>
                    <li>标识“*”的选项为必填项，其余为选填项。</li>
                    <li>最小起订量不能小于规格，并且是规格的整数倍。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/goods/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;商品名称：</div>
                                <div class="label_value">
                                    <input type="text" name="goods_name" class="text" value="" maxlength="40" autocomplete="off" id="goods_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;商品英文名称：</div>
                                <div class="label_value">
                                    <input type="text" name="goods_name_en" class="text" value="" maxlength="40" autocomplete="off" id="goods_name_en">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;关键词：</div>
                                <div class="label_value">
                                    <input type="text" name="keywords" class="text" value="" maxlength="40" autocomplete="off" id="keywords">
                                    <div class="form_prompt"></div>
                                    <div class="notic">关键词，多个用|分隔</div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>特殊规格：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="is_special" id="is_special">
                                        <option value="0" selected="selected">否</option>
                                        <option value="1">是</option>
                                    </select>
                                    <div style="margin-left:10px;" class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>所属品牌：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="brand_id" id="brand_id">
                                        <option value="">请选择品牌</option>
                                        @if(!empty($brands))
                                        @foreach($brands as $v)
                                            <option  value="{{$v['id']}}" en="{{$v['brand_name_en']}}">{{$v['brand_name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <div style="margin-left:10px;" class="form_prompt"></div>
                                    <input class="brand_name" type="hidden" name="brand_name" value="">
                                    <input class="brand_name_en" type="hidden" name="brand_name_en" value="">
                                </div>

                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>所属分类：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="cat_id" id="cat_id">
                                        <option value="">请选择分类</option>
                                        @if(!empty($cateTrees))
                                            @foreach($cateTrees as $v)
                                                <option  value="{{$v['id']}}">|<?php echo str_repeat('-->',$v['level']).$v['cat_name'];?></option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div style="margin-left:10px;" class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>单位名称：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="unit_id" id="unit_id">
                                        <option value="">请选择单位</option>
                                        @foreach($units as $v)
                                            <option  value="{{$v['id']}}">{{$v['unit_name']}}</option>
                                        @endforeach
                                    </select>
                                    <div style="margin-left:10px;" class="form_prompt"></div>
                                    <input class="unit_name" type="hidden" name="unit_name" value="{{$units[0]['unit_name']}}">
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;商品型号：</div>
                                <div class="label_value">
                                    <input type="text" name="goods_model" class="text" value="" maxlength="40" autocomplete="off" id="goods_model">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;包装规格：</div>
                                <div class="label_value">
                                    <input type="text" name="packing_spec" class="text" value="" maxlength="40" autocomplete="off" id="packing_spec">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;最小起订量：</div>
                                <div class="label_value">
                                    <input type="text" name="min_limit" class="text" value="" maxlength="40" autocomplete="off" id="min_limit">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;含量：</div>
                                <div class="label_value">
                                    <input type="text" name="goods_content" class="text" value="" maxlength="40" autocomplete="off" id="goods_content">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;英文含量：</div>
                                <div class="label_value">
                                    <input type="text" name="goods_content_en" class="text" value="" maxlength="40" autocomplete="off" id="goods_content_en">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;包装单位：</div>
                                <div class="label_value">
                                    <input type="text" name="packing_unit" class="text" value="" maxlength="40" autocomplete="off" id="packing_unit">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;英文包装单位：</div>
                                <div class="label_value">
                                    <input type="text" name="packing_unit_en" class="text" value="" maxlength="40" autocomplete="off" id="packing_unit_en">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;商品属性：</div>
                                <div class="label_value">
                                    <div class="attribute"></div>
                                    <input type="hidden" id="goods_attr" name="goods_attr">
                                    <div class="layui-btn attr-btn"  style="margin-top:5px;float:left;">
                                        <i class="layui-icon">&#xe608;</i> 添加属性
                                    </div>
                                    <div style="margin-left: 20px;line-height: 50px;" class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">商品图片：</div>
                                <div class="label_value">
                                    <button style="float: left;" type="button" class="layui-btn upload-file" data-type="" data-path="goods" >
                                        <i class="layui-icon">&#xe681;</i> 上传图片
                                    </button>
                                    <input type="hidden" value="" class="text" id="original_img"  name="original_img" style="display:none;">
                                    <img  style="width:60px;height:60px;display:none;margin-top: -5px;margin-left:10px;" class="layui-upload-img">
                                    <div style="margin-left: 10px;line-height:40px;" class="form_prompt"></div>
                                </div>
                            </div>



                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;市场价：</div>
                                <div class="label_value">
                                    <input type="text" name="market_price" class="text" value="" maxlength="40" autocomplete="off" id="market_price">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>

                            {{--<div class="item">--}}
                                {{--<div class="label"><span class="require-field">*</span>&nbsp;商品重量：</div>--}}
                                {{--<div class="label_value">--}}
                                    {{--<input type="text" name="goods_weight" class="text" value="" maxlength="40" autocomplete="off" id="goods_weight">--}}
                                    {{--<div class="form_prompt"></div>--}}
                                    {{--<div class="notic"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="item">
                                <div class="label">&nbsp;pc商品详情：</div>
                                <div class="label_value">
                                    <script id="goods_desc" name="goods_desc" type="text/plain"></script>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;pc商品英文详情：</div>
                                <div class="label_value">
                                    <script id="goods_desc_en" name="goods_desc_en" type="text/plain"></script>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;移动端商品详情：</div>
                                <div class="label_value">
                                    <script id="desc_mobile" name="desc_mobile" type="text/plain"></script>
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
        var ue1 = UE.getEditor('goods_desc',{initialFrameHeight:400});
        ue1.ready(function() {
            ue1.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });

        var ue2 = UE.getEditor('desc_mobile',{initialFrameHeight:400});
        ue2.ready(function() {
            ue2.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });

        var ue3 = UE.getEditor('goods_desc_en',{initialFrameHeight:400});
        ue3.ready(function() {
            ue3.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
    <script type="text/javascript">
        var tag_token = $("#_token").val();

        //选择品牌的同时给隐藏的brand_name赋值
        $("#brand_id").change(function(){
            var option = $("#brand_id option:selected");
            $(".brand_name").val(option.text());
            $(".brand_name_en").val(option.attr('en'));
        })

        //选择单位的同时给隐藏的unit_name赋值
        $("#unit_id").change(function(){
            var option = $("#unit_id option:selected");
            $(".unit_name").val(option.text());
        })

        //属性名输入框获取焦点事件
        $(document).delegate(".attr_name","focus",function(){
            $(".query").children().filter("li").remove();
            $.post('/admin/goods/getAttrs',{'attr_name':"",'_token':tag_token},function(res){
                if(res.code==200){
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        $(".query").append('<li class="searchAttr" attr-id="'+data[i].id+'" style="cursor: pointer;">'+data[i].attr_name+'</li>');
                    }
                }
            },"json");
        });


        //属性名输入框模糊查询
        $(document).delegate(".attr_name","input oninput",function(){
            var attr_name = $(this).val();
            $(".query").children().filter("li").remove();
            $.post('/admin/goods/getAttrs',{'attr_name':attr_name,'_token':tag_token},function(res){
                if(res.code==200){
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        $(".query").append('<li class="searchAttr" attr-id="'+data[i].id+'" style="cursor: pointer;">'+data[i].attr_name+'</li>');
                    }
                }
            },"json");
        });

        //属性值输入框获取焦点事件
        $(document).delegate(".attr_value","focus",function(){
            var attr_id = $(".attr_name").attr('attr-id');
            $(".query1").children().filter("li").remove();
            $.post('/admin/goods/getAttrValues',{'attr_id':attr_id,'_token':tag_token},function(res){
                if(res.code==200){
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        $(".query1").append('<li class="searchAttrValue" attr-value-id="'+data[i].id+'" style="cursor: pointer;">'+data[i].attr_value+'</li>');
                    }
                }
            },"json");
        });

        //属性值输入框模糊查询
        $(document).delegate(".attr_value","input oninput",function(){
            var attr_value = $(this).val();
            $(".query1").children().filter("li").remove();
            $.post('/admin/goods/getAttrValues',{'attr_value':attr_value,'_token':tag_token},function(res){
                if(res.code==200){
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        $(".query1").append('<li class="searchAttrValue" attr-value-id="'+data[i].id+'" style="cursor: pointer;">'+data[i].attr_value+'</li>');
                    }
                }
            },"json");
        });

        $(document).delegate(".searchAttr","click",function(){
            var attr_name = $(this).text();
            var attr_id = $(this).attr('attr-id');
            $(".attr_name").val(attr_name);
            $(".attr_name").attr('attr-id',attr_id);
            $(".query").children().filter("li").remove();
        });

        $(document).delegate(".searchAttrValue","click",function(){
            var attr_value = $(this).text();
            var attr_value_id = $(this).attr('attr-value-id');
            $(".attr_value").val(attr_value);
            $(".attr_value").attr('attr-value-id',attr_value_id);
            $(".query1").children().filter("li").remove();
        });


        layui.use(['upload','layer'], function() {
            var upload = layui.upload;
            var layer = layui.layer;
            var index = 0;

            //添加属性
            $(".attr-btn").click(function () {
                index = layer.open({
                    type: 1,
                    title: '添加属性',
                    area: ['500px', '300px'],
                    content: '<div style="position: relative;"> <input  type="text"  attr-id="" style="margin-left:20px;width:130px;" placeholder="属性名" class="text attr_name" />' +
                    '<ul class="query" style="position: absolute;top: 30px;left:20px;background: #fff;width: 152px; box-shadow: 1px 1px 1px 1px #dedede;">' +
                    '</ul>' +
                    '<input type="text" attr-value-id=""  style="width:130px;" placeholder="属性值" class="text attr_value" >' +
                    '<ul class="query1" style="position: absolute;top: 30px;left: 188px;background: #fff;width: 144px; box-shadow: 1px 1px 1px 1px #dedede;">' +
                    '</ul></div>' +
                    '<div><button  class="layui-btn layui-btn-sm layui-btn-danger">确定</button></div>'
                });

            });

            $(document).delegate(".layui-btn-danger","click",function(){

                var attr_name=$(".attr_name").val();
                var attr_value=$(".attr_value").val();
                var goods_attr=$("#goods_attr").val();
                if(attr_name==""){
                    layer.close(index);//关闭弹窗
                    return ;
                }
                if(attr_value==""){
                    layer.close(index);//关闭弹窗
                    return ;
                }
                $(".attribute").append('<div style="width:299px;margin-top:10px;height:28px;" ><span style="font-size:16px;color:skyblue;" >'+attr_name+':'+attr_value+'</span>&nbsp;&nbsp;<button style="font-size:14px;color:#8bff58;cursor:pointer;" class="deleteAttr layui-btn layui-btn-xs" attr-data="'+attr_name+':'+attr_value+'" >删除</button></div>');

                if(goods_attr==""){
                    $("#goods_attr").val(attr_name+":"+attr_value);
                }else{
                    $("#goods_attr").val(attr_name+":"+attr_value+";"+goods_attr);
                }
                layer.close(index);//关闭弹窗
            });

            $(document).delegate(".deleteAttr","click",function(){
                var currAttr = $(this).attr('attr-data');
                var attrCollection = $("#goods_attr").val().split(";");//字符串转数组
                attrCollection.splice($.inArray(currAttr,attrCollection),1);//删除
                $("#goods_attr").val(attrCollection.join(';'));
                console.log($("#goods_attr").val());
                $(this).parent('div').remove();
            });
        });

        layui.use(['upload','layer'], function(){
            var upload = layui.upload;
            var layer = layui.layer;

            //文件上传
            upload.render({
                elem: '.upload-file' //绑定元素
                ,url: "/uploadImg" //上传接口
                ,accept:'file'
                ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                    this.data={'upload_type':this.item.attr('data-type'),'upload_path':this.item.attr('data-path')};
                }
                ,done: function(res){
                    //上传完毕回调
                    if(1 == res.code){
                        var item = this.item;
                        item.siblings('input').attr('value', res.data.path);
                        item.siblings('img').show().attr('src', res.data.url);
                        item.siblings('div').filter(".form_prompt").remove();
                    }else{
                        layer.msg(res.msg, {time:2000});
                    }
                }
            });
        });

        $(function(){
            $('#is_special').change(function(){
                var _val = $(this).val();
                if(_val == 1){
                    $('#brand_id option:first').val(0);
                    $('#unit_id option:first').val(0);
                    $('#packing_spec').val(1);
                    $('#min_limit').val(1);
                    $('#goods_content').val('100%');
                    $('#packing_unit').val('箱');
                    $('#market_price').val(1);
                }else{
                    $('#brand_id option:first').val('');
                    $('#unit_id option:first').val('');
                    $('#packing_spec').val('');
                    $('#min_limit').val('');
                    $('#goods_content').val('');
                    $('#packing_unit').val('');
                    $('#market_price').val('');
                }
            });
            //表单验证
            $("#submitBtn").click(function(){
                if($("#article_form").valid()){
                    $("#article_form").submit();
                }
            });

            //清空表单editorBox.setContent('')
            $('.button_reset').click(function(){
                ue1.setContent('');
                ue2.setContent('');
                ue3.setContent('');
            });

            $('#article_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                ignore : [],
                rules:{
                    goods_name :{
                        required : true,
                    },
                    goods_name_en :{
                        required : true,
                    },
                    keywords:{
                        required : true
                    },
                    brand_id:{
                        required : true
                    },
                    unit_id:{
                        required : true
                    },
//                    goods_model:{
//                        required : true
//                    },
                    packing_spec:{
                        required : true,
                        number:true,
                    },
                    min_limit:{
                        required : true,
                        number:true,
                    },
                    packing_unit:{
                        required : true
                    },
                    packing_unit_en:{
                        required : true
                    },
                    market_price:{
                        required : true,
                        number:true
                    },
//                    goods_weight:{
//                        required : true,
//                        number:true
//                    },
//                    goods_attr:{
//                        required:true
//                    },
                    cat_id:{
                        required:true
                    },
                    goods_content:{
                        required :true,
                    },
                    goods_content_en:{
                        required :true,
                    },
//                    original_img:{
//                        required :true,
//                    },

                },
                messages:{
                    goods_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    goods_name_en:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    keywords:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    brand_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    unit_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
//                    goods_model :{
//                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
//                    },
                    packing_spec :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字'
                    },
                    min_limit :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字'
                    },
                    packing_unit :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    packing_unit_en :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    market_price :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字',
                    },
//                    goods_weight :{
//                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
//                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字',
//                    },
//                    goods_attr :{
//                        required : '<i class="icon icon-exclamation-sign"></i>'+'不能为空',
//                    },
                    cat_id:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    goods_content:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    goods_content_en:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
//                    original_img:{
//                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
//                    },
                }
            });
            $('#packing_spec').change(function(){
                $('#min_limit').val('');
            });
        });
    </script>


@stop
