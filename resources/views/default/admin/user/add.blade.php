@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/user/list" class="s-back">返回</a>会员 - 添加会员</div>
        <div class="content">
            <div class="tabs_info">
                <ul>
                    <li class="curr"><a href="javascript:;">添加会员</a></li>
                    <li><a href="mc_user.php">会员批量添加</a></li>
                </ul>
            </div>
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>可从管理平台手动添加一名新会员，并填写相关信息。</li>
                    <li>标识“<em>*</em>”的选项为必填项，其余为选填项。</li>
                    <li>新增会员后可从会员列表中找到该条数据，并再次进行编辑操作，但该会员名称不可变。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-content">
                    <div class="mian-info">
                        <form method="post" action="/user/add" name="theForm" id="user_form" novalidate="novalidate">
                            <div class="switch_info">
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;会员名称：</div>
                                    <div class="label_value">
                                        <input type="text" id="user_name" name="user_name" class="text" value="" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;昵称：</div>
                                    <div class="label_value">
                                        <input type="text" id="nick_name" name="nick_name" class="text" value="" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;邮件地址：</div>
                                    <div class="label_value">
                                        <input type="text" name="email" class="text" value="" id="email" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;登录密码：</div>
                                    <div class="label_value">
                                        <input type="password" style="display:none">
                                        <input type="password" name="password" class="text" value="" id="password">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;确认密码：</div>
                                    <div class="label_value">
                                        <input type="password" style="display:none">
                                        <input type="password" name="confirm_password" class="text" value="" id="confirm_password">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label">性别：</div>
                                    <div class="label_value">
                                        <div class="checkbox_items">

                                            <div class="checkbox_item">
                                                <input type="radio" class="ui-radio" name="sex" id="sex_1" value="1" checked="">
                                                <label for="sex_1" class="ui-radio-label">男</label>
                                            </div>
                                            <div class="checkbox_item">
                                                <input type="radio" class="ui-radio" name="sex" id="sex_2" value="0" checked="">
                                                <label for="sex_2" class="ui-radio-label">女</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label">出生日期：</div>
                                    <div class="label_value">
                                        <div class="layui-inline">
                                            <input name="birthday" type="text" class="layui-input" id="test1">
                                        </div>
                                    </div>
                                </div>

                                <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>

                                <!---->
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>身份证号：</div>
                                    <div class="label_value">
                                        <input type="text" id="id_card" name="id_card" class="text" value="" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>身份证正面：</div>
                                    <div class="label_value">
                                        <button type="button" class="layui-btn" id="avatar">上传图片</button>
                                        <input type="text" class="text" id="front_of_id_card" name="front_of_id_card"  style="display:none;" >
                                        <img style="width:50px;height:50px;display:none;"  class="layui-upload-img" id="demo1" >
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>身份证反面：</div>
                                    <div class="label_value">
                                        <button type="button" class="layui-btn" id="avatar2">上传图片</button>
                                        <input type="text" class="text" id="reverse_of_id_card" name="reverse_of_id_card" style="display:none;">
                                        <img style="width:50px;height:50px;display:none;"  class="layui-upload-img" id="demo3" >
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label">&nbsp;</div>
                                    <div class="label_value info_btn">
                                        <a href="javascript:;" class="button" id="submitBtn"> 确定 </a>
                                        <input type="hidden" name="act" value="insert">
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
        /*这里把JS用到的所有语言都赋值到这里*/
        var process_request = "<i class='icon-spinner icon-spin'></i>";

        var todolist_confirm_save = "是否将更改保存到记事本？";
        var todolist_confirm_clear = "是否清空内容？";
        var start_data_notnull = "开始日期不能为空";
        var end_data_notnull = "结束日期不能为空";
        var data_invalid_gt = "输入的结束时间应大于起始日期";
        var file_not_null = "上传文件不能为空";
        var confirm_delete = "确定删除吗?";
        var confirm_delete_fail = "删除失败";
        var file_null = "请选择上传文件";
        var title_name_one = "已完成更新，请关闭该窗口！";
        var title_name_two = "正在更新数据中，请勿关闭该窗口！";
        var no_username = "没有输入用户名。";
        var invalid_email = "没有输入邮件地址或者输入了一个无效的邮件地址。";
        var no_password = "没有输入密码。";
        var less_password = "输入的密码不能少于六位。";
        var passwd_balnk = "密码中不能包含空格";
        var no_confirm_password = "没有输入确认密码。";
        var password_not_same = "输入的密码和确认密码不一致。";
        var invalid_pay_points = "消费积分数不是一个整数。";
        var invalid_rank_points = "等级积分数不是一个整数。";
        var password_len_err = "新密码和确认密码的长度不能小于6";
        var remove_log_confirm = "您确定要删除该会员操作日志吗？";
        var no_nickname = "昵称不能为空";
    </script>
    <script type="text/javascript">
        var tag_token = $("#_token").val();
        layui.use(['laydate','upload'], function(){
            var laydate = layui.laydate;
            var upload = layui.upload;
            //执行一个laydate实例
            laydate.render({
                elem: '#test1' //指定元素
            });
            //文件上传
            var uploadInst = upload.render({
                elem: '#avatar' //绑定元素
                ,url: "{{url('/uploadImg')}}" //上传接口
                ,accept:'file'
                ,data:{'_token':tag_token}
                ,done: function(res){
                    //上传完毕回调
                    if(200 == res.code){
                        $('#demo1').show();
                        $('#front_of_id_card').val(res.data);
                        $('#demo1').attr('src', res.data);
                        layer.msg(res.msg, {time:2000});
                    }else{
                        layer.msg(res.msg, {time:2000});
                    }
                }

            });
            //文件上传
            var uploadInst = upload.render({
                elem: '#avatar2' //绑定元素
                ,url: "{{url('/uploadImg')}}" //上传接口
                ,accept:'file'
                ,data:{'_token':tag_token}
                ,done: function(res){
                    //上传完毕回调
                    if(200 == res.code){
                        $('#demo3').show();
                        $('#reverse_of_id_card').val(res.data);
                        $('#demo3').attr('src', res.data);
                        layer.msg(res.msg, {time:2000});
                    }else{
                        layer.msg(res.msg, {time:2000});
                    }
                }

            });
        });
        //表单验证
        $(function(){
            $("#submitBtn").click(function(){
                if($("#user_form").valid()){
                    $("#user_form").submit();
                }
            });

            $('#user_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },


            rules : {
                    user_name : {
                        required : true
                    },
                    nick_name : {
                        required : true
                    },
                    email : {
                        required : true,
                        email : true
                    },
                    password : {
                        required : true,
                        minlength:6
                    },
                    confirm_password : {
                        required : true,
                        equalTo:"#password"
                    },
                    id_card : {
                        required : true,
                        minlength : 18
                    },
                    front_of_id_card : {
                        required : true,
                    },
                    reverse_of_id_card : {
                        required : true
                    }

                },
                messages : {
                    user_name : {
                        required : '<i class="icon icon-exclamation-sign"></i>'+no_username
                    },
                    nick_name : {
                        required : '<i class="icon icon-exclamation-sign"></i>'+no_nickname
                    },
                    email : {
                        required : '<i class="icon icon-exclamation-sign"></i>email不能为空',
                        email : '<i class="icon icon-exclamation-sign"></i>'+invalid_email
                    },
                    password : {
                        required : '<i class="icon icon-exclamation-sign"></i>'+no_password,
                        minlength : '<i class="icon icon-exclamation-sign"></i>'+less_password
                    },
                    confirm_password : {
                        required : '<i class="icon icon-exclamation-sign"></i>'+no_confirm_password,
                        equalTo:'<i class="icon icon-exclamation-sign"></i>'+password_not_same
                    },
                    id_card : {
                        required : '<i class="icon icon-exclamation-sign"></i>身份证号不能为空',
                        minlength : '<i class="icon icon-exclamation-sign"></i>身份证号18位'
                    },
                    front_of_id_card : {
                        required : '<i class="icon icon-exclamation-sign"></i>请上传身份证正面',
                    },
                    reverse_of_id_card : {
                        required : '<i class="icon icon-exclamation-sign"></i>请上传身份证反面',
                    },
                }
            });
        });
    </script>

@stop
