@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
<div class="warpper">
    <div class="title"><a href="/admin/link/list" class="s-back">返回</a>系统设置 - 编辑友情链接</div>
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
                                <input name="link_name" value="{{$link['link_name']}}" class="text" autocomplete="off" type="text">
                                <div class="notic m20">当你添加文字链接时, 链接LOGO为你的链接名称.</div>
                                <div class="form_prompt"></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="label"><span class="require-field">*</span>链接地址：</div>
                            <div class="label_value">
                                <input name="link_url" value="{{$link['link_url']}}" class="text" autocomplete="off" type="text">
                                <div class="form_prompt"></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="label">显示顺序：</div>
                            <div class="label_value">
                                <input name="sort_order" value="{{$link['sort_order']}}" class="text" autocomplete="off" type="text">
                            </div>
                        </div>
                        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                        <div class="item shop_logo">
                            <div class="label"><span class="require-field">*</span>链接LOGO：</div>
                            <div class="label_value">
                                <div class="type-file-box" style="width:600px;">
                                    <button type="button" class="layui-btn" id="avatar">上传图片</button>
                                    <input type="text"  class="text" id="link_logo" name="link_logo"  style="display:none;">
                                    <img @if(empty($link['link_logo'])) style="width:60px;height:60px;display:none;" @else style="width:60px;height:60px;" src="{{$link['link_logo']}}"  @endif  class="layui-upload-img" id="demo1" ><br/>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="label">或LOGO地址：</div>
                            <div class="label_value">
                                <input name="link_logo" id="remote_link_logo" class="text" autocomplete="off" value="{{$link['link_logo']}}" type="text">
                                <div class="notic m20">在指定远程LOGO图片时, LOGO图片的URL网址必须为http:// 或 https://开头的正确URL格式!</div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="label">&nbsp;</div>
                            <div class="label_value info_btn">
                                <input value="确定" class="button" id="submitBtn" type="submit">
                                <input type="hidden" name="id" value="{{$link['id']}}">
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
                elem: '#avatar' //绑定元素
                , url: "{{url('/uploadImg')}}" //上传接口
                , accept: 'file'
                , data: {'_token': tag_token}
                , done: function (res) {
                    //上传完毕回调
                    if (200 == res.code) {
                        $('#demo1').show();
                        $('#link_logo').val(res.data);
                        $('#demo1').attr('src', res.data);
                        $('#remote_link_logo').attr('name',"");
                        layer.msg(res.msg, {time: 2000});
                    } else {
                        layer.msg(res.msg, {time: 2000});
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

            jQuery.validator.addMethod("isMobile", function(value, element) {
                var length = value.length;
                var mobile = /^1[34578]\d{9}$/;/*/^1(3|4|5|7|8)\d{9}$/*/
                return this.optional(element) || (length == 11 && mobile.test(value));
            }, "请正确填写您的手机号码");




            $('#link_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                rules:{
                    link_name :{
                        required : true,
                    },
                    link_url :{
                        required : true
                    }
                },
                messages:{
                    link_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'链接名称不能为空'
                    },
                    link_url :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'链接地址不能为空'
                    }
                }
            });
        });
    </script>
@stop
