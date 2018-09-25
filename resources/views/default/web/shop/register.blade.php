<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>register</title>
</head>
{{--<script src="http://code.jquery.com/jquery-1.4.1.min.js"></script>--}}
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
    店铺名称  <input type="text" name="shop_name" id="shop_name"><br>
    企业全称  <input type="text" name="company_name" id="company_name"><br>
    授权委托书电子版  <input type="file" name="attorney_letter_fileImg" id="attorney_letter_fileImg"><br>
    营业执照注册号  <input type="text" name="business_license_id" id="business_license_id"><br>
    营业执照副本电子版  <input type="file" name="license_fileImg" id="license_fileImg"><br>
    纳税人识别号  <input type="text" name="taxpayer_id" id="taxpayer_id"><br>
    是否自营  <input type="text" name="is_self_run" id="is_self_run"><br>
    用户姓名   <input type="text" name="name" id="name" placeholder="请输入负责人姓名"><br>
    手机号    <input type="text" name="mobile" id="mobile"><br>
    手机验证码  <input type="text" name="mobile_code" id="mobile_code"><input type="button" onclick="messageCode();" value="获取验证码" id="code" /><br>
    密　码   <input type="password" name="password" id="password"><br>
    确认密码  <input type="password" name="password_confirmation" id="password_confirmation"><br>
            <input name="protocol" type="checkbox" value="1" id="protocol" > <a href="javascript:void(0)">《协议》</a>
    {{--<input type="button" value="注册" onclick="submit()">--}}
    <a href="javascript:void(0)" onclick="submit()">注册</a>
    <a href="/shop/login.html">登录</a>
</form>
</div>
</body>
<script>
    var flag = false;
    function messageCode(){
        var mobile = $('#mobile').val();
        console.log(mobile);
        if(!flag){
            $.ajax({
                headers:{ 'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                'type':'post',
                'data':{'mobile':mobile,'_token':'{{csrf_token()}}'},
                'url':"{{url('/shop/getSmsCode')}}",
                success:function(res){
                    var result = JSON.parse(res);
                    console(result);
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
</script>
</html>

