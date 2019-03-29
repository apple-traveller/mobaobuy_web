@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '实名认证')
    <!-- <link rel="stylesheet" href="/defaultcss/global.css" /> -->
        <!-- <link rel="stylesheet" href="/default/css/index.css" /> -->
@section('css')
    <style>
        .account_infor_list{margin-top: 30px;margin-left: 40px;}
        .account_infor_list li{overflow: hidden;line-height: 40px;}
        .account_infor_list li .infor_title{float: left; text-align: right;line-height: 40px;width: 163px;}
        .account_infor_list li .infor_title_input{width: 85px;float: left; text-align: right;height: 40px;line-height: 40px;}
        .infor_input{width: 260px;height: 40px;line-height: 40px;border: 1px solid #DEDEDE;margin-left: 10px;padding: 10px;box-sizing: border-box;}
        .account_infor_btn{width: 140px;height: 40px;line-height: 40px;border: none; border-radius:3px;margin-left: 135px;margin-top: 30px;background-color: #75b335;}
        .account_tab {
        width: 376px;
        margin: 0 auto;
        }
        .account_tab li {
            width: 188px;
            height: 45px;
            line-height: 45px;
            font-size: 16px;
            float: left;
            text-align: center;
            margin: 0;
            cursor: default;
        }
        .account_curr {
            border-bottom: 1px solid #75b335;
            color: #75b335;
        }
    </style>
@endsection
@section('js')
    <script type="text/javascript">
        $(function(){
            $(".account li").click(function(){
                $(this).addClass('account_curr').siblings().removeClass('account_curr');
                $('.tab_list>li').eq($(this).index()).show().siblings().hide();
            });
            //调用示例
            layer.photos({
                photos: '.layer-photos-demo'
                ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
            });

        })
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
            var is_self = $(this).attr('id');
            var data = $("#user_real_form").serialize();
            // console.log(is_firm);
            // console.log(data);return;
            var jsonData = formToJson(data);
            $.post('/account/saveUserReal',{jsonData,'is_self':is_self},function(res){
                if (res.code == 1) {
                    $.msg.success('{{trans('home.save_success')}}');
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
        
            <div class="clearfix bb1 f4bg">

                @if(!empty($user_real))
                    @if($user_real['is_firm'] == '0')
                        <ul class="account_tab"><li class="account_curr">{{trans('home.individual_account')}}</li></ul>
                    @elseif($user_real['is_firm'] == '1')
                         <ul class="account_tab"><li id="firm">{{trans('home.enterprise_account')}}</li></ul>
                     @else
                        <ul class="account_tab"><li class="account_curr">{{trans('home.individual_account')}}</li><li id="firm">{{trans('home.enterprise_account')}}</li></ul>
                    @endif


                @else
                 <ul class="account_tab"><li class="account_curr">{{trans('home.individual_account')}}</li><li id="firm">{{trans('home.enterprise_account')}}</li></ul>
                @endif
             </div>
            
             
                <ul class="tab_list">
                <!-- 个人账户 -->
                 @if($user_real['is_firm'] == '0')
                 <li>
                     <ul class="account_infor_list">
                    <li><span class="infor_title">{{trans('home.account_number')}}：</span>
                        <span class="ml10">
                            {{$user_name}}
                        </span>
                    </li>
                    <input type="hidden" name="user_id"  value="{{$user_id}}" >
                
                    <li class="mt25">
                        <span class="infor_title">{{trans('home.real_name')}}：</span>
                        <span class=" fl">
                            <input type="text" name="real_name" class="infor_input" @if(!empty($user_real['real_name'])) value="{{$user_real['real_name']}}" disabled="disabled" @else value="" @endif/>
                        </span>
                    </li>

                    <li class="mt25">
                        <span class="infor_title">{{trans('home.front_card')}}：</span>
                        <span class="ml10 fl">
                            @if(!empty($user_real['front_of_id_card']))
                                @if($user_real['review_status']==1)
                                    <div id="layer-photos-demo" class="layer-photos-demo">
                                        {{--<img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ URL::asset('storage/'.$user_real['front_of_id_card']) }}" src="{{ URL::asset('storage/'.$user_real['front_of_id_card']) }}" alt="身份证正面">--}}
                                         <img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ getFileUrl($user_real['front_of_id_card']) }}" src="{{ getFileUrl($user_real['front_of_id_card']) }}" alt="{{trans('home.front_card')}}">
                                        <span style="margin: 0 0 0 10px;">{{trans('home.uploaded_audited_tips')}}</span>
                                    </div>
                                @elseif($user_real['review_status']==0)
                                    <div id="layer-photos-demo" class="layer-photos-demo">
                                        <img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ getFileUrl($user_real['front_of_id_card']) }}" src="{{ getFileUrl($user_real['front_of_id_card']) }}" alt="{{trans('home.front_card')}}">
                                        <span style="margin: 0 0 0 10px;">{{trans('home.uploaded_auditing_tips')}}……</span>
                                    </div>
                                @else
                                    <span style="float:left;color:red;margin-right:10px;">{{trans('home.uploaded_audit_failed_tips')}}</span>
                                    @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'front_of_id_card'])@endcomponent
                                @endif
                            @else
                                @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'front_of_id_card'])@endcomponent
                            @endif
                        </span>
                    </li>
                    <li class="mt25">
                        <span class="infor_title">{{trans('home.back_card')}}：</span>
                        <span class="ml10 fl">
                            @if(!empty($user_real['reverse_of_id_card']))
                                @if($user_real['review_status']==1)
                                    <div class="layer-photos-demo">
                                        <img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ getFileUrl($user_real['reverse_of_id_card']) }}" src="{{ getFileUrl($user_real['reverse_of_id_card']) }}" alt="{{trans('home.back_card')}}">
                                         {{--<img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ URL::asset('storage/'.$user_real['reverse_of_id_card']) }}" src="{{ URL::asset('storage/'.$user_real['reverse_of_id_card']) }}" alt="身份证反面">--}}
                                        <span style="margin: 0 0 0 10px;">{{trans('home.uploaded_audited_tips')}}</span>
                                    </div>
                                @elseif($user_real['review_status']==0)
                                    <div class="layer-photos-demo">
                                        {{--<img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ URL::asset('storage/'.$user_real['reverse_of_id_card']) }}" src="{{ URL::asset('storage/'.$user_real['reverse_of_id_card']) }}" alt="身份证反面">--}}
                                        <img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ getFileUrl($user_real['reverse_of_id_card']) }}" src="{{ getFileUrl($user_real['reverse_of_id_card']) }}" alt="{{trans('home.back_card')}}">
                                        <span style="margin: 0 0 0 10px;">{{trans('home.uploaded_auditing_tips')}}……</span>
                                    </div>
                                @else
                                    <span style="float:left;color:red;margin-right:10px;">{{trans('home.uploaded_audit_failed_tips')}}</span>
                                    @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'reverse_of_id_card'])@endcomponent
                                @endif
                            @else
                                @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'reverse_of_id_card'])@endcomponent
                            @endif
                        </span>
                    </li>
                @if(!empty($user_real))
                    @if($user_real['review_status'] == 0 || $user_real['review_status'] == 1)
                        
                    @else
                    <button class="account_infor_btn code_greenbg fs18 white" id="1">{{trans('home.save')}}</button>
                    @endif
                @else
                    <button class="account_infor_btn code_greenbg fs18 white" id="1">{{trans('home.save')}}</button>
                @endif
                </ul>
                </li>
                

               
                @else
                 <!-- 企业账户 -->
                       <li>
                     <ul class="account_infor_list">
                    <li><span class="infor_title">{{trans('home.account_number')}}：</span>
                        <span class="ml10">
                            {{$user_name}}
                        </span>
                    </li>
                    <input type="hidden" name="user_id"  value="{{$user_id}}" >
                   
               
                    <li class="mt25">
                         <span class="infor_title">{{trans('home.enterprise_name')}}：</span>
                        <span class=" fl">
                            <input type="text" name="real_name_firm" class="infor_input" @if(!empty($user_real['real_name'])) value="{{$user_real['real_name']}}" disabled="disabled" @else value="" @endif />
                        </span>
                    </li>

                    <li class="mt25">
                       <span class="infor_title">{{trans('home.taxpayer_identification_number')}}：</span>
                        <span class=" fl">
                            <input type="text" name="tax_id" class="infor_input" @if(!empty($user_real['tax_id'])) value="{{$user_real['tax_id']}}" disabled="disabled" @else value="" @endif />
                        </span>
                    </li>


                      <li class="mt25">
                         <span class="infor_title">{{trans('home.electronic_authorization')}}：</span>
                        <span class=" fl">
                            @if(!empty($user_real['attorney_letter_fileImg']))               
                                @if($user_real['review_status']==1)
                                    <div id="layer-photos-demo" class="layer-photos-demo">
                                        {{--<img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ URL::asset('storage/'.$user_real['attorney_letter_fileImg']) }}" src="{{ URL::asset('storage/'.$user_real['attorney_letter_fileImg']) }}" alt="授权委托书电子版">--}}
                                        <img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ getFileUrl($user_real['attorney_letter_fileImg']) }}" src="{{ getFileUrl($user_real['attorney_letter_fileImg']) }}" alt="{{trans('home.electronic_authorization')}}">
                                        <span style="margin: 0 0 0 10px;">{{trans('home.uploaded_audited_tips')}}</span>
                                    </div>
                                @elseif($user_real['review_status']==0)
                                    <div class="layer-photos-demo">
                                        <img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ getFileUrl($user_real['attorney_letter_fileImg']) }}" src="{{ getFileUrl($user_real['attorney_letter_fileImg']) }}" alt="{{trans('home.electronic_authorization')}}">
                                        {{--<img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ URL::asset('storage/'.$user_real['attorney_letter_fileImg']) }}" src="{{ URL::asset('storage/'.$user_real['attorney_letter_fileImg']) }}" alt="授权委托书电子版">--}}
                                        <span style="margin: 0 0 0 10px;">{{trans('home.uploaded_auditing_tips')}}……</span>
                                    </div>
                                @else
                                    <span style="float:left;color:red;margin-right:10px;">{{trans('home.uploaded_audit_failed_tips')}}</span>
                                    @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/letterFile','name'=>'attorney_letter_fileImg'])@endcomponent
                                @endif
                            @else
                                @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/letterFile','name'=>'attorney_letter_fileImg'])@endcomponent
                            @endif
                        </span>
                    </li>

                    <li class="mt25">
                         <span class="infor_title">{{trans('home.electronic_invoice')}}：</span>
                        <span class=" fl">
                             @if(!empty($user_real['invoice_fileImg']))
                                @if($user_real['review_status']==1)
                                    <div class="layer-photos-demo">
                                        <img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ getFileUrl($user_real['invoice_fileImg']) }}" src="{{ getFileUrl($user_real['invoice_fileImg']) }}" alt="{{trans('home.electronic_invoice')}}">
                                         {{--<img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ URL::asset('storage/'.$user_real['invoice_fileImg']) }}" src="{{ URL::asset('storage/'.$user_real['invoice_fileImg']) }}" alt="开票资料电子版">--}}
                                        <span style="margin: 0 0 0 10px;">{{trans('home.uploaded_audited_tips')}}</span>
                                    </div>
                                @elseif($user_real['review_status']==0)
                                    <div class="layer-photos-demo">
                                        <img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ getFileUrl($user_real['invoice_fileImg']) }}" src="{{ getFileUrl($user_real['invoice_fileImg']) }}" alt="{{trans('home.electronic_invoice')}}">
                                        <span style="margin: 0 0 0 10px;">{{trans('home.uploaded_auditing_tips')}}……</span>
                                    </div>
                                @else
                                    <span style="float:left;color:red;margin-right:10px;">{{trans('home.uploaded_audit_failed_tips')}}</span>
                                    @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'invoice_fileImg'])@endcomponent
                                @endif
                            @else
                                @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/invoiceFile','name'=>'invoice_fileImg'])@endcomponent
                            @endif
                        </span>
                    </li>
                    <li class="mt25">
                         <span class="infor_title">{{trans('home.electronic_license')}}：</span>
                        <span class=" fl">
                            @if(!empty($user_real['license_fileImg']))
                                @if($user_real['review_status']==1)
                                    <div class="layer-photos-demo">
                                        <img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ getFileUrl($user_real['license_fileImg']) }}" src="{{ getFileUrl($user_real['license_fileImg']) }}" alt="营业执照电子版">
                                        <span style="margin: 0 0 0 10px;">{{trans('home.uploaded_audited_tips')}}</span>
                                    </div>
                                @elseif($user_real['review_status']==0)
                                    <div class="layer-photos-demo">
                                        <img style="width:60px;height: 50px;" layer-pid="" layer-src="{{ getFileUrl($user_real['license_fileImg']) }}" src="{{ getFileUrl($user_real['license_fileImg']) }}" alt="营业执照电子版">
                                        <span style="margin: 0 0 0 10px;">{{trans('home.uploaded_auditing_tips')}}……</span>
                                    </div>
                                @else
                                    <span style="float:left;color:red;margin-right:10px;">{{trans('home.uploaded_audit_failed_tips')}}</span>
                                    @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'license_fileImg'])@endcomponent
                                @endif
                            @else
                                @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/licenseFile','name'=>'license_fileImg'])@endcomponent
                            @endif
                        </span>
                    </li>
                    <li class="mt25">
                        <span class="infor_title">审核状态{{trans('home.account_number')}}：</span>
                        <span class=" fl">
                            @if(!empty($user_real))  
                                 @if($user_real['review_status'] == 0)
                                    待审核{{trans('home.account_number')}}
                                @elseif($user_real['review_status'] == 1)
                                    已审核{{trans('home.account_number')}}
                                @else
                                    审核不通过{{trans('home.account_number')}}
                                @endif
                            @else

                            @endif
                           
                        </span>
                    </li>
              
             <!--   <button class="account_infor_btn code_greenbg fs18 white" id="2">企业保 存</button>  -->
                </ul>
                </li>
             </ul>
             @endif
        </form>
    </div>
@endsection
