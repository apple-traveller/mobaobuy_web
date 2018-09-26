<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录页</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="{{asset(themePath('/').'images/animated_favicon.gif')}}" type="image/gif" />
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/purebox.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/login.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/layui/css/layui.css')}}" />

    <script src="{{asset(themePath('/').'js/jquery-1.9.1.min.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/jquery.SuperSlide.2.1.1.js')}}" ></script>

</head>

<body>
<div class="login-layout">

    <form id="form1" name='theForm' id="theForm" method="post">
        <div class="login-form layui-form" style="position: relative">
            <div class="formContent">
                <div class="title"><div class="logo">
                        <img style="max-height:60px;" src="{{asset('/images/logo.png')}}">
                    </div>
                    平台管理中心</div>
                <div class="formInfo">
                    <div class="formText">
                        <i class="icon icon-user"></i>
                        <input type="text" id="username" name="username" autocomplete="off" class="input-text" value="" placeholder="管理员" />
                    </div>
                    <div class="formText">
                        <i class="icon icon-pwd"></i>
                        <input type="password" style="display:none"/>
                        <input type="password"  id="password" name="password" autocomplete="off" class="input-text" value="" placeholder="密码" />
                    </div>
                    <div class="formText submitDiv">
                        <span class="submit_span">
                            <input style="border-radius: 50px;margin:0 auto;display: block;" lay-filter="login" id="sunBtn" type="button" name="submit" class="sub" value="登录" />
                        </span>
                    </div>
                </div>
            </div>
            <div id="error" style="position: absolute;left:0px;bottom: 30px;text-align: center;width:395px;">

            </div>
        </div>
    </form>
</div>
<div id="bannerBox">
    <ul id="slideBanner" class="slideBanner">
        <li><img src="{{asset(themePath('/').'images/banner_1.jpg')}}"></li>
        <li><img src="{{asset(themePath('/').'images/banner_2.jpg')}}"></li>
        <li><img src="{{asset(themePath('/').'images/banner_3.jpg')}}"></li>
        <li><img src="{{asset(themePath('/').'images/banner_4.jpg')}}"></li>
        <li><img src="{{asset(themePath('/').'images/banner_5.jpg')}}"></li>
    </ul>
</div>
<script src="{{asset(themePath('/').'plugs/layui/layui.js')}}" ></script>
<script src="{{asset(themePath('/').'js/jquery.purebox.js')}}" ></script>
<script type="text/javascript">
    $("#sunBtn").click(function(){
        layui.use(['layer','form'], function(){
            var form = layui.form,
                layer = layui.layer;
            var username = $("#username").val();
            var password = $("#password").val();
            if(username.length<2){
                layer.msg("管理员长度不能小于两个字符", {icon: 5});
                return false;
            }
            if(password.length==0){
                layer.msg("密码不能为空", {icon: 5});
                return false;
            }

            $.post('{{url('/admin/login')}}', $("#form1").serialize(), function (res) {
                if (res.code == 1) {
                   // layer.msg(res.msg, {icon: 1});
                    setTimeout(function(){
                        window.location.href = "{{url('/admin/index')}}"
                    }, 1000);

                } else {
                    layer.msg(res.msg, {icon: 5});


                }
            }, "json");

        });


    })

    $("#bannerBox").slide({mainCell:".slideBanner",effect:"fold",interTime:3500,delayTime:500,autoPlay:true,autoPage:true,endFun:function(i,c,s){
            $(window).resize(function(){
                var width = $(window).width();
                var height = $(window).height();
                s.find(".slideBanner,.slideBanner li").css({"width":width,"height":height});
            });
        }});

    $(function(){
        $(".formText .input-text").focus(function(){
            $(this).parent().addClass("focus");
        });

        $(".formText .input-text").blur(function(){
            $(this).parent().removeClass("focus");
        });

        $(".checkbox").click(function(){
            if($(this).hasClass("checked")){
                $(this).removeClass("checked");
                $('input[name=remember]').val(0);
            }else{
                $(this).addClass("checked");
                $('input[name=remember]').val(1);
            }
        });







    });
</script>
</body>
</html>
