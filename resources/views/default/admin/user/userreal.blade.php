@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/user/list?is_firm={{$is_firm}}&currpage={{$currpage}}" class="s-back">返回{{$currpage}}</a>会员 - 审核实名认证信息</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="#" name="theForm" id="user_update" novalidate="novalidate">

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
                                        @else
                                        <div  content="{{getFileUrl($info['front_of_id_card'])}}" class="layui-btn viewImg">点击查看</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;身份证反面：</div>
                                    <div class="label_value font14">
                                        @if($info['front_of_id_card']=="") 未上传
                                        @else
                                        <div  content="{{getFileUrl($info['reverse_of_id_card'])}}" class="layui-btn viewImg">点击查看</div>
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
                                            <div  content="{{getFileUrl($info['license_fileImg'])}}" class="layui-btn viewImg">点击查看</div>
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
                                        <div data-status="0" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($info['review_status']==0) @else layui-btn-primary @endif '>待实名</div>
                                        <div data-status="1" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($info['review_status']==1) @else layui-btn-primary @endif '>已实名</div>
                                        <div data-status="2" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($info['review_status']==2) @else layui-btn-primary @endif '>不通过</div>
                                </div>
                            </div>




                            <input type="hidden" name="id" value="{{$info['id']}}">
                            <input type="hidden" name="is_firm" value="{{$is_firm}}">
                            <input type="hidden" name="currpage" value="{{$currpage}}">



                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        layui.use(['layer'], function() {
            var layer = layui.layer;

            $(".viewImg").click(function(){
                var content = $(this).attr('content');
                index = layer.open({
                    type: 1,
                    title: '详情',
                    area: ['700px', '500px'],
                    content: '<img src="'+content+'">'
                });
            });

            $(".review_status").click(function () {
                var postData = {
                    "id": "{{$info['id']}}",
                    "is_firm": "{{$is_firm}}",
                    "currpage": "{{$currpage}}",
                    "review_status": $(this).attr("data-status"),
                };
                $.post('/admin/user/userReal', postData, function (res) {
                    if (res.code == 1) {
                        layer.msg(res.msg,{
                            icon: 1,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        },function(){
                            window.location.href=res.data;
                        });
                    } else {
                        layer.msg(res.msg);
                    }
                }, "json");
            });
        });

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
