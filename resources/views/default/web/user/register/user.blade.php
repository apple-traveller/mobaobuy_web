<!doctype html>
<html lang="en">
<head>
    <title>{{getConfig('shop_name')}}_个人注册</title>
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

    <div class="clearfix mt20">
        <div class="register-box">
            <div class="register-form">
                <div class="form">
                    <div class="item">
                        <div class="item-libel">{{trans('home.user_name')}}</div>
                        <div class="item-info"><input type="text" class="text" autocomplete="false" maxlength="11" id="phone" name="phone" placeholder="{{trans('home.login_mobile')}}" onblur="phoneValidate()"></div>
                        <div class="input-tip"><label id="phone_error" class="error" for="phone"></label></div>
                    </div>
                    <div class="item">
                        <div class="item-libel">{{trans('home.set_password')}}</div>
                        <div class="item-info"><input type="password" class="text" name="password" maxlength="16" placeholder="{{trans('home.password_placeholder')}}" id="password" onblur="pwdValidate()"></div>
                        <div class="input-tip"><label id="pwd_error" class="error" for="password"></label></div>
                    </div>
                    <div class="item">
                        <div class="item-libel">{{trans('home.graphic_code')}}</div>
                        <div class="item-info" style="width: 178px;">
                            <input style="width: 158px;" type="text" class="text" maxlength="4" placeholder="{{trans('home.graphic_code')}}" id="verify" onblur="verifyValidate();">
                        </div>
                        <img src="" title="{{trans('home.change_code')}}" style="margin-left: 10px;line-height: 35px;height: 45px; width: 140px;margin-top: -4px;" alt="{{trans('home.change_code')}}" id="imVcode">
                        <div class="input-tip"><label id="verify_error" class="error" for="phone"></label></div>
                    </div>
                    <div class="item">
                        <div class="item-libel">{{trans('home.code')}}</div>
                        <div class="item-info msgCode-swap blackgraybg" style="width: 178px;">
                            <input style="width: 158px;background-color: transparent;" name="msgCode" id="messCode" type="text" class="text" maxlength="6" readonly onblur="msgCodeValidate();">
                        </div>
                        <input type="button" class="messCode_but" style="margin-left: 10px;line-height: 35px;height: 45px; width: 140px;" id="messCode_but" value="{{trans('home.get_code')}}">
                        <div class="input-tip"><label id="msgCode_error" class="error" for="phone"></label></div>
                    </div>
                </div>
            </div>
            <div class="register-checkbox" style="width:300px;margin: 0 auto">
                <label class="check_box">
                    <p style="width:20px; height:20px;overflow: hidden;float:left;margin-top: 1px;">
                        <input name="" id="action" onchange="genreCheck();" type="checkbox" checked="checked" />
                    </p>
                    <span>
                        {{trans('home.read_agreed')}}<a class="orange">{{trans('home.registration_agreement')}}</a>
                    </span>

                </label>
            </div>
            <button class="register-button" id="sub-btn">{{trans('home.ok')}}</button>
        </div>
    </div>
    <div class="clearfix" style="height: 35px;"></div>
    @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
</body>
</html>

<script>
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

    gv();
    // 手机格式验证
    function phoneValidate() {
        $("#phone_error").html('');
        if (isNull.test($("#phone").val())) {
            $("#phone_error").html("<i class='iconfont icon-minus-circle-fill'></i>请输入手机号");
            checkAccount = false;

            return false;
        } else if (!Utils.isPhone($("#phone").val())) {
            $("#phone_error").html("<i class='iconfont icon-minus-circle-fill'></i>手机号码格式不正确");
            checkAccount = false;

            return false;
        }
        checkNameExists();
    }

    // 验证手机是否注册
    function checkNameExists() {
        Ajax.call("{{url('user/checkNameExists')}}", "accountName="+$("#phone").val(), function (result){
            if (result.msg) {
                $("#phone_error").html("<i class='iconfont icon-minus-circle-fill'></i>手机号已经注册！");
                checkAccount = false;
            } else {
                checkAccount = true;
            }
        }, "POST", "JSON",false);
    }

    // 密码格式检查
    function pwdValidate() {
        $("#pwd_error").html('');
        if (isNull.test($("#password").val())) {
            $("#pwd_error").html("<i class='iconfont icon-minus-circle-fill'></i>请输入密码");
            return false;
        } else if (!pwdReg.test($("#password").val())) {
            $("#pwd_error").html("<i class='iconfont icon-minus-circle-fill'></i>密码必须包含字母和数字长度8-16位字符");
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
            $("#verify_error").html("<i class='iconfont icon-minus-circle-fill'></i>验证码不能为空");
            registerCode = false;
            return false;
        } else if (!veriCodeExep.test($("#verify").val())) {
            $("#verify_error").html("<i class='iconfont icon-minus-circle-fill'></i>您输入的验证码有误");
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
                $("#verify_error").html('');
                return true;
            } else {
                registerCode = false;
                gv();
                $("#verify_error").html("<i class='iconfont icon-minus-circle-fill'></i>验证码不正确");
            }
        }, "POST", "JSON",false);
    }
    //  手机验证码格式检查
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
    // 点击获取短信验证码
    function sendMessage(type) {
        phoneValidate();
        verifyValidate ();

        if (!checkAccount || !pwdValidate() || !registerCode) {
            return false;
        }
        params = {
            accountName: $("#phone").val(),
            verifyCode: $("#verify").val(),
            t: t,
        };
        Ajax.call("{{url('/register/sendSms')}}", params, function (result){
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
    function genreCheck() {
        if ($("#action").is(':checked')) {
            $("#sub-btn").attr("class", "register-button");
        } else {
            $("#sub-btn").attr("class", "register-button-gray");
        }
    }
    $('#sub-btn').click(function ()  {
        if (!$("#action").is(':checked')) {
            return false;
        }
        phoneValidate();
        verifyValidate ();

        if (!checkAccount || !pwdValidate() || !registerCode || !msgCodeValidate()) {
            return false;
        }
        params = {
            accountName: $("#phone").val(),
            password: window.btoa($("#password").val()),
            messCode: $("#messCode").val()
        };
        Ajax.call("{{url('/userRegister')}}", params, function (result){
            if (result.code == 1) {
                window.location.href = result.url;
            }else{
                $.msg.alert(result.msg);
            }
        }, "POST", "JSON");
        gv()
    });
</script>
