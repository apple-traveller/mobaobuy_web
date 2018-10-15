<!doctype html>
<html lang="en">
<head>
    <title>{{getConfig('shop_name')}}_登录</title>
    @include(themePath('.','web').'web.include.partials.base')
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

    <div class="clearfix" style="height:465px;background: url({{themePath('/','web').'img/login_bg.png'}})no-repeat;background-size: 100% 100%;">
        <div class="w1200">
            <div class="login-box">
                <div style="padding: 30px;">
                    <div class="login-title">会员登录</div>
                    <div class="login-item"><input type="text" id="user_name" name="user_name" class="login_input" placeholder="输入您的账户名"/></div>
                    <div class="login-item"><input type="password" id="password" name="password" class="login_input" placeholder="输入您的密码"/></div>
                    <div class="login-item"><button class="login_btn fs16">登录</button></div>
                    <div style="margin: 7px auto;overflow: hidden;"><a class="fl" href="{{url('findPwd')}}">忘记密码？</a><a class="fr" href="{{route('register')}}">注册新账号</a></div>
                    <div class="login-error"><i class="iconfont icon-minus-circle-fill"></i><span class="error-content"></span></div>
                </div>
            </div>
        </div>
    </div>

    @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.copyright')

    <script>
        $('.login_btn').click(function (){
            data = {
                user_name: $("#user_name").val(),
                password: window.btoa($("#password").val()),
            };
            Ajax.call("{{url('login')}}", data , function(result) {
                if (result.code == 1) {
                    window.location.href = "{{url('/')}}";
                } else {
                    $("#password").val('');
                    $('.error-content').text(result.msg);
                    $('.login-error').addClass('show');

                }
            }, "POST", "JSON");
        });
    </script>
</body>
</html>