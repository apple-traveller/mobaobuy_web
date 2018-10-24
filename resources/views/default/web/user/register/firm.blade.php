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

            <div class="go-login">已有账号，可 <a href="{{route('login')}}" style="color:#36a3ef">直接登录</a></div>
        </div>
    </div>
    <div class="register-type">
        <div class="w1200"><ul><li onclick="javascript:window.location.href='{{route('register')}}'">个人注册</li><li class="curr">企业注册</li></ul></div>
    </div>
    <div class="clearfix">
        <div class="register-box">
            <div class="register-form">
                <div class="form">
                    <div class="item">
                        <div class="item-libel">企业全称</div>
                        <div class="item-info"><input type="text" class="text" id="company_name" name="company_name" placeholder="企业全称" onblur="nameValidate()"></div>
                        <div class="input-tip"><label id="company_error" class="error"></label></div>
                    </div>
                    <div class="item">
                        <div class="item-libel">用户名</div>
                        <div class="item-info"><input type="text" class="text" maxlength="11" id="phone" name="phone" placeholder="请输入手机号码" onblur="phoneValidate()"/></div>
                        <div class="input-tip"><label id="phone_error" class="error"></label></div>
                    </div>
                    <div class="item">
                        <div class="item-libel">设置密码</div>
                        <div class="item-info"><input type="password" class="text" name="password" maxlength="16" placeholder="密码由8-16个字符(字母+数字组成)" id="password" onblur="pwdValidate()"></div>
                        <div class="input-tip"><label id="pwd_error" class="error"></label></div>
                    </div>
                    <div class="item">
                        <div class="item-libel">图形验证码</div>
                        <div class="item-info" style="width: 178px;">
                            <input style="width: 158px;" type="text" class="text" maxlength="4" placeholder="图形验证码" id="verify" onblur="verifyValidate();">
                        </div>
                        <img src="" title="点击换一个校验码" style="margin-left: 10px;line-height: 35px;height: 43px; width: 130px;" alt="点击换一个校验码" id="imVcode">
                        <div class="input-tip"><label id="verify_error" class="error"></div>
                    </div>
                    <div class="item">
                        <div class="item-libel">手机验证码</div>
                        <div class="item-info msgCode-swap blackgraybg" style="width: 178px;">
                            <input style="width: 158px;background-color: transparent;" name="msgCode" id="messCode" type="text" class="text" maxlength="6" readonly onblur="msgCodeValidate();">
                        </div>
                        <input type="button" class="messCode_but" style="margin-left: 10px;line-height: 35px;height: 43px; width: 130px;" id="messCode_but" value="获取手机验证码">
                        <div class="input-tip"><label id="msgCode_error" class="error"></label></div>
                    </div>
                    <div class="item">
                        <div class="item-libel">授权委托书</div>
                        @component('widgets.upload_file',['upload_type'=>'firm_attorney','upload_path'=>'firm/attorney','name'=>'attorney_letter_fileImg'])@endcomponent
                        <div class="input-tip"><label id="attorney_error" class="error"></label></div>
                    </div>
                    <div class="item">
                        <div class="item-libel">营业执照</div>
                        @component('widgets.upload_file',['upload_type'=>'firm_license','upload_path'=>'firm/license','name'=>'license_fileImg'])@endcomponent
                        <div class="input-tip"><label id="license_error" class="error"></label></div>
                    </div>
                </div>
            </div>
            <div class="register-checkbox">
                <label class="check_box"><input name="" id="action" onchange="genreCheck();" type="checkbox" checked="checked" />我已阅读并同意<a class="orange">《秣宝平台用户注册协议》</a></label>
            </div>
            <button class="register-button" id="sub-btn">同意并注册</button>
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
    var checkCompany = false;
    var checkAccount = false;
    var msType = false;
    var msType02 = true;
    var registerCode = false;
    var t = 0;

    gv();

    // 验证手机是否注册
    function nameValidate() {
        $("#company_error").html('');
        if (isNull.test($("#company_name").val())) {
            $("#company_error").html("请输入企业全称");
            checkCompany = false;

            return false;
        }

        Ajax.call("{{url('user/checkCanRegister')}}", "companyName="+$("#company_name").val(), function (result){
            if (result.msg) {
                checkCompany = true;
            } else {
                $("#company_error").html("<i class='iconfont icon-minus-circle-fill'></i>企业名称不对或已被注册！");
                checkCompany = false;
            }
        }, "POST", "JSON");
    }

    // 手机格式验证
    function phoneValidate() {
        $("#phone_error").html('');
        if (isNull.test($("#phone").val())) {
            $("#phone_error").html("<i class='iconfont icon-minus-circle-fill'></i>请输入手机号");
            checkAccount = false;

            return false;
        } else if (!Utils.isPhone($("#phone").val())) {
            $("#phone_error").html("<i class='iconfont icon-minus-circle-fill'></i>手机号码格式不正确！");
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
        }, "POST", "JSON");
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
                $("#verify_error").html("<i class='iconfont icon-minus-circle-fill'></i>"+result.msg);
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
    // 验证授权委托书
    function checkAttorneyExists() {
        $("#attorney_error").html("");
        if (isNull.test($("#attorney_letter_fileImg").val())) {
            $("#attorney_error").html("<i class='iconfont icon-minus-circle-fill'></i>授权委托书不能为空");
            return false;
        }
        return true;
    }
    // 验证营业执照
    function checkLicenseExists() {
        $("#license_error").html("");
        if (isNull.test($("#license_fileImg").val())) {
            $("#license_error").html("<i class='iconfont icon-minus-circle-fill'></i>营业执照不能为空");
            return false;
        }
        return true;
    }
    function genreCheck() {
        if ($("#action").is(':checked')) {
            $("#sub-btn").attr("class", "register-button");
        } else {
            $("#sub-btn").attr("class", "register-button-gray");
        }
    }
    $('#sub-btn').click(function ()  {
        phoneValidate();
        verifyValidate ();
        if (!checkCompany || !checkAccount || !pwdValidate() || !registerCode || !msgCodeValidate() || !checkAttorneyExists() || !checkLicenseExists()) {
            return false;
        }
        params = {
            companyName: $("#company_name").val(),
            accountName: $("#phone").val(),
            password: window.btoa($("#password").val()),
            messCode: $("#messCode").val(),
            attorneyLetterFileImg: $("#attorney_letter_fileImg").val(),
            licenseFileImg: $("#license_fileImg").val(),
        };
        Ajax.call("{{url('/firmRegister')}}", params, function (result){
            if (result.code == 1) {
                window.location.href= result.url;
            }else{
                $.msg.error(result.msg);
            }
        }, "POST", "JSON");
        gv()
    });
</script>
