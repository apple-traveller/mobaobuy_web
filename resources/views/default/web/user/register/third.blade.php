<!doctype html>
<html lang="en">
<head>
    <title>{{getConfig('shop_name')}}_绑定账号</title>
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

    <div class="clearfix mt20">
        <div class="register-box">
            <div class="register-form">
                <div class="form">
                    <input type="hidden" name="third_type" id="third_type" value="{{$type}}" />
                    <div class="item">
                        <div class="item-libel">用户名</div>
                        <div class="item-info"><input type="text" class="text" autocomplete="false" maxlength="11" id="phone" name="phone" placeholder="请输入手机号码" onblur="phoneValidate()"></div>
                        <div class="input-tip"><label id="phone_error" class="error" for="phone"></label></div>
                    </div>
                    <div class="item b_msg" style="display: none">
                        手机号未注册！是否
                        <a class="next_banding" style='color:#ff6600'>继续绑定</a>，或者<a href='/' style='color:#ff6600'>返回首页</a>
                    </div>
                    <div class="item b_password" style="display: none">
                        <div class="item-libel">输入密码</div>
                        <div class="item-info"><input type="password" class="text" name="password" maxlength="16" placeholder="密码由8-16个字符(字母+数字组成)" id="password" onblur="pwdValidate()"></div>
                        <div class="input-tip"><label id="pwd_error" class="error" for="password"></label></div>
                    </div>
                    <div class="item b_img_code" style="display: none">
                        <div class="item-libel">图形验证码</div>
                        <div class="item-info" style="width: 178px;">
                            <input style="width: 158px;" type="text" class="text" maxlength="4" placeholder="图形验证码" id="verify" onblur="verifyValidate();">
                        </div>
                        <img src="" title="点击换一个校验码" style="margin-left: 10px;line-height: 35px;height: 43px; width: 130px;" alt="点击换一个校验码" id="imVcode">
                        <div class="input-tip"><label id="verify_error" class="error" for="phone"></label></div>
                    </div>
                    <div class="item b_mobile_code" style="display: none">
                        <div class="item-libel">手机验证码</div>
                        <div class="item-info msgCode-swap blackgraybg" style="width: 178px;">
                            <input style="width: 158px;background-color: transparent;" name="msgCode" id="messCode" type="text" class="text" maxlength="6" readonly onblur="msgCodeValidate();">
                        </div>
                        <input type="button" class="messCode_but" style="margin-left: 10px;line-height: 35px;height: 43px; width: 130px;" id="messCode_but" value="获取手机验证码">
                        <div class="input-tip"><label id="msgCode_error" class="error" for="phone"></label></div>
                    </div>
                </div>
            </div>
            <div class="register-checkbox">
                <label class="check_box"><input name="" id="action" onchange="genreCheck();" type="checkbox" checked="checked" />我已阅读并同意<a class="orange">《秣宝平台用户注册协议》</a></label>
            </div>
            <button class="register-button" id="sub-btn">绑定该账号</button>
        </div>
    </div>
    <div class="clearfix" style="height: 35px;"></div>
    @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
</body>
</html>

<script>
    $("#phone").val('');
    $("#password").val('');
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
        phoneValidateBool();
        //验证手机
        if(!checkNameExists()){//手机号已经注册  直接输入密码绑定第三方账号
            $('.b_password').show();
            $('.b_img_code').hide();
            $('.b_mobile_code').hide();
            $('.b_msg').hide();
            $('#sub-btn').attr('class','register-button sub-btn')
        }else{//手机号未注册 注册新账号并绑定第三方账号
            $('.b_msg').show();
            $('.b_password').hide();
            $('#sub-btn').attr('class','register-button')
        }
    }
    function phoneValidateBool(){
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
    }
    $('.next_banding').click(function(){
        $('.b_msg').hide();
        $('.b_password').show();
        $('.b_img_code').show();
        $('.b_mobile_code').show();
        $('#sub-btn').attr('class','register-button sub-btn-register')
    });
    // 验证手机是否注册
    function checkNameExists() {
        $.ajax({
            url: "{{url('user/checkNameExists')}}",
            dataType: "json",
            data: {
                'accountName':$("#phone").val()
            },
            type: "POST",
            async:false,
            success: function (data) {
                if(data.code == 1){
                    $("#phone_error").html("<i class='iconfont icon-minus-circle-fill'></i>手机号已经注册！");
                    checkAccount = false;
                }else{
                    checkAccount = true;
                }
            }
        })
        return checkAccount;
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
        }, "POST", "JSON");
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
        phoneValidateBool();
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

    //无账号注册并绑定
    $(document).delegate('.sub-btn-register','click',function(){
        if (!$("#action").is(':checked')) {
            return false;
        }
        phoneValidateBool();
        verifyValidate ();
        if (!checkAccount || !pwdValidate() || !registerCode || !msgCodeValidate()) {
            return false;
        }
        params = {
            accountName: $("#phone").val(),
            password: window.btoa($("#password").val()),
            messCode: $("#messCode").val(),
            third_type:$('#third_type').val()
        };
        Ajax.call("{{url('/login/createNewUser')}}", params, function (result){
            if (result.code == 1) {
                window.location.href = '/';
            }else{
                $.msg.error(result.msg);
            }
        }, "POST", "JSON");
        gv()
    });
    //有账号直接绑定
    $(document).delegate('.sub-btn','click',function(){
        if (!$("#action").is(':checked')) {
            return false;
        }
        phoneValidateBool();
        verifyValidate ();
        if (!checkAccount || !pwdValidate()) {
            return false;
        }
        params = {
            username: $("#phone").val(),
            password: window.btoa($("#password").val()),
            third_type:$('#third_type').val()
        };
        Ajax.call("{{url('/login/createThird')}}", params, function (result){
            if (result.code == 1) {
                window.location.href = '/';
            }else{
                $.msg.error(result.msg);
            }
        }, "POST", "JSON");
        gv()
    });
</script>
