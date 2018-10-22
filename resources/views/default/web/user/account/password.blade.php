@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '重置密码')
@section('css')
    <style>
        .account_infor_list{margin-top: 30px;margin-left: 40px;}
        .account_infor_list li{overflow: hidden;line-height: 40px;}
        .account_infor_list li .infor_title{width: 85px;float: left; text-align: right;line-height: 40px;}
        .account_infor_list li .infor_title_input{width: 85px;float: left; text-align: right;height: 40px;line-height: 40px;}
        .infor_input{width: 260px;height: 40px;line-height: 40px;border: 1px solid #DEDEDE;margin-left: 10px;padding: 10px;box-sizing: border-box;}
        .account_infor_btn{width: 140px;height: 40px;line-height: 40px;border: none; border-radius:3px;margin-left: 135px;margin-top: 30px;background-color: #75b335;}
    </style>
@endsection
@section('js')
    <script type="text/javascript">
        var InterValObj; //timer变量，控制时间
        var countdown = 60; //间隔函数，1秒执行
        //        var curCount; //当前剩余秒数
        var isNull = /^[\s]{0,}$/;
        var pwdReg = /^(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9@#\$%\^&\*\/\.]{8,16})$/;  // 正则密码
        var verify = /^\d{6}$/; // 正则短信验证码
        var veriCodeExep = /^\w{4}$/; // 正则图形验证
        var checkAccount = false;
        var msType = false;
        var msType02 = true;
        var registerCode = false;
        var t = 0;


        function msgCodeValidate() {
            $("#msgCode_error").html("");
            if (isNull.test($("#messCode").val())) {
                $("#msgCode_error").html("<i class='iconfont icon-minus-circle-fill'></i>手机验证码不能为空");
                return false;
            } else if (!verify.test($("#messCode").val())) {
                $("#msgCode_error").html("<i class='iconfont icon-minus-circle-fill'></i>您输入的手机验证码有误");
                return false;
            }
            return true;
        }
        $('#messCode_but').click(function ()  {
            if(msType02) {
                sendMessage(true);
            }
        });

        function sendMessage(type) {
            params = {
                accountName: "{{$userInfo['user_name']}}",
            };
            Ajax.call("{{url('/account/sendSms')}}", params, function (result){
                if (result.code == 1) {
                    Settime (type);
                    $('.msgCode-swap').removeClass('blackgraybg');
                    $('.msgCode-swap input').removeAttr('readonly');
                }else{
                    $("#msgCode_error").html("<i class='iconfont icon-minus-circle-fill'></i>"+result.msg);
                }
            }, "GET", "JSON");
        }

        function Settime(type) {
            if (countdown == 0) {
                $("#messCode_but").val("获取手机验证码");
                $("#messCode_but").attr("class", "messCode_but");
                countdown = 60;
                msType = true;
                msType02 = true;
            } else {
                msType = false;
                msType02 = false;

                $("#messCode_but").val(countdown + "s重新获取");
                countdown--;
                setTimeout(function() {
                    Settime(type);
                }, 1000);
            }
        }

        function checkPassword(){
            var password = $(".password").val();
            var repassword = $(".repassword").val();
            if(password===repassword){
                return true;
            }else{
                $(".repassword").after('<span class="ml5 red errorMsg">两次输入的密码不一致</span>');
                return false;

            }

        }

        function formToJson(data){
            data= decodeURIComponent(data,true);//防止中文乱码
            data = data.replace(/&/g, "','" );
            data = data.replace(/=/g, "':'" );
            data = "({'" +data + "'})" ;
            obj = eval(data);
            return obj;
        }

        $('.account_infor_btn').click(function (){
            if (!checkPassword() || !msgCodeValidate()) {
                return false;
            }
            /*if (!checkPassword()) {
                return false;
            }*/

            var data = $("#user_real_form").serialize();
            var jsonData = formToJson(data);
            $.post('/account/editPassword',jsonData,function(res){
                console.log(res.data);
                if (res.code == 1) {
                    $.msg.success(res.msg);
                    window.location.href="/account/editPassword";
                } else {
                    $.msg.alert(res.msg);
                }
            },"json");
        });
    </script>
@endsection

@section('content')
    <div class="clearfix mt25">
        <form method="post" action="javascript:void(0);" id="user_real_form">
            <ul class="account_infor_list">
                <li><span class="infor_title">@if($userInfo['is_firm']==1)公司名称：@else昵称：@endif</span><span class="ml10">{{$userInfo['nick_name']}}</span></li>
                <li class="mt20"><span class="infor_title_input">手机号：</span><span class="ml10">{{$userInfo['user_name']}}</span></li>
                <li class="mt20"><span class="infor_title_input">旧密码：</span><input name="password" type="password" class="infor_input" placeholder="请填写原密码"/></li>
                <li class="mt20"><span class="infor_title_input">新密码：</span><input name="newpassword" type="password" class="infor_input password" placeholder="请填写新密码"/></li>
                <li class="mt20"><span class="infor_title_input">确认密码：</span><input name="renewpassword" type="password" class="infor_input repassword" placeholder="请再次填写新密码"/></li>

                <li class="mt20">
                    <span class="infor_title_input">手机验证码：</span>
                        <input style="float:left;" type="text" id="messCode" maxlength="6" onblur="msgCodeValidate();" class="infor_input" placeholder="请输入手机验证码"/>
                        <input type="button" class="messCode_but" style="margin-left: 10px;line-height: 35px;height: 43px; width: 130px;float:left;" id="messCode_but" value="获取手机验证码">
                        <div style="padding-left:25px;line-height: 40px;" class="input-tip"><label id="msgCode_error" class="error" for="phone"></label></div>
                </li>
            </ul>
            <button class="account_infor_btn code_greenbg fs18 white">保 存</button>
        </form>
    </div>
@endsection
