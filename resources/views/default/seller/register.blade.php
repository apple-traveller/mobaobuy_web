<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>register</title>
</head>
<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
<style>
    .main{
        text-align: center;
        background-color: #fff;
        border-radius: 20px;
        width: 600px;
        height: 350px;
        margin: auto;
        position: absolute;
        top: 20px;
        left: 600px;
    }
</style>
<body>
<div class="main" >
<h1>商户注册</h1>
<form>
    店铺名称  <input type="text" name="shop_name" id="shop_name" onblur="checkShopName()"><br>
    <div style="height: 20px;">
        <div class="reg_error" id="shop_name_error"></div>
    </div>
    企业全称  <input type="text" name="company_name" id="company_name" onblur="checkCompany()"><br>
    <div style="height: 20px;">
        <div class="reg_error" id="company_name_error"></div>
    </div>
    授权委托书电子版  <input type="file" name="attorney_letter_fileImg" id="attorney_letter_fileImg" onblur="checkAttorney_letter_fileImg()"><br>
    <div style="height: 20px;">
        <div class="reg_error" id="attorney_letter_fileImg_error"></div>
    </div>
    营业执照注册号  <input type="text" name="business_license_id" id="business_license_id" onblur="check_license_id()"><br>
    <div style="height: 20px;">
        <div class="reg_error" id="business_license_id_error"></div>
    </div>
    营业执照副本电子版  <input type="file" name="license_fileImg" id="license_fileImg"><br>
    <div style="height: 20px;">
        <div class="reg_error" id="license_fileImg_error"></div>
    </div>
    纳税人识别号  <input type="text" name="taxpayer_id" id="taxpayer_id" onblur="check_taxpayer()"><br>
    <div style="height: 20px;">
        <div class="reg_error" id="taxpayer_id_error"></div>
    </div>
    是否自营  <input type="text" name="is_self_run" id="is_self_run"><br>
    <div style="height: 20px;">
        <div class="reg_error" id="is_self_run_error"></div>
    </div>
    用户姓名   <input type="text" name="name" id="name" placeholder="请输入负责人姓名"><br>
    <div style="height: 20px;">
        <div class="reg_error" id="name_error"></div>
    </div>
    手机号    <input type="text" name="mobile" id="mobile"><br>
    <input style="width: 98px;" type="text" maxlength="4" placeholder="图形验证码"
           id="verify" onblur="verifyValidate();"><img src="" title="点击换一个校验码"
                                                       alt="点击换一个校验码" id="imVcode">
    <div style="height: 20px;">
        <div class="reg_error" id="verify_error"></div>
    </div>
    手机验证码  <input type="text" name="mobile_code" id="mobile_code"><input type="button" onclick="messageCode();" value="获取验证码" id="code" /><br>
    密　码   <input type="password" name="password" id="password"><br>
    确认密码  <input type="password" name="password_confirmation" id="password_confirmation"><br>
            <input name="protocol" type="checkbox" value="1" id="protocol" > <a href="javascript:void(0)">《协议》</a>
    {{--<input type="button" value="注册" onclick="submit()">--}}
    <a href="javascript:void(0)" onclick="submit()">注册</a>
    <a href="/seller/login.html">登录</a>
</form>
</div>
</body>
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
    var flag = false;
    gv();
    // 检查店铺名称
    function checkShopName() {
        let ShopName = $('#shop_name').val();
        if (isNull.test(ShopName)){
            $('#shop_name_error').html('店铺名不能为空');
            checkAccount = false;
            return false;
        }
        $.ajax({
            'type':'get',
            'data':{'shop_name':ShopName,'_token':'{{csrf_token()}}'},
            'url':"{{url('/seller/checkShopName')}}",
            success(res){
                if (res.msg){
                    $('#shop_name_error').html(res.msg);
                    checkAccount = false;
                    return false;
                } else {
                    $('#shop_name_error').html('');
                    checkAccount = true;
                }
            }
        });
    }
    // 检查企业
    function checkCompany() {
        let companyName = $('#company_name').val();
        if (isNull.test(companyName)){
            $('#company_name_error').html('企业名称不能为空');
            checkAccount = false;
        } else {
            $.ajax({
                'type':'get',
                'data':{'company_name':companyName,'_token':'{{csrf_token()}}'},
                'url':"{{url('/seller/checkCompany')}}",
                success(res){
                    console.log(res);
                    if (res.code == 200){
                        $('#company_name_error').html(res.msg);
                        checkAccount = true;
                    } else {
                        $('#company_name_error').html(res.msg);
                        checkAccount = false;
                        return false;
                    }
                }
            });
        }
    }
    // 检查执照注册号
    function check_license_id() {
        let license_id = $('#business_license_id');
        if (license_id){
            checkAccount = true;
        } else {
            $('#business_license_id_error').html('请填写注册号');
            checkAccount = false;
            return false;
        }
    }

    // 检查纳税人识别号
    function check_taxpayer() {
        let taxpayer_id = $('#taxpayer_id').val();
        if (taxpayer_id){
            checkAccount = true;
        } else {
            checkAccount = false;
            $('#taxpayer_id_error').html('请填写纳税人识别号');
            return false;
        }
    }
    // 发送短信
    function messageCode(){
        var mobile = $('#mobile').val();
        console.log(mobile);
        if(!flag){
            $.ajax({
                'type':'post',
                'data':{'mobile':mobile,'_token':'{{csrf_token()}}'},
                'url':"{{url('/shop/getSmsCode')}}",
                success:function(res){
                    var result = JSON.parse(res);
                    if(result.code){
                        alert('发送成功');
                        var time = 60;
                        flag = true;
                        var timer = setInterval(function(){
                            time--;
                            $('#code').val(time + '后重新获取');
                            if(time == 1){
                                $('#code').val('获取验证码');
                                time = 60;
                                clearInterval(timer);
                                flag = false;
                                return false;
                            }
                        },1000)
                    }
                }
            })
        }
        return;
    }

    // 提交
    function submit() {
            var _shop_name = $('#shop_name').val();
            var _company_name = $('#company_name').val();
            var _attorney_letter_fileImg = $('#attorney_letter_fileImg').val();
            var _business_license_id = $('#business_license_id').val();
            var _license_fileImg = $('#license_fileImg').val();
            var _taxpayer_id = $('#taxpayer_id').val();
            var _is_self_run = $('#is_self_run').val();
            var _password = $('#password').val();
            var _mobile = $('#mobile').val();
            var _mobile_code = $('#mobile_code').val();
            // if ($('#protocol').checked())

            var _protocol = $('#protocol').checked ? $('#protocol').val():'';

            let _data = {
                'shop_name':_shop_name,
                'company_name':_company_name,
                'attorney_letter_fileImg':_attorney_letter_fileImg,
                'business_license_id':_business_license_id,
                'license_fileImg':_license_fileImg,
                'taxpayer_id':_taxpayer_id,
                'is_self_run':_is_self_run,
                'password':_password,
                'mobile':_mobile,
                'mobile_code':_mobile_code,
                'protocol':_protocol
            };
            console.log(_data);
    }
    // 图形验证码
    $('#imVcode').click(function(){
        console.log(44);
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
</script>
</html>

