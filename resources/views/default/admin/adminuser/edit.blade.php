@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/adminuser/list?currpage={{$currpage}}" class="s-back">返回</a>管理员 - 编辑管理员</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/adminuser/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <input type="hidden" name="id" value="{{$adminUser['id']}}" >

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;账号：</div>
                                <div class="label_value">
                                    <input type="text" name="user_name" class="text" value="{{$adminUser['user_name']}}" maxlength="40" autocomplete="off" id="user_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;密码：</div>
                                <div class="label_value">
                                    <input type="text" name="password" class="text" value="" maxlength="40" autocomplete="off" id="password">
                                    <div class="form_prompt"></div>
                                    <div class="notic">留空表示不修改密码</div>
                                </div>

                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;真实姓名：</div>
                                <div class="label_value">
                                    <input type="text" name="real_name" class="text" value="{{$adminUser['real_name']}}" maxlength="40" autocomplete="off" id="real_name">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;手机：</div>
                                <div class="label_value">
                                    <input type="text" name="mobile" class="text" value="{{$adminUser['mobile']}}" maxlength="40" autocomplete="off" id="mobile">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>邮箱：</div>
                                <div class="label_value">
                                    <input type="text" name="email" class="text" value="{{$adminUser['email']}}" maxlength="40" autocomplete="off" id="email">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>头像：</div>
                                <div class="label_value">
                                    <button type="button" class="layui-btn upload-file" style="" data-type="" data-path="adminuser" >上传图片</button>
                                    <input type="text" value="{{$adminUser['avatar']}}" class="text"  name="avatar" style="display:none;">
                                    <img @if(!empty($adminUser['avatar'])) style="width:30px;height:30px;margin-right:10px;" src="{{getFileUrl($adminUser['avatar'])}}" @else style="width:30px;height:30px;display:none;margin-right:10px;"  @endif   class="layui-upload-img"><br/>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>


                            <div class="item">
                                <div class="label"><span class="require-field">*</span>性别：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="sex" id="sex">
                                        <option @if($adminUser['sex']==0) selected @endif value="0">保密</option>
                                        <option @if($adminUser['sex']==1) selected @endif value="1">男</option>
                                        <option @if($adminUser['sex']==2) selected @endif value="2">女</option>
                                    </select>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否为超级管理员：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="is_super" id="is_super">
                                        <option @if($adminUser['is_super']==0) selected @endif value="0">否</option>
                                        <option @if($adminUser['is_super']==1) selected @endif value="1">是</option>
                                    </select>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否冻结：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="is_freeze" id="is_freeze">
                                        <option @if($adminUser['is_freeze']==0) selected @endif value="0">否</option>
                                        <option @if($adminUser['is_freeze']==0) selected @endif value="1">是</option>
                                    </select>
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
                        item.siblings('img').parent('div').children(".form_prompt").remove();
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
                    real_name:{
                        required : true,
                    },
                    mobile:{
                        required : true,
                        number:true,
                    },
                    email:{
                        required : true,
                    },
                    avatar:{
                        required : true,
                    }
                },
                messages:{
                    user_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    real_name :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    mobile :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字'
                    },
                    email :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    avatar :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    }
                }
            });
        });
    </script>


@stop
