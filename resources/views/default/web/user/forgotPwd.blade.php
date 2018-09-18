<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<script src="http://code.jquery.com/jquery-1.4.1.min.js"></script>
<body>
	@if(count($errors)>0)
    <div class="alert alert-warning" role="alert">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif
	<form method="post" action="/forgotPwd">
	<input type="hidden" name="_token" value="{{ csrf_token() }}" /><br>
	手机号码:<div id="mobile">{{session('_web_info')['user_name']}}</div>
	<br>
	手机验证码<input type="text" name="mobile_code"><input type="button" onclick="messageCode();" value="获取手机验证码" /><br>
	请输入新密码<input type="password" name="newPassword"><br>
	请再次输入新密码<input type="password" name="newPassword_confirmation"><br>
	<input type="hidden" name="type" value="sms_find_signin">
	<input type="submit" name="" value="提交">
	</form>
</body>
</html>
<script>
    var flag = false;
    function messageCode(){
        var user_name = $('#user_name').val();
        var is_type = $('input[name=type]').val();
        if(!flag){
            $.ajax({
                headers:{ 'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                'type':'post',
                'data':{'user_name':user_name,'_token':'{{csrf_token()}}','is_type':is_type},
                'url':"{{url('/getCode')}}",
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
</script>