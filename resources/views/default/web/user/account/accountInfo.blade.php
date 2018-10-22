@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '账号信息')
@section('css')
    <style>
        .account_infor_list{margin-top: 30px;margin-left: 40px;}
        .account_infor_list li{overflow: hidden;}
        .account_infor_list li .infor_title{width: 150px;float: left; text-align: right;}
        .account_infor_list li .infor_title_input{width: 85px;float: left; text-align: right;height: 40px;line-height: 40px;}
        .infor_input{width: 260px;height: 40px;line-height: 40px;border: 1px solid #DEDEDE;margin-left: 10px;padding: 10px;box-sizing: border-box;}
        .account_infor_btn{width: 140px;height: 40px;line-height: 40px;border: none; border-radius:3px;margin-left: 135px;margin-top: 30px;background-color: #75b335;}
    </style>
@endsection
@section('js')
    <script type="text/javascript">
        $(".attorney_letter_fileImg").click(function(){
            var img = $(this).attr('data-img');
            index = layer.open({
                type: 1,
                title: '添加商品',
                area: ['500px', '300px'],
                content: '<img src="'+img+'">'
            });
        });


        function formToJson(data){
            data= decodeURIComponent(data,true);//防止中文乱码
            data = data.replace(/&/g, "','" );
            data = data.replace(/=/g, "':'" );
            data = "({'" +data + "'})" ;
            obj = eval(data);
            return obj;
        }

        $('.account_infor_btn').click(function (){

            var data = $("#user_real_form").serialize();
            var jsonData = formToJson(data);
            $.post('/account/saveUser',jsonData,function(res){
                console.log(res.data);
                if (res.code == 1) {
                    $.msg.success('保存成功');
                    window.location.href="/account/userInfo?id="+res.data;
                } else {
                    $.msg.alert(res.msg);
                }
            },"json");
        });
    </script>
@endsection

@section('content')
    <div class="clearfix mt25">
        <form method="post" action="javascript:void(0);" id="user_real_form">
        <div class="w1200">
                <ul class="account_infor_list">
                    <input type="hidden" name="id" value="{{$userInfo['id']}}">
                    <li><span class="infor_title">@if($userInfo['is_firm']==1)公司名称：@else昵称：@endif</span><span class="ml10"><input name="nick_name" type="text"  class="infor_input nick_name" value="{{$userInfo['nick_name']}}"></span></li>
                    <li class="mt25"><span class="infor_title">积分：</span><span class="ml20 fl">{{$userInfo['points']}}</span><a href="/account/viewPoints" class="fl ml30 orange">查看积分</a></li>
                    @if($userInfo['is_firm']==1)
                        <li class="mt25"><span class="infor_title">授权委托书：</span><span class="fl ml20"><a data-img="{{getFileUrl($userInfo['attorney_letter_fileImg'])}}"  class="fl ml10 orange attorney_letter_fileImg">查看</a></span></li>
                        <li class="mt25"><span class="infor_title">负责人姓名：</span><span class="fl ml10"><input name="contactName" type="text" @if(!empty($userInfo['contactName'])) value="{{$userInfo['contactName']}}" @else value="" @endif  class="infor_input contactName"  /></span></li>
                        <li class="mt25"><span class="infor_title">负责人手机：</span><span class="fl ml10"><input name="contactPhone" type="text" @if(!empty($userInfo['contactPhone'])) value="{{$userInfo['contactPhone']}}" @else value="" @endif class="infor_input contactPhone" /></span></li>
                        <li class="mt25">
                            <span class="infor_title">订单是否需审批：</span>
                            <span class="ml20 fl">
                            <input type="radio" @if(!empty($userInfo)&&$userInfo['need_approval']==0) checked @endif name="need_approval" value="0"> 否
                            <input type="radio" @if(!empty($userInfo)&&$userInfo['need_approval']==1) checked @endif name="need_approval" value="1"> 是
                        </span>
                        </li>
                    @else

                    @endif
                </ul>
            <button class="account_infor_btn code_greenbg fs18 white">保 存</button>
        </div>
        </form>
    </div>
@endsection
