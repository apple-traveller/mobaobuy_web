<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="//www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>沫宝网登录</title>
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'layui/seller_login/index.min.css')}}" />
    <script src="{{asset(themePath('/').'js/jquery-1.9.1.min.js')}}" ></script>
    {{--<script src="{{asset(themePath('/').'layui/seller_login/fai.min.js')}}" ></script>--}}
    <script src="{{asset(themePath('/').'layui/layui.js')}}" ></script>
    <script src="{{asset(themePath('/').'layui/layui.js')}}" ></script>
    <script src="{{asset('js/jquery.base64.js')}}" ></script>
    <script src="{{asset('js/jquery.cookie.js')}}" ></script>
</head>


<body style="background-color: rgb(240, 246, 254); font-family: 微软雅黑;">
<div class="container">

    <div style="text-align:center">
        <div class="header-new">
            <div class="fkw-topbar-box">
                <a class="fkw-logo" target="_blank" title="点击可打开沫宝网" href="/"></a>
                <div class="f-topbar-right">
                    <a href="{{env('APP_URL').'seller/register.html'}}" target="_blank" style="text-decoration:none;color:#738299;font-size:14px">免费注册</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ## END header ## -->

    <!-- ## START middle ## -->
    <div class="middle">
        <div class="content" style="height:600px;background: url(default/img/login_bg.jpg)no-repeat;background-size: 100% 100%;">
            <!-- ## START middle left ## -->
            <div class="left">

                <a id="reg-button" class="regBtn"></a>
            </div>
            <!-- ## END middle left ## -->

            <!-- ## START middle right ## -->
            <div class="right">

                <div class="loginBody">
                    <div id="normalLogin">
                        <div class="righttop">
                            <div class="loginTab pwdLoginTab checkLoginTab" _loginmode="pwdLogin">密码登录</div>
                            {{--<div class="loginTab codeLoginTab" _loginmode="codeLogin">短信码登录</div>--}}
                        </div>
                        <div id="log-form" class="rightmid">
                            <div class="pwdLoginPanel loginPanel">
                                <div class="log-input-container">
                                    <div class="clear" style="font-size:0px;"></div>
                                    <div class="log-line log-line-hover" id="rowCacct">
                                        <div class="log-txt log-txt-hover" style="display: block;">用户名</div>
                                        <input id="log-cacct" type="text" autocomplete="off" maxlength="34" class="log-input input2">
                                        <div class="logIcoNew logIcoCacct">&nbsp;</div>
                                    </div>
                                    <div class="log-line" id="rowPwd">
                                        <div id="passwordLabel" class="log-txt">密码</div>
                                        <input id="log-pwd" type="password" autocomplete="new-password" maxlength="20" class="log-input input2" aria-autocomplete="list">
                                        <input id="showPwd" type="txt" autocomplete="new-password" maxlength="20" class="log-input input2">
                                        <div id="showPassword" class="log-showPwd loginWindowImg" _show="true"></div>
                                        <div class="logIcoNew logIcoPwd">&nbsp;</div>
                                    </div>
                                </div>
                                <div class="goin1"><a href="javascript:;" onclick="openPassword();">忘记密码？</a></div>
                                <div class="option">
                                    {{--<div class="goin"><input id="auto-login" class="checkBox" type="checkbox"><label class="checkItemLabel"></label><label for="auto-login">两周内自动登录</label></div>--}}
                                </div>
                            </div>
                            <div class="codeLoginPanel loginPanel">
                                <div class="log-line" id="mobile">
                                    <div class="log-txt">手机号码</div>
                                    <input id="log-mobile" type="text" autocomplete="off" maxlength="34" class="log-input input2">
                                    <div class="logIcoNew logIcoMobile">&nbsp;</div>
                                </div>
                                <div class="log-line" id="mobileCode" style="width: 157px;">
                                    <div class="log-txt">短信码</div>
                                    <input id="log-mobileCode" style="width: 95px;" type="text" autocomplete="off" maxlength="6" class="log-input input2">
                                    <div class="logIcoNew logIcoMobileCode">&nbsp;</div>
                                </div>
                                <div class="mobileCodeBtn" disabled="disabled">获取短信码</div>
                                <div style="clear:both"></div>
                                <div id="codeLogin-valid-line" class="log-line" style="display:none;">
                                    <div class="log-txt" style="width:116px; left:12px;">验证码</div>
                                    <input id="codeLogin-valid" type="text" class="log-input input2" style="width:116px; padding-left:12px;">
                                    <img id="codeLogin-valid-img" title="看不清？点击换一张">
                                    <span id="codeLogin-refresh-btn" title="看不清？点击换一张"></span>
                                </div>
                            </div>
                            <div id="error" class="worn"></div>
                            <div id="login-button" class="loginBtn">登&nbsp;&nbsp;录</div>
                            <div class="clear"></div>
                        </div>

                    </div>
                </div>

                <div class="login_otherAcct">
                    <span class=""></span>
                    <a class="login_QQI" href="javascript:;"></a>
                    <a class="registerHref" href="{{env('APP_URL').'seller/register.html'}}">立即注册</a>
                </div>

            </div>
            <!-- ## END middle right ## -->

            <!--<div class="clear"></div>-->

            <div class="foot">
                <div class="graw">Copyright <font style="font-family:" 微软雅黑',="" '黑体',="" '新宋体',="" 'arial="" unicode="" ms'"="">© </font> 2010-2018 沫宝有限公司<br>
                    <div style="padding:5px 0 10px 0;">

                        <a target="_blank" href="{{env('APP_URL'.'seller/register.html')}}" style="display:inline-block;text-decoration:none;height:20px;line-height:20px; margin-right:5px;"><img src="{{asset(themePath('/').'layui/seller_login/beianIcon.png')}}" width="20" height="20" <p="" style="float:left;height:20px;line-height:20px;margin: 0px 5px 0px 0px; color:#898989;">粤公网安备 XXXXXXXXXXX号<p></p></a>

                        <a href="" target="_blank" rel="nofollow">粤XXXXXXX号</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ## END middle ## -->
</div>

<script type="text/x-template" id="t-imgVerify">
    <div class="m-imgVerify">
        <span class="close"></span>
        <div class="title">请先完成下方验证</div>
        <div class="inputLine">
            <input type="text" maxlength="4" class="codeVal" placeholder="请输入右侧验证码"><!--
			--><img class="codeImg">
            <span class="refreshBtn">换一张</span>
        </div>
        <div class="msg"></div>
        <button class="u-bigBtn confirmBtn">确定</button>
    </div>

</script>
<script type="text/javascript">
    function isMobile(mobile){
        var pattern = /^1[3456789]\d{9}$/;
        return pattern.test(mobile);
    }
    var cacct = "";
    var sacct = "";

    $(function(){
        //存储wx，qq注册来源业务，用于扫码回调时注册业务、注册成功回调
        login.initEvent();

        var logAcct = $('#log-cacct'), logAcctVal;
        //从url/cookie中获取用户名
        if (cacct.length > 0) {
            logAcctVal = cacct;
        }else{
            logAcctVal = $.cookie('loginCacct');
        }
        if(logAcctVal != null && $.trim(logAcctVal) != ''){
            if(!isMobile(logAcctVal) && !Fai.isEmail(logAcctVal)){
                var logSacctVal = $.cookie('loginSacct');
                var logUseSacct = $.cookie('loginUseSacct');
                if (sacct.length > 0) {
                    logSacctVal = sacct;
                }
                if(logSacctVal) {
                    logSacct.val(logSacctVal);
                }
                //这个cookie用来判断登录状态
                if(logUseSacct == 1) {
                    $('#staff-login')[0].click();
                }
            }
            logAcct.val(logAcctVal);
            $('#log-cacct').blur();
        }
        //原来手机和邮箱存的cookie是loginAcct，这里过渡一下，过一段时间可以直接删掉
        else{
            logAcctVal = $.cookie('loginAcct');
            if(logAcctVal != null && $.trim(logAcctVal) != ''){
                logAcct.val(logAcctVal);
                $('#log-cacct').blur();
            }
        }
        $.cookie('loginAcct', null, {path:'/', domain:'fkw.com'});
        //////


        showCode(false);


        checkFocus( 'log-cacct' );
        checkFocus( 'log-pwd' );
        checkFocus( 'log-valid' );

        setTimeout(autoFocus, 50);
    });

    //自动获取输入框焦点
    function autoFocus(){
        $('#log-cacct, #log-pwd').filter(':visible').each(function(){
            var $this = $(this);
            if($this.val() == ''){
                $this.focus();
                checkFocus($this.attr('id'));
                return false;
            }
        });
    }

    function checkFocus( id ){
        var input = $('#' + id),
            val = input.val();
        if (id != "log-pwd"){
            val = $.trim(val);
        }
        $('#log-form').find('input.log-input').removeClass('input1');
        var txt = input.parent().children('.log-txt');
        $('.log-txt').removeClass("log-txt-hover");
        txt.addClass('log-txt-hover');
        $('.log-line').removeClass("log-line-hover");
        if ( id != "log-valid" ){
            input.parent().addClass("log-line-hover");
        }
        if( val == '' ){
            txt.show();
//			if ( Fai.isIE7() ){
//				input.css("background", "transparent");
//			}
        }else{
            txt.hide();
//			if ( Fai.isIE7() ){
//				input.css("background", "#fff");
//			}
        }
//		input.addClass('input1');
    }

    function showCode( needCode ){
        var loginMode = $(".checkLoginTab").attr("_loginmode");
        var login_line = $('#log-valid-line');
        var log_valid = $('#log-valid');
        var login_valid_img = $('#log-valid-img');
        if(loginMode == 'codeLogin'){
            login_line = $('#codeLogin-valid-line');
            log_valid = $('#codeLogin-valid');
            login_valid_img = $('#codeLogin-valid-img');
        }
        if( needCode ){
            login_line.show();
            log_valid.val('').focus();
            login_valid_img.attr( 'src', 'validateCode.jsp?'  + parseInt(Math.random() * 1000)+'&validateCodeRegType=3');
        }else{
            login_line.hide();
        }
    }

    function changeValidImg(){
        showCode( true );
    }


    function reg(){
        var reg_url = 'http://www.fkw.com/reg.html?_fromsite=false';
        top.location.href = reg_url;
    }

    function showMsg(msg){
        $('#error').text( msg ).show();
        if($.trim(msg) == '' || msg == null){
            $('#error').hide();
        }
    }

    function openPassword(){
        window.open("{{env('APP_URL').'seller/findPwd.html'}}", "_blank");
    }



    function userLogin(){
        $('.wxLoginIframe').hide();
        $('.wxLoginTip').show();
        $('.wxLoginTips').show();
        $('.acctLoginTips').hide();
        $('.userLoginDesc').hide();
        $('.login_WeChatTips').hide();
        $('#normalLogin').show();
        $('.wxLoginCode').hide();
    }


    var login = {
            initEvent:function() {
                //关于登录方式的选择：密码登录或者短信登录
                $(".loginTab").click(function(){
                    $(".loginTab").removeClass("checkLoginTab");
                    $(this).addClass("checkLoginTab");
                    $(".loginPanel").hide();
                    $("."+ $(this).attr("_loginMode") +"Panel").show();
                    showMsg("");
                })


                $('#showPwd').focus(function(){
                    checkFocus( 'showPwd' );
                }).blur(function(){
                    checkFocus( 'showPwd' );
                }).keydown(function(event){
                    checkFocus( 'showPwd' );
                    if( event.keyCode == 13 ){
                        login.loginAcct();
                    }
                }).keyup(function(){
                    checkFocus( 'showPwd' );
                    $("#log-pwd").val($("#showPwd").val());
                })

                $('#log-mobile').focus(function(){
                    checkFocus( 'log-mobile' );
                }).blur(function(){
                    checkFocus( 'log-mobile' );
                }).keydown(function(event){
                    checkFocus( 'log-mobile' );
                    if( event.keyCode == 13 ){
                        login.loginAcct();
                    }
                }).keyup(function(){
                    checkFocus( 'log-mobile' );
                })

                $('#log-mobileCode').focus(function(){
                    checkFocus( 'log-mobileCode' );
                }).blur(function(){
                    checkFocus( 'log-mobileCode' );
                }).keydown(function(event){
                    checkFocus( 'log-mobileCode' );
                    if( event.keyCode == 13 ){
                        login.loginAcct();
                    }
                }).keyup(function(){
                    checkFocus( 'log-mobileCode' );
                })

                $("#showPassword").click(function(){
                    if($(this).attr("_show") == 'true'){
                        $(this).attr("_show",false);
                        $("#log-pwd").hide();
                        $("#showPwd").show();
                        $(this).addClass("log-hidePwd");
                    }else{
                        $(this).attr("_show",true);
                        $("#log-pwd").show();
                        $("#showPwd").hide();
                        $(this).removeClass("log-hidePwd");
                    }
                })

                $('.mobileCodeBtn').click(function(){
                    if($(".mobileCodeBtn").attr("disabled") != "disabled" && login.checkMobile()){
                        login.getCodeBtnClick();
                    }
                });

                $('#log-cacct').focus(function(){
                    checkFocus( 'log-cacct' );
                }).blur(function(){
                    var acctVal = $(this).val().replace(/\s+/g, '');
                    $(this).val(acctVal);
                    checkFocus( 'log-cacct' );
                }).keydown(function(event){
                    checkFocus( 'log-cacct' );
                    if( event.keyCode == 13 ){
                        var acctVal = $(this).val().replace(/\s+/g, '');
                        $(this).val(acctVal);
                        login.loginAcct();
                    }
                }).keyup(function(){
                    checkFocus( 'log-cacct' );
                })

                $('#log-pwd').focus(function(){
                    checkFocus( 'log-pwd' );
                }).blur(function(){
                    checkFocus( 'log-pwd' );
                }).keydown(function(event){
                    checkFocus( 'log-pwd' );
                    if( event.keyCode == 13 ){
                        login.loginAcct();
                    }
                }).keyup(function(){
                    checkFocus( 'log-pwd' );
                    $("#showPwd").val($("#log-pwd").val());
                })

                $('#log-valid').focus(function(){
                    checkFocus( 'log-valid' );
                }).blur(function(){
                    checkFocus( 'log-valid' );
                }).keydown(function(event){
                    checkFocus( 'log-valid' );
                    if( event.keyCode == 13 ){
                        login.loginAcct();
                    }
                }).keyup(function(){
                    checkFocus( 'log-valid' );
                })

                $('#codeLogin-valid').focus(function(){
                    checkFocus( 'codeLogin-valid' );
                }).blur(function(){
                    checkFocus( 'codeLogin-valid' );
                }).keydown(function(event){
                    checkFocus( 'codeLogin-valid' );
                    if( event.keyCode == 13 ){
                        login.loginAcct();
                    }
                }).keyup(function(){
                    checkFocus( 'codeLogin-valid' );
                })

                $('#log-valid-img, #log-refresh-btn, #codeLogin-valid-img, #codeLogin-refresh-btn').click( changeValidImg )
                $('#login-button').click(function(){
                    login.loginAcct();
                });
                $('#login-button').hover(function(){
                    $(this).addClass("loginBtn-hover");
                }, function(){
                    $(this).removeClass("loginBtn-hover");
                });
                $('#reg-button, #reg-link').click( reg );
                $('#reg-button').hover(function(){
                    $(this).addClass("regBtn-hover");
                }, function(){
                    $(this).removeClass("regBtn-hover");
                });

                $("#log-mobile").keyup(function(){
                    if(Fai.isMobile($.trim($("#log-mobile").val()))){
                        $(".mobileCodeBtn").addClass("mobileCodeBtn_ok");
                        $(".mobileCodeBtn").removeAttr("disabled");
                    }else{
                        $(".mobileCodeBtn").removeClass("mobileCodeBtn_ok");
                        $(".mobileCodeBtn").attr("disabled", "disabled");
                    }
                })

                $(".mobileCodeBtn").mouseover(function(){
                    if(Fai.isMobile($.trim($("#log-mobile").val())) && $(this).attr("disabled") != "disabled"){
                        $(".mobileCodeBtn").addClass("mobileCodeBtn_hover");
                    }else{
                        $(".mobileCodeBtn").removeClass("mobileCodeBtn_hover");
                    }
                }).mouseout(function(){
                    $(".mobileCodeBtn").removeClass("mobileCodeBtn_hover");
                })

            },
            loginAcct:function(){
                var me = $('#login-button');
                if( me.hasClass('disabled') ){
                    return;
                }

                cacct = $('#log-cacct').val();
                var pwd = $('#log-pwd').val();
                var valid = $('#log-valid').val();
                var autoLogin = $('#auto-login').prop('checked');
                var params = {};
                var staffLogin = $('#staff-login').prop("checked");
                var loginModel = $(".checkLoginTab").attr("_loginmode");
                if(loginModel == 'pwdLogin'){
                    if( !cacct ){
                        showMsg( '请输入帐号' );
                        $('#log-cacct').focus();
                        return;
                    }
                    if( !pwd ){
                        showMsg( '请输入密码' );
                        $('#log-pwd').focus();
                        return;
                    }
                    if( $('#log-valid-line').is(':visible') && !valid ){
                        showMsg( '请输入验证码' );
                        $('#log-valid').focus();
                        return;
                    }
                }else{
                    var loginMoile = $.trim($("#log-mobile").val());
                    var mobileCode = $.trim($('#log-mobileCode').val());
                    if( !loginMoile ){
                        showMsg( '请输入手机号码' );
                        $('#log-mobile').focus();
                        return;
                    }
                    if( !mobileCode ){
                        showMsg( '请输入短信码' );
                        $('#log-mobileCode').focus();
                        return;
                    }
                }
                if(loginModel == 'pwdLogin'){
                    params.type='pwdLogin';
                    params.user_name=cacct;
                    params.password = $.base64.btoa(pwd);
                }else{
                    params.type = 'smsCode';
                    params.loginMoile = loginMoile;
                    params.mobileCode = mobileCode;
                }
                me.addClass( 'disabled' ).html('正在登录...');
                showMsg('');
                $.ajax({
                    type: 'post',
                    url: '/seller/login',
                    data: params,
                    error: function(){
                        me.removeClass( 'disabled' ).html('登&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;录');
                        showMsg( '服务繁忙，请稍候重试' );
                    },
                    success: function(res){
                        if (res.code == 1){
                            window.location.href="{{url('/seller')}}";
                        } else {
                            $('#password').val('');
                            showMsg(res.msg);
                            me.removeClass( 'disabled' ).html('登&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;录');
                        }
                    }
                })
            },
            checkMobile:function(){
                var $mobile = $('#log-mobile'),
                    msg = '';
                var mobile = $.trim($mobile.val());
                if(!mobile){
                    msg = '请输入手机号码';
                }else if(!Fai.isMobile(mobile)){
                    msg = '请输入正确的11位手机号码';
                }

                if(msg){
                    showMsg( msg);
                    return false;
                }else{
                    return true;
                }
            },
            getCodeBtnClick:function(){
                var loginMoile = $.trim($("#log-mobile").val());
                var $btn = $('.mobileCodeBtn');
                var timeCtrl = $btn[0]._timeCtrl;
                if(!timeCtrl){
                    timeCtrl = {
                        timer: null,
                        second: 60,
                        clickCnt: 0
                    };
                    $btn[0]._timeCtrl = timeCtrl;
                }
                if(timeCtrl.timer){
                    return false;
                }
                if($(".mobileCodeBtn").attr("disabled") == "disabled"){
                    return false;
                }
                // $.ajax({
                //     type:"post",
                //     url:"/seller/SmsCodeLogin",
                //     success: function(res){
                //         if (res.code==1){
                //             if(true && false){
                //                 login.mImgVerify.show(false);
                //             }else{
                //                 $btn.attr('disabled', 'disabled');
                //                 login.mImgVerify.sendValidateCode(null, null, function(msg){
                //                     showMsg( msg);
                //                     $(".mobileCodeBtn").removeClass('mobileCodeBtn_ok');
                //                     //$btn.removeAttr('disabled');
                //                 });
                //             }
                //
                //         } else {
                //             $btn.attr('disabled', 'disabled');
                //             $btn.removeClass('mobileCodeBtn_ok');
                //             $('#error').text("").show();
                //             $('#error').html('手机未验证，请<a href="/seller/register.html" target="_blank" style="color:#3497db">注册</a>');
                //         }
                //     }
                // });
                $.ajax({
                    type:"post",
                    url:"/seller/SmsCodeLogin",
                    data: {
                        'mobile':loginMoile,
                        'rand':Math.random(0,23423432)
                    },
                    error: function(){
                        if(typeof callbackErr == 'function'){
                            callbackErr('系统繁忙');
                        }
                    },
                    success: function(res){
                        if(res.code==1){
                            //operatePopupVc('false');
                            $btn.attr('disabled', 'disabled');
                            $btn.removeClass('mobileCodeBtn_ok');
                            clearInterval(timeCtrl.timer);
                            timeCtrl.clickCnt++;
                            timeCtrl.second = 60;
                            timeCtrl.timer = setInterval(function(){
                                if(timeCtrl.second > 0){
                                    $btn.html('已发送(' + timeCtrl.second + ')');
                                    timeCtrl.second--;
                                }else{
                                    $btn.html('重新获取').removeAttr('disabled');
                                    $btn.addClass('mobileCodeBtn_ok');
                                    clearInterval(timeCtrl.timer);
                                    timeCtrl.timer = null;
                                }
                            }, 1000);

                            $btn.closest('.u-input').find('.msg').removeClass('z-err').show();
                            var cacctStr = cacct;
                            if(validateCode){
                                login.mImgVerify.close();
                            }
                            $codeInput.focus();
                            if(typeof callbackSuc == 'function'){
                                callbackSuc();
                            }
                            if($("#codeLogin-valid-line").css("display") == "block"){
                                $("#codeLogin-refresh-btn").click();
                            }
                        }else{
                            showMsg(res.msg);
                        }
                    }
                });
            }
        }

    ;(function($, undefined){
        //如果是mjzpro10过来，用cookie记录一下。用于portal.jsp登录后打log by jser
        if(false){
            $.cookie("isFromMJZPro10", true);
        }
    }(jQuery));
</script>
</body>
</html>
