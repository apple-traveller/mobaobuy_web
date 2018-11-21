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
            <div class="login-box">
                <div style="padding: 30px;">
                    <div class="login-title">会员登录</div>
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
        </div>
    </div>

    @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.copyright')

    <script>
        $(function(){
            $('body').keydown(function(event){
                if(event.keyCode == '13'){
                    userLogin();
                }
            });
        });

        function userLogin(){
            $('.error-content').text('');
            $('.login-error').hide();
            data = {
                user_name: $("#user_name").val(),
                password: $.base64.btoa($("#password").val()),
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

    </script>
</body>
</html>
