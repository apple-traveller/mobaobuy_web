@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/brand/list" class="s-back">返回</a>品牌 - 添加品牌</div>
        <div class="content">

            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>标识“*”的选项为必填项，其余为选填项。</li>
                </ul>
            </div>

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/brand/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;品牌名称：</div>
                                <div class="label_value">
                                    <input type="text" name="brand_name" class="text" value="" maxlength="40" autocomplete="off" id="brand_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;品牌英文名称：</div>
                                <div class="label_value">
                                    <input type="text" name="brand_name_en" class="text" value="" maxlength="40" autocomplete="off" id="brand_name_en">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;品牌首字母：</div>
                                <div class="label_value">
                                    <input type="text" name="brand_first_char" class="text" value="" maxlength="40" autocomplete="off" id="brand_first_char">
                                    <div class="form_prompt"></div>
                                    <div class="notic">请仔细填写品牌首字母</div>
                                </div>
                            </div>

                            <div style="margin-top:10px;" class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;品牌Logo：</div>
                                <div class="label_value">
                                    <button style="float: left;" type="button" class="layui-btn upload-file" data-type="" data-path="brand" ><i class="layui-icon">&#xe681;</i>上传图片</button>
                                    <input type="text" value="" class="text"  name="brand_logo" style="display:none;">
                                    <img  style="width:60px;height:60px;margin-left:10px;margin-top:-10px;display:none;"   class="layui-upload-img">
                                    <div style="float: left;" style="float: left;margin-left: 10px;line-height: 36px;" class="form_prompt brand_logo"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>品牌描述：</div>
                                <div class="label_value">
                                    <textarea id="brand_desc" name="brand_desc" class="textarea"></textarea>
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>排序：</div>
                                <div class="label_value">
                                    <input type="text" name="sort_order" class="text" autocomplete="off" id="sort_order" value="50"/>
                                </div>
                                <div class="form_prompt"></div>
                            </div>


                            <div class="item">
                                <div class="label"><span class="require-field">*</span>是否推荐：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="is_recommend" id="is_recommend">
                                        <option  value="0">否</option>
                                        <option  value="1">是</option>
                                    </select>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
                                    <input type="submit" value=" 确定 " class="button" id="submitBtn">
                                    <input type="reset" value=" 重置 " class="button button_reset">
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var tag_token = $("#_token").val();
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
                        $(".brand_logo").remove();
                    }else{
                        layer.msg(res.msg, {time:2000});
                    }
                }
            });

        });

        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#article_form").valid()){
                    $("#article_form").submit();
                }
            });

            jQuery.validator.addMethod("isLetter", function(value,element,params) {
                var exp = new RegExp(params);//实例化正则对象，参数为传入的正则表达式
                return exp.test(value);
            }, "只能是一位大写字母");

            $('#article_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                ignore : [],
                rules:{
                    brand_name :{
                        required : true,
                    },
                    brand_name_en :{
                        required : true,
                    },
                    brand_first_char :{
                        required : true,
                        isLetter : "[A-Z]"
                    },
                    brand_logo:{
                        required : true
                    },
                    brand_desc:{
                        required : true
                    },
                },
                messages:{
                    brand_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    brand_name_en:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    brand_first_char :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    brand_logo:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'品牌logo不能为空'
                    },
                    brand_desc :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                }
            });
        });
    </script>


@stop
