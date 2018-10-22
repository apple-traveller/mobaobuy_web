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
            Ajax.call('/account/saveUser',jsonData,function(res){
                console.log(res.data);
                if (res.code == 1) {
                    $.msg.success('保存成功');
                    window.location.reload();
                } else {
                    $.msg.alert(res.msg);
                }
            },'POST','JSON');
        });
    </script>
@endsection

@section('content')
    <div class="clearfix mt25">
        <form method="post" action="javascript:void(0);" id="user_real_form">
        <div class="w1200">
                <ul class="account_infor_list">
                    <input type="hidden" name="id" value="{{$userInfo['id']}}">
                    <li><span class="infor_title">@if($userInfo['is_firm']==1)公司名称：@else昵称：@endif</span><span class="ml10"><input name="nick_name" type="text" @if($userInfo['is_firm']==1) disabled="disabled" @endif class="infor_input nick_name" value="{{$userInfo['nick_name']}}"></span></li>
                    <li class="mt25"><span class="infor_title">电子邮箱：</span><span class="ml10"><input name="email" type="email" value="{{$userInfo['email']}}" class="infor_input"></span></li>
                    @if($userInfo['is_firm']==1)
                        <li class="mt25"><span class="infor_title">授权委托书：</span><span class="fl ml20"><i class="iconfont icon-image img-tooltip" @if(!isset($userInfo['attorney_letter_fileImg']) || empty($userInfo['attorney_letter_fileImg'])) style="display: none;" @else data-img="{{getFileUrl($userInfo['attorney_letter_fileImg'])}}" @endif ></i></span></li>
                        <li class="mt25"><span class="infor_title">负责人姓名：</span><span class="fl ml10"><input name="contactName" disabled="disabled" type="text" @if(!empty($userInfo['contactName'])) value="{{$userInfo['contactName']}}" @else value="" @endif  class="infor_input contactName"  /></span></li>
                        <li class="mt25"><span class="infor_title">负责人手机：</span><span class="fl ml10"><input name="contactPhone" disabled="disabled" type="text" @if(!empty($userInfo['contactPhone'])) value="{{$userInfo['contactPhone']}}" @else value="" @endif class="infor_input contactPhone" /></span></li>
                        <li class="mt25">
                            <span class="infor_title">订单是否需审批：</span>
                            <span class="ml20 fl">
                            <input type="radio" @if(!empty($userInfo)&&$userInfo['need_approval']==0) checked @endif name="need_approval" value="0" id="no"> <label for="no">否</label>
                            <input type="radio" @if(!empty($userInfo)&&$userInfo['need_approval']==1) checked @endif name="need_approval" value="1" id="yes"> <label for="yes">是</label>
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
