@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/brand/list" class="s-back">返回</a>品牌 - 添加品牌</div>
        <div class="content">

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
                                <div class="label"><span class="require-field">*</span>&nbsp;品牌首字母：</div>
                                <div class="label_value">
                                    <input type="text" name="brand_first_char" class="text" value="" maxlength="40" autocomplete="off" id="brand_first_char">
                                    <div class="form_prompt"></div>
                                    <div class="notic">请仔细填写品牌首字母</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;品牌Logo：</div>
                                <div class="label_value">
                                    <button type="button" class="layui-btn layui-btn-sm" style="float:left;margin-right:10px;" id="avatar">上传图片</button>
                                    <input type="hidden" size="0" value="" class="text" id="brand_logo" name="brand_logo" >
                                    <img  style="width:30px;height:30px;display:none;float:left;margin-right:10px;"    class="layui-upload-img" id="demo1" >
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>品牌描述：</div>
                                <div class="label_value">
                                    <textarea id="brand_desc" name="brand_desc" rows="5" cols="40"></textarea>
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>排序：</div>
                                <div class="label_value">
                                    <input type="text" name="sort_order" class="text text_2 valid" autocomplete="off" id="sort_order" value="50"/>
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>是否删除：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:30%;" name="is_delete" id="is_delete">
                                        <option  value="0">否</option>
                                        <option  value="1">是</option>
                                    </select>
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>是否推荐：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:30%;" name="is_recommend" id="is_recommend">
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
                                    <input type="hidden" name="id" value="">
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
            var uploadInst = upload.render({
                elem: '#avatar' //绑定元素
                ,url: "/uploadImg" //上传接口
                ,accept:'file'
                ,data:{'_token':tag_token}
                ,done: function(res){
                    //上传完毕回调
                    if(200 == res.code){
                        $('#demo1').show();
                        $('#brand_logo').val(res.data);
                        $('#demo1').attr('src', res.data);
                        layer.msg(res.msg, {time:2000});
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
                    brand_first_char :{
                        required : true,
                        isLetter : "[A-Z]"
                    },
                    category_links:{
                        required : true
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
                    brand_first_char :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    brand_desc :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    brand_logo:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'品牌logo不能为空'
                    }

                }
            });
        });
    </script>


@stop
