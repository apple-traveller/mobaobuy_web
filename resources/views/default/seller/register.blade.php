<!doctype html>
<html lang="en">
<head>
    <title>商家入驻</title>
    @include(themePath('.','seller').'seller.include.partials.base')
    <script src="{{asset('js/jquery.base64.js')}}" ></script>
        <style>
            .register-type li {
                width: 236px;
                height: 45px;
                line-height: 45px;
                font-size: 39px;
                float: left;
                text-align: center;
                margin: 0;
                margin-left: 60px;
                cursor: pointer;
            }
        </style>
</head>
<body style="background-color: #f4f4f4;">
<div class="clearfix whitebg">
    <div class="register-title">
        <div class="logo">
            <a href="/">
                <img src="{{getFileUrl(getConfig('shop_logo', asset('images/logo.png')))}}">
            </a>
        </div>

        <div class="go-login">已有账号，可 <a href="/seller/login.html" style="color:#36a3ef">直接登录</a></div>
    </div>
</div>
<div class="clearfix" style="height: 35px;"></div>

<div class="clearfix">
    <div class="register-box">
        <div class="register-form">
            <div class="form">
                <div class="item">
                    <div class="item-libel">企业全称</div>
                    <div class="item-info"><input type="text" class="text" maxlength="20" id="company_name" name="company_name" placeholder="请输入企业全称" onblur="companyNameValidate()"/></div>
                    <div class="input-tip"><label id="company_error" class="error"></label></div>
                </div>
                <div class="item">
                    <div class="item-libel">授权委托书电子版</div>
                    @component('widgets.upload_file',['upload_type'=>'firm_attorney','upload_path'=>'firm/attorney','name'=>'attorney_letter_fileImg'])@endcomponent
                    <div class="input-tip"><label id="attorney_letter_error" class="error"></label></div>
                </div>
                <div class="item">
                    <div class="item-libel">营业执照副本电子版</div>
                    @component('widgets.upload_file',['upload_type'=>'firm_attorney','upload_path'=>'firm/license','name'=>'license_fileImg'])@endcomponent
                    <div class="input-tip"><label id="license_error" class="error"></label></div>
                </div>

                <div class="item">
                    <div class="item-libel">负责人电话</div>
                    <div class="item-info"><input type="text" class="text" maxlength="11" id="contactPhone" name="contactPhone" placeholder="负责人电话" onblur="contactPhoneValidate()" /></div>
                    <div class="input-tip"><label id="contactPhone_error" class="error"></label></div>
                </div>

                <div class="item">
                    <div class="item-libel">设置密码</div>
                    <div class="item-info"><input type="password" class="text" name="password" maxlength="16" placeholder="密码由8-16个字符(字母+数字组成)" id="password" onblur="pwdValidate()"></div>
                    <div class="input-tip"><label id="pwd_error" class="error"></label></div>
                </div>
                <div class="item">
                    <div class="item-libel">图形验证码</div>
                    <div class="item-info" style="width: 178px;">
                        <input style="width: 158px;" type="text" class="text" maxlength="4" placeholder="图形验证码"  id="verify" onblur="verifyValidate();">
                    </div>
                    <img src="" title="点击换一个校验码" style="margin-left: 10px;line-height: 35px;height: 43px; width: 130px;" alt="点击换一个校验码" id="imVcode">
                    <div class="input-tip"><label id="verify_error" class="error"></label></div>
                </div>
                <div class="item">
                    <div class="item-libel">手机验证码</div>
                    <div class="item-info msgCode-swap blackgraybg" style="width: 178px;">
                        <input style="width: 158px;background-color: transparent;" name="msgCode" id="messCode" type="text" class="text" readonly maxlength="6" onblur="msgCodeValidate();">
                    </div>
                    <input type="button" class="messCode_but" style="margin-left: 10px;line-height: 35px;height: 43px; width: 130px;" id="messCode_but" value="获取手机验证码">
                    <div class="input-tip"><label id="msgCode_error" class="error"></label></div>
                </div>

            </div>
        </div>
        <div class="register-checkbox">
            <label class="check_box"><input name="" id="action" onchange="genreCheck();" type="checkbox" checked="checked" />我已阅读并同意<a class="orange">《注册服务协议》</a></label>
        </div>
        <button class="register-button" id="sub-btn">同意并提交申请</button>
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
    var checkShop = false;
    var msType = false;
    var msType02 = true;
    var registerCode = false;
    var t = 0;

    gv();

    //验证企业全称
    function companyNameValidate(){
        var company_name = $('#company_name').val();
        if (jQuery.trim(company_name).length==0){
            $('#company_error').html("<i class='iconfont icon-minus-circle-fill'></i>企业全称不能为空");
            checkCompany = false;
            return false;
        } else {
            $.ajax({
                type:'get',
                data:{'company_name':company_name},
                url:"{{url('/seller/checkCompany')}}",
                async:false,
                success(res){
                    if (res.code == 200){
                        $('#company_error').html("");

                        checkCompany = true;
                    } else {
                        $('#company_error').html("<i class='iconfont icon-minus-circle-fill'>企业不存在</i>");
                        checkCompany = false;
                    }
                }
            });
        }
    }
    //验证注册号
    function licenseValidate(){
        var business_license_id = $("#business_license_id").val();
        if(jQuery.trim(business_license_id).length==0){
            $("#business_license_error").html("<i class='iconfont icon-minus-circle-fill'></i>注册号不能为空");
            return false;
        } else {
            $("#business_license_error").html("");
        }
    }

    //验证纳税号
    function taxpayerValidate(){
        var taxpayer_id = $("#taxpayer_id").val();
        if(jQuery.trim(taxpayer_id).length==0){
            $("#taxpayer_error").html("<i class='iconfont icon-minus-circle-fill'></i>纳税号不能为空");
            return false;
        } else {
            $("#taxpayer_error").html("");
        }
    }

    //验证店铺负责人
    function contactNameValidate(){
        var contactName = $("#contactName").val();
        if(jQuery.trim(contactName).length==0){
            $("#contactName_error").html("<i class='iconfont icon-minus-circle-fill'></i>负责人不能为空");
            return false;
        } else {
            $("#contactName_error").html("");
        }
    }

    //验证店铺负责人电话
    function contactPhoneValidate(){
        var contactPhone = $("#contactPhone").val();
        if(jQuery.trim(contactPhone).length==0){
            $("#contactPhone_error").html("<i class='iconfont icon-minus-circle-fill'></i>负责人电话不能为空");
            return false;
        } else {
            phoneValidate(contactPhone);
        }
    }

    // 手机格式验证
    function phoneValidate(contactPhone) {
        $("#contactPhone_error").html('');
       if (!Utils.isPhone(contactPhone)) {
           console.log(contactPhone);
            $("#contactPhone_error").html("<i class='iconfont icon-minus-circle-fill'></i>手机号码格式不正确！");
            checkAccount = false;
            return false;
        } else {
            checkAccount = true;
            $("#contactPhone_error").html("");
        }

    }

    // 密码格式检查
    function pwdValidate() {
        $("#pwd_error").html('');
        if (isNull.test($("#password").val())) {
            $("#pwd_error").html("<i class='iconfont icon-minus-circle-fill'></i>请输入密码");
            checkAccount = false;
            return false;
        }
        else if (!pwdReg.test($("#password").val())) {
            $("#pwd_error").html("<i class='iconfont icon-minus-circle-fill'></i>密码必须包含字母和数字长度8-16位字符");
            checkAccount = false;
            return false;
        }
        else {
            checkAccount = true;
            $("#pwd_error").html("");
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
        } else {
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
            }, "POST", "JSON",false);
        }
    }
    //  手机验证码格式检查
    function msgCodeValidate() {
        $("#msgCode_error").html("");
        if (isNull.test($("#messCode").val())) {
            $("#msgCode_error").html("<i class='iconfont icon-minus-circle-fill'></i>手机验证码不能为空");
            checkAccount = false;
            return false;
        } else if (!verify.test($("#messCode").val())) {
            $("#msgCode_error").html("<i class='iconfont icon-minus-circle-fill'></i>您输入的手机验证码有误");
            checkAccount = false;
            return false;
        } else {
            checkAccount = true;
            return true;
        }
        console.log(checkAccount);

    }
    $('#messCode_but').click(function ()  {
        if(msType02) {
            sendMessage(true);
        }
    });
    // 点击获取短信验证码
    function sendMessage(type) {
        contactPhoneValidate();
        verifyValidate (); // ajax 设为同步， 不然数据无法及时更新
        if (!checkAccount ||!registerCode) {
            return false;
        }

        params = {
            mobile: $("#contactPhone").val(),
            verifyCode: $("#verify").val(),
            t: t,
        };
        Ajax.call("{{url('/seller/getSmsCode')}}", params, function (result){
            if (result.code == 1) {
                Settime (type);
                $('.msgCode-swap').removeClass('blackgraybg');
                $('.msgCode-swap input').removeAttr('readonly');
            }else{
                $("#verify_error").html("<i class='iconfont icon-minus-circle-fill'></i>"+result.msg);
            }
        }, "POST", "JSON");
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
    $('#sub-btn').click(function (){
        shopNameValidate();
        contactPhoneValidate();
        verifyValidate ();
        if (!checkCompany || !checkAccount || !pwdValidate() || !registerCode || !msgCodeValidate() || !checkAttorneyExists() || !checkLicenseExists()) {
            return false;
        }
        params = {
            shop_name: $("#shop_name").val(),
            companyName: $("#company_name").val(),
            contactName: $("#contactName").val(),
            password: $.base64.btoa($("#password").val()),
            mobile: $("#contactPhone").val(),
            mobile_code: $("#messCode").val(),
            business_license_id: $("#business_license_id").val(),
            taxpayer_id: $("#taxpayer_id").val(),
            is_self_run: $('input:radio[name="is_self_run"]:checked').val(),
            attorney_letter_fileImg: $("#attorney_letter_fileImg").val(),
            license_fileImg: $("#license_fileImg").val(),
        };
        Ajax.call("{{url('/seller/register')}}", params, function (result){
            if (result.code == 1) {
                window.location.href="/seller/login.html";
            }else{
                $.msg.error(result.msg);
            }
        }, "POST", "JSON");
        gv()
    });

    //验证店铺唯一性
    function shopNameValidate(){
        var shop_name = $("#shop_name").val();
        if(jQuery.trim(shop_name).length==0){
            $("#shop_error").html("<i class='iconfont icon-minus-circle-fill'></i>店铺名称不能为空");
            checkShop = false;
            return false;
        }else{
            Ajax.call("{{url('/seller/checkShopName')}}", "shop_name="+shop_name, function (result){
                if(result.code==1){
                    $("#shop_error").html("");
                    checkShop = true;
                    return true;
                }else{
                    $("#shop_error").html("<i class='iconfont icon-minus-circle-fill'></i>"+result.msg);
                    checkShop = false;
                    return false;
                }
            }, "POST", "JSON");
        }
    }
    // 上传图片预览
    $(document).tooltip({
        items: ".img-tooltip",
        content: function() {
            var element = $( this );
            var url = element.data('img');
            return "<img class='map' src='"+url+"'>";
        }
    });
</script>
