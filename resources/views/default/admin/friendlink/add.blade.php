@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
<div class="warpper">
    <div class="title"><a href="/admin/link/list" class="s-back">返回</a>系统设置 - 添加新链接</div>
    <div class="content">
        <div class="explanation" id="explanation">
            <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
            <ul>
                <li>请认真填写链接名称、链接地址等信息。</li>
                <li>标识“<em>*</em>”的选项为必填项，其余为选填项。</li>
            </ul>
        </div>
        <div class="flexilist">
            <div class="mian-info">
                <form action="/admin/link/save" method="post" name="theForm" enctype="multipart/form-data" id="link_form" novalidate="novalidate">
                    <div class="switch_info user_basic">
                        <div class="item">
                            <div class="label"><span class="require-field">*</span>链接名称：</div>
                            <div class="label_value">
                                <input name="link_name" value="" class="text" autocomplete="off" type="text">
                                <div class="notic m20">当你添加文字链接时, 链接LOGO为你的链接名称.</div>
                                <div class="form_prompt"></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="label"><span class="require-field">*</span>链接地址：</div>
                            <div class="label_value">
                                <input name="link_url" value="" class="text" autocomplete="off" type="text">
                                <div class="form_prompt"></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="label">显示顺序：</div>
                            <div class="label_value">
                                <input name="sort_order" value="50" class="text" autocomplete="off" type="text">
                            </div>
                        </div>
                        <div class="item shop_logo">
                            <div class="label"><span class="require-field">*</span>链接LOGO：</div>
                            <div class="label_value">
                                <div class="type-file-box" style="width:600px;">
                                    <button type="button" class="layui-btn upload-file" data-type="friend_link" data-path="friend_link">上传图片</button>
                                    <input type="text"  class="text" name="link_logo"  style="display:none;">
                                    <img  style="width:60px;height:60px;display:none;"   class="layui-upload-img" id="demo1" ><br/>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="label">&nbsp;</div>
                            <div class="label_value info_btn">
                                <input value="确定" class="button" id="submitBtn" type="submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <script>
        var tag_token = $("#_token").val();
        layui.use(['upload','layer'], function() {
            var upload = layui.upload;
            var layer = layui.layer;

            //文件上传
            var uploadInst = upload.render({
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
            //表单验证
            $("#submitBtn").click(function(){
                if($("#link_form").valid()){
                    $("#link_form").submit();
                }
            });

            $('#link_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                ignore : [],
                rules:{
                    link_name :{
                        required : true,
                    },
                    link_url :{
                        required : true,
                    },
                    link_logo:{
                        required:true,
                    }
                },
                messages:{
                    link_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'链接名称不能为空'
                    },
                    link_url :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'链接地址不能为空'
                    },
                    link_logo:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'链接LOGO不能为空'
                    }
                }
            });
        });
    </script>
@stop
