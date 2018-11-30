<!doctype html>
<html lang="en">
<head>
    <title>{{getConfig('shop_name')}}_登录</title>
    @include(themePath('.','web').'web.include.partials.base')
    <script src="{{asset('js/jquery.base64.js')}}" ></script>
    <style>
        .login-sd {
            line-height: 30px;
            text-align: center;
            border-bottom: 1px dotted #ccc;
        }
        .login-sdn {
            padding-top: 20px;
            text-align: center;
        }
    </style>
   
</head>
<body>
    <div class="clearfix">
        <div class="logo-box">
            <div class="logo">
                <a href="/">
                    <img src="{{getFileUrl(getConfig('shop_logo', asset('images/logo.png')))}}">
                </a>
            </div>
            <div class="service-tel">全国免费服务热线 : {{getConfig('service_phone')}}</div>
        </div>
    </div>

    <div class="clearfix" style="height:600px;background: url({{themePath('/','web').'img/login_bg.jpg'}})no-repeat;background-size: 100% 100%;">
        <div class="w1200">
            <li>
            <div class="login-box">
                <div style="padding: 30px;">
                    <div class="login-title">会员登录  <a class="messLogin" style="float:right;">短信登陆</a></div>

                    <div class="login-item"><input type="text" id="user_name" name="user_name" class="login_input" placeholder="输入您的账户名"/></div>
                    <div class="login-item"><input type="password" id="password" name="password" class="login_input" placeholder="输入您的密码"/></div>

                    <div class="login-item"><button class="login_btn fs16" onclick="userLogin()">登录</button></div>
                    <div style="margin: 7px auto;overflow: hidden;"><a class="fl" href="{{url('findPwd')}}">忘记密码？</a><a class="fr" href="{{route('register')}}">注册新账号</a></div>
                    <div class="login-error"><i class="iconfont icon-minus-circle-fill"></i><span class="error-content"></span></div>
                    <div>
                        <h3 class="login-sd"><i>第三方账号登录</i></h3>
                        <p class="login-sdn"><a rel="nofollow" style="padding-right:15px;" href="/login/qqLogin" class="ml5p" title="QQ登录"><img src="/img/qq.jpg" alt="QQ登录" /></a>
                            <a href="/login/wxLogin" target="_blank" class="ml5p" title="微信登录"><img src="/img/wx.jpg"/></a>
                        </p>
                    </div>
                </div>
            </div>
            </li>
        <li style="display: none;">
            <div class="login-box">
                <div style="padding: 30px;">
                    <div class="login-title">短信登陆 <a class="login" style="float:right;">会员登陆</a></div>
                    <div class="login-item"><input type="text" id="account" name="user_name" class="login_input" placeholder="输入您的手机号"/></div>
                    <div class="login-item"><input type="password" id="apassword" name="password" class="login_input" placeholder="输入您的短信验证码" style="width:66%;" /><input type="button" value="获取验证码" style="height:42px;width:102px;" id="messCode_but"></div>
                    <div class="login-item"><button class="login_btn fs16" onclick="messLogin()">登录</button></div>
                    <div style="margin: 7px auto;overflow: hidden;"><a class="fl" href="{{url('findPwd')}}">忘记密码？</a><a class="fr" href="{{route('register')}}">注册新账号</a></div>
                    <div class="login-error"><i class="iconfont icon-minus-circle-fill"></i><span class="error-content"></span></div>
                    <div>
                        <h3 class="login-sd"><i>第三方账号登录</i></h3>
                        <p class="login-sdn"><a rel="nofollow" style="padding-right:15px;" href="/login/qqLogin" class="ml5p" title="QQ登录"><img src="/img/qq.jpg" alt="QQ登录" /></a>
                            <a href="/login/wxLogin" target="_blank" class="ml5p" title="微信登录"><img src="/img/wx.jpg"/></a>
                        </p>
                    </div>
                </div>
            </div>
        </li>
        </div>
    </div>

    @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.copyright')

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

        $(function(){
            $('body').keydown(function(event){
                if(event.keyCode == '13'){
                    userLogin();
                }
            });

            $(".w1200 .messLogin").click(function(){
                $(this).parents('li').hide();
                 $(this).parents('li').siblings('li').show();
            });

            $(".w1200 .login").click(function(){
                $(this).parents('li').hide();
                 $(this).parents('li').siblings('li').show();
            });
        });

        function userLogin(){
            $('.error-content').text('');
            $('.login-error').hide();
            data = {
                user_name: $("#user_name").val(),
                password: $.base64.btoa($("#password").val()),
                flag:'login'
            };

            Ajax.call("{{url('login')}}", data , function(result) {
                if (result.code == 1) {
                    window.location.href = "{{url('/')}}";
                } else {
                    $("#password").val('');
                    $('.error-content').text(result.msg);
                    $('.login-error').show();

                }
            }, "POST", "JSON");

        }

        function messLogin(){
            $('.error-content').text('');
            $('.login-error').hide();
            data = {
                user_name: $("#account").val(),
                password: $.base64.btoa($("#apassword").val()),
                flag : 'messageLogin'
            };

            Ajax.call("{{url('login')}}", data , function(result) {
                if (result.code == 1) {
                    window.location.href = "{{url('/')}}";
                } else {
                    $("#password").val('');
                    $('.error-content').text(result.msg);
                    $('.login-error').show();

                }
            }, "POST", "JSON");

        }


        // 点击获取短信验证码
        $('#messCode_but').click(function ()  {
            if(msType02) {
                sendMessage(true);
            }
        });
        function sendMessage(type) {
            var user_name = $('#account').val();
            params = {
                user_name:user_name
            };
            Ajax.call("{{url('/sendMessLoginSms')}}", params, function (result){
                console.log(result);
                if (result.code == 1) {
                    Settime (type);
                }else{
                    // $.msg.alert(result.msg);
                    $("#password").val('');
                    $('.error-content').text(result.msg);
                    $('.login-error').show();
                     
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

    </script>
</body>
</html>
