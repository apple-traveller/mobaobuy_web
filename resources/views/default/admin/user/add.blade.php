@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/user/list" class="s-back">返回</a>用户 - 添加用户</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>添加用户。</li>
                    <li>标识“*”的选项为必填项，其余为选填项。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/user/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;登录用户名(手机号)：</div>
                                <div class="label_value">
                                    <input type="text" name="user_name" class="text" value="" maxlength="40" autocomplete="off" id="user_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;密码：</div>
                                <div class="label_value">
                                    <input type="password" name="password" class="text" value="" maxlength="40" autocomplete="off" id="password">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;昵称：</div>
                                <div class="label_value">
                                    <input type="text" name="nick_name" class="text" value="" maxlength="40" autocomplete="off" id="nick_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;电子邮箱：</div>
                                <div class="label_value">
                                    <input type="text" name="email" class="text" value="" maxlength="40" autocomplete="off" id="email">
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

        layui.use(['upload','layer'], function(){
            var upload = layui.upload;
            var layer = layui.layer;
            var isNull = /^[\s]{0,}$/;
            //文件上传
           $("#user_name").blur(function(){
               if (isNull.test($(this).val())) {
                   layer.msg('请输入手机号',{icon:1,time:1000});
                   $(this).val("");
                   return false;
               } else if (!Utils.isPhone($(this).val())) {
                   layer.msg('手机号格式不正确',{icon:1,time:1000});
                   $(this).val("");
                   return false;
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

            $('#article_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                ignore : [],
                rules:{
                    user_name :{
                        required : true,
                    },
                    password :{
                        required : true,
                    },
                },
                messages:{
                    user_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    password :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                }
            });
        });
    </script>


@stop
