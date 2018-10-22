@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '实名认证')
@section('css')
    <style>
        .account_infor_list{margin-top: 30px;margin-left: 40px;}
        .account_infor_list li{overflow: hidden;line-height: 40px;}
        .account_infor_list li .infor_title{float: left; text-align: right;line-height: 40px;width: 163px;}
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
            $.post('/account/saveUserReal',jsonData,function(res){
                console.log(res.data);
                if (res.code == 1) {
                    $.msg.success('保存成功');
                    window.location.href="/account/userRealInfo";
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
                    <li><span class="infor_title">账号：</span>
                        <span class="ml10">
                            {{$user_name}}
                        </span>
                    </li>
                    <input type="hidden" name="user_id"  value="{{$user_id}}" >
                @if($is_firm==0)
                    <li class="mt25">
                        <span class="infor_title">真实姓名：</span>
                        <span class=" fl">
                            <input type="text" name="real_name" class="infor_input" @if(!empty($user_real['real_name'])) value="{{$user_real['real_name']}}" @else value="" @endif />
                        </span>
                    </li>
                    <li class="mt25">
                        <span class="infor_title">性别：</span>
                        <span class="ml10 fl">
                            <input type="radio" @if(!empty($user_real)&&$user_real['sex']==0) checked @endif name="sex" value="0"> 保密
                            <input type="radio" @if(!empty($user_real)&&$user_real['sex']==1) checked @endif name="sex" value="1"> 男
                            <input type="radio" @if(!empty($user_real)&&$user_real['sex']==2) checked @endif name="sex" value="2"> 女
                        </span>
                    </li>
                    <li class="mt25">
                        <span class="infor_title">生日：</span>
                        <span class=" fl">
                            <input name="birthday" class="infor_input" type="text" @if(!empty($user_real['birthday'])) value="{{$user_real['birthday']}}" @else value="" @endif  >
                        </span>
                    </li>
                    <li class="mt25">
                        <span class="infor_title">身份证正面：</span>
                        <span class="ml10 fl">
                            @if(!empty($user_real['front_of_id_card']))
                                @if($user_real['review_status']==1) 已经上传，审核已经通过
                                @elseif($user_real['review_status']==0) 已经上传，审核中
                                @else <span style="float:left;color:red;margin-right:10px;">审核不通过，请重新上传</span> @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'front_of_id_card'])@endcomponent
                                @endif
                            @else
                                @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'front_of_id_card'])@endcomponent
                            @endif
                        </span>
                    </li>
                    <li class="mt25">
                        <span class="infor_title">身份证反面：</span>
                        <span class="ml10 fl">
                            @if(!empty($user_real['reverse_of_id_card']))
                                @if($user_real['review_status']==1) 已经上传，审核已经通过
                                @elseif($user_real['review_status']==0) 已经上传，审核中
                                @else <span style="float:left;color:red;margin-right:10px;">审核不通过，请重新上传</span> @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'reverse_of_id_card'])@endcomponent
                                @endif
                            @else
                                @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'reverse_of_id_card'])@endcomponent
                            @endif
                        </span>
                    </li>

               @else
                    <li class="mt25"><span class="infor_title">企业全称：</span>
                        <span class="ml10">
                        {{$user_real['real_name']}}
                        </span>
                    </li>
                    <li class="mt25">
                        <span class="infor_title">纳税人识别号：</span>
                        <span class=" fl">
                            {{$user_real['taxpayer_id']}}
                        </span>
                    </li>
                    <li class="mt25">
                        <span class="infor_title">营业执照注册号：</span>
                        <span class=" fl">
                            {{$user_real['business_license_id']}}
                        </span>
                    </li>
                    <li class="mt25">
                        <span class="infor_title">营业执照电子版：</span>
                        <span class="ml10 fl">
                            <i class="iconfont icon-image img-tooltip" @if(!isset($user_real['license_fileImg']) || empty($user_real['license_fileImg'])) style="display: none;" @else data-img="{{getFileUrl($user_real['license_fileImg'])}}" @endif ></i>
                        </span>
                    </li>
                        <li class="mt25">
                            <span class="infor_title">审核状态：</span>
                            <span class=" fl">
                                @if($user_real['review_status'] == 0)
                                    待审核
                                @elseif($user_real['review_status'] == 1)
                                    已审核
                                @else
                                    审核不通过
                                @endif
                        </span>
                        </li>
               @endif
                </ul>
            @if($is_firm==0)
                <button class="account_infor_btn code_greenbg fs18 white">保 存</button>
            @endif
        </div>
        </form>
    </div>
@endsection
