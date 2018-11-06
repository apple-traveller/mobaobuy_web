@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/goodscategory/list" class="s-back">返回</a>商品 - 添加分类</div>
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
                        <form action="/admin/goodscategory/save" method="post" name="theForm" enctype="multipart/form-data" id="category_info_form" novalidate="novalidate">
                            <div class="switch_info">
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;分类名称：</div>
                                    <div class="label_value">
                                        <input type="text" name="cat_name" class="text" id="cat_name" maxlength="20" value="" size="27">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>分类别名：</div>
                                    <div class="label_value">
                                        <input type="text" name="cat_alias_name" class="text" id="cat_alias_name" maxlength="20" value="" size="27">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label">上级分类：</div>
                                    <div class="label_value">

                                            <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="parent_id" id="parent_id">
                                                <option value="0">顶级分类</option>
                                                @foreach($catesTree as $cates)
                                                <option @if($cates['id']==$parent_id) selected @endif value="{{$cates['id']}}">|<?php echo str_repeat('-->',$cates['level']).$cates['cat_name'];?></option>
                                                @endforeach
                                            </select>

                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label">排序：</div>
                                    <div class="label_value">
                                        <input type="text" class="text text_4 valid" name="sort_order" id="sort_order" value="50" size="15" autocomplete="off" aria-invalid="false">
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label">是否显示：</div>
                                    <div class="label_value">
                                        <div class="checkbox_items">
                                            <div class="checkbox_item">
                                                <input type="radio" class="ui-radio" name="is_show" id="is_show_1" value="1" checked="true">
                                                <label for="is_show_1" class="ui-radio-label">是</label>
                                            </div>
                                            <div class="checkbox_item">
                                                <input type="radio" class="ui-radio" name="is_show" id="is_show_0" value="0">
                                                <label for="is_show_0" class="ui-radio-label">否</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label">是否显示在导航栏：</div>
                                    <div class="label_value">
                                        <div class="checkbox_items">
                                            <div class="checkbox_item">
                                                <input type="radio" class="ui-radio" name="is_nav_show" id="show_in_nav_1" value="1">
                                                <label for="show_in_nav_1" class="ui-radio-label">是</label>
                                            </div>
                                            <div class="checkbox_item">
                                                <input type="radio" class="ui-radio" name="is_nav_show" id="show_in_nav_0" value="0" checked="true">
                                                <label for="show_in_nav_0" class="ui-radio-label">否</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label">是否显示在顶部：</div>
                                    <div class="label_value">
                                        <div class="checkbox_items">
                                            <div class="checkbox_item">
                                                <input type="radio" class="ui-radio" name="is_top_show" id="is_top_style_1" value="1">
                                                <label for="is_top_style_1" class="ui-radio-label">是</label>
                                            </div>
                                            <div class="checkbox_item">
                                                <input type="radio" class="ui-radio" name="is_top_show" id="is_top_style_0" value="0" checked="true">
                                                <label for="is_top_style_0" class="ui-radio-label">否</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>

                                <div class="item">
                                    <div class="label">分类菜单图标：</div>
                                    <div class="label_value" >
                                            <div class="img_label_value" >
                                                <div style="cursor: pointer;" id="iconBtn">
                                                    <i class="layui-icon layui-icon-picture" style="font-size: 30px; "></i>点击查看图标库&nbsp;&nbsp;
                                                    <span><img id="iconImg" style="width:20px;height:20px;display:none;" src=""></span>
                                                </div>
                                                <style>
                                                    .img_item{width: 100%;
                                                        line-height: 30px;
                                                        float: left;
                                                        margin-bottom: 10px;}
                                                    .img_item .img_item_label {
                                                        width: 11%;
                                                        float: left;

                                                        padding-right: 8px;
                                                        /* font-weight: bold; */
                                                        color: #333;
                                                    }
                                                    .img_item .img_label_value {
                                                        width: 98%;
                                                        float: left;
                                                    }
                                                </style>

                                                <div class="img_item" style="height: 125px;display:none;overflow: hidden;">
                                                    {{--<div class="img_item_label" >请选择：</div>--}}
                                                    <div class="label_value" style="width: 100%">
                                                        @foreach($icons as $vo)
                                                            <div style="float:left;margin-right:10px;height:50px;" >
                                                                <input type="radio" class="iconButton" name="cat_icon" value="/default/icon/{{$vo}}" >
                                                                <img  style="width:20px;height:20px;" src="/default/icon/{{$vo}}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                自定义：

                                                <button type="button" class="layui-btn upload-file" data-type="" data-path="goodscategory" >上传图片</button>
                                                <input type="text" value="" class="text"  name="cat_icon" style="display:none;">
                                                <img  style="width:60px;height:60px;display:none;"    class="layui-upload-img"><br/>
                                                <div class="notic">（注：图标大小不能大于1M，格式为png和jpg）</div>
                                            </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;栏目链接：</div>
                                    <div class="label_value">
                                        <input type="text" name="category_links" class="text" id="category_links" maxlength="20" value="" size="27">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>



                                <div class="item">
                                    <div class="label">&nbsp;</div>
                                    <div class="label_value info_btn">
                                        <input type="submit" value=" 确定 " class="button" id="submitBtn">
                                        <input type="reset" value=" 重置 " class="button button_reset">
                                        <input type="hidden" name="id" value="">
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
        var tag_token = $("#_token").val();
        layui.use(['upload','layer'], function(){
            var upload = layui.upload;
            var layer = layui.layer;

            $("#iconBtn").click(function(){
                $('.img_item').slideToggle();
            });

            $(".iconButton").click(function(){
                //console.log($(this).val());
                $('#iconImg').attr('src',$(this).val());
                $('#iconImg').css('display',"inline");
                $('.img_item').slideToggle();
            });

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
                        $('#cat_icon').attr('checked','true');
                        $('#iconImg').css('display',"none");
                    }else{
                        layer.msg(res.msg, {time:2000});
                    }
                }
            });

        });

        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#category_info_form").valid()){
                    $("#category_info_form").submit();
                }
            });

            jQuery.validator.addMethod("specialchar", function(value, element) {
                return this.optional(element) || !/[@'\\"#$%&\^*]/.test(value);
            },("不能包含特殊字符"));

            $('#category_info_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                rules:{
                    cat_name :{
                        required : true,
                        specialchar:""
                    },
                    cat_alias_name :{
                        required : true
                    },
                    category_links:{
                        required : true
                    },
                },
                messages:{
                    cat_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'分类名称不能为空'
                    },
                    cat_alias_name :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'分类别名不能为空'
                    },
                    category_links:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'分类链接不能为空'
                    }
                }
            });
        });
    </script>

@stop
