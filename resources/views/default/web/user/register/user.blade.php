<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>
</head>
{{--<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>--}}
<script src="http://code.jquery.com/jquery-1.4.1.min.js"></script>
<body>
<h1>注册</h1>
<!-- <a href="http://mbb.com">tiaozhuan</a> -->
@if(count($errors)>0)
    <div class="alert alert-warning" role="alert">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif
<h4>个人注册</h4><a href="{{route('firmRegister')}}">企业注册</a>
<form action="/userRegister" method="post">
<input type="text" maxlength="11" id="phone" name="phone" placeholder="请输入手机号码" onblur="phoneValidate()"><br>
<div style="height: 20px;">
    <div class="reg_error" id="phone_error"></div>
</div>
<input type="password" name="password" maxlength="16" placeholder="密码由8-16个字符(字母+数字组成)" id="password" onblur="pwdValidate()"><br>
    <div style="height: 20px;">
        <div class="reg_error" id="pwd_error"></div>
    </div>
<input style="width: 98px;" type="text" maxlength="4" placeholder="图形验证码"
           id="verify" onblur="verifyValidate();"><img src="" title="点击换一个校验码"
                                                       alt="点击换一个校验码" id="imVcode">
    <div style="height: 20px;">
        <div class="reg_error" id="verify_error"></div>
    </div>

    <div class="reg_user"><input name="msgCode" id="messCode" type="text" maxlength="6" placeholder="手机验证码" onblur="msgCodeValidate();">
        <input type="button" class="messCode_but" id="messCode_but" value="获取手机验证码">
    </div>
    <div style="height: 20px;">
        <div class="reg_error" id="msgCode_error"></div>
    </div>
    <div class="g-fl">
        <input type="checkbox" id="action" value="" onchange="genreCheck();" checked="checked">
        <label for="action" class="checked">我已阅读并同意</label>
    </div>
    <div class="g-fl">
        <a target="_blank" href="sites/term/ZCXY.html" class="black">《注册服务协议》</a>
    </div>

    <input type="button" id="sub-btn" value="注册">
<a href="{{route('login')}}">去登录</a>
</form>
</body>
</html>

<script>
    var InterValObj; //timer变量，控制时间
    var countdown = 60; //间隔函数，1秒执行
    //        var curCount; //当前剩余秒数
    var phoneReg = /^(((13[0-9]{1})|(14[0-9]{1})|(15[0-9]{1})|(16[0-9]{1})|(17[0-9]{1})|(18[0-9]{1})||(19[0-9]{1}))+\d{8})$/; // 正则手机号
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
            $("#phone_error").html("请输入手机号");
            checkAccount = false;

            return false;
        } else if (!phoneReg.test($("#phone").val())) {
            $("#phone_error").html("手机号码格式不正确！");
            checkAccount = false;

            return false;
        }
        checkNameExists();
    }

    // 验证手机是否注册
    function checkNameExists() {
        $.ajax({
            url: "{{url('user/checkNameExists')}}",
            dataType: "json",
            data: {
                accountName: $("#phone").val(),
                _token: "{{csrf_token()}}"
            },
            type: "POST",
            success: function (data) {
                if (data.msg) {
                    $("#phone_error").html("手机号已经注册！");
                    checkAccount = false;
                } else {
                    checkAccount = true;
                }
            }
        });
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
        $.ajax({
            url: "{{url('checkVerifyCode')}}",
            type: 'post',
            cache: false,
            async: false,
            data: {
                t: t,
                verifyCode: $('#verify').val(),
                _token: "{{csrf_token()}}"
            },
            success:function (data) {
                if(data.msg) {
                    registerCode = true;
                    $("#verify_error").text('');
                    return true;
                } else {
                    registerCode = false;
                    gv();
                    $("#verify_error").text("验证码不正确");
                }
            }
        })
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
        $.ajax({
            url: "{{url('/register/sendSms')}}",
            data: {
                accountName: $("#phone").val(),
                verifyCode: $("#verify").val(),
                t: t,
            },
            type: "GET",
            success: function (data) {
//                    console.log(data);
                if (data.code == 1) {
                        $('#numnerTip .tipName').text('短信验证码已发送到');
                        $('#numnerTip .numer').text($('#phone').val());
                        $('#numnerTip .tip_las').text('，请注意查收');
                        $('#numnerTip').show();

                    Settime (type);
                }else{
                    $("#verify_error").html(data.desc);
                }
            }
        });
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
        phoneValidate();
        verifyValidate ();
        if (!checkAccount || !pwdValidate() || !registerCode || !msgCodeValidate()) {
            return false;
        }

        $.ajax({
            url: "{{route('register')}}",
            data: {
                accountName: $("#phone").val(),
                password: window.btoa($("#password").val()),
                messCode: $("#messCode").val()
            },
            type: "POST",
            success: function (data) {
                console.log(data);
                if (data.code == 1) {
                    window.location.href="{{route('login')}}";
                }else{
                    alert(data.msg)
                }
            }
        });
        gv()
    });
</script>