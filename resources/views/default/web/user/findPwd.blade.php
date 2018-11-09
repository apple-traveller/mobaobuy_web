<!doctype html>
<html lang="en">
<head>
    <title>{{getConfig('shop_name')}}_找回密码</title>
    @include(themePath('.','web').'web.include.partials.base')
</head>
<body style="background-color: #f4f4f4;">
<div class="clearfix whitebg">
    <div class="register-title">
        <div class="logo">
            <a href="/">
                <img src="{{getFileUrl(getConfig('shop_logo', asset('images/logo.png')))}}">
            </a>
        </div>

        <div class="go-login">已有账号，可 <a href="{{route('login')}}" style="color:#36a3ef">直接登录</a></div>
    </div>
</div>

    <div class="clearfix mt25">
        <div class="register-box">
            <div class="register-form">
            <div class="form">
                <div class="item">
                    <div class="item-libel">手机号</div>
                    <div class="item-info"><input type="text" class="text" autocomplete="false" id="accountName" value=""></div>
                    <div class="input-tip"></div>
                </div>
                <div class="item">
                    <div class="item-libel">图形验证码</div>
                    <div class="item-info" style="width: 178px;">
                        <input style="width: 158px;" type="text" class="text" maxlength="4" placeholder="图形验证码" id="verify" onblur="verifyValidate();">
                    </div>
                    <img src="" title="点击换一个校验码" style="margin-left: 10px;line-height: 35px;height: 43px; width: 130px;" alt="点击换一个校验码" id="imVcode">
                    <div class="input-tip"><label id="verify_error" class="error" for="phone"></label></div>
                </div>
                <div class="item">
                    <div class="item-libel">手机验证码</div>
                    <div class="item-info msgCode-swap blackgraybg" style="width: 178px;">
                        <input style="width: 158px;background-color: transparent;" name="msgCode" id="messCode" type="text" class="text" maxlength="6" readonly="" onblur="msgCodeValidate();">
                    </div>
                    <input type="button" class="messCode_but" style="margin-left: 10px;line-height: 35px;height: 43px; width: 130px;" id="messCode_but" value="获取手机验证码">
                    <div class="input-tip"><label id="msgCode_error" class="error" for="phone"></label></div>
                </div>
                <div class="item">
                    <div class="item-libel">新密码</div>
                    <div class="item-info"><input type="password" class="text" name="password" maxlength="16" placeholder="密码由8-16个字符(字母+数字组成)" id="password" onblur="pwdValidate()"></div>
                    <div class="input-tip"><label id="pwd_error" class="error" for="password"></label></div>
                </div>
            </div>
        </div>
        <button class="register-button" id="sub-btn">确 定</button>
    </div>

    <div class="clearfix" style="height: 35px;"></div>
    @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')

</body>
</html>
    <script>
        var countdown = 60; //间隔函数，1秒执行
        var isNull = /^[\s]{0,}$/;
        var pwdReg = /^(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9@#\$%\^&\*\/\.]{8,16})$/;  // 正则密码
        var verify = /^\d{6}$/; // 正则短信验证码
        var veriCodeExep = /^\w{4}$/; // 正则图形验证
        var checkAccount = false;
        var msType = false;
        var msType02 = true;
        var registerCode = false;
        var t = 0;

        gv();

        // 密码格式检查
        function pwdValidate() {
            $("#pwd_error").html('');
            if (isNull.test($("#password").val())) {
                $("#pwd_error").html("请输入密码");
                return false;
            } else if (!pwdReg.test($("#password").val())) {
                $("#pwd_error").html("密码必须包含字母和数字长度8-16位字符");
                return false;
            }
            return true;
        }

        $('#imVcode').click(function(){
            gv();
        });
        function gv() {
            t = new Date().getTime();
            $('#imVcode').attr('src', "{{url('verifyCode')}}" + "?t=" + t + "&width=80&height=20");

        }
        // 图形验证码格式检查
        function verifyValidate() {
            $("#verify_error").html("&nbsp;");
            if (isNull.test($("#verify").val())) {
                $("#verify_error").html("验证码不能为空");
                registerCode = false;
                return false;
            } else if (!veriCodeExep.test($("#verify").val())) {
                $("#verify_error").html("您输入的验证码有误");
                registerCode = false;
                return false;
            }
            params = {
                t: t,
                verifyCode: $('#verify').val()
            };
            Ajax.call("{{url('checkVerifyCode')}}", params, function (result){
                if(result.msg) {
                    registerCode = true;
                    $("#verify_error").text('');
                    return true;
                } else {
                    registerCode = false;
                    gv();
                    $("#verify_error").text("验证码不正确");
                }
            }, "POST", "JSON",false);

        }
        //  手机验证码格式检查
        function msgCodeValidate() {
            $("#msgCode_error").html("");
            if (isNull.test($("#messCode").val())) {
                $("#msgCode_error").html("手机验证码不能为空");
                return false;
            } else if (!verify.test($("#messCode").val())) {
                $("#msgCode_error").html("您输入的手机验证码有误");
                return false;
            }
            return true;
        }
        $('#messCode_but').click(function ()  {
            if(msType02) {
                sendMessage(true);
            }
        });
        // 点击获取短信验证码
        function sendMessage(type) {
            verifyValidate ();
            var accountName = $('#accountName').val();
            if (!registerCode) {
                return false;
            }
            params = {
                verifyCode: $("#verify").val(),
                t: t,
                accountName:accountName

            };

            Ajax.call("{{url('/findPwd/sendSms')}}", params, function (result){

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
                if(type) {
                    $('#numnerTip').hide();
                }
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
        $('#sub-btn').click(function ()  {
            verifyValidate ();
            if (!pwdValidate() || !registerCode || !msgCodeValidate()) {
                return false;
            }
            params = {
                password: window.btoa($("#password").val()),
                messCode: $("#messCode").val()
            };
            Ajax.call("{{url('/findPwd')}}", params, function (result){
                if (result.code == 1) {
                    $.msg.tips('修改成功！');
                    window.location.reload();
                }else{
                    $.msg.error(result.msg);
                }
            }, "POST", "JSON");
            gv()
        });
    </script>
