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

            <div class="go-login">{{trans('home.login_prefix')}} <a href="{{route('login')}}" style="color:#36a3ef">{{trans('home.login_suffix')}}</a></div>
        </div>
    </div>

    <div class="clearfix mt25">
        <div class="register-box">
            <div class="register-form form">
                <div class="item">
                    <div class="item-libel">{{trans('home.mobile')}}</div>
                    <div class="item-info"><input type="text" class="text" autocomplete="false" id="accountName" value="" placeholder="{{trans('home.login_mobile')}}"></div>
                    <div class="input-tip"></div>
                </div>
                <div class="item">
                    <div class="item-libel">{{trans('home.graphic_code')}}</div>
                    <div class="item-info" style="width: 178px;">
                        <input style="width: 158px;" type="text" class="text" maxlength="4" placeholder="{{trans('home.graphic_code')}}" id="verify" onblur="verifyValidate();">
                    </div>
                    <img src="" title="{{trans('home.change_code')}}" style="margin-left: 10px;line-height: 35px;height: 43px; width: 130px;" alt="{{trans('home.change_code')}}" id="imVcode">
                    <div class="input-tip"><label id="verify_error" class="error" for="phone"></label></div>
                </div>
                <div class="item">
                    <div class="item-libel">{{trans('home.code')}}</div>
                    <div class="item-info msgCode-swap blackgraybg" style="width: 178px;">
                        <input style="width: 158px;background-color: transparent;" name="msgCode" id="messCode" type="text" class="text" maxlength="6" readonly="" onblur="msgCodeValidate();">
                    </div>
                    <input type="button" class="messCode_but" style="margin-left: 10px;line-height: 35px;height: 43px; width: 130px;" id="messCode_but" value="{{trans('home.get_code')}}">
                    <div class="input-tip"><label id="msgCode_error" class="error" for="phone"></label></div>
                </div>
                <div class="item">
                    <div class="item-libel">{{trans('home.new_password')}}</div>
                    <div class="item-info"><input type="password" class="text" name="password" maxlength="16" placeholder="{{trans('home.password_placeholder')}}" id="password" onblur="pwdValidate()"></div>
                    <div class="input-tip"><label id="pwd_error" class="error" for="password"></label></div>
                </div>
            </div>
            <button class="register-button" id="sub-btn">{{trans('home.ok')}}</button>
        </div>

    </div>

    <div class="clearfix" style="height: 35px;"></div>
    @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
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
                $("#pwd_error").html("{{trans('home.login_password')}}");
                return false;
            } else if (!pwdReg.test($("#password").val())) {
                $("#pwd_error").html("{{trans('home.password_placeholder')}}");
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
                $("#verify_error").html("{{trans('home.code_required_tips')}}");
                registerCode = false;
                return false;
            } else if (!veriCodeExep.test($("#verify").val())) {
                $("#verify_error").html("{{trans('home.code_error_tips')}}");
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
                    $("#verify_error").text("{{trans('home.code_error_tips')}}");
                }
            }, "POST", "JSON",false);

        }
        //  手机验证码格式检查
        function msgCodeValidate() {
            $("#msgCode_error").html("");
            if (isNull.test($("#messCode").val())) {
                $("#msgCode_error").html("{{trans('home.code_required_tips')}}");
                return false;
            } else if (!verify.test($("#messCode").val())) {
                $("#msgCode_error").html("{{trans('home.code_error_tips')}}");
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
                $("#messCode_but").val("{{trans('home.get_code')}}");
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

                $("#messCode_but").val(countdown + "s {{trans('home.regain')}}");
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
                messCode: $("#messCode").val(),
                accountName: $('#accountName').val()
            };
            Ajax.call("{{url('/findPwd')}}", params, function (result){
                if (result.code == 1) {
                    $.msg.alert('{{trans('home.edit_success')}}！',{time:2000});
                    setTimeout(function () { window.location.reload(); }, 2000);
                }else{
                    $.msg.error(result.msg);
                }
            }, "POST", "JSON");
            gv()
        });
    </script>

</body>
</html>

