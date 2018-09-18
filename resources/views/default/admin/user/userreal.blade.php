@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/user/list?is_firm={{$is_firm}}&currpage={{$currpage}}" class="s-back">返回{{$currpage}}</a>会员 - 审核实名认证信息</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="/admin/user/userReal" name="theForm" id="user_update" novalidate="novalidate">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;真实姓名：</div>
                                <div class="label_value font14">{{$info['real_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;性别：</div>
                                <div class="label_value font14">
                                    @if($info['sex']==0) 保密
                                    @elseif($info['sex']==1)男
                                    @elseif($info['sex']==2)女
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;生日：</div>
                                <div class="label_value font14">{{$info['birthday']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;添加时间：</div>
                                <div class="label_value font14">{{$info['add_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;审核意见：</div>
                                <div class="label_value">
                                    <textarea class="textarea" name="review_content" rows="10" cols="50">{{$info['review_content']}}</textarea>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;审核时间：</div>
                                <div class="label_value font14">{{$info['review_time']}}</div>
                            </div>

                            @if($is_firm==0)
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;身份证正面：</div>
                                    <div class="label_value font14">
                                        @if($info['front_of_id_card']=="") 未上传
                                        @else<img src="{{$info['front_of_id_card']}}" style="width:200px;height:200px;">
                                        @endif
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;身份证反面：</div>
                                    <div class="label_value font14">
                                        @if($info['front_of_id_card']=="") 未上传
                                        @else<img src="{{$info['reverse_of_id_card']}}" style="width:200px;height:200px;">
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($is_firm==1)
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;营业执照注册号：</div>
                                    <div class="label_value font14">
                                        {{$info['business_license_id']}}
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;营业执照副本电子版：</div>
                                    <div class="label_value font14">

                                        @if($info['license_fileImg']=="") 未上传
                                        @else
                                            <p ><a href="{{$info['license_fileImg']}}" style="color:red;font-size: 25px" download="license_fileImg">下载原图</a></p>
                                            <img src="{{$info['license_fileImg']}}" style="width:200px;height:200px;">
                                        @endif
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;纳税人识别号：</div>
                                    <div class="label_value font14">{{$info['taxpayer_id']}}</div>
                                </div>
                            @endif

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;审核状态：</div>
                                <div class="label_value font14">
                                    @if($info['review_status']==0)<div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-primary'>待审核</div>
                                    @elseif($info['review_status']==1)<div class='layui-btn layui-btn-sm layui-btn-radius'>已实名</div>
                                    @else<div class='layui-btn layui-btn-sm layui-btn-radius  layui-btn-danger'>待实名</div>
                                    @endif
                                </div>
                            </div>




                            <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="id" value="{{$info['id']}}">
                            <input type="hidden" name="is_firm" value="{{$is_firm}}">
                            <input type="hidden" name="currpage" value="{{$currpage}}">
                            <input type="hidden" name="review_status" value="{{$info['review_status']}}">
                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
                                    @if($info['review_status']==2)
                                        <input value="审核通过" class="button" id="submitBtn" type="submit">
                                    @else
                                        <input value="审核不通过" class="button" id="submitBtn" type="submit">
                                    @endif

                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#user_update").valid()){
                    $("#user_update").submit();
                }
            });

            $('#user_update').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                rules:{
                    review_content :{
                        required : true,
                    },


                },
                messages:{
                    review_content:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'审核意见不能为空'
                    }

                }
            });
        });
    </script>
@stop
