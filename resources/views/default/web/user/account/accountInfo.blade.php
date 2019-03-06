@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '账号信息')
@section('css')
    <style>
        .account_infor_list{margin-top: 30px;margin-left: 40px;}
        .account_infor_list li{overflow: hidden;}
        .account_infor_list li .infor_title{width: 150px;float: left; text-align: right;height:40px;line-height: 40px;}
        .account_infor_list li .infor_title_input{width: 85px;float: left; text-align: right;height: 40px;line-height: 40px;}
        .infor_input{width: 260px;height: 40px;line-height: 40px;border: 1px solid #DEDEDE;margin-left: 10px;padding: 10px;box-sizing: border-box;}
        .account_infor_btn{width: 140px;height: 40px;line-height: 40px;border: none; border-radius:3px;margin-left: 135px;margin-top: 30px;background-color: #75b335;}
        .account_layout_btn{width: 140px;height: 40px;line-height: 40px;border: none; border-radius:3px;margin-left: 35px;margin-top: 30px;background-color: red;}
    </style>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).tooltip({
            items: ".img-tooltip",
            content: function() {
                var element = $( this );
                var url = element.data('img');
                return "<img class='map' src='"+url+"'>";
            }
        });

        $(".attorney_letter_fileImg").click(function(){
            var img = $(this).attr('data-img');
            index = layer.open({
                type: 1,
                title: '添加商品',
                area: ['500px', '300px'],
                content: '<img src="'+img+'">'
            });
        });

        // function formToJson(data){
        //     data= decodeURIComponent(data,true);//防止中文乱码
        //     data = data.replace(/&/g, "','" );
        //     data = data.replace(/=/g, "':'" );
        //     data = "({'" +data + "'})" ;
        //     obj = eval(data);
        //     return obj;
        // }

        $('.account_infor_btn').click(function (){

            var data = $("#user_real_form").serialize();
            // var jsonData = formToJson(data);
            Ajax.call('/account/saveUser',data,function(res){
                console.log(res.data);
                if (res.code == 1) {
                    $.msg.alert('{{trans('home.save_success')}}');
                    window.location.reload();
                } else {
                    $.msg.alert(res.msg);

                }
            },'POST','JSON');
        });
        @if(!$userInfo['is_firm'])
        //注销账号
        $('.account_layout_btn').click(function(){
            $.msg.confirm('{{trans('home.cancellation_account_tips')}}',
                function(){
                    Ajax.call('/account/accountLogout',{},function(res){
                        console.log(res.data);
                        if (res.code == 1) {
                            $.msg.alert('{{trans('home.cancellation_account_success')}}');
                            window.location.href = '/';
                        } else {
                            $.msg.alert(res.msg);
                        }
                    },'GET','JSON');
                },
                function(){

                }
            )
        });
        @endif
    </script>
@endsection

@section('content')
    <div class="clearfix mt25">
        <form method="post" action="javascript:void(0);" id="user_real_form">
        <div class="w1200">
                <ul class="account_infor_list">
                    <input type="hidden" name="id" value="{{$userInfo['id']}}">
                    <li><span class="infor_title">{{trans('home.nickname')}}：</span><span class="ml10"><input name="nick_name" type="text" @if(session('_web_user')['is_firm']) readonly="readonly" @endif class="infor_input" value="{{$userInfo['nick_name']}}"></span></li>
                  <!--   @if($userInfo['real_name'] == '') @else<li style="margin-top:20px;"><span class="infor_title">@if($userInfo['is_firm']==1)公司名称：@else真实姓名：@endif</span><span class="ml10"><input name="real_name" type="text" @if($userInfo['is_firm']==1) disabled="disabled" @endif class="infor_input nick_name" value="{{$userInfo['real_name']}}"></span></li>@endif -->
                    <li class="mt25"><span class="infor_title">{{trans('home.email')}}：</span><span class="ml10"><input name="email" type="text" value="{{$userInfo['email']}}" class="infor_input"></span></li>
                    @if($userInfo['is_firm']==1)
                        <li class="mt25">
                            <span class="infor_title">{{trans('order_is_approval')}}：</span>
                            <span class="ml20 fl" style="margin-top: 10px;">
                                <input type="radio" @if(!empty($userInfo)&&$userInfo['need_approval']==0) checked @endif name="need_approval" value="0" id="no"> <label for="no">{{trans('no')}}</label>
                                <input class="ml10" type="radio" @if(!empty($userInfo)&&$userInfo['need_approval']==1) checked @endif name="need_approval" value="1" id="yes"> <label for="yes">{{trans('yes')}}</label>
                            </span>
                        </li>
                    @else

                    @endif
                </ul>
            <button class="account_infor_btn code_greenbg fs18 white">{{trans('home.save')}}</button>
            {{--未实名认证和 个人认证的时候可以注销账号 注销个人认证的账号要注意清除与企业的关联信息--}}
            @if(!$userInfo['is_firm'])
                <button class="account_layout_btn redbg fs18 white">{{trans('home.cancellation_account')}}</button>
            @endif
        </div>
        </form>
    </div>
@endsection
