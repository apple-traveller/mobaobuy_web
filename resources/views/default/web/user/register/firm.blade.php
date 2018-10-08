<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>
</head>
@include('partials.base_header')
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/','web').'css/base.css')}}">
<body>
<h1>注册</h1>
<h4>企业注册</h4><a href="{{route('register')}}">个人注册</a>

<form id="ff" method="post">
    <div>
        <label for="name">企业全称:</label>
        <input type="text" id="company_name" name="company_name" placeholder="企业全称" onblur="nameValidate()">
        <div style="height: 20px;" class="reg_error" id="company_error"></div>
    </div>
    <div>
        <label for="email">手机号码:</label>
        <input type="text" maxlength="11" id="phone" name="phone" placeholder="请输入手机号码" onblur="phoneValidate()"/>
        <div style="height: 20px;" class="reg_error" id="phone_error"></div>
    </div>
    <div>
        <label for="email">登录密码:</label>
        <input type="password" name="password" maxlength="16" placeholder="密码由8-16个字符(字母+数字组成)" id="password" onblur="pwdValidate()">
        <div style="height: 20px;" class="reg_error" id="pwd_error"></div>
    </div>
    <div>
        <label for="email">图型验证码:</label>
        <input style="width: 98px;" type="text" maxlength="4" placeholder="图形验证码"
               id="verify" onblur="verifyValidate();"><img src="" title="点击换一个校验码"
                                                           alt="点击换一个校验码" id="imVcode">
        <div style="height: 20px;" class="reg_error" id="verify_error"></div>
    </div>
    <div>
        <label for="email">手机验证码:</label>
        <input name="msgCode" id="messCode" type="text" maxlength="6" placeholder="手机验证码" onblur="msgCodeValidate();">
        <input type="button" class="messCode_but" id="messCode_but" value="获取手机验证码">
        <div style="height: 20px;" class="reg_error" id="msgCode_error"></div>
    </div>
    <div style="min-height: 50px;">
        <label style="float: left;" for="email">授权委托书:</label>
        @component('widgets.upload_file',['upload_type'=>'firm_attorney','upload_path'=>'firm/attorney','name'=>'attorney_letter_fileImg'])@endcomponent

        <div style="height: 20px;" class="reg_error" id="attorney_error"></div>
    </div>
    <div style="min-height: 50px;">
        <label style="float: left;" for="email">营业执照:</label>
        @component('widgets.upload_file',['upload_type'=>'firm_license','upload_path'=>'firm/license','name'=>'license_fileImg'])@endcomponent
        <div style="height: 20px;" class="reg_error" id="license_error"></div>
    </div>
    <div>
        <input type="button" id="sub-btn" value="注册">
    </div>
</form>
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
                $("#company_error").html("企业名称不对或已被注册！");
                checkCompany = false;
            }
        }, "POST", "JSON");
    }

    // 手机格式验证
    function phoneValidate() {
        $("#phone_error").html('');
        if (isNull.test($("#phone").val())) {
            $("#phone_error").html("请输入手机号");
            checkAccount = false;

            return false;
        } else if (!Utils.isPhone($("#phone").val())) {
            $("#phone_error").html("手机号码格式不正确！");
            checkAccount = false;

            return false;
        }
        checkNameExists();
    }

    // 验证手机是否注册
    function checkNameExists() {
        Ajax.call("{{url('user/checkNameExists')}}", "accountName="+$("#phone").val(), function (result){
            if (result.msg) {
                $("#phone_error").html("手机号已经注册！");
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
        }, "POST", "JSON");
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
                $('#numnerTip .tipName').text('短信验证码已发送到');
                $('#numnerTip .numer').text($('#phone').val());
                $('#numnerTip .tip_las').text('，请注意查收');
                $('#numnerTip').show();

                Settime (type);
            }else{
                $("#verify_error").html(result.msg);
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
            $("#attorney_error").html("授权委托书不能为空");
            return false;
        }
        return true;
    }
    // 验证营业执照
    function checkLicenseExists() {
        $("#license_error").html("");
        if (isNull.test($("#license_fileImg").val())) {
            $("#license_error").html("手机验证码不能为空");
            return false;
        }
        return true;
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
                window.location.href="{{route('login')}}";
            }else{
                $.msg.error(result.msg);
            }
        }, "POST", "JSON");
        gv()
    });
</script>
