<div class="ibox">

    @if(trim($__env->yieldContent('title')))
        <div class="ibox-title notselect">
            <h5>@yield('title','')</h5>
            @yield('button')
        </div>
    @endif
    <div class="ibox-content">
        @if(isset($alert))
            <div class="alert alert-{{$alert['type']}} alert-dismissible" role="alert" style="border-radius:0">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                @if(isset($alert['title']))<p style="font-size:18px;padding-bottom:10px">{{$alert['title']}}</p>@endif
                @if(isset($alert['content']))<p style="font-size:14px">{{$alert['content']}}</p>@endif
            </div>
        @endif
        @yield('content')
    </div>
</div>
<script>
    var config = {
        socket_server: '127.0.0.1:8283',
        uid: "{{session('_account_user_info.id')}}",
        uname: "{{session('_account_user_info.real_name')}}",
        avatar: "{{session('_account_user_info.avatar')}}",
        sign: "{{session('_account_user_info.sign')}}",
        user_list_url : "{{url('/im/getUserList')}}",
        member_list_url: "{{url('/im/getMemberList')}}", // 分组成员信息
        upload_img_url: '{{url('/uploadImg')}}', // 图片上传接口
        upload_file_url: '{{url('/uploadFile')}}',// 文件上传接口
        find_url: "{{'/findgroup/index'}}", // 查询群组接口
        chatlog_url: '{{'/chatlog'}}', // 聊天记录接口
        change_sign_url: "{{url('/im/sign')}}", // 修改个性签名
        join_group_url: '{{url('/findgroup/joinDetail')}}', // 加入群组
    };

</script>
<script src="{{ asset(themePath('/').'js/main.js')}}" ></script>