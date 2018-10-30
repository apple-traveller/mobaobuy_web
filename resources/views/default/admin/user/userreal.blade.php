@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/user/list?review_status={{$review_status}}&currpage={{$currpage}}" class="s-back">返回{{$currpage}}</a>会员 - 审核实名认证信息</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="#" name="theForm" id="user_update" novalidate="novalidate">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;真实姓名(企业名称)：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['real_name']))
                                        {{$info['real_name']}}
                                    @else
                                        无
                                    @endif
                                </div>
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
                                <div class="label_value font14">
                                    @if(!empty($info['birthday']))
                                        {{$info['birthday']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;添加时间：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['add_time']))
                                        {{$info['add_time']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>


                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;身份证正面：</div>
                                <div class="label_value font14">
                                    @if($info['front_of_id_card']=="")
                                        未上传
                                    @else
                                        <div  content="{{getFileUrl($info['front_of_id_card'])}}" class="layui-btn viewImg">点击查看</div>
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;身份证反面：</div>
                                <div class="label_value font14">
                                    @if($info['front_of_id_card']=="")
                                        未上传
                                    @else
                                        <div content="{{getFileUrl($info['reverse_of_id_card'])}}" class="layui-btn viewImg">点击查看</div>
                                    @endif
                                </div>
                            </div>



                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;开票资料电子版：</div>
                                <div class="label_value font14">
                                    @if($info['invoice_fileImg']=="") 未上传
                                    @else
                                        <div  content="{{getFileUrl($info['invoice_fileImg'])}}" class="layui-btn viewImg">点击查看</div>
                                    @endif
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
                                <div class="label"><span class="require-field">*</span>&nbsp;授权委托书电子版：</div>
                                <div class="label_value font14">
                                    @if($info['attorney_letter_fileImg']=="") 未上传
                                    @else
                                        <div  content="{{getFileUrl($info['attorney_letter_fileImg'])}}" class="layui-btn viewImg">点击查看</div>
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;负责人姓名：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['contactName']))
                                        {{$info['contactName']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;负责人电话：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['contactPhone']))
                                        {{$info['contactPhone']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否能开专票：</div>
                                <div class="label_value font14">
                                    @if($info['is_special']==0)
                                        否
                                    @else
                                        能
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;公司抬头：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['company_name']))
                                        {{$info['company_name']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;税号：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['tax_id']))
                                        {{$info['tax_id']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;开户银行：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['bank_of_deposit']))
                                        {{$info['bank_of_deposit']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;银行账号：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['bank_account']))
                                        {{$info['bank_account']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;开票地址：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['company_address']))
                                        {{$info['company_address']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;开票电话：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['company_telephone']))
                                        {{$info['company_telephone']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;开票电话：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['company_telephone']))
                                        {{$info['company_telephone']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;审核意见：</div>
                                <div class="label_value">
                                    <textarea id="review_content" name="review_content" class="textarea">@if(!empty($info['review_content'])){{$info['review_content']}}@else @endif</textarea>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>



                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;审核状态：</div>
                                <div class="label_value font14">
                                        <div data-status="0" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($info['review_status']==0) @else layui-btn-primary @endif '>待实名</div>
                                        <div data-status="1" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($info['review_status']==1) @else layui-btn-primary @endif '>已实名</div>
                                        <div data-status="2" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($info['review_status']==2) @else layui-btn-primary @endif '>不通过</div>
                                </div>
                            </div>

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
                var review_content = $.trim($("#review_content").val());
                if(review_content==''){
                    layer.msg("请填写审核意见");
                    return false;
                }
                var postData = {
                    "id": "{{$info['id']}}",
                    "review_content":review_content,
                    "review_status": $(this).attr("data-status"),
                    "preview_status":"{{$review_status}}",
                    "attorney_letter_fileImg":"{{$info['attorney_letter_fileImg']}}"
                };
                $.post('/admin/user/userReal', postData, function (res) {
                    if (res.code == 1) {
                        //console.log(res.data);return false;
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


    </script>
@stop
