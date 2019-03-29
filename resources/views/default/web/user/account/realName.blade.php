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
        .accounts {
        width: 376px;
        margin: 0 auto;
        }
        .accounts li {
            width: 188px;
            height: 45px;
            line-height: 45px;
            font-size: 16px;
            float: left;
            text-align: center;
            margin: 0;
            /*cursor: default;*/
            cursor: pointer;
        }

        .account_curr {
            border-bottom: 1px solid #75b335;
            color: #75b335;

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
    </style>
@endsection
@section('js')
    <script type="text/javascript">
        $(function(){
            $(".accounts li").click(function(){
                $(this).addClass('account_curr').siblings().removeClass('account_curr');
                $('.tab_list>li').eq($(this).index()).show().siblings().hide();
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
            // console.log(data);
            data  += '&is_self='+is_self;
            $.post('/account/saveUserReal',data,function(res){
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
                        <ul class="accounts"><li class="account_curr">{{trans('home.individual_account')}}</li></ul>
                    @elseif($user_real['is_firm'] == '1')
                         <ul class="accounts"><li id="firm">{{trans('home.enterprise_account')}}</li></ul>
                     @else
                        <ul class="accounts"><li class="account_curr">{{trans('home.individual_account')}}</li><li id="firm">{{trans('home.enterprise_account')}}</li></ul>
                    @endif
                @else
                    <ul class="accounts"><li class="account_curr">{{trans('home.individual_account')}}</li><li id="firm">{{trans('home.enterprise_account')}}</li></ul>
                @endif
            </div>
                
            <ul class="tab_list">
                <!-- 个人账户 -->
                @if(empty($user_real))
                     <li>
                        <ul class="account_infor_list">
                            <li>
                                <span class="infor_title">{{trans('home.account_number')}}：</span>
                                <span class="ml10">
                                    {{$user_name}}
                                </span>
                             </li>
                            <input type="hidden" name="user_id"  value="{{$user_id}}" >

                            <li class="mt25">
                                <span class="infor_title">{{trans('home.real_name')}}：</span>
                                <span class=" fl">
                                    <input type="text" style="width:182px;" name="real_name" class="infor_input" @if(!empty($user_real['real_name'])) value="{{$user_real['real_name']}}" @else value="" @endif/>
                                </span>
                            </li>

                            <li class="mt25">
                                <span class="infor_title">{{trans('home.front_card')}}：</span>
                                <span class="ml10 fl">
                                    @if(!empty($user_real['front_of_id_card']))
                                        @if($user_real['review_status']==1)
                                            {{trans('home.uploaded_audited_tips')}}
                                        @elseif($user_real['review_status']==0)
                                            {{trans('home.uploaded_auditing_tips')}}
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
                                            {{trans('home.uploaded_audited_tips')}}
                                        @elseif($user_real['review_status']==0)
                                            {{trans('home.uploaded_auditing_tips')}}
                                        @else
                                            <span style="float:left;color:red;margin-right:10px;">{{trans('home.uploaded_audit_failed_tips')}}</span>
                                            @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'reverse_of_id_card'])@endcomponent
                                        @endif
                                    @else
                                        @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'reverse_of_id_card'])@endcomponent
                                    @endif
                                </span>
                            </li>
                            <li class="mt25"><span class="infor_title">{{trans('home.be_careful')}}：</span>
                                <span class="fl">
                                    {{trans('home.upload_tips')}}
                                </span>
                            </li>
                        <button class="account_infor_btn code_greenbg fs18 white" id="1">{{trans('home.save')}}</button>
                        </ul>
                    </li>

                    <li style="display: none;">
                        <ul class="account_infor_list">
                            <li><span class="infor_title" style="margin-left:-8px;">{{trans('home.account_number')}}：</span>
                                <span class="ml10">
                                    {{$user_name}}
                                </span>
                            </li>
                            <input type="hidden" name="user_id"  value="{{$user_id}}" >

                            <li class="mt25">
                                 <span class="infor_title">{{trans('home.enterprise_name')}}：</span>
                                <span class=" fl" style="margin-left:-8px;">
                                    <input type="text" name="real_name_firm" class="infor_input" @if(!empty($user_real['real_name'])) value="{{$user_real['real_name']}}" @else value="" @endif />
                                </span>
                            </li>

                            <li class="mt25">
                                <span class="infor_title">{{trans('home.electronic_authorization')}}：</span>
                                <span class=" fl">
                                    @if(!empty($user_real['attorney_letter_fileImg']))
                                            @if($user_real['review_status']==1)
                                                {{trans('home.uploaded_audited_tips')}}
                                            @elseif($user_real['review_status']==0)
                                                {{trans('home.uploaded_auditing_tips')}}
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
                                 <span class="infor_title">{{trans('home.authorization_download')}}：</span>
                                <span class=" fl" style="width:60px;height: 40px;">
                                    <input type="button" download="{{trans('home.electronic_authorization')}}.docx" style="border:none;width:82px;height:40px;" onclick="window.open('{{asset("letterFile/公司授权委托书.docx")}}')" value="{{trans('home.click_download')}}">
                                </span>
                            </li>

                            <li class="mt25">
                                <span class="infor_title">{{trans('home.electronic_invoice')}}：</span>
                                <span class=" fl">
                                    @if(!empty($user_real['invoice_fileImg']))
                                        @if($user_real['review_status']==1)
                                            {{trans('home.uploaded_audited_tips')}}
                                        @elseif($user_real['review_status']==0)
                                            {{trans('home.uploaded_auditing_tips')}}
                                        @else
                                            <span style="float:left;color:red;margin-right:10px;">{{trans('home.uploaded_audit_failed_tips')}}</span>
                                            @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/invoiceFile','name'=>'invoice_fileImg'])@endcomponent
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
                                            {{trans('home.uploaded_audited_tips')}}
                                        @elseif($user_real['review_status']==0)
                                            {{trans('home.uploaded_auditing_tips')}}
                                        @else
                                            <span style="float:left;color:red;margin-right:10px;">{{trans('home.uploaded_audit_failed_tips')}}</span>
                                            @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/licenseFile','name'=>'license_fileImg'])@endcomponent
                                        @endif
                                    @else
                                        @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/licenseFile','name'=>'license_fileImg'])@endcomponent
                                    @endif
                                </span>
                            </li>
                            <li class="mt25"><span class="infor_title">{{trans('home.be_careful')}}：</span>
                                <span class="fl">
                                    {{trans('home.upload_tips')}}
                                </span>
                            </li>
                            <button class="account_infor_btn code_greenbg fs18 white" id="2">{{trans('home.save')}}</button>
                        </ul>
                    </li>
          
                @else
                    @if($user_real['review_status'] == 2 && $user_real['is_firm'] == 0)
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
                                <input type="text" style="width:182px;" name="real_name" class="infor_input" @if(!empty($user_real['real_name'])) value="{{$user_real['real_name']}}" @else value="" @endif/>
                            </span>
                        </li>
                
                        <li class="mt25">
                            <span class="infor_title">{{trans('home.front_card')}}：</span>
                            <span class="ml10 fl">
                                @if(!empty($user_real['front_of_id_card']))
                                    @if($user_real['review_status']==1)
                                        {{trans('home.uploaded_audited_tips')}}
                                    @elseif($user_real['review_status']==0)
                                        {{trans('home.uploaded_auditing_tips')}}
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
                                        {{trans('home.uploaded_audited_tips')}}
                                    @elseif($user_real['review_status']==0)
                                        {{trans('home.uploaded_auditing_tips')}}
                                    @else
                                        <span style="float:left;color:red;margin-right:10px;">{{trans('home.uploaded_audit_failed_tips')}}</span>
                                        @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'reverse_of_id_card'])@endcomponent
                                    @endif
                                @else
                                    @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'reverse_of_id_card'])@endcomponent
                                @endif
                            </span>
                        </li>
                        <li class="mt25"><span class="infor_title">{{trans('home.be_careful')}}：</span>
                            <span class="fl">
                                {{trans('home.upload_tips')}}
                            </span>
                        </li>
                        <button class="account_infor_btn code_greenbg fs18 white" id="1">{{trans('home.save')}}</button>
                        </ul>
                        </li>
                
                    @elseif($user_real['review_status'] == 2 && $user_real['is_firm'] == 1)
                   


                        <!-- 企业账户 -->
                        <li>
                            <ul class="account_infor_list">
                            <li class="mt25"><span class="infor_title">{{trans('home.account_number')}}：</span>
                                <span class="fl">
                                    {{$user_name}}
                                </span>
                            </li>
                            <input type="hidden" name="user_id"  value="{{$user_id}}" >

                            <li class="mt25">
                                 <span class="infor_title">{{trans('home.enterprise_name')}}：</span>
                                <span class=" fl" style="margin-left:-8px;">
                                    <input type="text" name="real_name_firm" class="infor_input" @if(!empty($user_real['real_name'])) value="{{$user_real['real_name']}}" @else value="" @endif />
                                </span>
                            </li>

                            <li class="mt25">
                                <span class="infor_title">{{trans('home.electronic_authorization')}}：</span>
                                <span class=" fl">
                                    @if(!empty($user_real['attorney_letter_fileImg']))
                                            @if($user_real['review_status']==1)
                                                {{trans('home.uploaded_audited_tips')}}
                                            @elseif($user_real['review_status']==0)
                                                {{trans('home.uploaded_auditing_tips')}}
                                            @else
                                                <span style="float:left;color:red;margin-right:10px;">{{trans('home.uploaded_audit_failed_tips')}}</span>
                                                @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/letterFile','name'=>'attorney_letter_fileImg'])@endcomponent
                                            @endif
                                    @else
                                            @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/letterFile','name'=>'attorney_letter_fileImg'])@endcomponent
                                    @endif
                                      <!--   @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/letterFile','name'=>'attorney_letter_fileImg'])@endcomponent -->
                                 </span>
                            </li>
                            <li class="mt25">
                                <span class="infor_title">{{trans('home.authorization_download')}}：</span>
                                <span class=" fl" style="width:60px;height: 40px;">
                                    <input type="button" download="{{trans('home.electronic_authorization')}}.docx" style="border:none;width:82px;height:40px;" onclick="window.open('{{asset("letterFile/公司授权委托书.docx")}}')" value="{{trans('home.click_download')}}">

                                </span>
                            </li>

                            <li class="mt25">
                                <span class="infor_title">{{trans('home.electronic_invoice')}}：</span>
                                <span class=" fl">
                                    @if(!empty($user_real['invoice_fileImg']))
                                        @if($user_real['review_status']==1)
                                            {{trans('home.uploaded_audited_tips')}}
                                        @elseif($user_real['review_status']==0)
                                            {{trans('home.uploaded_auditing_tips')}}
                                        @else
                                            <span style="float:left;color:red;margin-right:10px;">{{trans('home.uploaded_audit_failed_tips')}}</span>
                                            @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/invoiceFile','name'=>'invoice_fileImg'])@endcomponent
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
                                            {{trans('home.uploaded_audited_tips')}}
                                        @elseif($user_real['review_status']==0)
                                            {{trans('home.uploaded_auditing_tips')}}
                                        @else
                                            <span style="float:left;color:red;margin-right:10px;">{{trans('home.uploaded_audit_failed_tips')}}</span>
                                            @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/licenseFile','name'=>'license_fileImg'])@endcomponent
                                        @endif
                                    @else
                                        @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/licenseFile','name'=>'license_fileImg'])@endcomponent
                                     @endif

                                </span>
                            </li>
                            <li class="mt25"><span class="infor_title">{{trans('home.be_careful')}}：</span>
                                <span class="fl">
                                    {{trans('home.upload_tips')}}
                                </span>
                            </li>
                            <button class="account_infor_btn code_greenbg fs18 white" id="2">{{trans('home.save')}}</button>
                            </ul>
                        </li>
                    @endif
                @endif

             </ul>
        </form>
    </div>
@endsection
