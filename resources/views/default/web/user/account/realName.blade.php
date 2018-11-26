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
                console.log(res.data);
                if (res.code == 1) {
                    $.msg.success('保存成功');
                    window.location.href="/account/userRealInfo";
                } else {
                    console.log(res.data);
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
                        <ul class="account"><li class="account_curr">个人账户</li></ul> 
                    @elseif($user_real['is_firm'] == '1')
                         <ul class="account"><li id="firm">企业账户</li></ul>
                     @else
                        <ul class="account"><li class="account_curr">个人账户</li><li id="firm">企业账户</li></ul>
                    @endif


                @else
                 <ul class="accounts"><li class="account_curr">个人账户</li><li id="firm">企业账户</li></ul> 
                @endif
             </div>

                <ul class="tab_list">
                <!-- 个人账户 -->
                 <li>
                     <ul class="account_infor_list">
                    <li><span class="infor_title">账号：</span>
                        <span class="ml10">
                            {{$user_name}}
                        </span>
                    </li>
                    <input type="hidden" name="user_id"  value="{{$user_id}}" >
                
                    <li class="mt25">
                        <span class="infor_title">真实姓名：</span>
                        <span class=" fl">
                            <input type="text" style="width:102px;" name="real_name" class="infor_input" @if(!empty($user_real['real_name'])) value="{{$user_real['real_name']}}" @else value="" @endif/>
                        </span>
                    </li>
                
                    <li class="mt25">
                        <span class="infor_title">身份证正面：</span>
                        <span class="ml10 fl">
                            @if(!empty($user_real['front_of_id_card']))
                                @if($user_real['review_status']==1)
                                    已经上传，审核已经通过
                                @elseif($user_real['review_status']==0)
                                    已经上传，审核中
                                @else
                                    <span style="float:left;color:red;margin-right:10px;">审核不通过，请重新上传</span>
                                    @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'front_of_id_card'])@endcomponent
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
                                @if($user_real['review_status']==1)
                                    已经上传，审核已经通过
                                @elseif($user_real['review_status']==0)
                                    已经上传，审核中
                                @else
                                    <span style="float:left;color:red;margin-right:10px;">审核不通过，请重新上传</span>
                                    @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'reverse_of_id_card'])@endcomponent
                                @endif
                            @else
                                @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'reverse_of_id_card'])@endcomponent
                            @endif
                        </span>
                    </li>
                @if(!empty($user_real))
                    @if($user_real['review_status'] == '0')
                        
                    @else
                    <button class="account_infor_btn code_greenbg fs18 white" id="1">保 存</button> 

                    @endif
                @else
                    <button class="account_infor_btn code_greenbg fs18 white" id="1">保 存</button> 
                @endif
                </ul>
                </li>
                

               

                 <!-- 企业账户 -->
                       <li style="display: none;">
                     <ul class="account_infor_list">
                    <li><span class="infor_title" style="margin-left:-8px;">账号：</span>
                        <span class="ml10">
                            {{$user_name}}
                        </span>
                    </li>
                    <input type="hidden" name="user_id"  value="{{$user_id}}" >
                   
               
                    <li class="mt25">
                         <span class="infor_title">企业全称：</span>
                        <span class=" fl" style="margin-left:-8px;">
                            <input type="text" name="real_name_firm" class="infor_input" @if(!empty($user_real['real_name'])) value="{{$user_real['real_name']}}" @else value="" @endif />
                        </span>
                    </li>

                  <!--   <li class="mt25">
                       <span class="infor_title">纳税人识别号：</span>
                        <span class=" fl">
                            <input type="text" name="tax_id" class="infor_input" @if(!empty($user_real['tax_id'])) value="{{$user_real['tax_id']}}" @else value="" @endif />
                        </span>
                    </li> -->

                    <!--  <li class="mt25">
                       <span class="infor_title">公司抬头：</span>
                        <span class=" fl">
                            <input type="text" name="company_name" class="infor_input" @if(!empty($user_real['company_name'])) value="{{$user_real['company_name']}}" @else value="" @endif />
                        </span>
                    </li>

                     <li class="mt25">
                       <span class="infor_title">开户银行：</span>
                        <span class=" fl">
                            <input type="text" name="bank_of_deposit" class="infor_input" @if(!empty($user_real['bank_of_deposit'])) value="{{$user_real['bank_of_deposit']}}" @else value="" @endif />
                        </span>
                    </li>

                    <li class="mt25">
                       <span class="infor_title">银行账号：</span>
                        <span class=" fl">
                            <input type="text" name="bank_account" class="infor_input" @if(!empty($user_real['bank_account'])) value="{{$user_real['bank_account']}}" @else value="" @endif />
                        </span>
                    </li>

                     <li class="mt25">
                       <span class="infor_title">开票地址：</span>
                        <span class=" fl">
                            <input type="text" name="company_address" class="infor_input" @if(!empty($user_real['company_address'])) value="{{$user_real['company_address']}}" @else value="" @endif />
                        </span>
                    </li>

                     <li class="mt25">
                       <span class="infor_title">开票电话：</span>
                        <span class=" fl">
                            <input type="text" name="company_telephone" class="infor_input" @if(!empty($user_real['company_telephone'])) value="{{$user_real['company_telephone']}}" @else value="" @endif />
                        </span>
                    </li> -->

                      <li class="mt25">
                         <span class="infor_title">授权委托书电子版：</span>
                        <span class=" fl">
                            @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/letterFile','name'=>'attorney_letter_fileImg'])@endcomponent
                        </span>
                    </li>
                     <li class="mt25">
                         <span class="infor_title">授权委托书模板下载：</span>
                        <span class=" fl" style="width:60px;height: 40px;">
                            <input type="button" download="授权委托书电子档.docx" style="border:none;width:82px;height:40px;" onclick="window.open('{{asset("storage/user/letterFile/授权委托书电子档.docx")}}')" value="点击下载">
                        </span>
                    </li>

                    <li class="mt25">
                         <span class="infor_title">开票资料电子版：</span>
                        <span class=" fl">
                            @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/invoiceFile','name'=>'invoice_fileImg'])@endcomponent
                        </span>
                    </li>
                    <li class="mt25">
                         <span class="infor_title">营业执照电子版：</span>
                        <span class=" fl">
                            @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/licenseFile','name'=>'license_fileImg'])@endcomponent
                        </span>
                    </li>
                   <!--  <li class="mt25">
                        <span class="infor_title">审核状态：</span>
                        <span class=" fl">
                            @if(!empty($user_real))  
                                 @if($user_real['review_status'] == 0)
                                    待审核
                                @elseif($user_real['review_status'] == 1)
                                    已审核
                                @else
                                    审核不通过
                                @endif
                            @else

                            @endif
                           
                        </span>
                    </li> -->
               <button class="account_infor_btn code_greenbg fs18 white" id="2">保 存</button> 
                </ul>
                </li>
             </ul>
        </form>
    </div>
@endsection
