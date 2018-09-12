<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>
</head>
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
<form action="/userRegister" method="post" enctype="multipart/form-data">
    {{--{{ csrf_field() }}--}}
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
手机号码<input type="text" name="user_name" placeholder=""><br>
昵　称<input type="text" name="nick_name" placeholder="" id="nick_name"><br>
授权委托书<input type="file" name="attorney_letter_fileImg"><br> 
营业执照<input type="file" name="license_fileImg"><br> 
营业执照注册号<input type="text" name="business_license_id"><br>
纳税人识别号<input type="text" name="taxpayer_id"><br>
手机验证码<input type="text" name="mobile_code"><input type="button" onclick="messageCode();" value="获取验证码" id="code" /><br>
密　码<input type="password" name="password"><br>
确认密码<input type="password" name="password_confirmation">
<input type="hidden" name="is_firm" value="0">
<input type="submit" value="注册">
</form>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    var flag = false;
    function messageCode(){
        var user_name = $('#user_name').val();
        if(!flag){
            $.ajax({
                headers:{ 'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                'type':'post',
                'data':{'user_name':user_name},
                'url':'{{url('/messageCode')}}',
                success:function(res){
                    console.log('cs');
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
</script>