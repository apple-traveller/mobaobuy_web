@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/shop/list" class="s-back">返回</a>店铺 - 添加入驻店铺</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/shop/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;会员：</div>
                                <div class="label_value">
                                    <input type="text" name="nick_name" class="text" value="" maxlength="40" autocomplete="off" id="nick_name">
                                    <input type="hidden" name="user_id" class="text" value="" maxlength="40" autocomplete="off" id="user_id">
                                    <ul class="query" style="position: absolute;top: 60px; background: #fff;width: 320px; box-shadow: 1px 1px 1px 1px #dedede;">

                                    </ul>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;店铺名称：</div>
                                <div class="label_value">
                                    <input type="text" name="shop_name" class="text" value="" maxlength="40" autocomplete="off" id="shop_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;企业全称：</div>
                                <div class="label_value">
                                    <input type="text" name="company_name" class="text" value="" maxlength="40" autocomplete="off" id="company_name">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;负责人姓名：</div>
                                <div class="label_value">
                                    <input type="text" name="contactName" class="text" value="" maxlength="40" autocomplete="off" id="contactName">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>负责人手机：</div>
                                <div class="label_value">
                                    <input type="text" name="contactPhone" class="text" value="" maxlength="40" autocomplete="off" id="contactPhone">
                                    <div class="form_prompt"></div>
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>授权委托书电子版：</div>
                                <div class="label_value">
                                    <button type="button" class="layui-btn layui-btn-sm" style="float:left;margin-right:10px;" id="avatar_attorney_letter_fileImg">上传图片</button>
                                    <input type="hidden"  value="" class="text" id="attorney_letter_fileImg" name="attorney_letter_fileImg" >
                                    <img  style="width:30px;height:30px;display:none;float:left;margin-right:10px;" class="layui-upload-img" id="demo_attorney_letter_fileImg" >
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;营业执照副本电子版：</div>
                                <div class="label_value">
                                    <button type="button" class="layui-btn layui-btn-sm" style="float:left;margin-right:10px;" id="avatar_license_fileImg">上传图片</button>
                                    <input type="hidden"  value="" class="text" id="license_fileImg" name="license_fileImg" >
                                    <img  style="width:30px;height:30px;display:none;float:left;margin-right:10px;" class="layui-upload-img" id="demo_license_fileImg" >
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>营业执照注册号：</div>
                                <div class="label_value">
                                    <input type="text" name="business_license_id" class="text" value="" maxlength="40" autocomplete="off" id="business_license_id">
                                    <div class="form_prompt"></div>
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>纳税人识别号：</div>
                                <div class="label_value">
                                    <input type="text" name="taxpayer_id" class="text" value="" maxlength="40" autocomplete="off" id="taxpayer_id">
                                    <div class="form_prompt"></div>
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否自营：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="is_self_run" id="is_self_run">
                                        <option value="0">否</option>
                                        <option selected  value="1">是</option>
                                    </select>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否自营：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="is_self_run" id="is_self_run">
                                        <option value="0">否</option>
                                        <option selected  value="1">是</option>
                                    </select>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否通过审核：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="is_validated" id="is_validated">
                                        <option value="0">否</option>
                                        <option selected value="1">是</option>
                                    </select>
                                </div>
                            </div>


<hr>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>默认店铺管理员：</div>
                                <div class="label_value">
                                    <input type="text" name="user_name" class="text" value="" maxlength="40" autocomplete="off" id="user_name">
                                    <div class="form_prompt"></div>
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>店铺管理员密码：</div>
                                <div class="label_value">
                                    <input type="text" name="password" class="text" value="" maxlength="40" autocomplete="off" id="password">
                                    <div class="form_prompt"></div>
                                </div>
                                <div class="form_prompt"></div>
                            </div>


                            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
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
        var tag_token = $("#_token").val();

        layui.use(['upload','layer'], function() {
            var upload = layui.upload;
            var layer = layui.layer;
            //文件上传
            var uploadInst = upload.render({
                elem: '#avatar_attorney_letter_fileImg' //绑定元素
                , url: "/uploadImg" //上传接口
                , accept: 'file'
                , data: {'_token': tag_token}
                , done: function (res) {
                    //上传完毕回调
                    if (200 == res.code) {
                        $("#demo_attorney_letter_fileImg").show();
                        $('#attorney_letter_fileImg').val(res.data);
                        $("#demo_attorney_letter_fileImg").parent('div').children(".form_prompt").remove();
                        $("#demo_attorney_letter_fileImg").attr('src', res.data);
                        layer.msg(res.msg, {time: 2000});
                    } else {
                        layer.msg(res.msg, {time: 2000});
                    }
                }
            });

            //文件上传
            var uploadInst = upload.render({
                elem: '#avatar_license_fileImg' //绑定元素
                , url: "/uploadImg" //上传接口
                , accept: 'file'
                , data: {'_token': tag_token}
                , done: function (res) {
                    //上传完毕回调
                    if (200 == res.code) {
                        $("#demo_license_fileImg").show();
                        $('#license_fileImg').val(res.data);
                        $("#license_fileImg").parent('div').children(".form_prompt").remove();
                        $("#demo_license_fileImg").attr('src', res.data);
                        layer.msg(res.msg, {time: 2000});
                    } else {
                        layer.msg(res.msg, {time: 2000});
                    }
                }
            });


        });

        $("#nick_name").focus(function(){
            $.post('/admin/shop/getUsers',{'_token':tag_token},function(res){
                if(res.code==200){
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        $(".query").append('<li class="searchAttr" data-id="'+data[i].id+'" style="cursor: pointer;padding-left: 10px;box-sizing: border-box;">'+data[i].nick_name+'</li>');
                    }
                }
            },"json");
        });

        //user_id输入框模糊查询
        $("#nick_name").bind("input propertychange",function(res){
            var nick_name = $(this).val();
            $(".query").children().filter("li").remove();
            $.post('/admin/shop/getUsers',{'nick_name':nick_name,'_token':tag_token},function(res){
                if(res.code==200){
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        $(".query").append('<li class="searchAttr" data-id="'+data[i].id+'" style="cursor: pointer;padding-left: 10px;box-sizing: border-box;">'+data[i].nick_name+'</li>');
                    }
                }
            },"json");
        });

        $(document).delegate(".searchAttr","click",function(){
            var nick_name = $(this).text();
            var user_id = $(this).attr('data-id');
            $("#user_id").val(user_id);
            $("#nick_name").val(nick_name);
            $(".query").children().filter("li").remove();
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
                    shop_name :{
                        required : true,
                    },
                    company_name :{
                        required : true,
                    },
                    contactName:{
                        required : true,
                    },
                    contactPhone:{
                        required : true,
                        number:true,
                    },
                    attorney_letter_fileImg:{
                        required : true,
                    },
                    license_fileImg:{
                        required : true,
                    },
                    business_license_id:{
                        required : true,
                        number:true,
                    },
                    taxpayer_id:{
                        required : true,
                        number:true,
                    }
                },
                messages:{
                    shop_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    company_name :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    contactName :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    contactPhone :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字'
                    },
                    attorney_letter_fileImg :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    license_fileImg :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                    business_license_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字'
                    },
                    taxpayer_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字'
                    }
                }
            });
        });
    </script>


@stop
