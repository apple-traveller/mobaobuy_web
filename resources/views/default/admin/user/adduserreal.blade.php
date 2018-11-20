@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
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
    @include('partials.base_header')
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/','web').'css/style.css')}}" />
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="{{asset(themePath('/','web').'js/base.js')}}"></script>
    <script>
        $(function(){
            $(".accounts li").click(function(){
                $(this).addClass('account_curr').siblings().removeClass('account_curr');
                $('.tab_list>li').eq($(this).index()).show().siblings().hide();
            });

            $('.account_infor_btn').click(function (){
                var is_self = $(this).attr('id');
                var data = $("#user_real_form").serialize();
                // console.log(data);
                data  += '&is_self='+is_self;
                $.post('/admin/user/addUserRealForm',data,function(res){
                    console.log(res.data);
                    if (res.code == 1) {
                        $.msg.success('保存成功');
                       window.location.reload();
                    } else {
                        console.log(res.data);
                        $.msg.alert(res.msg);
                    }
                },"json");
            });
        })
    </script>

    <div class="warpper">
        <div class="title"><a href="/admin/user/list" class="s-back">返回</a>用户 - 添加用户</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>添加用户。</li>
                    <li>标识“*”的选项为必填项，其余为选填项。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    {{--<form action="/admin/user/saveUserReal" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">--}}
                        {{--<div class="switch_info" style="display: block;">--}}

                            {{--<div class="item">--}}
                                {{--<div class="label"><span class="require-field">*</span>&nbsp;登录用户名(手机号)：</div>--}}
                                {{--<div class="label_value">--}}
                                    {{--<input type="text" name="user_name" class="text" value="" maxlength="40" autocomplete="off" id="user_name">--}}
                                    {{--<div class="form_prompt"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                          {{----}}

                            {{--<div class="item">--}}
                                {{--<div class="label">&nbsp;</div>--}}
                                {{--<div class="label_value info_btn">--}}
                                    {{--<input type="submit" value="确定" class="button" id="submitBtn">--}}
                                    {{--<input type="reset" value="重置" class="button button_reset">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}

                    <form method="post" action="javascript:void(0);" id="user_real_form">

                        <div class="clearfix bb1 f4bg">


                                <ul class="accounts"><li class="account_curr">个人账户</li><li id="firm">企业账户</li></ul>

                        </div>

                        <ul class="tab_list">
                            <!-- 个人账户 -->
                            <li>
                                <ul class="account_infor_list">
                                    <li><span class="infor_title">账号：</span>
                                        <span class="ml10">
                            {{$userInfo['user_name']}}
                        </span>
                                    </li>
                                    <input type="hidden" name="user_id"  value="{{$userInfo['id']}}" >

                                    <li class="mt25">
                                        <span class="infor_title">真实姓名：</span>
                                        <span class=" fl">
                            <input type="text" style="width:102px;" name="real_name" class="infor_input" />
                        </span>
                                    </li>

                                    <li class="mt25">
                                        <span class="infor_title">身份证正面：</span>
                                        <span class="ml10 fl">

                                            @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'front_of_id_card'])@endcomponent
                        </span>
                                    </li>
                                    <li class="mt25">
                                        <span class="infor_title">身份证反面：</span>
                                        <span class="ml10 fl">

                                                    @component('widgets.upload_file',['upload_type'=>'','upload_path'=>'user/idcard','name'=>'reverse_of_id_card'])@endcomponent

                        </span>
                                    </li>
                                        <button class="account_infor_btn code_greenbg fs18 white" id="1">保 存</button>
                                </ul>
                            </li>




                            <!-- 企业账户 -->
                            <li style="display: none;">
                                <ul class="account_infor_list">
                                    <li><span class="infor_title" style="margin-left:-8px;">账号：</span>
                                        <span class="ml10">
                            {{$userInfo['user_name']}}
                        </span>
                                    </li>
                                    <input type="hidden" name="user_id"  value="{{$userInfo['id']}}" >


                                    <li class="mt25">
                                        <span class="infor_title">企业全称：</span>
                                        <span class=" fl" style="margin-left:-8px;">
                            <input type="text" name="real_name_firm" class="infor_input" />
                        </span>
                                    </li>



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
                                    <button class="account_infor_btn code_greenbg fs18 white" id="2">保 存</button>
                                </ul>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        layui.use(['upload','layer'], function(){
            var upload = layui.upload;
            var layer = layui.layer;
            var isNull = /^[\s]{0,}$/;
            //文件上传
           $("#user_name").blur(function(){
               if (isNull.test($(this).val())) {
                   layer.msg('请输入手机号',{icon:1,time:1000});
                   $(this).val("");
                   return false;
               } else if (!Utils.isPhone($(this).val())) {
                   layer.msg('手机号格式不正确',{icon:1,time:1000});
                   $(this).val("");
                   return false;
               }
           });
        });

        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#article_form").valid()){
                    $("#article_form").submit();
                }
            });

            $('#article_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                ignore : [],
                rules:{
                    user_name :{
                        required : true,
                    },
                    password :{
                        required : true,
                    },
                },
                messages:{
                    user_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    password :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                }
            });
        });
    </script>


@stop
