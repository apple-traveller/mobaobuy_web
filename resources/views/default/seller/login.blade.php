<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script><!--//webfonts-->
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'layui/css/login.css')}}" />
    <script src="{{asset(themePath('/').'js/jquery-1.9.1.min.js')}}" ></script>
    <script src="{{asset(themePath('/').'layui/layui.js')}}" ></script>
</head>
<body>
<script>
    $(document).ready(function(c) {
        $('.close').on('click', function(c){
            $('.login-form').fadeOut('slow', function(c){
                $('.login-form').hide();
            });
        });
        $('.open').on('click', function(c){
            $('.login-form').fadeOut('slow', function(c){
                $('.login-form').show();
            });
        });
    });
</script>
<h1 class="open">商户登陆</h1>
<div class="login-form">
    <div class="close"> </div>
    <div class="clear"> </div>
    <div class="avtar">
        <img src="{{asset(themePath('/').'layui/images/login/avtar.png')}}" />
    </div>
    <form action="/seller/login" method="post" onsubmit="submitForm()">
        <input type="text" class="text" name="user_name" id="user_name" onfocus="this.value = '';" >
        <div class="key">
            <input type="password" name="password" id="password" onfocus="this.value = '';" autocomplete='tel'>
        </div>
    </form>
    <div class="signin">
        <input type="submit" value="Login" onclick="submitForm()" >
    </div>
</div>

</body>
<script>
    $('body').keyup(function (event) {
        if (event.keyCode==13){
            submitForm();
        }
    });
    function submitForm() {
        layui.use(['layer'],function () {
            let layer = layui.layer;
            let user_name = $('#user_name').val();
            let password = window.btoa($('#password').val());
            // $('#password').val(password);
            $.ajax({
                url: '/seller/login',
                data: {
                    user_name: user_name,
                    password: password
                },
                type: 'POST',
                success: function (res) {
                    if (res.code == 1){
                        window.location.href="{{url('/seller')}}";
                    } else {
                        $('#password').val('');
                       layer.msg(res.msg);
                    }
                }
            });
        });
    }
</script>
</html>
